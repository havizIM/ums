<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('admin/main');
  }

  function dashboard()
  {
    $this->load->view('admin/dashboard');
  }

  function log()
  {
    $this->load->view('admin/log');
  }

  function divisi()
  {
    $this->load->view('admin/divisi');
  }

  function karyawan($id = null)
  {
    if($id == null){
      $this->load->view('admin/karyawan');
    } else {
      $this->load->view('admin/detail_karyawan');
    }
  }

  function add_karyawan()
  {
    $this->load->view('admin/add_karyawan');
  }

  function master_izin()
  {
    $this->load->view('admin/master_izin');
  }

  function master_cuti()
  {
    $this->load->view('admin/master_cuti');
  }

  function master_cuti_bersama()
  {
    $this->load->view('admin/master_cuti_bersama');
  }

  function edit_karyawan($id)
  {
    $this->load->view('admin/edit_karyawan');
  }

  function profil()
  {
    $this->load->view('admin/profil');
  }

  function cuti($id = null)
  {
    if($id == null){
       $this->load->view('admin/cuti');
    } else {
       $this->load->view('admin/detail_cuti');
    }
  }

  function add_cuti()
  {
    $this->load->view('admin/add_cuti');
  }

  function edit_cuti()
  {
    $this->load->view('admin/edit_cuti');
  }

  function izin($id = null)
  {
    if($id == null){
       $this->load->view('admin/izin');
    } else {
       $this->load->view('admin/detail_izin');
    }
  }

  function add_izin()
  {
    $this->load->view('admin/add_izin');
  }

  function edit_izin()
  {
    $this->load->view('admin/edit_izin');
  }

  function revisi_absen($id = null)
  {
    if($id == null){
       $this->load->view('admin/revisi_absen');
    } else {
       $this->load->view('admin/detail_revisi');
    }
  }

  function add_revisi()
  {
    $this->load->view('admin/add_revisi');
  }

  function edit_revisi()
  {
    $this->load->view('admin/edit_revisi');
  }

  function approval_pengganti($id = null)
  {
    if($id == null){
       $this->load->view('admin/approval_pengganti');
    } else {
       $this->load->view('admin/detail_approval_pengganti');
    }
  }

  function cetak_absensi()
  {
    $this->load->view('admin/cetak_absensi');
  }

  function import_absensi()
  {
    $this->load->view('admin/import_absensi');
  }

}
