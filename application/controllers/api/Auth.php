<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Auth extends CI_Controller {

  function __construct()
  {
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
              'kelamin'        => $key->kelamin,
              'foto'           => $key->foto,
              'level'          => $level,
              'token'          => $key->token,
              'jabatan'        => $key->jabatan,
              'id_divisi'      => $key->id_divisi,
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
                $this->pusher->trigger('ums', 'log', $log);
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
            $this->pusher->trigger('ums', 'log', $log);
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
                $this->pusher->trigger('ums', 'log', $log);
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
          $where = array(
            'a.nik' => $otorisasi->nik
          );

          $show       = $this->KaryawanModel->show($where, FALSE);
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
              'kategori'    => 'Ubah',
              'keterangan'  => 'Mengubah Profile Karyawan'
            );

            $edit = $this->KaryawanModel->edit($nik, $karyawan, $user, $log);

            if(!$edit){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengubah data karyawan'));
            } else {
              $this->pusher->trigger('ums', 'karyawan', $log);
              json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengubah data karyawan'));
            }
          }
        }
      }
    }
  }

  function lupa_password(){
    $method = $_SERVER['REQUEST_METHOD'];

    if($method != 'POST') {
      json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah' ));
    } else {
      $email            = $this->input->post('email');
			$new_password     = substr(str_shuffle("01234567890abcdefghijklmnopqestuvwxyz"), 0, 5);

      if($email == null){
        json_output(400, array('status' => 400, 'description' => 'Failed', 'message' => 'Email tidak boleh kosong' ));
      } else {
        $param    = array('a.email' => $email);
        $karyawan = $this->AuthModel->cekOtorisasi($param);

        if($karyawan->num_rows() != 1){
  				json_output(400, array('status' => 400, 'description' => 'Failed', 'message' => 'Email tidak ditemukan' ));
  			} else {

          $otorisasi = $karyawan->row();

          $data_email = array(
            'nama'            => $otorisasi->nama,
            'password'        => $new_password
          );

          /* ---------- Setting Email Offline ------------- */
          // $config = array(
          //   'charset'   => 'utf-8',
          //   'wordwrap'  => TRUE,
          //   'mailtype'  => 'html',
          //   'protocol'  => 'smtp',
          //   'smtp_host' => 'ssl://smtp.gmail.com',
          //   'smtp_user' => 'adm.titan001@gmail.com',
          //   'smtp_pass' => 'cintaku1',
          //   'smtp_port' => 465,
          //   'crlf'      => "\r\n",
          //   'newline'   => "\r\n"
          // );

          // $this->load->library('email');

          // $this->email->initialize($config);
          // $this->email->from('adm.titan001@gmail.com', 'Admin SIPPK');
          // $this->email->to($email_perusahaan);
          // $this->email->subject('Reset Password Akun SIPPK');
          // $this->email->message($template);
          /* -------------- Setting Email Offline --------------- */

          /* ----------------- Setting Email Online ---------------------- */
          $this->load->library('email');

          $config = array(
              'protocol'  => 'smtp',
              'smtp_host' => 'ssl://smtp.googlemail.com',
              'smtp_port' => 465,
              'smtp_user' => 'adm.titan001@gmail.com',
              'smtp_pass' => 'cintaku1',
              'mailtype'  => 'html',
              'charset'   => 'utf-8'
          );
          $this->email->initialize($config);
          $this->email->set_mailtype("html");
          $this->email->set_newline("\r\n");

          $template = $this->load->view('email/lupa_password', $data_email, TRUE);

          $this->email->to($otorisasi->email);
          $this->email->from('umsosella@gmail.com','SIPACAR');
          $this->email->subject('Reset Password Akun SIPACAR');
          $this->email->message($template);
          /* ---------------- Setting Email Online ------------------- */

          /* ----------------- New Setting ------------------------ */
          // $this->load->library('email');

          // $this->email->set_newline("\r\n");

          // $config['protocol'] = 'smtp';
          // $config['smtp_host'] = 'smtp.gmail.com';
          // $config['smtp_port'] = '587';
          // $config['smtp_user'] = 'adm.titan001@gmail.com';
          // $config['smtp_from_name'] = 'Admin Titan Group';
          // $config['smtp_pass'] = 'cintaku1';
          // $config['wordwrap'] = TRUE;
          // $config['newline'] = "\r\n";
          // $config['mailtype'] = 'html';                       

          // $this->email->initialize($config);

          // $this->email->from('adm.titan001@gmail.com', 'Admin SIPPK');
          // $this->email->to($email_perusahaan);
          // $this->email->subject('Reset Password Akun SIPPK');
          // $this->email->message($template);

        /* ----------------- New Setting ------------------------ */

          $send = $this->email->send();
          
          if (!$send) {
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Tidak dapat mengirim email'));
          } else {
            $param2    = array('email' => $email);
            $data      = array(
              'password' => $new_password
            );

            $update = $this->AuthModel->resetPass($param2, $data);

            if(!$update){
							json_output(400, array('status' => 400, 'description' => 'Failed', 'message' => 'Gagal melakukan reset password' ));
						} else {
							json_output(200, array('status' => 200, 'description' => 'Success', 'message' => 'Berhasil melakukan reset password. Silahkan cek email anda untuk mendapatkan password baru'));
						}
          }
        }
      }
    }
  }

}

 ?>
