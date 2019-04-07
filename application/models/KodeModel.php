<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class KodeModel extends CI_Model
  {

    function buatKode($tabel, $inisial, $field, $panjang)
    {
      $sql = "SELECT MAX(RIGHT(".$field.", ".$panjang.")) as kd_max FROM $tabel";
      $q = $this->db->query($sql);

      if($q->num_rows() > 0){
        foreach ($q->result() as $key) {
          $tmp = ((int)$key->kd_max)+1;
          $kd = sprintf("%0".$panjang."s", $tmp);
        }
      } else {
        $kd = sprintf("%0".$panjang."s", $tmp);
      }

      $new_kode = $inisial.$kd;
      return $new_kode;
    }
  }

?>
