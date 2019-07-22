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

    function show($where){


        // return $this->db->query('SELECT 
                                 
        //                          a.tgl_absen, a.jam_masuk, a.jam_keluar,
        //                          b.tanggal_cuti, d.nama_cuti,
        //                          e.tgl_izin, f.keperluan
        
        //                         FROM absensi a
        //                         LEFT OUTER JOIN detail_cuti b ON b.tanggal_cuti = a.tgl_absen
        //                         LEFT JOIN cuti c ON c.id_pcuti = b.id_pcuti AND c.status = "Approve 3"
        //                         LEFT JOIN jenis_cuti d ON d.id_cuti = c.id_cuti
        //                         LEFT OUTER JOIN izin e ON e.tgl_izin = a.tgl_absen AND e.status = "Approve 2"
        //                         LEFT JOIN jenis_izin f ON f.id_izin = e.id_izin 

        //                         WHERE (a.nik = "'.$where['nik'].'" OR c.nik = "'.$where['nik'].'" OR e.nik = "'.$where['nik'].'")
        //                         AND (MONTH(a.tgl_absen) = "'.$where['bulan'].'" OR MONTH(b.tanggal_cuti) = "'.$where['bulan'].'" OR MONTH(e.tgl_izin) = "'.$where['bulan'].'")
        //                         AND (YEAR(a.tgl_absen) = "'.$where['bulan'].'" OR YEAR(b.tanggal_cuti) = "'.$where['bulan'].'" OR YEAR(e.tgl_izin) = "'.$where['bulan'].'")
                                   
        // ');

        return $this->db->query('SELECT 

                                a.nik AS nik_absen, a.tgl_absen, a.jam_masuk, a.jam_keluar,
                                b.tanggal_cuti, d.nama_cuti, c.nik AS nik_cuti,
                                e.tgl_izin, f.keperluan, e.nik AS nik_izin

                                FROM absensi a

                                LEFT JOIN detail_cuti b ON b.tanggal_cuti = a.tgl_absen
                                LEFT JOIN cuti c ON c.id_pcuti = b.id_pcuti AND c.status = "Approve 3"
                                LEFT JOIN jenis_cuti d ON d.id_cuti = c.id_cuti

                                LEFT JOIN izin e ON e.tgl_izin = a.tgl_absen AND e.status = "Approve 2"
                                LEFT JOIN jenis_izin f ON f.id_izin = e.id_izin

                                UNION

                                SELECT 
                                a.nik AS nik_absen, a.tgl_absen, a.jam_masuk, a.jam_keluar,
                                b.tanggal_cuti, d.nama_cuti, c.nik AS nik_cuti,
                                e.tgl_izin, f.keperluan, e.nik AS nik_izin

                                FROM absensi a

                                RIGHT JOIN detail_cuti b ON b.tanggal_cuti = a.tgl_absen
                                RIGHT JOIN cuti c ON c.id_pcuti = b.id_pcuti AND c.status = "Approve 3"
                                RIGHT JOIN jenis_cuti d ON d.id_cuti = c.id_cuti

                                RIGHT JOIN izin e ON e.tgl_izin = a.tgl_absen AND e.status = "Approve 2"
                                RIGHT JOIN jenis_izin f ON f.id_izin = e.id_izin

                                WHERE (a.nik = "'.$where['nik'].'" OR c.nik = "'.$where['nik'].'" OR e.nik = "'.$where['nik'].'")
                                
                                

                                
                                   
        ');
  }


}

?>
