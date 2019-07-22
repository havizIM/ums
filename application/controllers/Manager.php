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

  function log()
  {
    $this->load->view('manager/log');
  }

  function profil()
  {
    $this->load->view('manager/profil');
  }

  function cuti($id = null)
  {
    if($id == null){
       $this->load->view('manager/cuti');
    } else {
       $this->load->view('manager/detail_cuti');
    }
  }

  function add_cuti()
  {
    $this->load->view('manager/add_cuti');
  }

  function edit_cuti($id = null)
  {
    $this->load->view('manager/edit_cuti');
  }

  function approval_pengganti($id = null)
  {
    if($id == null){
       $this->load->view('manager/approval_pengganti');
    } else {
       $this->load->view('manager/detail_approval_pengganti');
    }
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

  function absensi()
  {
    $this->load->view('manager/absensi');
  }

}
