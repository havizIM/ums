<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LogModel extends CI_Model {

    function add($data)
    {
      return $this->db->insert('log', $data);
    }

    function show($nik)
    {
      return $this->db->select('*')
                      ->from('log a')
                      ->join('user b', 'b.nik = a.nik', 'left')
                      ->join('karyawan c', 'c.nik = b.nik', 'left')
                      ->where('a.nik', $nik)
                      ->get();
    }

}

?>
