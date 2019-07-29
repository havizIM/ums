<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Approval_izin extends CI_Controller {
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
              'a.nik !='   => $otorisasi->nik
          );

          $izin       = $this->IzinModel->show($where_cuti, FALSE, FALSE);
          $response   = array();

          foreach($izin->result() as $key){
            $json = array();

            $json['id']           = $key->id_pizin;
            $json['pemohon']      = array('nik' => $key->nik, 'nama' => $key->nama_pemohon, 'jabatan' => $key->jabatan_pemohon, 'id_divisi' => $key->id_divisi, 'divisi' => $key->divisi_pemohon);
            $json['jenis_izin']   = array('id_izin' => $key->id_izin, 'keperluan' => $key->keperluan, 'keterangan_izin' => $key->keterangan_izin);
            $json['tgl_izin']     = $key->tgl_izin;
            $json['keterangan']   = $key->keterangan;
            $json['tgl_input']    = $key->tgl_input;
            $json['status']       = $key->status;
            
            $where_approval       = array('a.id_pizin' => $key->id_pizin);
            
            $json['approval']     =  $this->ApprovalIzinModel->show($where_approval, FALSE, FALSE)->result();
            
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

            $id_pizin = $this->input->get('id');

            if($id_pizin == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Izin tidak ditemukan'));
            } else {
              $where = array('id_pizin' => $id_pizin);

              $data = array('status' => 'Ditolak');

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_pizin,
                'refrensi'    => 'Cuti',
                'kategori'    => 'Approval 1',
                'keterangan'  => 'Menyetujui izin'
              );

              $approval = array(
                'id_pizin'    => $id_pizin,
                'nik'         => $otorisasi->nik,
                'keterangan'  => 'Ditolak'
              );

              $update = $this->IzinModel->edit($where, $data, $log, $approval, FALSE);

              if(!$update){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menyetujui izin'));
              } else {
                $this->pusher->trigger('ums', 'izin', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menyetujui izin'));
              }
            }
        }
      }
    }
  }

  public function approve_1($token = null){
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

              $data = array('status' => 'Approve 1');

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_pizin,
                'refrensi'    => 'Izin',
                'kategori'    => 'Batalkan',
                'keterangan'  => 'Menyetujui Izin'
              );

              $approval = array(
                'id_pizin'    => $id_pizin,
                'nik'         => $otorisasi->nik,
                'keterangan'  => 'Approve 1'
              );

              $update = $this->IzinModel->edit($where, $data, $log, $approval, FALSE);

              if(!$update){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengapprove izin'));
              } else {
                $this->pusher->trigger('ums', 'izin', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengapprove izin'));
              }
            }
        }
      }
    }
  }

  public function approve_2($token = null){
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

              $data = array('status' => 'Approve 2');

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_pizin,
                'refrensi'    => 'Izin',
                'kategori'    => 'Batalkan',
                'keterangan'  => 'Menyetujui Izin'
              );

              $approval = array(
                'id_pizin'    => $id_pizin,
                'nik'         => $otorisasi->nik,
                'keterangan'  => 'Approve 2'
              );

              $update = $this->IzinModel->edit($where, $data, $log, $approval, FALSE);

              if(!$update){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengapprove izin'));
              } else {
                $this->pusher->trigger('ums', 'izin', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengapprove izin'));
              }
            }
        }
      }
    }
  }


}

?>
