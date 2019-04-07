<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

  function show($token = null){
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

          $show  = $this->LogModel->show($otorisasi->nik);
          $user  = array();

          foreach($show->result() as $key){
            $json = array();

            $json['id_log']     = $key->id_log;
            $json['nik']        = $key->nik;
            $json['nama']       = $key->nama;
            $json['keterangan'] = $key->keterangan;
            $json['id_ref']     = $key->id_ref;
            $json['kategori']   = $key->kategori;
            $json['tgl_log']    = $key->tgl_log;

            $user[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $user));
        }
      }
    }
  }

}

?>
