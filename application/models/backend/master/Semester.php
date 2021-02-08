<?php

	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Semester extends CI_Model {

		function read() {
			$this->db->select('*');
			$this->db->from('semester');
			$query = $this->db->get();
			return $query->result_array();
		}

		function detail($id) {
			$this->db->select('*');
			$this->db->from('semester');
			$this->db->where('id_semester', $id);
			$query = $this->db->get();
			return $query->row();
		}

		function detail_berjalan() {
			$this->db->select('*');
			$this->db->from('semester');
			$this->db->where('berjalan', '1');
			$query = $this->db->get();
			return $query->row();
		}


	}

?>
