<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CutiModel extends CI_Model {
  function show($where, $like, $between){
        $this->db->select('a.*')
                 ->select('b.nama_cuti, b.keterangan, b.lampiran')
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

  function total_cuti($where1, $where2){
    $this->db->select('*')
             ->select('(SELECT SUM(jumlah_cuti) FROM cuti WHERE id_cuti = jenis_cuti.id_cuti AND nik = "'.$where2['nik'].'" AND (YEAR(tgl_mulai) = "'.$where2['tahun'].'" AND YEAR(tgl_selesai) = "'.$where2['tahun'].'") AND status = "'.$where2['status'].'") as total_cuti')

             ->from('jenis_cuti');


    if(!empty($where1)){
            foreach($where1 as $key => $value){
                if($value != null){
                    $this->db->where($key, $value);
                }
            }
        }

    return $this->db->get();

  }

  function add($data, $log, $detail)
  {
    $this->db->trans_start();
    $this->db->insert('cuti', $data);
    $this->db->insert('log', $log);

    if(!empty($detail)){
        $this->db->insert_batch('detail_cuti', $detail);
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

  function edit($where, $data, $log, $approval, $detail)
  {
    $this->db->trans_start();
    $this->db->where($where)->update('cuti', $data);
    $this->db->insert('log', $log);

    if(!empty($approval)){
        $this->db->insert('approval_cuti', $approval);
    }

    if(!empty($detail)){
        $this->db->where($where)->delete('detail_cuti');
        $this->db->insert_batch('detail_cuti', $detail);
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
