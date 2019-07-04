<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Cuti extends CI_Controller {
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

    $this->load->model('CutiModel');
    $this->load->model('ApprovalCutiModel');
    $this->load->model('LampiranCutiModel');
    $this->load->model('KaryawanModel');
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
            $id_pcuti     = $this->KodeModel->buatKode('cuti', 'PCT', 'id_pcuti', 9);
            $id_cuti      = $this->input->post('id_cuti');
            $tgl_mulai    = date('Y-m-d', strtotime($this->input->post('tgl_mulai')));
            $tgl_selesai  = date('Y-m-d', strtotime($this->input->post('tgl_selesai')));;
            $alamat       = $this->input->post('alamat');
            $telepon      = $this->input->post('telepon');
            $pengganti    = $this->input->post('pengganti');
            $jumlah_cuti  = $this->input->post('jumlah_cuti');

            if($id_cuti == null || $tgl_mulai == null || $tgl_selesai == null || $alamat == null || $telepon == null || $pengganti == null || $jumlah_cuti == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

                $data = array(
                    'id_pcuti'      => $id_pcuti,
                    'nik'           => $otorisasi->nik,
                    'id_cuti'       => $id_cuti,
                    'tgl_mulai'     => $tgl_mulai,
                    'tgl_selesai'   => $tgl_selesai,
                    'alamat'        => $alamat,
                    'telepon'       => $telepon,
                    'pengganti'     => $pengganti,
                    'jumlah_cuti'   => $jumlah_cuti,
                    'status'        => 'Proses'
                );

                $log = array(
                    'nik'         => $otorisasi->nik,
                    'id_ref'      => $id_pcuti,
                    'refrensi'    => 'Cuti',
                    'kategori'    => 'Add',
                    'keterangan'  => 'Menambahkan cuti baru'
                );

                $add = $this->CutiModel->add($data, $log);

                if(!$add){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data cuti'));
                } else {
                    $this->pusher->trigger('ums', 'cuti', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data cuti'));
                }
            }
        }
      }
    }
  }

  function add_lampiran($token = null)
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
            
            $id_pcuti           = $this->input->post('id_pcuti');
            $nama_lampiran      = $this->input->post('nama_lampiran');

            if($id_pcuti == null || $nama_lampiran == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

                $lampiran = $this->_upload_file('lampiran_cuti', $id_pcuti.'-'.$nama_lampiran);

                if($lampiran == null){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Silahkan pilih dokumen lampiran'));
                } else {
                  $data = array(
                      'id_pcuti'       => $id_pcuti,
                      'nama_lampiran'  => $nama_lampiran,
                      'lampiran'       => $lampiran
                  );

                  $log = array(
                      'nik'         => $otorisasi->nik,
                      'id_ref'      => $id_pcuti,
                      'refrensi'    => 'Lampiran Cuti',
                      'kategori'    => 'Add',
                      'keterangan'  => 'Menambahkan lampiran'
                  );

                  $add = $this->CutiModel->add($data, $log);

                  if(!$add){
                      json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah lampiran cuti'));
                  } else {
                      $this->pusher->trigger('ums', 'cuti', $log);
                      json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah lampiran cuti'));
                  }
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

  function cari_pengganti($token = null){
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

          $where  = array(
            'a.nik'       => $this->input->get('nik'),
            'a.nik !='    => $otorisasi->nik,
            'a.id_divisi' => $this->input->get('id_divisi')
          );

          $like   = array(
            'a.nama' => $this->input->get('nama')
          );

          $show       = $this->KaryawanModel->show($where, $like);
          $karyawan   = array();

          foreach($show->result() as $key){
            $json = array();

            $json['nik'] = $key->nik;
            $json['nama'] = $key->nama;
            $json['tmp_lahir'] = $key->tmp_lahir;
            $json['tgl_lahir'] = $key->tgl_lahir;
            $json['kelamin'] = $key->kelamin;
            $json['status_kawin'] = $key->status_kawin;
            $json['pendidikan'] = $key->pendidikan;
            $json['alamat'] = $key->alamat;
            $json['telepon'] = $key->telepon;
            $json['tgl_masuk'] = $key->tgl_masuk;
            $json['status_karyawan'] = $key->status_karyawan;
            $json['jabatan'] = $key->jabatan;
            $json['id_divisi'] = $key->id_divisi;
            $json['nama_divisi'] = $key->nama_divisi;
            $json['email'] = $key->email;
            $json['level'] = $key->level;
            $json['tgl_registrasi'] = $key->tgl_registrasi;
            $json['foto'] = $key->foto;

            $karyawan[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $karyawan));
        }
      }
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
            $id_pcuti     = $this->input->get('id_pcuti');
            $id_cuti      = $this->input->post('id_cuti');
            $tgl_mulai    = date('Y-m-d', strtotime($this->input->post('tgl_mulai')));
            $tgl_selesai  = date('Y-m-d', strtotime($this->input->post('tgl_selesai')));;
            $alamat       = $this->input->post('alamat');
            $telepon      = $this->input->post('telepon');
            $pengganti    = $this->input->post('pengganti');
            $jumlah_cuti  = $this->input->post('jumlah_cuti');

            if($id_cuti == null || $tgl_mulai == null || $tgl_selesai == null || $alamat == null || $telepon == null || $pengganti == null || $jumlah_cuti == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

                $where = array('id_pcuti' => $id_pcuti);

                $data = array(
                    'nik'           => $otorisasi->nik,
                    'id_cuti'       => $id_cuti,
                    'tgl_mulai'     => $tgl_mulai,
                    'tgl_selesai'   => $tgl_selesai,
                    'alamat'        => $alamat,
                    'telepon'       => $telepon,
                    'pengganti'     => $pengganti,
                    'jumlah_cuti'   => $jumlah_cuti
                );

                $log = array(
                    'nik'         => $otorisasi->nik,
                    'id_ref'      => $id_pcuti,
                    'refrensi'    => 'Cuti',
                    'kategori'    => 'Edit',
                    'keterangan'  => 'Mengedit Cuti Baru'
                );

                $add = $this->CutiModel->edit($where, $data, $log, FALSE);

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
              'a.id_pcuti' => $this->input->get('id'),
              'a.nik'      => $otorisasi->nik
          );

          

          $cuti       = $this->CutiModel->show($where_cuti, FALSE, FALSE);
          $response   = array();

          foreach($cuti->result() as $key){
            $json = array();

            $json['id']           = $key->id_pcuti;
            $json['pemohon']      = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'divisi' => $key->divisi_pemohon);
            $json['jenis_cuti']   = array('id_cuti' => $key->id_cuti, 'nama_cuti' => $key->nama_cuti, 'keterangan' => $key->keterangan);
            $json['tgl_mulai']    = $key->tgl_mulai;
            $json['tgl_selesai']  = $key->tgl_selesai;
            $json['alamat']       = $key->alamat;
            $json['telepon']      = $key->telepon;
            $json['jumlah_cuti']  = $key->jumlah_cuti;
            $json['pengganti']    = array('nik' => $key->pengganti, 'nama' => $key->nama_pengganti, 'jabatan' => $key->jabatan_pengganti, 'divisi' => $key->divisi_pengganti);
            $json['tgl_input']    = $key->tgl_input;
            $json['status']       = $key->status;
            
            $where_approval       = array('a.id_pcuti' => $key->id_pcuti);
            $json['approval']     =  $this->ApprovalCutiModel->show($where_approval, FALSE, FALSE)->result();

            $where_lampiran       = array('id_pcuti' => $key->id_pcuti);
            $json['lampiran']     =  $this->LampiranCutiModel->show($where_lampiran, FALSE)->result();
            
            $response[] = $json;
        }
        

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $response));
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

            $id_pcuti = $this->input->get('id');

            if($id_pcuti == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Cuti tidak ditemukan'));
            } else {
              $where = array('id_pcuti' => $id_pcuti);

              $data = array('status' => 'Batal');

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_pcuti,
                'refrensi'    => 'Cuti',
                'kategori'    => 'Batalkan',
                'keterangan'  => 'Membatalkan Cuti'
              );

              $update = $this->CutiModel->edit($where, $data, $log, FALSE);

              if(!$update){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal membatalkan cuti'));
              } else {
                $this->pusher->trigger('ums', 'cuti', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil membatalkan cuti'));
              }
            }
        }
      }
    }
  }


}

?>
