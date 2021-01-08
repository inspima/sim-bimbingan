<?php

	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Jabatan extends CI_Model {

		function read() {
			$this->db->select('*');
			$this->db->from('jabatan');
			$query = $this->db->get();
			return $query->result_array();
		}

		function detail($id) {
			$this->db->select('*');
			$this->db->from('jabatan');
			$this->db->where('id_jabatan', $id);
			$query = $this->db->get();
			return $query->row();
		}


	}

?>
