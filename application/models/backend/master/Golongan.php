<?php

	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Golongan extends CI_Model {

		function read() {
			$this->db->select('*');
			$this->db->from('golongan');
			$query = $this->db->get();
			return $query->result_array();
		}

		function detail($id) {
			$this->db->select('*');
			$this->db->from('golongan');
			$this->db->where('id_golongan', $id);
			$query = $this->db->get();
			return $query->row();
		}


	}

?>
