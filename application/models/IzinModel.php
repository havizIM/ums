<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class IzinModel extends CI_Model {
  function show($where, $like, $between){
        $this->db->select('a.*')
                 ->select('b.keperluan, b.keterangan_izin')
                 ->select('c.nama as nama_pemohon, c.jabatan as jabatan_pemohon')
                 ->select('d.id_divisi, d.nama_divisi as divisi_pemohon')

                 ->from('izin a')
                 ->join('jenis_izin b', 'b.id_izin = a.id_izin')
                 ->join('karyawan c', 'c.nik = a.nik')
                 ->join('divisi d', 'd.id_divisi = c.id_divisi');

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

  function add($data, $log, $lampiran)
  {
    $this->db->trans_start();
    $this->db->insert('izin', $data);
    $this->db->insert('log', $log);

    if(!empty($lampiran)){
        $this->db->insert('lampiran_izin', $lampiran);
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


  function edit($where, $data, $log, $approval, $lampiran)
  {
    $this->db->trans_start();
    $this->db->where($where)->update('izin', $data);
    $this->db->insert('log', $log);

    if(!empty($lampiran)){
        $this->db->where($where)->update('lampiran_izin', $lampiran);
    }

    if(!empty($approval)){
            $this->db->insert('approval_izin', $approval);
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
