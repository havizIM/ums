<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Karyawan extends CI_Controller {
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

              $foto = $this->upload_file('foto', $nik);

              if($foto === null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'File gagal diupload'));
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
                  'foto'     => $foto,
                  'token'    => sha1($nama)
                );

                $log = array(
                  'nik'         => $otorisasi->nik,
                  'id_ref'      => $nik,
                  'refrensi'    => 'Karyawan',
                  'kategori'    => 'Add',
                  'keterangan'  => 'Menambah Karyawan Baru'
                );

                $add = $this->KaryawanModel->add($karyawan, $user, $log);

                if(!$add){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data karyawan'));
                } else {
                  $this->pusher->trigger('ums', 'karyawan', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data karyawan'));
                }
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

          $where  = array(
            'a.nik'       => $this->input->get('nik'),
            'a.id_divisi' => $this->input->get('id_divisi')
          );

          $like   = array(
            'a.nama' => $this->input->get('nama')
          );

          $show       = $this->KaryawanModel->show($where, $like);
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
                'id_ref'      => $nik,
                'refrensi'    => 'Karyawan',
                'kategori'    => 'Delete',
                'keterangan'  => 'Menghapus data karyawan'
              );

              $delete = $this->KaryawanModel->delete($nik, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus karyawan'));
              } else {
                $this->pusher->trigger('ums', 'karyawan', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus karyawan'));
              }
            }
          }
        }
      }
    }
  }

  function edit($token = null){
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
            $nik             = $this->input->get('nik');
            $nama            = $this->input->post('nama');
            $tmp_lahir       = $this->input->post('tmp_lahir');
            $tgl_lahir       = $this->input->post('tgl_lahir');
            $kelamin         = $this->input->post('kelamin');
            $tgl_masuk       = $this->input->post('tgl_masuk');
            $status_karyawan = $this->input->post('status_karyawan');
            $jabatan         = $this->input->post('jabatan');
            $id_divisi       = $this->input->post('id_divisi');
            $level           = $this->input->post('level');

            if($nik == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'NIK tidak ditemukan'));
            } else {
              if($nama == null || $tmp_lahir == null || $tgl_lahir == null || $kelamin == null || $tgl_masuk == null || $status_karyawan == null || $jabatan == null || $id_divisi == null || $level == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {

                $karyawan = array(
                  'nama'            => $nama,
                  'tmp_lahir'       => $tmp_lahir,
                  'tgl_lahir'       => $tgl_lahir,
                  'kelamin'         => $kelamin,
                  'tgl_masuk'       => $tgl_masuk,
                  'status_karyawan' => $status_karyawan,
                  'jabatan'         => $jabatan,
                  'id_divisi'       => $id_divisi
                );

                $user = array(
                  'level'    => $level
                );

                $foto = $this->upload_file('foto', $nik);
                if($foto !== null){
                    $user['foto'] = $foto;
                }

                $log = array(
                  'nik'         => $otorisasi->nik,
                  'id_ref'      => $nik,
                  'refrensi'    => 'Karyawan',
                  'kategori'    => 'Edit',
                  'keterangan'  => 'Mengirim Karyawan Baru'
                );

                $edit = $this->KaryawanModel->edit($nik, $karyawan, $user, $log);

                if(!$edit){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data karyawan'));
                } else {
                  $this->pusher->trigger('ums', 'karyawan', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data karyawan'));
                }
              }
            }
          }
        }
      }
    }
  }

  function upload_file($name, $id)
  {
    if(isset($_FILES[$name]) && $_FILES[$name]['name'] != ""){
      $files = glob('doc/'.$name.'/'.$id.'.*');
      foreach ($files as $key) {
        unlink($key);
      }

      $config['upload_path']   = './doc/'.$name.'/';
      $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
      $config['overwrite']     = TRUE;
			$config['max_size']      = '3048';
			$config['remove_space']  = TRUE;
			$config['file_name']     = $id;

      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      if(!$this->upload->do_upload($name)){
        return null;
      } else {
        $file = $this->upload->data();
        return $file['file_name'];
      }
    } else {
      return null;
    }
  }

  /* ------------------------------ Delete File ----------------------------- */
  function delete_file($name, $id){
    $files = glob('doc/'.$name.'/'.$id.'.*');
    foreach ($files as $key) {
      unlink($key);
    }
  }


}

?>
