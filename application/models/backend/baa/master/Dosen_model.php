<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	class Dosen_model extends CI_Model
	{

		public function read()
		{
			$this->db->select('p.*, d.departemen');
			$this->db->from('pegawai p');
			$this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
			$this->db->where('p.status', 1);
			$this->db->where('p.jenis_pegawai', 1);
			$this->db->order_by('p.nama', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function detail($id)
		{
			$this->db->select('p.*, d.departemen');
			$this->db->from('pegawai p');
			$this->db->join('departemen d', 'd.id_departemen = p.id_departemen', 'left');
			$this->db->where('p.status', 1);
			$this->db->where('p.jenis_pegawai', 1);
			$this->db->where('p.id_pegawai', $id);

			$query = $this->db->get();
			return $query->row();
		}

		public function update($data, $id_pegawai)
		{
			$this->db->where('id_pegawai', $id_pegawai);
			$this->db->update('pegawai', $data);
		}

	}

?>
