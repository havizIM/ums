<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class KaryawanModel extends CI_Model {
  function show($where, $like){

      $this->db->select('*')->from('karyawan a')->join('user b', 'b.nik = a.nik')->join('divisi c', 'c.id_divisi = a.id_divisi');

     if(!empty($where)){
            foreach($where as $key => $value){
                if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

        if(!empty($like)){
            foreach($like as $key => $value){
                if($value != null){
                    $this->db->like($key, $value);
                }
            }
        }

      $this->db->order_by('b.tgl_registrasi', 'desc');
      return $this->db->get();
  }

  function add($karyawan, $user, $log)
  {
    $this->db->trans_start();
    $this->db->insert('karyawan', $karyawan);
    $this->db->insert('user', $user);
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

  function delete($nik, $log)
  {
    $this->db->trans_start();
    $this->db->where('nik', $nik)->delete('user');
    $this->db->where('nik', $nik)->delete('karyawan');
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

  function edit($nik, $karyawan, $user, $log)
  {
    $this->db->trans_start();
    $this->db->where('nik', $nik)->update('karyawan', $karyawan);
    $this->db->where('nik', $nik)->update('user', $user);
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
