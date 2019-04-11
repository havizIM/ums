<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Auth extends CI_Controller {

  function __construct()
  {
    parent::__construct();

		$this->load->model('AuthModel');
  }

  function login_user()
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if($method != 'POST') {
      json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah' ));
    } else {

      $nik      = $this->input->post('nik');
      $password = $this->input->post('password');

      if($nik == null || $password == null) {
        json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'NIP dan Password belum lengkap' ));
      } else {
        $user   = $this->AuthModel->loginUser($nik);

        if($user->num_rows() == 0){
          json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'NIP tidak ditemukan' ));
        } else {
          foreach($user->result() as $key){
            $db_password      = $key->password;
            $status_karyawan  = $key->status_karyawan;
            $level            = strtolower($key->level);

            $session = array(
              'nik'            => $key->nik,
              'nama_user'      => $key->nama,
              'tgl_registrasi' => $key->tgl_registrasi,
              'foto'           => $key->foto,
              'level'          => $level,
              'token'          => $key->token,
              'jabatan'        => $key->jabatan,
              'divisi'         => $key->nama_divisi
            );

            $log = array(
              'nik'         => $key->nik,
              'id_ref'      => '-',
              'keterangan'  => 'User login',
              'kategori'    => 'Login'
            );
          }

          if(hash_equals($password, $db_password)){
            if($status_karyawan != 'Aktif'){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'User sudah tidak aktif' ));
            } else {

              $add = $this->LogModel->add($log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal melakukan login' ));
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

                $pusher->trigger('ums', 'log', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil melakukan login', 'data' => $session ));
              }
            }
          } else {
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Password salah' ));
          }
        }
      }
    }
  }

  function logout_user($token = null)
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if($method != 'GET') {
      json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah' ));
    } else {
      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {
          $otorisasi = $auth->row();

          $log = array(
            'nik'         => $otorisasi->nik,
            'id_ref'      => '-',
            'keterangan'  => 'User login',
            'kategori'    => 'Login'
          );

          $add = $this->LogModel->add($log);

          if(!$add){
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal Logout'));
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

            $pusher->trigger('ums', 'log', $log);
            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil logout'));
          }
        }
      }
    }
  }

  function password_user($token = null)
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if($method != 'POST') {
      json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah' ));
    } else {
      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {
          $otorisasi = $auth->row();

          $db_password  = $otorisasi->password;
          $old_password = $this->input->post('password_lama');
          $new_password = $this->input->post('password_baru');

          if($old_password == null || $new_password == null){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
          } else {
            if($old_password != $db_password){
              json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Password lama salah'));
            } else {

              $data = array(
                'password' => $new_password
              );

              $log = array(
                'nik'         => $otorisasi->nik,
                'id_ref'      => '-',
                'keterangan'  => 'Mengganti password lama menjadi password baru',
                'kategori'    => 'Ganti Password'
              );

              $pass = $this->AuthModel->gantiPass($otorisasi->nik, $data, $log);

              if(!$pass){
                json_output(500, array('status' => 500, 'description' => 'Gagal', 'message' => 'Gagal mengganti password'));
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

                $pusher->trigger('ums', 'log', $log);
                json_output(200, array('status' => 200, 'description' => 'Gagal', 'message' => 'Berhasil mengganti password'));
              }
            }
          }
        }
      }
    }
  }

}

 ?>
