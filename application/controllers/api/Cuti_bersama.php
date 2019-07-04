<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Cuti_bersama extends CI_Controller {
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

          $otorisasi = $auth->row();

          if($otorisasi->level != 'Admin'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $keterangan        = $this->input->post('keterangan');
            $tgl_cuti_bersama  = $this->input->post('tgl_cuti_bersama');

            if($keterangan == null || $tgl_cuti_bersama == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

              $data = array(
                'keterangan'       => $keterangan,
                'tgl_cuti_bersama' => $tgl_cuti_bersama
              );

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => '-',
                'refrensi'    => 'Cuti bersama',
                'kategori'    => 'Add',
                'keterangan'  => 'Menambahkan jenis cuti bersama'
              );

              $add = $this->CutiBersamaModel->add($data, $log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah cuti bersama'));
              } else {
                $this->pusher->trigger('ums', 'cuti_bersama', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah cuti bersama'));
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

          $where = array(
            'id_cuti_bersama' => $this->input->get('id_cuti_bersama')
          );

          $show             = $this->CutiBersamaModel->show($where, FALSE, FALSE);
          $cuti_bersama     = array();

          foreach($show->result() as $key){
            $json = array();

            $json['id_cuti_bersama']   = $key->id_cuti_bersama;
            $json['keterangan']        = $key->keterangan;
            $json['tgl_cuti_bersama']  = $key->tgl_cuti_bersama;
            $json['tgl_input']         = $key->tgl_input;

            $cuti_bersama[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $cuti_bersama));
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
            $id_cuti_bersama = $this->input->get('id_cuti_bersama');

            if($id_cuti_bersama == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Izin tidak ditemukan'));
            } else {
              $where = array('id_cuti_bersama' => $id_cuti_bersama);

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_cuti_bersama,
                'refrensi'    => 'Cuti Bersama',
                'kategori'    => 'Delete',
                'keterangan'  => 'Menghapus salah satu cuti bersama'
              );

              $delete = $this->CutiBersamaModel->delete($where, $log);

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
  }


}

?>
