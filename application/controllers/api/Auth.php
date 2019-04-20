<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Auth extends CI_Controller {

  function __construct()
  {
    parent::__construct();

		$this->load->model('AuthModel');
    $this->load->model('KaryawanModel');
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
              'refrensi'    => 'Auth',
              'kategori'    => 'Login',
              'keterangan'  => 'User login'
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
            'refrensi'    => 'Auth',
            'kategori'    => 'Logout',
            'keterangan'  => 'User logout'
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
                'refrensi'    => 'Auth',
                'kategori'    => 'Change Password',
                'keterangan'  => 'Mengganti password lama menjadi password baru'
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

  function profile($token = null){
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

          $show       = $this->KaryawanModel->show($otorisasi->nik, null);
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

  function edit_profile($token = null){
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
          $nik            = $otorisasi->nik;
          $email          = $this->input->post('email');
          $status_kawin   = $this->input->post('status_kawin');
          $pendidikan     = $this->input->post('pendidikan');
          $alamat         = $this->input->post('alamat');
          $telepon        = $this->input->post('telepon');

          if($email == null || $status_kawin == null || $pendidikan == null || $alamat == null || $telepon == null){
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
          } else {

            $karyawan = array(
              'status_kawin' => $status_kawin,
              'pendidikan'   => $pendidikan,
              'alamat'       => $alamat,
              'telepon'      => $telepon
            );

            $user = array(
              'email'        => $email
            );

            $log = array(
              'nik'         => $nik,
              'id_ref'      => $nik,
              'refrensi'    => 'User',
              'kategori'    => 'Edit',
              'keterangan'  => 'Mengedit Profile Karyawan'
            );

            $edit = $this->KaryawanModel->edit($nik, $karyawan, $user, $log);

            if(!$edit){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data karyawan'));
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
              json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data karyawan'));
            }
          }
        }
      }
    }
  }

}

 ?>
