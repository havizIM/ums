<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Karyawan extends CI_Controller {
  function __construct(){
    parent::__construct();

		$this->load->model('KaryawanModel');
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
            $nik             = $this->input->post('nik');
            $nama            = $this->input->post('nama');
            $tmp_lahir       = $this->input->post('tmp_lahir');
            $tgl_lahir       = $this->input->post('tgl_lahir');
            $kelamin         = $this->input->post('kelamin');
            $status_kawin    = $this->input->post('status_kawin');
            $pendidikan      = $this->input->post('pendidikan');
            $alamat          = $this->input->post('alamat');
            $telepon         = $this->input->post('telepon');
            $tgl_masuk       = $this->input->post('tgl_masuk');
            $status_karyawan = $this->input->post('status_karyawan');
            $jabatan         = $this->input->post('jabatan');
            $id_divisi       = $this->input->post('id_divisi');
            $email           = $this->input->post('email');
            $level           = $this->input->post('level');

            if($nik == null || $nama == null || $tmp_lahir == null || $tgl_lahir == null || $kelamin == null || $status_kawin == null || $pendidikan == null || $alamat == null || $telepon == null || $tgl_masuk == null || $status_karyawan == null || $jabatan == null || $id_divisi == null || $email == null || $level == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

              $karyawan = array(
                'nik'             => $nik,
                'nama'            => $nama,
                'tmp_lahir'       => $tmp_lahir,
                'tgl_lahir'       => $tgl_lahir,
                'kelamin'         => $kelamin,
                'status_kawin'    => $status_kawin,
                'pendidikan'      => $pendidikan,
                'alamat'          => $alamat,
                'telepon'         => $telepon,
                'tgl_masuk'       => $tgl_masuk,
                'status_karyawan' => $status_karyawan,
                'jabatan'         => $jabatan,
                'id_divisi'       => $id_divisi
              );

              $user = array(
                'nik'      => $nik,
                'email'    => $email,
                'password' => $nik,
                'level'    => $level,
                'foto'     => 'user.jpg',
                'token'    => sha1($nama)
              );

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => '-',
                'keterangan'  => 'Menambah Karyawan '.$nik,
                'kategori'    => 'Karyawan'
              );

              $add = $this->KaryawanModel->add($karyawan, $user, $log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data karyawan'));
              } else {
                $options = array(
                  'cluster' => 'ap1',
                  'useTLS' => true
                );
                $pusher = new Pusher\Pusher(
                  '9f324d52d4872168e514',
                  '0bc1f341940046001b79',
                  '752686',
                  $options
                );

                $pusher->trigger('ums', 'karyawan', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data karyawan'));
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

          $nik   = $this->input->get('nik');
          $nama  = $this->input->get('nama');

          $show       = $this->KaryawanModel->show($nik);
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
            $nik = $this->input->get('nik');

            if($nik == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'NIK tidak ditemukan'));
            } else {
              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => '-',
                'keterangan'  => 'Menghapus Karyawan '.$nik,
                'kategori'    => 'Karyawan'
              );

              $delete = $this->KaryawanModel->delete($nik, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus karyawan'));
              } else {
                $options = array(
                  'cluster' => 'ap1',
                  'useTLS' => true
                );
                $pusher = new Pusher\Pusher(
                  '9f324d52d4872168e514',
                  '0bc1f341940046001b79',
                  '752686',
                  $options
                );

                $pusher->trigger('ums', 'karyawan', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus karyawan'));
              }
            }
          }
        }
      }
    }
  }


}

?>
