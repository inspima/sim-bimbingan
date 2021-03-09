<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Semester extends CI_Model
	{

		function read()
		{
			$this->db->select('*');
			$this->db->from('semester');
			$query = $this->db->get();
			return $query->result_array();
		}

		function detail($id)
		{
			$this->db->select('*');
			$this->db->from('semester');
			$this->db->where('id_semester', $id);
			$query = $this->db->get();
			return $query->row();
		}

		function detail_berjalan()
		{
			$this->db->select('*');
			$this->db->from('semester');
			$this->db->where('berjalan', '1');
			$query = $this->db->get();
			return $query->row();
		}

		function semester_pengajuan($tanggal)
		{
			$this->db->select('*');
			$this->db->from('semester');
			$this->db->where('periode_awal >=', $tanggal);
			$this->db->where('periode_akhir <=', $tanggal);
			$query = $this->db->get();
			return $query->row();
		}

		public function save($data)
		{
			$this->db->insert('semester', $data);
		}

		public function update($data, $id_semester)
		{
			$this->db->where('id_semester', $id_semester);
			$this->db->update('semester', $data);
		}


	}

?>
