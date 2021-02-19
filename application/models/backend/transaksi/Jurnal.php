<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Jurnal extends CI_Model
	{

		public function read_validasi_doktoral()
		{
			$this->db->select("j.*,m.nama,concat(jnj.jenjang,' ',p.nm_prodi) prodi, jd.judul");
			$this->db->from('jurnal j');
			$this->db->join('disertasi d', 'd.id_disertasi= j.id_tugas_akhir');
			$this->db->join('judul_disertasi jd', 'jd.id_disertasi=d.id_disertasi and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= j.nim');
			$this->db->join('prodi p', 'p.id_prodi = m.id_prodi');
			$this->db->join('jenjang jnj', 'jnj.id_jenjang = p.id_jenjang');
			$this->db->order_by('d.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		function detail($nim)
		{
			$this->db->select('*');
			$this->db->from('jurnal');
			$this->db->where('nim', $nim);
			$query = $this->db->get();
			return $query->row();
		}

		public function save($data)
		{
			$this->db->insert('jurnal', $data);
		}

		function update($data, $id_jurnal)
		{
			$this->db->where('id_jurnal', $id_jurnal);
			$this->db->update('jurnal', $data);
		}


	}

?>
