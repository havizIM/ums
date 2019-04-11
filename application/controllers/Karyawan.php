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

}
