<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {

    function loginUser($nik)
    {
      return $this->db->select('*')
                      ->from('user a')
                      ->join('karyawan b', 'b.nik = a.nik', 'left')
                      ->join('divisi c', 'c.id_divisi = b.id_divisi', 'left')
                      ->where('a.nik', $nik)
                      ->get();
    }

    function cekAuth($token)
    {
      return $this->db->select('*')
                      ->from('user a')
                      ->join('karyawan b', 'b.nik = a.nik', 'left')
                      ->join('divisi c', 'c.id_divisi = b.id_divisi', 'left')
                      ->where('a.token', $token)
                      ->get();
    }

    function cekOtorisasi($where)
    {
      $this->db->select('*')
              ->from('user a')
              ->join('karyawan b', 'b.nik = a.nik', 'left')
              ->join('divisi c', 'c.id_divisi = b.id_divisi', 'left');

      if(!empty($where)){
            foreach($where as $key => $value){
                if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

      return $this->db->get();
    }

    function gantiPass($param, $data, $log)
    {
      $this->db->trans_start();
      $this->db->where('nik', $param)->update('user', $data);
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

    function resetPass($param, $data)
    {
      $this->db->trans_start();
      $this->db->where($param)->update('user', $data);
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
