<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Direksi extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('direksi/main');
  }

  function dashboard()
  {
    $this->load->view('direksi/dashboard');
  }

  function log()
  {
    $this->load->view('direksi/log');
  }

  function profil()
  {
    $this->load->view('direksi/profil');
  }

}
