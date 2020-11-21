<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tugas_akhir extends CI_Model {

    function detail_skripsi($nim) {
        $this->db->select('s.*');
        $this->db->from('skripsi s');
        $this->db->where('nim', $nim);
        $this->db->order_by('id_skripsi', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

    function detail_tesis($nim) {
        $this->db->select('s.*');
        $this->db->from('tesis s');
        $this->db->where('nim', $nim);
        $this->db->order_by('id_skripsi', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

    function detail_disertasi($nim) {
        $this->db->select('s.*');
        $this->db->from('disertasi s');
        $this->db->where('nim', $nim);
        $this->db->order_by('id_disertasi', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

}

?>