<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Jenis_cuti extends CI_Controller {
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

		$this->load->model('JcutiModel');
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
            $id_cuti          = $this->KodeModel->buatKode('jenis_cuti', 'C', 'id_cuti', 4);
            $nama_cuti        = $this->input->post('nama_cuti');
            $banyak_cuti      = $this->input->post('banyak_cuti');
            $lampiran         = $this->input->post('lampiran');
            $keterangan       = $this->input->post('keterangan');

            if($nama_cuti == null || $keterangan == null || $banyak_cuti == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

              $data = array(
                'id_cuti'         => $id_cuti,
                'nama_cuti'       => $nama_cuti,
                'banyak_cuti'     => $banyak_cuti,
                'lampiran'        => $lampiran,
                'keterangan'      => $keterangan
              );

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_cuti,
                'refrensi'    => 'Jenis Cuti',
                'kategori'    => 'Add',
                'keterangan'  => 'Menambahkan jenis cuti baru'
              );

              $add = $this->JcutiModel->add($data, $log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah jenis cuti'));
              } else {
                $this->pusher->trigger('ums', 'jenis_cuti', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah jenis cuti'));
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
            'id_cuti'    => $this->input->get('id_cuti')
          );

          $show           = $this->JcutiModel->show($where);
          $jenis_cuti     = array();

          foreach($show->result() as $key){
            $json = array();

            $json['id_cuti']      = $key->id_cuti;
            $json['nama_cuti']    = $key->nama_cuti;
            $json['banyak_cuti']  = $key->banyak_cuti;
            $json['lampiran']  = $key->lampiran;
            $json['keterangan']   = $key->keterangan;

            $jenis_cuti[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $jenis_cuti));
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
            $id_cuti = $this->input->get('id_cuti');

            if($id_cuti == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Cuti tidak ditemukan'));
            } else {
              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => $id_cuti,
                'refrensi'    => 'Jenis Cuti',
                'kategori'    => 'Hapus',
                'keterangan'  => 'Menghapus salah satu jenis cuti'
              );

              $delete = $this->JcutiModel->delete($id_cuti, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus jenis cuti'));
              } else {
                $this->pusher->trigger('ums', 'jenis_cuti', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus jenis cuti'));
              }
            }
          }
        }
      }
    }
  }


}

?>
