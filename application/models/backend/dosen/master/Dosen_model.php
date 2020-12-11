<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dosen_model extends CI_Model {

    public function read_aktif($id_departemen) {
        $this->db->select('p.id_pegawai, p.id_departemen, p.nip, p.nama, p.email, p.status_berjalan, d.departemen');
        $this->db->from('pegawai p');
        $this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
        $this->db->where('p.status', 1);
        $this->db->where('p.status_berjalan', 1);
        $this->db->where('p.jenis_pegawai', 1);
        $this->db->where('p.id_departemen', $id_departemen);
        $this->db->order_by('p.nama', 'asc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_aktif_alldep() {
        $this->db->select('p.id_pegawai, p.id_departemen, p.nip, p.nama, p.email, p.status_berjalan, d.departemen');
        $this->db->from('pegawai p');
        $this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
        $this->db->where('p.status', 1);
        $this->db->where('p.status_berjalan', 1);
        $this->db->where('p.jenis_pegawai', 1);
        $this->db->order_by('p.nama', 'asc');

        $query = $this->db->get();
        return $query->result_array();
    }

}

?>