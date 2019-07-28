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
    $this->load->model('CutiBersamaModel');
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
            $id_cuti      = $this->input->post('id_cuti');
            $tgl_mulai    = date('Y-m-d', strtotime($this->input->post('tgl_mulai')));
            $tgl_selesai  = date('Y-m-d', strtotime($this->input->post('tgl_selesai')));;
            $alamat       = $this->input->post('alamat');
            $telepon      = $this->input->post('telepon');
            $pengganti    = $this->input->post('pengganti');
            $jumlah_cuti  = $this->input->post('jumlah_cuti');

            $mycode       = 'PCT-'.date('my').'-';
            $id_pcuti     = $this->KodeModel->buatKode('cuti', $mycode, 'id_pcuti', 3);

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


                $start  = new DateTime($tgl_mulai);
                $plus    = new DateTime($tgl_selesai);
                $end     = $plus->modify('+1 days');

                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($start, $interval, $end);

                $detail = array();
                foreach($period as $dt){
                  $detail[] = array(
                    'id_pcuti' => $id_pcuti,
                    'tanggal_cuti' => $dt->format('Y-m-d')
                  );
                }

                $add = $this->CutiModel->add($data, $log, $detail);

                if(!$add){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data cuti'));
                } else {
                    $this->pusher->trigger('ums', 'cuti', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data cuti', 'data' => $detail));
                }
            }
        }
      }
    }
  }

  function sisa_cuti($token = null)
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

          $where1 = array(
            'id_cuti' => $this->input->get('id_cuti')
          );
          
          $where2 = array(
              'tahun'   => date('Y'),
              'status'  => 'Approve 3',
              'nik'     => $otorisasi->nik
          );

          $where_cb = array(
            'YEAR(tgl_cuti_bersama)' => date('Y')
          );

          $cuti             = $this->CutiModel->total_cuti($where1, $where2);
          $jml_cuti_bersama = $this->CutiBersamaModel->show($where_cb, FALSE, FALSE)->num_rows();
          $response         = array();

          foreach($cuti->result() as $key){
            $json = array();

            $json['id_cuti']     = $key->id_cuti;
            $json['nama_cuti']   = $key->nama_cuti;
            $json['keterangan']  = $key->keterangan;
            $json['banyak_cuti'] = $key->banyak_cuti;
            $json['total_cuti']  = $key->total_cuti;
            $json['jml_cb']      = $jml_cuti_bersama;

            if($key->nama_cuti === 'Cuti Tahunan'){
              $json['sisa_cuti']   = $key->banyak_cuti - $key->total_cuti - $jml_cuti_bersama;
            } else {
              $json['sisa_cuti']   = $key->banyak_cuti - $key->total_cuti;
            }
            
            $response[] = $json;
          }
        

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $response));
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
                      'lampiran_cuti'  => $lampiran
                  );

                  $log = array(
                      'nik'         => $otorisasi->nik,
                      'id_ref'      => $id_pcuti,
                      'refrensi'    => 'Lampiran Cuti',
                      'kategori'    => 'Add',
                      'keterangan'  => 'Menambahkan lampiran'
                  );

                  $add = $this->LampiranCutiModel->add($data, $log);

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

  public function delete_lampiran($token = null){
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
          $id_lampiran_cuti = $this->input->get('id_lampiran_cuti');
          $nama_lampiran    = $this->input->get('nama_lampiran');

          if($id_lampiran_cuti == null){
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Izin tidak ditemukan'));
          } else {
            $where = array('id_lampiran_cuti' => $id_lampiran_cuti);

            $log = array(
              'nik'         => $otorisasi->nik,
              'id_ref'      => $id_lampiran_cuti,
              'refrensi'    => 'Cuti Bersama',
              'kategori'    => 'Delete',
              'keterangan'  => 'Menghapus salah satu cuti bersama'
            );

            $id_file = $id_lampiran_cuti.'-'.$nama_lampiran;
            $this->_delete_file('lampiran_cuti', $id_file);

            $delete = $this->LampiranCutiModel->delete($where, $log);

            if(!$delete){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus cuti bersama'));
            } else {
              $this->pusher->trigger('ums', 'cuti_bersama', $log);
              json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus cuti bersama'));
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

  function _delete_file($name, $id){
    $files = glob('doc/'.$name.'/'.$id.'.*');
    foreach ($files as $key) {
      unlink($key);
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

                $start  = new DateTime($tgl_mulai);
                $plus    = new DateTime($tgl_selesai);
                $end     = $plus->modify('+1 days');

                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($start, $interval, $end);

                $detail = array();
                foreach($period as $dt){
                  $detail[] = array(
                    'id_pcuti' => $id_pcuti,
                    'tanggal_cuti' => $dt->format('Y-m-d')
                  );
                }

                $add = $this->CutiModel->edit($where, $data, $log, FALSE, $detail);

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
            $json['jenis_cuti']   = array('id_cuti' => $key->id_cuti, 'nama_cuti' => $key->nama_cuti, 'keterangan' => $key->keterangan, 'lampiran' => $key->lampiran);
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

          $where_cuti = array(
              'MONTH(a.tgl_input)' => $this->input->get('bulan'),
              'YEAR(a.tgl_input)' => $this->input->get('tahun'),
              'a.status' => 'Approve 3'
          );

          $cuti       = $this->CutiModel->show($where_cuti, FALSE, FALSE);
          $response   = array();

          foreach($cuti->result() as $key){
            $json = array();

            $json['id']           = $key->id_pcuti;
            $json['pemohon']      = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'divisi' => $key->divisi_pemohon);
            $json['jenis_cuti']   = array('id_cuti' => $key->id_cuti, 'nama_cuti' => $key->nama_cuti, 'keterangan' => $key->keterangan, 'lampiran' => $key->lampiran);
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
        

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'bulan' => $this->input->get('bulan'), 'tahun' => $this->input->get('tahun'), 'data' => $response));
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

          $where_cuti = array(
              'YEAR(a.tgl_input)' => date('Y'),
              'a.status' => 'Approve 3'
          );

          $cuti       = $this->CutiModel->show($where_cuti, FALSE, FALSE);
          $response   = array();

          foreach($cuti->result() as $key){
            $json = array();

            $json['id']           = $key->id_pcuti;
            $json['pemohon']      = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'divisi' => $key->divisi_pemohon);
            $json['jenis_cuti']   = array('id_cuti' => $key->id_cuti, 'nama_cuti' => $key->nama_cuti, 'keterangan' => $key->keterangan, 'lampiran' => $key->lampiran);
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
        

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'bulan' => $this->input->get('bulan'), 'tahun' => $this->input->get('tahun'), 'data' => $response));
        }
      }
    }
  }

  function by_master_cuti($token = null)
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

          $tahun  = date('Y');
          
          if($otorisasi->level === 'Kabag'){
            $id_divisi = $otorisasi->id_divisi;
          } else {
            $id_divisi = '';
          }

          $cuti       = $this->CutiModel->by_master_cuti($tahun, $id_divisi)->result();

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $cuti));
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

              $update = $this->CutiModel->edit($where, $data, $log, FALSE, FALSE);

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
