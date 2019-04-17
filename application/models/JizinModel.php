<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class JizinModel extends CI_Model {
  function show($id_izin = null){

      $this->db->select('*')->from('jenis_izin');

      if($id_izin != null){
        $this->db->where('id_izin', $id_izin);
      }

      $this->db->order_by('id_izin', 'desc');
      return $this->db->get();
  }

  function add($data, $log)
  {
    $this->db->trans_start();
    $this->db->insert('jenis_izin', $data);
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


  function delete($id_izin, $log)
  {
    $this->db->trans_start();
    $this->db->where('id_izin', $id_izin)->delete('jenis_izin');
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


}

?>
