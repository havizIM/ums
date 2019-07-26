<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('manager/main');
  }

  function dashboard()
  {
    $this->load->view('manager/dashboard');
  }

  function approval_cuti($id = null){
    if($id == null){
       $this->load->view('manager/approval_cuti');
    } else {
       $this->load->view('manager/detail_approval_cuti');
    }
  }

  function approval_izin($id = null){
    if($id == null){
       $this->load->view('manager/approval_izin');
    } else {
       $this->load->view('manager/detail_approval_izin');
    }
  }

  function approval_revisi($id = null){
    if($id == null){
       $this->load->view('manager/approval_revisi');
    } else {
       $this->load->view('manager/detail_approval_revisi');
    }
  }

  function log()
  {
    $this->load->view('manager/log');
  }

  function cetak_absensi()
  {
    $this->load->view('manager/cetak_absensi');
  }

  function laporan_cuti()
  {
    $this->load->view('manager/laporan_cuti');
  }

  function laporan_izin()
  {
    $this->load->view('manager/laporan_izin');
  }

  function laporan_revisi()
  {
    $this->load->view('manager/laporan_revisi');
  }

  function profil()
  {
    $this->load->view('manager/profil');
  }

}
