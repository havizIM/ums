<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kabag extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('kabag/main');
  }

  function dashboard()
  {
    $this->load->view('kabag/dashboard');
  }

  function log()
  {
    $this->load->view('kabag/log');
  }

  function profil()
  {
    $this->load->view('kabag/profil');
  }

  function approval_cuti($id = null){
    if($id == null){
       $this->load->view('kabag/approval_cuti');
    } else {
       $this->load->view('kabag/detail_approval_cuti');
    }
  }

  function approval_izin($id = null){
    if($id == null){
       $this->load->view('kabag/approval_izin');
    } else {
       $this->load->view('kabag/detail_approval_izin');
    }
  }

  function approval_revisi($id = null){
    if($id == null){
       $this->load->view('kabag/approval_revisi');
    } else {
       $this->load->view('kabag/detail_approval_revisi');
    }
  }

  function cetak_absensi()
  {
    $this->load->view('kabag/cetak_absensi');
  }

}
