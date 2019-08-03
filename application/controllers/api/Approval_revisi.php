<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Approval_revisi extends CI_Controller {
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
    $this->load->model('AbsensiModel');
    $this->load->model('ApprovalRevisiModel');
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
              'a.nik !='        => $otorisasi->nik
          ); 

          $izin       = $this->RevisiModel->show($where_cuti, FALSE, FALSE);
          $response   = array();

          foreach($izin->result() as $key){
            $json = array();

            $json['id']             = $key->id_previsi;
            $json['pemohon']        = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'id_divisi' => $key->id_divisi, 'divisi' => $key->divisi_pemohon);
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

  public function tolak($token = null){
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

              $data = array('status' => 'Ditolak');

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_previsi,
                'refrensi'    => 'Koreksi Absen',
                'kategori'    => 'Tolak',
                'keterangan'  => 'Menolak Koreksi Absen'
              );

              $approval = array(
                'id_previsi'    => $id_previsi,
                'nik'         => $otorisasi->nik,
                'keterangan'  => 'Ditolak'
              );

              $update = $this->RevisiModel->edit($where, $data, $log, $approval, FALSE, FALSE);

              if(!$update){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menolak Koreksi absen'));
              } else {
                $this->pusher->trigger('ums', 'revisi_absen', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menolak Koreksi absen'));
              }
            }
        }
      }
    }
  }

  public function approve($token = null){
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
              
            } else {

              $where      = array('id_previsi' => $id_previsi);
              $new_absen  = $this->RevisiModel->show($where, FALSE, FALSE)->row();

              $param      = array(
                'tgl_absen' => $new_absen->tgl_absensi
              );

              $check_ab = $this->AbsensiModel->check($param);

              if($check_ab->num_rows() == 0){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Tanggal absen tidak ditemukan'));
              } else {
                $old_absen = $check_ab->row();

                $data = array('status' => 'Approve');

                $log = array(
                  'nik'         => $otorisasi->nik,
                  'id_ref'      => $id_previsi,
                  'refrensi'    => 'Koreksi Absen',
                  'kategori'    => 'Approve',
                  'keterangan'  => 'Menyetujui Koreksi Absen'
                );

                $approval = array(
                  'id_previsi'  => $id_previsi,
                  'nik'         => $otorisasi->nik,
                  'keterangan'  => 'Approve'
                );

                $where_ab = array(
                  'tgl_absen' => $old_absen->tgl_absen
                );

                $absen = array(
                  'jam_masuk'   => $new_absen->jam_datang,
                  'jam_keluar'  => $new_absen->jam_pulang
                );

                $update = $this->RevisiModel->edit($where, $data, $log, $approval, $where_ab, $absen);

                if(!$update){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal Menyetujui koreksi absen'));
                } else {
                  $this->pusher->trigger('ums', 'revisi_absen', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil Menyetujui koreksi absen'));
                }
              }
            }
        }
      }
    }
  }


}

?>
