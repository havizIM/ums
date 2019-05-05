<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Jenis_izin extends CI_Controller {
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

		$this->load->model('JizinModel');
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

          $otorisasi = $auth->row();

          if($otorisasi->level != 'Admin'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_izin          = $this->KodeModel->buatKode('jenis_izin', 'I', 'id_izin', 4);
            $keperluan        = $this->input->post('keperluan');
            $keterangan_izin  = $this->input->post('keterangan_izin');

            if($keperluan == null || $keterangan_izin == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

              $data = array(
                'id_izin'         => $id_izin,
                'keperluan'       => $keperluan,
                'keterangan_izin' => $keterangan_izin
              );

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_izin,
                'refrensi'    => 'Jenis Izin',
                'kategori'    => 'Add',
                'keterangan'  => 'Menambahkan jenis izin baru'
              );

              $add = $this->JizinModel->add($data, $log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah jenis izin'));
              } else {
                $this->pusher->trigger('ums', 'jenis_izin', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah jenis izin'));
              }
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

          $otorisasi      = $auth->row();
          $id_izin        = $this->input->get('id_izin');
          $show           = $this->JizinModel->show($id_izin);
          $jenis_izin     = array();

          foreach($show->result() as $key){
            $json = array();

            $json['id_izin']          = $key->id_izin;
            $json['keperluan']        = $key->keperluan;
            $json['keterangan_izin']  = $key->keterangan_izin;

            $jenis_izin[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $jenis_izin));
        }
      }
    }
  }

  public function delete($token = null){
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

          if($otorisasi->level != 'Admin'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_izin = $this->input->get('id_izin');

            if($id_izin == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Izin tidak ditemukan'));
            } else {
              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_izin,
                'refrensi'    => 'Jenis Izin',
                'kategori'    => 'Delete',
                'keterangan'  => 'Menghapus salah satu jenis izin'
              );

              $delete = $this->JizinModel->delete($id_izin, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus jenis izin'));
              } else {
                $this->pusher->trigger('ums', 'jenis_izin', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus jenis izin'));
              }
            }
          }
        }
      }
    }
  }


}

?>
