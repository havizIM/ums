<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ApprovalRevisiModel extends CI_Model {
  function show($where, $like, $between){
        $this->db->select('a.*')
                 ->select('b.nama, b.jabatan')
                 ->select('c.nama_divisi')

                 ->from('approval_absen a')
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
            $this->db->where("tgl_approve BETWEEN '$between[tgl_awal]' AND '$between[tgl_akhir]'");
        }
      
        $this->db->order_by('tgl_approve', 'desc');
        return $this->db->get();
  }


}

?>
