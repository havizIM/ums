<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Divisi extends CI_Controller {
  function __construct(){
    parent::__construct();

		$this->load->model('DivisiModel');
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
            $id_divisi    = $this->KodeModel->buatKode('divisi', 'DV', 'id_divisi', 4);
            $nama_divisi  = $this->input->post('nama_divisi');

            if($nama_divisi == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

              $data = array(
                'id_divisi'   => $id_divisi,
                'nama_divisi' => $nama_divisi
              );

              $log = array(
                'nik'        => $otorisasi->nik,
                'keterangan'  => 'Menambah Divisi '.$id_divisi,
                'kategori'    => 'Divisi'
              );

              $add = $this->DivisiModel->add($data, $log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data divisi'));
              } else {
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data divisi'));
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

          $otorisasi  = $auth->row();
          $id_divisi  = $this->input->get('id_divisi');
          $show       = $this->DivisiModel->show($id_user);
          $divisi     = array();

          foreach($show->result() as $key){
            $json = array();

            $json['id_divisi']   = $key->id_divisi;
            $json['nama_divisi']  = $key->nama_divisi;

            $divisi[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $divisi));
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
            $id_divisi = $this->input->get('id_divisi');

            if($id_divisi == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Divisi tidak ditemukan'));
            } else {
              $log = array(
                'nik'         => $otorisasi->nik,
                'keterangan'  => 'Menghapus Divisi '.$id_divisi,
                'kategori'    => 'Divisi'
              );

              $delete = $this->DivisiModel->delete($id_divisi, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus divisi'));
              } else {
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus divisi'));
              }
            }
          }
        }
      }
    }
  }


}

?>