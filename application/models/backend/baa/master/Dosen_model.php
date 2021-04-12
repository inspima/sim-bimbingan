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

		public function updateAktif($data, $id_jenjang, $nip)
		{
			$this->db->where('nip', $nip);
			$this->db->where('id_jenjang', $id_jenjang);
			$this->db->update('dosen_aktif', $data);
		}

		public function saveAktif($data)
		{
			$this->db->insert('dosen_aktif', $data);
		}

		public function detailAktif($id_jenjang, $nip)
		{
			$this->db->select('*');
			$this->db->from('dosen_aktif');
			$this->db->where('nip', $nip);
			$this->db->where('id_jenjang', $id_jenjang);
			$query = $this->db->get();
			return $query->row();
		}

		public function checkAktifPembimbing($id_jenjang, $nip)
		{
			$result = false;
			$this->db->select('*');
			$this->db->from('dosen_aktif');
			$this->db->where('nip', $nip);
			$this->db->where('id_jenjang', $id_jenjang);
			$query = $this->db->get();
			$data = $query->row();
			if (!empty($data)) {
				if ($data->pembimbing == 1) {
					$result = true;
				}
			}
			return $result;
		}

		public function checkAktifPenguji($id_jenjang, $nip)
		{
			$result = false;
			$this->db->select('*');
			$this->db->from('dosen_aktif');
			$this->db->where('nip', $nip);
			$this->db->where('id_jenjang', $id_jenjang);
			$query = $this->db->get();
			$data = $query->row();
			if (!empty($data)) {
				if ($data->penguji == 1) {
					$result = true;
				}
			}
			return $result;
		}

	}

?>
