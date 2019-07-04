<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LampiranCutiModel extends CI_Model {
  function show($where, $like){
        $this->db->select('*')
                 ->from('lampiran_cuti a');

        if(!empty($where)){
            foreach($where as $key => $value){
                if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        if(!empty($like)){
            foreach($where as $key => $value){
                if($value != null){
                    $this->db->like($key, $value);
                }
            }
        }
      
        $this->db->order_by('id_lampiran_cuti', 'desc');
        return $this->db->get();
  }

  function add($data, $log)
  {
    $this->db->trans_start();
    $this->db->insert('lampiran_cuti', $data);
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


  function delete($where, $log)
  {
    $this->db->trans_start();
    $this->db->where($where)->delete('lampiran_cuti');
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
