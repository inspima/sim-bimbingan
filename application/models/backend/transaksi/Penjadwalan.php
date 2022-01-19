<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Penjadwalan extends CI_Model
	{

		public function cekBentrokJadwal($ruang, $tgl, $jam)
		{
			$status = true;
			$message = 'Sukses';
			$query_s1_str = "SELECT * FROM ujian WHERE AND id_ruang = ? and tgl = ? and id_jam = ?";
			$query_s1 = $this->db->query($query_s1_str, [
				$ruang,
				$tgl,
				$jam
			]);
			$result_s1 = $query_s1->num_rows();

			$query_s2_str = "SELECT * FROM ujian_tesis WHERE AND id_ruang = ? and tgl = ? and id_jam = ?";
			$query_s2 = $this->db->query($query_s2_str, [
				$ruang,
				$tgl,
				$jam
			]);
			$result_s2 = $query_s2->num_rows();

			$query_s3_str = "SELECT * FROM ujian_disertasi WHERE AND id_ruang = ? and tgl = ? and id_jam = ?";
			$query_s3 = $this->db->query($query_s3_str, [
				$ruang,
				$tgl,
				$jam
			]);
			$result_s3 = $query_s3->num_rows();

			if ($result_s1 > 0 || $result_s2 > 0 || $result_s3 > 0) {
				$status = false;
				$message = 'Sudah ada jadwal lain pada tanggal/ruang/jam yang sama';
			}

			return [
				'status' => $status,
				'message' => $message
			];
		}


		public function cekBentrokPenguji($nip, $ruang, $tgl, $jam)
		{
			$status = true;
			$message = 'Sukses';
			$query_s1_str = "SELECT * FROM ujian WHERE AND id_ruang = ? and tgl = ? and id_jam = ?";
			$query_s1 = $this->db->query($query_s1_str, [
				$ruang,
				$tgl,
				$jam
			]);
			$result_s1 = $query_s1->num_rows();

			$query_s2_str = "SELECT * FROM ujian_tesis WHERE AND id_ruang = ? and tgl = ? and id_jam = ?";
			$query_s2 = $this->db->query($query_s2_str, [
				$ruang,
				$tgl,
				$jam
			]);
			$result_s2 = $query_s2->num_rows();

			$query_s3_str = "SELECT * FROM ujian_disertasi WHERE AND id_ruang = ? and tgl = ? and id_jam = ?";
			$query_s3 = $this->db->query($query_s3_str, [
				$ruang,
				$tgl,
				$jam
			]);
			$result_s3 = $query_s3->num_rows();

			if ($result_s1 > 0 || $result_s2 > 0 || $result_s3 > 0) {
				$status = false;
				$message = 'Sudah ada jadwal lain pada tanggal/ruang/jam yang sama';
			}

			return [
				'status' => $status,
				'message' => $message
			];
		}

		public function read_judul($id_skripsi)
		{
			$this->db->select('j.judul');
			$this->db->from('judul j');
			$this->db->join('skripsi s', 'j.id_skripsi = s.id_skripsi');
			$this->db->where('j.id_skripsi', $id_skripsi);
			$this->db->order_by('j.id_judul', 'desc');
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}

		function detail($id, $username)
		{
			$this->db->select('s.id_skripsi, s.id_departemen, s.tgl_pengajuan,  s.berkas_proposal, s.status_proposal, s.turnitin, s.toefl, d.departemen ');
			$this->db->from('skripsi s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', 2);
			$this->db->where('s.id_skripsi', $id);
			$this->db->limit(1);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->row();
		}


	}

?>
