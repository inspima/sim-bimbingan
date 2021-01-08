<?php

	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	class Pangkat extends CI_Model {

		function read() {
			$this->db->select('*');
			$this->db->from('pangkat');
			$query = $this->db->get();
			return $query->result_array();
		}

		function detail($id) {
			$this->db->select('*');
			$this->db->from('pangkat');
			$this->db->where('id_pangkat', $id);
			$query = $this->db->get();
			return $query->row();
		}


	}

?>
