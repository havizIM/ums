<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class JcutiModel extends CI_Model {
  function show($where){

      $this->db->select('*')->from('jenis_cuti');

      if(!empty($where)){
          foreach($where as $key => $value){
              if($value != null){
                  $this->db->where($key, $value);
              }
          }
      }

      $this->db->order_by('id_cuti', 'desc');
      return $this->db->get();
  }

  function add($data, $log)
  {
    $this->db->trans_start();
    $this->db->insert('jenis_cuti', $data);
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


  function delete($id_cuti, $log)
  {
    $this->db->trans_start();
    $this->db->where('id_cuti', $id_cuti)->delete('jenis_cuti');
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
