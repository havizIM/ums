<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DivisiModel extends CI_Model {
  function show($id_divisi = null){

      $this->db->select('*')->from('divisi');

      if($id_divisi != null){
        $this->db->where('id_divisi', $id_divisi);
      }

      $this->db->order_by('id_divisi', 'desc');
      return $this->db->get();
  }

  function add($data, $log)
  {
    $this->db->trans_start();
    $this->db->insert('divisi', $data);
    $this->db->insert('log', $log);
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }


  function delete($id_divisi, $log)
  {
    $this->db->trans_start();
    $this->db->where('id_divisi', $id_divisi)->delete('divisi');
    $this->db->insert('log', $log);
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return true;
    }
  }

  function by_divisi()
    {
      $this->db->select("b.nama_divisi, COUNT('a.nik') as jml_karyawan");

      $this->db->from("karyawan a");
      $this->db->join("divisi b", "b.id_divisi = a.id_divisi", "left");

      $this->db->group_by("a.id_divisi");
      return $this->db->get();
    }


}

?>
