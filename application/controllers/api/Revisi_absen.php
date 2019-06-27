<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Revisi_absen extends CI_Controller {
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

    $this->load->model('RevisiModel');
    $this->load->model('ApprovalRevisiModel');
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
            $id_previsi   = $this->KodeModel->buatKode('revisi_absen', 'PRA', 'id_previsi', 8);
            $tgl_absensi  = date('Y-m-d', strtotime($this->input->post('tgl_absensi')));
            $alasan       = $this->input->post('alasan');
            $keterangan   = $this->input->post('keterangan');
            $jam_datang   = $this->input->post('jam_datang');
            $jam_pulang   = $this->input->post('jam_pulang');

            if($tgl_absensi == null || $keterangan == null || $alasan == null || $jam_datang == null || $jam_pulang == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

                $data = array(
                    'id_previsi'        => $id_previsi,
                    'nik'               => $otorisasi->nik,
                    'tgl_absensi'       => $tgl_absensi,
                    'alasan'            => $alasan,
                    'keterangan'        => $keterangan,
                    'jam_datang'        => $jam_datang,
                    'jam_pulang'        => $jam_pulang,
                    'status'            => 'Proses'
                );

                $log = array(
                    'nik'         => $otorisasi->nik,
                    'id_ref'      => $id_previsi,
                    'refrensi'    => 'Revisi Absen',
                    'kategori'    => 'Add',
                    'keterangan'  => 'Menambahkan revisi absen baru'
                );

                $add = $this->RevisiModel->add($data, $log);

                if(!$add){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data revisi'));
                } else {
                    $this->pusher->trigger('ums', 'revisi_absen', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data revisi'));
                }
            }
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

            $id_previsi   = $this->input->get('id');
            $tgl_absensi  = date('Y-m-d', strtotime($this->input->post('tgl_absensi')));
            $alasan       = $this->input->post('alasan');
            $keterangan   = $this->input->post('keterangan');
            $jam_datang   = $this->input->post('jam_datang');
            $jam_pulang   = $this->input->post('jam_pulang');

            if($id_previsi == null || $tgl_absensi == null || $alasan == null || $keterangan == null || $jam_datang ==  null || $jam_pulang == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

                $where = array('id_previsi' => $id_previsi);

                $data = array(
                    'nik'               => $otorisasi->nik,
                    'tgl_absensi'       => $tgl_absensi,
                    'alasan'            => $alasan,
                    'keterangan'        => $keterangan,
                    'jam_datang'        => $jam_datang,
                    'jam_pulang'        => $jam_pulang
                );

                $log = array(
                    'nik'         => $otorisasi->nik,
                    'id_ref'      => $id_previsi,
                    'refrensi'    => 'Cuti',
                    'kategori'    => 'Edit',
                    'keterangan'  => 'Mengedit Revisi Absen Baru'
                );

                $add = $this->RevisiModel->edit($where, $data, $log);

                if(!$add){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data revisi absen'));
                } else {
                    $this->pusher->trigger('ums', 'revisi_absen', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data revisi absen'));
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
              'a.id_previsi' => $this->input->get('id'),
              'a.nik'        => $otorisasi->nik
          );

          

          $izin       = $this->RevisiModel->show($where_cuti, FALSE, FALSE);
          $response   = array();

          foreach($izin->result() as $key){
            $json = array();

            $json['id']             = $key->id_previsi;
            $json['pemohon']        = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'divisi' => $key->divisi_pemohon);
            $json['tgl_absensi']    = $key->tgl_absensi;
            $json['tgl_input']      = $key->tgl_input;
            $json['alasan']         = $key->alasan;
            $json['keterangan']     = $key->keterangan;
            $json['jam_pulang']     = $key->jam_pulang;
            $json['jam_datang']     = $key->jam_datang;
            $json['status']         = $key->status;
            
            $where_approval         = array('a.id_previsi' => $key->id_previsi);
            
            $json['approval']       =  $this->ApprovalRevisiModel->show($where_approval, FALSE, FALSE)->result();
            
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

            $id_previsi = $this->input->get('id');

            if($id_previsi == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Izin tidak ditemukan'));
            } else {
              $where = array('id_previsi' => $id_previsi);

              $data = array('status' => 'Batal');

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_previsi,
                'refrensi'    => 'Revisi Absen',
                'kategori'    => 'Batalkan',
                'keterangan'  => 'Membatalkan Revisi Absen'
              );

              $update = $this->RevisiModel->edit($where, $data, $log);

              if(!$update){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal membatalkan revisi absen'));
              } else {
                $this->pusher->trigger('ums', 'revisi_absen', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil membatalkan revisi absen'));
              }
            }
        }
      }
    }
  }


}

?>
