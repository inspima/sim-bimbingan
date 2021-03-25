<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	class Berita_model extends CI_Model
	{

		public function read()
		{
			$this->db->select('b.id_berita, b.isi_berita, b.tanggal_berita');
			$this->db->from('berita b');
			$this->db->join('berita_detail bd', 'b.id_berita = bd.id_berita');
			$this->db->where('b.status', 1);
			$this->db->where('bd.id_kategori', 1);
			$this->db->where('bd.status', 1);
			$this->db->order_by('id_berita', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}


	}

?>
