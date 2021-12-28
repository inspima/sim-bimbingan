<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	class Mkpkk_model extends CI_Model
	{

		public function read()
		{
			$this->db->select('m.*,d.departemen');
			$this->db->from('mkpkk m');
			$this->db->join('departemen d', 'd.id_departemen = m.id_departemen');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function detail($id)
		{
			$this->db->select('*');
			$this->db->from('mkpkk m');
			$this->db->where('id_mkpkk', $id);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_pengampu($id_mkpkk)
		{
			$this->db->select('m.*,p.nama');
			$this->db->from('mkpkk_pengampu m');
			$this->db->join('pegawai p', 'p.nip = m.nip');
			$this->db->where('m.id_mkpkk', $id_mkpkk);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function cek_pengampu_pjmk($id_mkpkk)
		{
			$this->db->select('m.*,p.nama');
			$this->db->from('mkpkk_pengampu m');
			$this->db->join('pegawai p', 'p.nip = m.nip');
			$this->db->where('m.pjmk', '1');
			$result = $this->db->count_all_results();
			if ($result == 0) {
				return true;
			} else {
				return false;
			}
		}

		public function cek_pengampu($id_mkpkk, $nip)
		{
			$this->db->select('m.*,p.nama');
			$this->db->from('mkpkk_pengampu m');
			$this->db->join('pegawai p', 'p.nip = m.nip');
			$this->db->where('m.id_mkpkk', $id_mkpkk);
			$this->db->where('m.nip', $nip);
			$result = $this->db->count_all_results();
			if ($result == 0) {
				return true;
			} else {
				return false;
			}
		}


		public function save($data)
		{
			$this->db->insert('mkpkk', $data);
		}

		public function update($data, $id)
		{
			$this->db->where('id_mkpkk', $id);
			$this->db->update('mkpkk', $data);
		}

		public function save_pengampu($data)
		{
			$this->db->insert('mkpkk_pengampu', $data);
		}

		public function update_pengampu($data, $id)
		{
			$this->db->where('id_mkpkk_pengampu', $id);
			$this->db->update('mkpkk_pengampu', $data);
		}

		public function delete_pengampu($id)
		{
			$this->db->where('id_mkpkk_pengampu', $id);
			$this->db->delete('mkpkk_pengampu');
		}

	}

?>
