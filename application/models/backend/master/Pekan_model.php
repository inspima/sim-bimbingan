<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Pekan_model extends CI_Model
	{

		function read()
		{
			$this->db->query('update pekan set status=1 where CURRENT_DATE between tgl_awal and tgl_akhir ');
			$this->db->query('update pekan set status=0 where CURRENT_DATE < tgl_awal or CURRENT_DATE > tgl_akhir ');
			$this->db->select('*');
			$this->db->from('pekan');
			$query = $this->db->get();
			return $query->result_array();
		}

		function detail($id)
		{
			$this->db->select('*');
			$this->db->from('pekan');
			$this->db->where('id_pekan', $id);
			$query = $this->db->get();
			return $query->row();
		}

		public function save($data)
		{
			$this->db->insert('pekan', $data);
		}

		public function update($data, $id_semester)
		{
			$this->db->where('id_pekan', $id_semester);
			$this->db->update('pekan', $data);
		}


	}

?>
