<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Izin extends CI_Controller {
  function __construct(){
    parent::__construct();

    $this->options = array(
      'cluster' => 'ap1',
      'useTLS' => true
    );

    $this->pusher = new Pusher\Pusher(
      '9f324d52d4872168e514',
      '0bc1f341940046001b79',
      '752686',
      $this->options
    );

    $this->load->model('IzinModel');
    $this->load->model('ApprovalIzinModel');
    $this->load->model('LampiranIzinModel');
  }

  function add($token = null)
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'POST') {
			json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
	  } else {

      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {

            $otorisasi    = $auth->row();
            $id_izin      = $this->input->post('id_izin');
            $tgl_izin     = date('Y-m-d', strtotime($this->input->post('tgl_izin')));
            $keterangan   = $this->input->post('keterangan');
            $lampiran     = $this->input->post('lampiran');
            
            $mycode       = 'PI-'.date('my').'-';
            $id_pizin     = $this->KodeModel->buatKode('izin', $mycode, 'id_pizin', 3);
            
            if($id_izin == null || $tgl_izin == null || $keterangan == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {
                if($lampiran == 'Y'){
                  $nama_lampiran = $this->input->post('nama_lampiran');
                  $lampiran_izin = $this->_upload_file('lampiran_izin', $id_pizin);

                  if($nama_lampiran == null || $lampiran_izin == null){
                      json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
                  } else {
                    $lampiran = array(
                      'id_pizin' => $id_pizin,
                      'nama_lampiran' => $nama_lampiran,
                      'lampiran_izin' => $lampiran_izin
                    );
                  } 
                } else {
                  $lampiran = array();
                }

                $data = array(
                    'id_pizin'      => $id_pizin,
                    'nik'           => $otorisasi->nik,
                    'id_izin'       => $id_izin,
                    'tgl_izin'      => $tgl_izin,
                    'keterangan'    => $keterangan,
                    'status'        => 'Proses'
                );

                $log = array(
                    'nik'         => $otorisasi->nik,
                    'id_ref'      => $id_pizin,
                    'refrensi'    => 'Izin',
                    'kategori'    => 'Add',
                    'keterangan'  => 'Menambahkan izin baru'
                );

                

                $add = $this->IzinModel->add($data, $log, $lampiran);

                if(!$add){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data izin'));
                } else {
                    $this->pusher->trigger('ums', 'izin', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data izin'));
                }
            }
        }
      }
    }
  }

  function _upload_file($name, $id)
  {
    if(isset($_FILES[$name]) && $_FILES[$name]['name'] != ""){
      $files = glob('doc/'.$name.'/'.$id.'.*');
      foreach ($files as $key) {
        unlink($key);
      }

      $config['upload_path']   = './doc/'.$name.'/';
      $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
      $config['overwrite']     = TRUE;
      $config['max_size']      = '3048';
      $config['remove_space']  = TRUE;
      $config['file_name']     = $id;

      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      if(!$this->upload->do_upload($name)){
        return null;
      } else {
        $file = $this->upload->data();
        return $file['file_name'];
      }
    } else {
      return null;
    }
  }

  function edit($token = null)
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'POST') {
			json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
	  } else {

      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {

            $otorisasi    = $auth->row();
            $id_pizin     = $this->input->get('id_pizin');
            $id_izin      = $this->input->post('id_izin');
            $tgl_izin     = date('Y-m-d', strtotime($this->input->post('tgl_izin')));
            $keterangan   = $this->input->post('keterangan');
            $lampiran     = $this->input->post('lampiran');

            if($id_izin == null || $tgl_izin == null || $keterangan == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

                $where = array('id_pizin' => $id_pizin);

                if($lampiran == 'Y'){
                  $nama_lampiran = $this->input->post('nama_lampiran');
                  $lampiran_izin = $this->_upload_file('lampiran_izin', $id_pizin);

                  if($nama_lampiran == null){
                      json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
                  } else {
                    $lampiran = array(
                      'id_pizin'      => $id_pizin,
                      'nama_lampiran' => $nama_lampiran
                    );

                    if($lampiran_izin != null){
                      $lampiran['lampiran_izin'] = $lampiran_izin;
                    }
                  } 
                } else {
                  $lampiran = array();
                }

                $data = array(
                    'nik'           => $otorisasi->nik,
                    'id_izin'       => $id_izin,
                    'tgl_izin'      => $tgl_izin,
                    'keterangan'    => $keterangan
                );

                $log = array(
                    'nik'         => $otorisasi->nik,
                    'id_ref'      => $id_pizin,
                    'refrensi'    => 'Cuti',
                    'kategori'    => 'Edit',
                    'keterangan'  => 'Mengedit Cuti Baru'
                );

                $add = $this->IzinModel->edit($where, $data, $log, FALSE, $lampiran);

                if(!$add){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data cuti'));
                } else {
                    $this->pusher->trigger('ums', 'cuti', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data cuti'));
                }
            }
        }
      }
    }
  }

  function show($token = null)
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'GET') {
      json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
		} else {

      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {

          $otorisasi  = $auth->row();

          $where_cuti = array(
              'a.id_pizin' => $this->input->get('id'),
              'a.nik'      => $otorisasi->nik
          );

          

          $izin       = $this->IzinModel->show($where_cuti, FALSE, FALSE);
          $response   = array();

          foreach($izin->result() as $key){
            $json = array();

            $json['id']           = $key->id_pizin;
            $json['pemohon']      = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'divisi' => $key->divisi_pemohon);
            $json['jenis_izin']   = array('id_izin' => $key->id_izin, 'keperluan' => $key->keperluan, 'keterangan_izin' => $key->keterangan_izin);
            $json['tgl_izin']     = $key->tgl_izin;
            $json['keterangan']   = $key->keterangan;
            $json['tgl_input']    = $key->tgl_input;
            $json['status']       = $key->status;
            
            $where_approval       = array('a.id_pizin' => $key->id_pizin);
            $json['approval']     =  $this->ApprovalIzinModel->show($where_approval, FALSE, FALSE)->result();

            $where_lampiran       = array('id_pizin' => $key->id_pizin);
            $json['lampiran']     =  $this->LampiranIzinModel->show($where_lampiran, FALSE)->result();
            
            $response[] = $json;
        }
        

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $response));
        }
      }
    }
  }

  function laporan($token = null)
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'GET') {
      json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
		} else {

      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {

          $otorisasi  = $auth->row();

          $where_izin = array(
              'MONTH(a.tgl_input)' => $this->input->get('bulan'),
              'YEAR(a.tgl_input)' => $this->input->get('tahun'),
              'a.status' => 'Approve 2'
          );

          $izin       = $this->IzinModel->show($where_izin, FALSE, FALSE);
          $response   = array();

          foreach($izin->result() as $key){
            $json = array();

            $json['id']           = $key->id_pizin;
            $json['pemohon']      = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'divisi' => $key->divisi_pemohon);
            $json['jenis_izin']   = array('id_izin' => $key->id_izin, 'keperluan' => $key->keperluan, 'keterangan_izin' => $key->keterangan_izin);
            $json['tgl_izin']     = $key->tgl_izin;
            $json['keterangan']   = $key->keterangan;
            $json['tgl_input']    = $key->tgl_input;
            $json['status']       = $key->status;
            
            $where_approval       = array('a.id_pizin' => $key->id_pizin);
            $json['approval']     =  $this->ApprovalIzinModel->show($where_approval, FALSE, FALSE)->result();

            $where_lampiran       = array('id_pizin' => $key->id_pizin);
            $json['lampiran']     =  $this->LampiranIzinModel->show($where_lampiran, FALSE)->result();
            
            $response[] = $json;
        }
        

          json_output(200, array('status' => 200, 'description' => 'Berhasil',  'bulan' => $this->input->get('bulan'), 'tahun' => $this->input->get('tahun'), 'data' => $response));
        }
      }
    }
  }

  function statistic($token = null)
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'GET') {
      json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
		} else {

      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {

          $otorisasi  = $auth->row();

          $where_izin = array(
              'YEAR(a.tgl_input)' => date('Y'),
              'a.status' => 'Approve 2'
          );

          $izin       = $this->IzinModel->show($where_izin, FALSE, FALSE);
          $response   = array();

          foreach($izin->result() as $key){
            $json = array();

            $json['id']           = $key->id_pizin;
            $json['pemohon']      = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'divisi' => $key->divisi_pemohon);
            $json['jenis_izin']   = array('id_izin' => $key->id_izin, 'keperluan' => $key->keperluan, 'keterangan_izin' => $key->keterangan_izin);
            $json['tgl_izin']     = $key->tgl_izin;
            $json['keterangan']   = $key->keterangan;
            $json['tgl_input']    = $key->tgl_input;
            $json['status']       = $key->status;
            
            $where_approval       = array('a.id_pizin' => $key->id_pizin);
            $json['approval']     =  $this->ApprovalIzinModel->show($where_approval, FALSE, FALSE)->result();

            $where_lampiran       = array('id_pizin' => $key->id_pizin);
            $json['lampiran']     =  $this->LampiranIzinModel->show($where_lampiran, FALSE)->result();
            
            $response[] = $json;
        }
        

          json_output(200, array('status' => 200, 'description' => 'Berhasil',  'bulan' => $this->input->get('bulan'), 'tahun' => $this->input->get('tahun'), 'data' => $response));
        }
      }
    }
  }

  public function batalkan($token = null){
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'GET') {
			json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
		} else {
      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {

          $otorisasi = $auth->row();

            $id_pizin = $this->input->get('id');

            if($id_pizin == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Izin tidak ditemukan'));
            } else {
              $where = array('id_pizin' => $id_pizin);

              $data = array('status' => 'Batal');

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_pizin,
                'refrensi'    => 'Cuti',
                'kategori'    => 'Batalkan',
                'keterangan'  => 'Membatalkan Izin'
              );

              $update = $this->IzinModel->edit($where, $data, $log, FALSE, FALSE);

              if(!$update){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal membatalkan izin'));
              } else {
                $this->pusher->trigger('ums', 'izin', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil membatalkan izin'));
              }
            }
        }
      }
    }
  }


}

?>
