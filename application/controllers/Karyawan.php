<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('karyawan/main');
  }

  function dashboard()
  {
    $this->load->view('karyawan/dashboard');
  }

  function log()
  {
    $this->load->view('karyawan/log');
  }

  function profil()
  {
    $this->load->view('karyawan/profil');
  }

  function cuti($id = null)
  {
    if($id == null){
       $this->load->view('karyawan/cuti');
    } else {
       $this->load->view('karyawan/detail_cuti');
    }
  }

  function add_cuti()
  {
    $this->load->view('karyawan/add_cuti');
  }

  function edit_cuti($id = null)
  {
    $this->load->view('karyawan/edit_cuti');
  }

  function izin($id = null)
  {
    if($id == null){
       $this->load->view('karyawan/izin');
    } else {
       $this->load->view('karyawan/detail_izin');
    }
  }

  function add_izin()
  {
    $this->load->view('karyawan/add_izin');
  }

  function edit_izin($id = null)
  {
    $this->load->view('karyawan/edit_izin');
  }

  function revisi_absen($id = null)
  {
    if($id == null){
       $this->load->view('karyawan/revisi_absen');
    } else {
       $this->load->view('karyawan/detail_revisi');
    }
  }

  function add_revisi()
  {
    $this->load->view('karyawan/add_revisi');
  }

  function edit_revisi($id = null)
  {
    $this->load->view('karyawan/edit_revisi');
  }

  function approval_pengganti($id = null)
  {
    if($id == null){
       $this->load->view('karyawan/approval_pengganti');
    } else {
       $this->load->view('karyawan/detail_approval_pengganti');
    }
  }

  function cetak_absensi()
  {
    $this->load->view('karyawan/cetak_absensi');
  }
}
