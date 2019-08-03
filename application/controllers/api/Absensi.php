<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Absensi extends CI_Controller {
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

    $this->load->library('excel');
    $this->load->model('KaryawanModel');
    $this->load->model('AbsensiModel');

    $this->load->model('CutiModel');
    $this->load->model('IzinModel');
    $this->load->model('RevisiModel');
  }

  function preview_absen($token = null){
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
                    if(isset($_FILES['file']['name']) ){
                        $path   = $_FILES['file']['tmp_name'];
                        $object = PHPExcel_IOFactory::load($path);


                        foreach($object->getWorksheetIterator() as $worksheet)
                        {
                            $highestRow = $worksheet->getHighestRow();
                            $highestColumn = $worksheet->getHighestColumn();


                                for($row = 2; $row <= $highestRow; $row++ )
                                {
                                    $check = $this->_check_nik($worksheet->getCellByColumnAndRow(0, $row)->getValue());

                                    if($check != null){
                                        $nik        = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                                        $nama       = $worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue();
                                        $tgl_absen  = $worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue();
                                        $jam_masuk  = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
                                        $jam_keluar = $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue();
                                

                                        $data[] = array(
                                            'nik'         => $nik,
                                            'nama'        => $nama,
                                            'tgl_absen'   => $tgl_absen,
                                            'jam_masuk'   => $jam_masuk,
                                            'jam_keluar'  => $jam_keluar
                                        );
                                    }
                                }
                        }
                        json_output(200, array('status' => 200, 'description' => 'Success', 'message' => 'Berhasil Preview absensi', 'data' => $data));
                    } else {
                        json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Silahkan pilih file yang akan di upload'));
                    }
                }
            }
        }
    }

    function _check_nik($nik) {
        if($nik == null){
            return null;
        } else {
            $where = array('a.nik' => $nik);
            return $this->KaryawanModel->show($where, FALSE)->num_rows();
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
                $absensi        = array();

                $where      = array(
                    'a.nik'   => $this->input->get('nik')
                );

                $karyawan   = $this->KaryawanModel->show($where, FALSE);

                foreach($karyawan->result() as $key){
                    
                    $json['nik']        = $key->nik;
                    $json['bulan']      = $this->input->get('bulan');
                    $json['tahun']      = $this->input->get('tahun');
                    $json['nama']       = $key->nama;
                    $json['jabatan']    = $key->jabatan;
                    $json['divisi']     = $key->nama_divisi;
                    $json['absensi']    = array();

                    $where_ab = array(
                        'nik'   => $key->nik,
                        'bulan' => $this->input->get('bulan'),
                        'tahun' => $this->input->get('tahun'),
                    );

                    $detail = $this->AbsensiModel->show($where_ab);
                    foreach($detail->result() as $key2){
                        $json_a['tgl']      = $key2->tgl;
                        $json_a['mynik']    = $key2->mynik;
                        $json_a['jam_m']    = $key2->jam_m;
                        $json_a['jam_k']    = $key2->jam_k;
                        $json_a['ket_cuti'] = $key2->ket_cuti;
                        $json_a['ket_izin'] = $key2->ket_izin;

                        $json['absensi'][] = $json_a;
                    }
                    
                    $absensi[] = $json;
                }

                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $absensi));
            }
          }
        }
    }

    function import_absen($token = null){
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
                    
                    $otorisasi  = $auth->row();
                    $post       = $this->input->post();

                    if(!isset($post['nik']) && count($post['nik']) < 1){
                        json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Silahkan import ulang absensi'));
                    } else {
                        $data       = array();
                        foreach($post['nik'] as $key => $val){
                            $data[] = array(
                                'nik'             => $post['nik'][$key],
                                'tgl_absen'       => $post['tgl_absen'][$key],
                                'jam_masuk'       => $post['jam_masuk'][$key],
                                'jam_keluar'      => $post['jam_keluar'][$key]
                            );
                        }

                        $log = array(
                            'nik'         => $otorisasi->nik,
                            'id_ref'      => '-',
                            'refrensi'    => 'Import Absensi',
                            'kategori'    => 'Import',
                            'keterangan'  => 'Mengimport Data Absensi'
                        );

                        $add = $this->AbsensiModel->add($data, $log);

                        if(!$add){
                            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal import absensi'));
                        } else {
                            $this->pusher->trigger('ums', 'absensi', $log);
                            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil import absensi'));
                        }
                    }
                    
                }
            }
        }
    }

    function statistic($token = null)
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
                $tahun      = date('Y');

                if($otorisasi->level === 'Kabag'){
                    $id_divisi = $otorisasi->id_divisi;
                } else {
                    $id_divisi = null;
                }

                // echo $id_divisi;

                $cuti       = $this->CutiModel->statistic($tahun, $id_divisi);
                $izin       = $this->IzinModel->statistic($tahun, $id_divisi);
                $revisi     = $this->RevisiModel->statistic($tahun, $id_divisi);

                $jml_cuti     = array("0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0");
                $jml_izin     = array("0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0");
                $jml_revisi   = array("0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0");

                foreach($cuti->result() as $key){
                    $index = $key->bulan - 1;

                    $jml_cuti[$index]   = $key->jml_cuti;
                }

                foreach($izin->result() as $key){
                    $index = $key->bulan - 1;

                    $jml_izin[$index]    = $key->jml_izin;
                }

                foreach($revisi->result() as $key){
                    $index = $key->bulan - 1;

                    $jml_revisi[$index] = $key->jml_revisi;
                }

                $statistic = array(
                    'cuti'    => array(
                        'count'   => $jml_cuti
                    ),
                    'izin'    => array(
                        'count'   => $jml_izin
                    ),
                    'revisi'  => array(
                        'count'   => $jml_revisi
                    )
                );

                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $statistic));
            }
          }
        }
    }

  


}

?>
