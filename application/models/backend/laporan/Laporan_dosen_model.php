<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Laporan_dosen_model extends CI_Model
	{

		public function __construct()
		{
			parent::__construct();
		}

		public function read_penguji_skripsi($username)
		{
			$this->db->select('s.*,p.id_penguji, p.status_tim,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nama,m.nim, d.departemen,jud.judul');
			$this->db->from('penguji p');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
			$this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1  and jud.persetujuan=1');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('p.nip', $username);
			$this->db->where('p.status', 2);
			$this->db->order_by('u.tanggal', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_tesis($username)
		{
			$this->db->select('s.*,p.id_penguji, p.status_tim,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nama,m.nim,jud.judul');
			$this->db->from('penguji_tesis p');
			$this->db->join('ujian_tesis u', 'p.id_ujian = u.id_ujian');
			$this->db->join('tesis s', 'u.id_tesis = s.id_tesis');
			$this->db->join('judul_tesis jud', 'jud.id_tesis = s.id_tesis and jud.status=1 and jud.jenis=1 ');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('p.nip', $username);
			$this->db->where('p.status', 2);
			$this->db->order_by('u.tanggal', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_disertasi($username)
		{
			$this->db->select('s.*,p.id_penguji, p.status_tim,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nama,m.nim,jud.judul');
			$this->db->from('penguji_disertasi p');
			$this->db->join('ujian_disertasi u', 'p.id_ujian = u.id_ujian');
			$this->db->join('disertasi s', 'u.id_disertasi = s.id_disertasi');
			$this->db->join('judul_disertasi jud', 'jud.id_disertasi = s.id_disertasi and jud.status=1');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('p.nip', $username);
			$this->db->where('u.status', 1);
			$this->db->where('p.status', 2);
			$this->db->order_by('u.tanggal', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

	}

?>
