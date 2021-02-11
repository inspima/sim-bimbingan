<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Minat_tesis_model extends CI_Model {

    public function read() {
        $this->db->select('id_minat, nm_minat');
        $this->db->from('minat_tesis');
        $this->db->where('status', 1);
        $this->db->order_by('nm_minat', 'asc');

        $query = $this->db->get();
        return $query->result_array();
    }

}

?>