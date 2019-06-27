<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CutiModel extends CI_Model {
  function show($where, $like, $between){
        $this->db->select('a.*')
                 ->select('b.nama_cuti, b.keterangan')
                 ->select('c.nama as nama_pemohon, c.jabatan as jabatan_pemohon')
                 ->select('d.id_divisi, d.nama_divisi as divisi_pemohon')
                 ->select('e.nama as nama_pengganti, c.jabatan as jabatan_pengganti')
                 ->select('f.id_divisi as idd_divisi, f.nama_divisi as divisi_pengganti')

                 ->from('cuti a')
                 ->join('jenis_cuti b', 'b.id_cuti = a.id_cuti')
                 ->join('karyawan c', 'c.nik = a.nik')
                 ->join('divisi d', 'd.id_divisi = c.id_divisi')
                 ->join('karyawan e', 'e.nik = a.pengganti')
                 ->join('divisi f', 'f.id_divisi = e.id_divisi');

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
    $this->db->insert('cuti', $data);
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

  function edit($where, $data, $log, $approval)
  {
    $this->db->trans_start();
    $this->db->where($where)->update('cuti', $data);
    $this->db->insert('log', $log);

    if(!empty($approval)){
        $this->db->insert('approval_cuti', $approval);
    }

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
