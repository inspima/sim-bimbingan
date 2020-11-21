<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prodi extends CI_Model {

    function read_all_prodi() {
        $this->db->select('p.*,j.jenjang');
        $this->db->from('prodi p');
        $this->db->join('jenjang j', 'j.id_jenjang = p.id_jenjang');
        $query = $this->db->get();
        return $query->result_array();
    }

    function detail($id_prodi) {
        $this->db->select('p.*,j.jenjang');
        $this->db->from('prodi p');
        $this->db->join('jenjang j', 'j.id_jenjang = p.id_jenjang');
        $this->db->where('id_prodi', $id_prodi);
        $query = $this->db->get();
        return $query->row();
    }

}

?>