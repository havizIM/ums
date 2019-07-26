<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AbsensiModel extends CI_Model {
  
    function add($data, $log)
    {
        $this->db->trans_start();
        $this->db->insert_batch('absensi', $data);
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

    function check($where){
        return $this->db->select('*')
                    ->from('absensi')
                    ->where($where)
                    ->get();
    }

    function show($where){
        $query = 'SELECT x.tgl, x.mynik, x.jam_m, x.jam_k, x.ket_cuti, x.ket_izin
                  FROM (
                            SELECT 
                                tgl_absen as tgl, nik as mynik, jam_masuk as jam_m, jam_keluar as jam_k, "-" as ket_cuti, "-" as ket_izin
                            FROM absensi

                      UNION ALL

                            SELECT 
                                a.tanggal_cuti as tgl, b.nik as mynik, "-" as jam_m, "-" as jam_k, c.nama_cuti as ket_cuti, "-" as ket_izin
                            FROM detail_cuti a
                            LEFT JOIN cuti b ON b.id_pcuti = a.id_pcuti
                            LEFT JOIN jenis_cuti c ON c.id_cuti = b.id_cuti

                      UNION ALL
                            SELECT
                                tgl_izin as tgl, nik as mynik, "-" as jam_m, "-" as jam_k, "-" as ket_cuti, keperluan as ket_izin
                            FROM izin d
                            LEFT JOIN jenis_izin e ON e.id_izin = d.id_izin

                      UNION ALL 
                            SELECT
                                tgl_cuti_bersama as tgl, "-" as mynik, "-" as jam_m, "-" as jam_k, keterangan as ket_cuti, "-" as ket_izin
                            FROM cuti_bersama
                  ) as x
                  WHERE mynik = '.$where['nik'].' AND YEAR(tgl) = '.$where['tahun'].' AND MONTH(tgl) = '.$where['bulan'].'
                  ORDER BY x.tgl
        ';
        return $this->db->query($query);
      
  }


}

?>
