<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RevisiModel extends CI_Model {
  function show($where, $like, $between){
        $this->db->select('a.*')
                 ->select('b.nama as nama_pemohon, b.jabatan as jabatan_pemohon')
                 ->select('c.id_divisi, c.nama_divisi as divisi_pemohon')

                 ->from('revisi_absen a')
                 ->join('karyawan b', 'b.nik = a.nik')
                 ->join('divisi c', 'c.id_divisi = b.id_divisi');

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

        if(!empty($between)){
            $this->db->where("tgl_input BETWEEN '$between[tgl_awal]' AND '$between[tgl_akhir]'");
        }
      
        $this->db->order_by('tgl_input', 'desc');
        return $this->db->get();
  }

  function add($data, $log)
  {
    $this->db->trans_start();
    $this->db->insert('revisi_absen', $data);
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


  function edit($where, $data, $log)
  {
    $this->db->trans_start();
    $this->db->where($where)->update('revisi_absen', $data);
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
