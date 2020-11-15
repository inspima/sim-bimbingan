<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Departemen_model extends CI_Model {

    public function read() {
        $this->db->select('id_departemen, departemen');
        $this->db->from('departemen');
        $this->db->where('status', 1);
        $this->db->order_by('departemen', 'asc');

        $query = $this->db->get();
        return $query->result_array();
    }

}

?>