<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CutiBersamaModel extends CI_Model {
  function show($where, $like, $between){
        $this->db->select('*')
                 ->from('cuti_bersama');

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
      
        $this->db->order_by('tgl_input', 'desc');
        return $this->db->get();
  }

  function add($data, $log)
  {
    $this->db->trans_start();
    $this->db->insert('cuti_bersama', $data);
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
    $this->db->where($where)->delete('cuti_bersama');
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
