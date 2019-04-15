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

  function karyawan()
  {
    $this->load->view('admin/karyawan');
  }

  function add_karyawan()
  {
    $this->load->view('admin/add_karyawan');
  }

}
