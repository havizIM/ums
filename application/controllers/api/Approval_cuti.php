<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Approval_cuti extends CI_Controller {
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
              'a.id_pcuti'   => $this->input->get('id'),
              'a.nik !='     => $otorisasi->nik,
          );

          $cuti       = $this->CutiModel->show($where_cuti, FALSE, FALSE);
          $response   = array();

          foreach($cuti->result() as $key){
            $json = array();

            $json['id']           = $key->id_pcuti;
            $json['pemohon']      = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'id_divisi' => $key->id_divisi, 'divisi' => $key->divisi_pemohon);
            $json['jenis_cuti']   = array('id_cuti' => $key->id_cuti, 'nama_cuti' => $key->nama_cuti, 'keterangan' => $key->keterangan);
            $json['tgl_mulai']    = $key->tgl_mulai;
            $json['tgl_selesai']  = $key->tgl_selesai;
            $json['alamat']       = $key->alamat;
            $json['telepon']      = $key->telepon;
            $json['jumlah_cuti']  = $key->jumlah_cuti;
            $json['pengganti']    = array('nik' => $key->pengganti, 'nama' => $key->nama_pengganti, 'jabatan' => $key->jabatan_pengganti,  'id_divisi' => $key->idd_divisi, 'divisi' => $key->divisi_pengganti);
            $json['tgl_input']    = $key->tgl_input;
            $json['status']       = $key->status;
            
            $where_approval       = array('a.id_pcuti' => $key->id_pcuti);
            
            $json['approval']     =  $this->ApprovalCutiModel->show($where_approval, FALSE, FALSE)->result();
            
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

            $id_pcuti = $this->input->get('id');

            if($id_pcuti == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Cuti tidak ditemukan'));
            } else {
              $where = array('id_pcuti' => $id_pcuti);

              $data = array('status' => 'Ditolak');

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_pcuti,
                'refrensi'    => 'Cuti',
                'kategori'    => 'Menolak',
                'keterangan'  => 'Menolak Approve Cuti sebagai Pengganti'
              );

              $approval = array(
                'id_pcuti'    => $id_pcuti,
                'nik'         => $otorisasi->nik,
                'keterangan'  => 'Ditolak'
              );

              $update = $this->CutiModel->edit($where, $data, $log, $approval);

              if(!$update){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menolak cuti'));
              } else {
                $this->pusher->trigger('ums', 'tolak', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menolak cuti'));
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

            $id_pcuti = $this->input->get('id');

            if($id_pcuti == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Cuti tidak ditemukan'));
            } else {
              $where = array('id_pcuti' => $id_pcuti);

              $data = array('status' => 'Approve 2');

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_pcuti,
                'refrensi'    => 'Cuti',
                'kategori'    => 'Approve',
                'keterangan'  => 'Menyetujui pengajuan cuti'
              );

              $approval = array(
                'id_pcuti'    => $id_pcuti,
                'nik'         => $otorisasi->nik,
                'keterangan'  => 'Approve 2'
              );

              $update = $this->CutiModel->edit($where, $data, $log, $approval, FALSE);

              if(!$update){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menyetujui cuti'));
              } else {
                $this->pusher->trigger('ums', 'approve', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menyetujui cuti'));
              }
            }
        }
      }
    }
  }


}

?>
