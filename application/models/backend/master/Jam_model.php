<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	class Jam_model extends CI_Model
	{

		public function read()
		{
			$this->db->select('*');
			$this->db->from('jam');
			$this->db->order_by('jam', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_aktif_by_jenjang($jenjang)
		{
			$this->db->select('j.id_jam, j.jam');
			$this->db->from('jam j');
			$this->db->join('jam_jenjang jj', 'jj.id_jam = j.id_jam');
			$this->db->where('j.status',1);
			$this->db->where('jj.id_jenjang',$jenjang);
			$this->db->order_by('j.jam','asc');

			$query = $this -> db -> get();
			return $query->result_array();
		}

		public function read_aktif_by_prodi($prodi)
		{
			$this->db->select('j.id_jam, j.jam');
			$this->db->from('jam j');
			$this->db->join('jam_prodi jj', 'jj.id_jam = j.id_jam');
			$this->db->where('j.status',1);
			$this->db->where('jj.id_prodi',$prodi);
			$this->db->order_by('j.jam','asc');

			$query = $this -> db -> get();
			return $query->result_array();
		}


		public function save($data)
		{
			$this->db->insert('jam', $data);
		}

		public function detail($id)
		{
			$this->db->select('*');
			$this->db->from('jam');
			$this->db->where('id_jam', $id);

			$query = $this->db->get();
			return $query->row();
		}

		public function readJamProdi($id)
		{
			$this->db->select('p.*,j.jenjang,rp.id_jam_prodi');
			$this->db->from('prodi p');
			$this->db->join('jenjang j', 'j.id_jenjang = p.id_jenjang');
			$this->db->join('jam_prodi rp','rp.id_prodi = p.id_prodi and rp.id_jam='.$id, 'left');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function update($data, $id)
		{
			$this->db->where('id_jam', $id);
			$this->db->update('jam', $data);
		}

		public function updateJamProdi($prodis, $id)
		{
			$this->db->where('id_jam', $id);
			$this->db->delete('jam_prodi');

			foreach ($prodis as $prodi) {
				$this->saveJamProdi($prodi, $id);
			}
		}

		public function saveJamProdi($id_prodi, $id_jam)
		{
			$this->db->insert('jam_prodi', [
					'id_jam' => $id_jam,
					'id_prodi' => $id_prodi,
				]
			);
		}


	}

?>
