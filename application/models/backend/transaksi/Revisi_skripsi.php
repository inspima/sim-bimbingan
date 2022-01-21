<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Revisi_skripsi extends CI_Model
	{

		public function readRiwayatRevisi($id_ujian)
		{
			$this->db->select('b.*,peg.nama,peg.nip');
			$this->db->from('bimbingan_revisi_skripsi b');
			$this->db->join('pegawai peg', 'b.id_dosen = peg.id_pegawai');
			$this->db->where('b.id_ujian', $id_ujian);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function readRiwayatRevisiDosen($id_ujian, $id_dosen)
		{
			$this->db->select('b.*,peg.nama,peg.nip');
			$this->db->from('bimbingan_revisi_skripsi b');
			$this->db->join('pegawai peg', 'b.id_dosen = peg.id_pegawai');
			$this->db->where('b.id_ujian', $id_ujian);
			$this->db->where('b.id_dosen', $id_dosen);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function detailPengujiRevisiByUjianNip($id_ujian,$nip)
		{
			$this->db->select('*');
			$this->db->from('penguji');
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('nip', $nip);
			$query = $this->db->get();
			return $query->row();
		}

		public function detailPengujiRevisi($id_penguji)
		{
			$this->db->select('*');
			$this->db->from('penguji');
			$this->db->where('id_penguji', $id_penguji);
			$query = $this->db->get();
			return $query->row();
		}

		public function updatePengujiRevisi($data, $id)
		{
			$this->db->where('id_penguji', $id);
			$this->db->update('penguji', $data);
		}

		public function saveRevisi($data)
		{
			$this->db->insert('bimbingan_revisi_skripsi', $data);
		}

		public function updateRevisi($data, $id)
		{
			$this->db->where('id_bimbingan_revisi_skripsi', $id);
			$this->db->update('bimbingan_revisi_skripsi', $data);
		}

		public function deleteRevisi($id)
		{
			$this->db->where('id_bimbingan_revisi_skripsi', $id);
			$this->db->delete('bimbingan_revisi_skripsi');
		}


	}

?>
