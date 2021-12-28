<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	class Ruang_model extends CI_Model
	{

		public function read()
		{
			$this->db->select('*');
			$this->db->from('ruang');
			$this->db->order_by('gedung', 'asc');
			$this->db->order_by('ruang', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_aktif()
		{
			$this->db->select('id_ruang, ruang, gedung');
			$this->db->from('ruang');
			$this->db->where('status', 1);
			$this->db->order_by('id_ruang', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}


		public function read_aktif_id_desc()
		{
			$this->db->select('id_ruang, ruang, gedung');
			$this->db->from('ruang');
			$this->db->where('status', 1);
			$this->db->order_by('id_ruang', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_ujian()
		{
			$jenis = 'ujian';
			$this->db->select('id_ruang, ruang, gedung, jenis, status');
			$this->db->from('ruang');
			$this->db->where('jenis', $jenis);
			$this->db->where('status', 1);
			$query = $this->db->get();

			return $query->result_array();
		}

		public function read_aktif_by_prodi($prodi)
		{
			$this->db->select('r.*');
			$this->db->from('ruang r');
			$this->db->join('ruang_prodi rp', 'rp.id_ruang = r.id_ruang');
			$this->db->where('r.status', 1);
			$this->db->where('rp.id_prodi', $prodi);
			$this->db->order_by('r.gedung', 'asc');
			$this->db->order_by('r.ruang', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function save($data)
		{
			$this->db->insert('ruang', $data);
		}

		public function detail($id)
		{
			$this->db->select('*');
			$this->db->from('ruang');
			$this->db->where('id_ruang', $id);

			$query = $this->db->get();
			return $query->row();
		}

		public function readRuangProdi($id)
		{
			$this->db->select('p.*,j.jenjang,rp.id_ruang_prodi');
			$this->db->from('prodi p');
			$this->db->join('jenjang j', 'j.id_jenjang = p.id_jenjang');
			$this->db->join('ruang_prodi rp', 'rp.id_prodi = p.id_prodi and rp.id_ruang=' . $id, 'left');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function update($data, $id)
		{
			$this->db->where('id_ruang', $id);
			$this->db->update('ruang', $data);
		}

		public function updateRuangProdi($prodis, $id)
		{
			$this->db->where('id_ruang', $id);
			$this->db->delete('ruang_prodi');

			foreach ($prodis as $prodi) {
				$this->saveRuangProdi($prodi, $id);
			}
		}

		public function saveRuangProdi($id_prodi, $id_ruang)
		{
			$this->db->insert('ruang_prodi', [
					'id_ruang' => $id_ruang,
					'id_prodi' => $id_prodi,
				]
			);
		}


	}

?>
