<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Skripsi extends CI_Model
	{

		public function read($username)
		{
			$this->db->select('s.*, d.departemen ');
			$this->db->from('skripsi s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', 2);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_mahasiswa_proposal($username)
		{
			$this->db->select('s.*, d.departemen ');
			$this->db->from('skripsi s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', 1);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->row_array();
		}

		public function read_mahasiswa($username)
		{
			$this->db->select('s.*, d.departemen ');
			$this->db->from('skripsi s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', 2);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->row_array();
		}

		public function read_mahasiswa_skripsi($username)
		{
			$this->db->select('s.*, d.departemen ');
			$this->db->from('skripsi s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('s.nim', $username);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->row_array();
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

		public function read_kadep_pengajuan($id_departemen)
		{
			$this->db->select('s.*, dn.departemen, sr.semester, m.nim, m.nama ,jud.judul');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.id_departemen', $id_departemen);
			$this->db->where('s.jenis', TAHAPAN_SKRIPSI_PROPOSAL);
			$this->db->where('s.status_proposal', STATUS_SKRIPSI_PROPOSAL_PENGAJUAN);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_kadep_diterima($id_departemen)
		{
			$this->db->select('s.*, dn.departemen, sr.semester, m.nim, m.nama ,jud.judul');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.id_departemen', $id_departemen);
			$this->db->where('s.jenis', TAHAPAN_SKRIPSI_PROPOSAL);
			$this->db->where('s.status_proposal >=', STATUS_SKRIPSI_PROPOSAL_SETUJUI_KADEP);
			$this->db->where('s.status_proposal <=', STATUS_SKRIPSI_PROPOSAL_UJIAN);
			$this->db->where('s.status_ujian_proposal', 0);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_kadep_selesai($id_departemen)
		{
			$this->db->select('s.*, dn.departemen, sr.semester, m.nim, m.nama ,jud.judul');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.id_departemen', $id_departemen);
			$this->db->where('s.status_proposal >=', STATUS_SKRIPSI_PROPOSAL_SELESAI);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_kadep_ditolak($id_departemen)
		{
			$this->db->select('s.*, dn.departemen, sr.semester, m.nim, m.nama ,jud.judul');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.id_departemen', $id_departemen);
			$this->db->where('s.jenis', TAHAPAN_SKRIPSI_PROPOSAL);
			$this->db->where('s.status_ujian_proposal >', HASIL_UJIAN_LANJUT);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_baa_proposal_ditolak()
		{
			$this->db->select('s.*, g.gelombang, dn.departemen, sr.semester, m.nim, m.nama ,jud.judul');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.jenis', TAHAPAN_SKRIPSI_PROPOSAL);
			$this->db->where('s.status_ujian_proposal >', HASIL_UJIAN_LANJUT);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_baa_proposal_penguji_blm_approve()
		{
			$this->db->select('s.*, g.gelombang, dn.departemen, sr.semester, m.nim, m.nama ,jud.judul,uj.id_ujian');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('ujian uj', 'uj.id_skripsi = s.id_skripsi and uj.id_ujian in (select id_ujian from penguji where status=\'1\')');
			$this->db->where('s.jenis', TAHAPAN_SKRIPSI_PROPOSAL);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
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

		function detail_by_id($id)
		{
			$this->db->select('s.*, jud.judul, dn.departemen, sr.semester, m.nim, m.nama,us.no_hp ');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('user us', 'us.username = m.nim');
			$this->db->where('s.id_skripsi', $id);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->row();
		}

		function detail_proposal($id_skripsi)
		{
			$this->db->select('s.id_skripsi, s.tgl_pengajuan, jud.judul, s.berkas_proposal, s.id_departemen, s.status_proposal, s.status_ujian_proposal, s.keterangan_proposal, dn.departemen, sr.semester, m.nim, m.nama,us.no_hp ');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('user us', 'us.username = m.nim');
			$this->db->where('s.status_proposal >=', STATUS_SKRIPSI_PROPOSAL_SETUJUI_KADEP);
			$this->db->where('s.id_skripsi', $id_skripsi);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->row();
		}

		function detail_skripsi($username)
		{
			$this->db->select('s.id_skripsi, s.id_departemen, s.tgl_pengajuan,  s.berkas_proposal, s.status_proposal, s.turnitin, s.toefl, d.departemen ');
			$this->db->from('skripsi s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', TAHAPAN_SKRIPSI_UJIAN);
			$this->db->limit(1);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->row();
		}

		public function cekskripsi($nim)
		{
			$this->db->select('s.id_skripsi');
			$this->db->from('skripsi s');
			$this->db->where('s.nim', $nim);
			$this->db->where('s.jenis', TAHAPAN_SKRIPSI_UJIAN);
			$query = $this->db->get();
			return $query->row();
		}

		function update($data, $id_skripsi)
		{
			$this->db->where('id_skripsi', $id_skripsi);
			$this->db->update('skripsi', $data);
		}

		function save($data)
		{
			$this->db->insert('skripsi', $data);
		}

		public function save_judul($dataj)
		{
			$this->db->insert('judul', $dataj);
		}

		// Pembimbing

		public function read_pembimbing_row($id_skripsi)
		{
			$this->db->select('p.id_pembimbing, p.id_skripsi, pg.nama,pg.nip, p.status,pg.ttd ');
			$this->db->from('pegawai pg');
			$this->db->join('pembimbing p', 'pg.nip = p.nip');
			$this->db->join('skripsi s', 'p.id_skripsi = s.id_skripsi');
			$this->db->where('s.id_skripsi', $id_skripsi);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_pembimbing($id_skripsi)
		{
			$this->db->select('p.id_pembimbing, p.id_skripsi, pg.nama,pg.nip, p.status,pg.ttd ');
			$this->db->from('pembimbing p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_skripsi', $id_skripsi);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_bimbingan($id)
		{
			$stts = array('1', '2');
			$this->db->select('b.id_bimbingan, b.id_skripsi, b.tanggal, b.hal, b.status');
			$this->db->from('bimbingan b');
			$this->db->join('skripsi s', 'b.id_skripsi = s.id_skripsi');
			$this->db->where('s.id_skripsi', $id);
			$this->db->where_in('b.status', $stts);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function cek_pembimbing($id_skripsi)
		{
			$stts = array('1', '2');
			$this->db->select('p.id_pembimbing, p.nip');
			$this->db->from('pembimbing p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_skripsi', $id_skripsi);
			$this->db->where_in('p.status', $stts);
			$query = $this->db->get();
			return $query->row();
		}

		public function hitung_bimbingan_aktif($nip)
		{
			$stts = array('2');
			$this->db->where_in('p.status_bimbingan', $stts);
			$this->db->where('p.nip', $nip);
			$this->db->where('s.jenis', 2);
			$this->db->join('skripsi s', 'p.id_skripsi = s.id_skripsi');
			$this->db->from('pembimbing p');
			$query = $this->db->count_all_results();
			return $query;
		}

		public function save_pembimbing($datap)
		{
			$this->db->insert('pembimbing', $datap);
		}

		public function update_pembimbing($data, $id)
		{
			$this->db->where('id_pembimbing', $id);
			$this->db->update('pembimbing', $data);
		}

		public function delete_pembimbing($id)
		{
			$this->db->where('id_pembimbing', $id);
			$this->db->delete('pembimbing');
		}

		public function save_bimbingan($data)
		{
			$this->db->insert('bimbingan', $data);
		}

		function update_bimbingan($data, $id_bimbingan)
		{
			$this->db->where('id_bimbingan', $id_bimbingan);
			$this->db->update('bimbingan', $data);
		}

		public function read_gelombang($id_skripsi)
		{
			$this->db->select('g.gelombang, st.semester');
			$this->db->from('skripsi s');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester st', 'g.id_semester = st.id_semester');
			$this->db->where('s.id_skripsi', $id_skripsi);
			$this->db->where('s.jenis', 2);
			$query = $this->db->get();
			return $query->row();
		}


		public function jumlah_bimbingan($id_skripsi)
		{
			$stts = array('2');
			$this->db->where_in('b.status', $stts);
			$this->db->where('b.id_skripsi', $id_skripsi);
			$this->db->where('s.jenis', 2);
			$this->db->join('skripsi s', 'b.id_skripsi = s.id_skripsi');
			$this->db->from('bimbingan b');
			$query = $this->db->count_all_results();
			return $query;
		}

		public function awal_bimbingan($id_skripsi)
		{
			$this->db->select('tanggal');
			$this->db->from('bimbingan');
			$this->db->where('id_skripsi', $id_skripsi);
			$this->db->where('status', 2);
			$this->db->order_by('tanggal', 'asc');
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}

		////

		function read_aktif($username)
		{
			$stts = array('1', '2', '3');
			$this->db->select('s.id_skripsi, s.id_departemen, s.id_gelombang, s.tgl_pengajuan, s.berkas_proposal, s.status_proposal, d.departemen, g.gelombang, t.semester ');
			$this->db->from('skripsi s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester t', 'g.id_semester = t.id_semester');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', 1);
			$this->db->where_in('s.status_proposal', $stts);
			$this->db->limit(1);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->row();
		}

		// Ujian & Jadwal

		public function read_jadwal_all()
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_ujian_by_id($id_ujian)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_ujian', $id_ujian);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_ujian_proposal($id_skripsi)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_skripsi', $id_skripsi);
			$this->db->where('u.jenis_ujian', UJIAN_SKRIPSI_PROPOSAL);//proposal
			$this->db->where('u.status', 1);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_ujian_skripsi($id_skripsi)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_skripsi', $id_skripsi);
			$this->db->where('u.jenis_ujian', UJIAN_SKRIPSI_UJIAN);//proposal
			$this->db->where('u.status', 1);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_ujian($id_skripsi)
		{
			$this->db->select('u.id_ujian, u.tanggal, u.id_ruang, u.id_jam, u.id_skripsi, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_skripsi', $id_skripsi);
			$this->db->where('u.jenis_ujian', 1);//proposal
			$this->db->where('u.status', 1);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_ujian_aktif($id_skripsi, $jenis)
		{
			$this->db->select('u.id_ujian, u.tanggal, u.id_ruang, u.id_jam, u.id_skripsi, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_skripsi', $id_skripsi);
			$this->db->where('u.jenis_ujian', $jenis);
			$this->db->where('u.hasil_ujian', 0);// Belum Ujian
			$query = $this->db->get();
			return $query->row();
		}

		public function read_ujian_ulang($id_skripsi, $jenis)
		{
			$this->db->select('u.id_ujian, u.tanggal, u.id_ruang, u.id_jam, u.id_skripsi, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_skripsi', $id_skripsi);
			$this->db->where('u.jenis_ujian', $jenis);
			$this->db->where('u.status_ujian', 2);
			$this->db->where('u.hasil_ujian', 0);// Belum Ujian
			$query = $this->db->get();
			return $query->row();
		}

		public function read_ujian_selesai($id_skripsi, $jenis)
		{
			$this->db->select('u.id_ujian, u.tanggal, u.id_ruang, u.id_jam, u.id_skripsi, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_skripsi', $id_skripsi);
			$this->db->where('u.jenis_ujian', $jenis);
			$this->db->where('u.hasil_ujian >', 0);// Belum Ujian
			$this->db->order_by('u.tanggal', 'desc');
			$query = $this->db->get();
			return $query->row();
		}

		public function read_jadwal($id_skripsi, $jenis)
		{
			$this->db->select('u.id_ujian, u.tanggal, u.id_ruang, u.id_jam, u.id_skripsi, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_skripsi', $id_skripsi);
			$this->db->where('u.jenis_ujian', $jenis);//proposal
			$this->db->where('u.status', 1);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_jadwal_by_id($id_ujian)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_ujian', $id_ujian);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_jadwal_riwayat($id_skripsi, $jenis)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_skripsi', $id_skripsi);
			$this->db->where('u.jenis_ujian', $jenis);//proposal
			$query = $this->db->get();
			return $query->result_array();
		}

		function ujian($id_skripsi, $username)
		{
			$this->db->select('u.id_ujian, u.id_skripsi, u.id_ruang, u.id_jam, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, g.id_gelombang, g.gelombang, d.departemen, sr.semester');
			$this->db->from('ujian u');
			$this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('s.id_skripsi', $id_skripsi);
			$this->db->where('s.nim', $username);
			$this->db->where('u.jenis_ujian', 2);
			$this->db->where_in('s.status_skripsi', 4); //app kps
			$this->db->where('u.status', 1);

			$query = $this->db->get();
			return $query->result_array();
		}

		function ujiana($id_skripsi, $username)
		{
			$stts = array('1', '2', '3', '4', '5');
			$this->db->select('u.id_ujian, u.id_skripsi, u.id_ruang, u.id_jam, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, g.id_gelombang, g.gelombang, d.departemen, sr.semester');
			$this->db->from('ujian u');
			$this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('s.id_skripsi', $id_skripsi);
			$this->db->where('s.nim', $username);
			$this->db->where('u.jenis_ujian', 2);
			$this->db->where_in('s.status_skripsi', $stts); //app kps
			$this->db->where('u.status', 1);

			$query = $this->db->get();
			return $query->result_array();
		}

		public function cek_ruang_terpakai($data)
		{
			$this->db->select('u.id_ujian');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.tanggal', $data['tanggal']);
			$this->db->where('u.id_ruang', $data['id_ruang']);
			$this->db->where('u.id_jam', $data['id_jam']);
			$this->db->where('u.status', 1);
			$query = $this->db->get();
			return $query->row();
		}

		public function save_ujian($datau)
		{
			$this->db->insert('ujian', $datau);
		}

		public function update_ujian($data, $id_ujian)
		{
			$this->db->where('id_ujian', $id_ujian);
			$this->db->update('ujian', $data);
		}

		// Penguji


		public function read_penguji_pengajuan_proposal($username)
		{
			$this->db->select('p.id_penguji, p.status_tim,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nama,m.nim, s.id_skripsi, s.berkas_proposal, d.departemen,jud.judul');
			$this->db->from('penguji p');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
			$this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('p.nip', $username);
			$this->db->where('p.status', 1);
			$this->db->where('u.jenis_ujian', 1);
			$this->db->where('u.status', 1);
			$this->db->order_by('u.tanggal', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_proposal($username)
		{
			$this->db->select('p.id_penguji, p.status_tim,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nama,m.nim, s.id_skripsi, s.berkas_proposal, d.departemen,jud.judul');
			$this->db->from('penguji p');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
			$this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('p.nip', $username);
			$this->db->where('p.status', 2);
			$this->db->where('u.jenis_ujian', UJIAN_SKRIPSI_PROPOSAL);
			$this->db->where('u.status', 1);
			$this->db->order_by('u.tanggal', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_pengajuan_skripsi($username)
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
			$this->db->where('p.status', 1);
			$this->db->where('u.jenis_ujian', 2);
			$this->db->where('u.status', 1);
			$this->db->order_by('u.tanggal', 'desc');

			$query = $this->db->get();
			return $query->result_array();
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
			$this->db->where('u.jenis_ujian', 2);
			$this->db->where('u.status', 1);
			$this->db->order_by('u.tanggal', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji($id_ujian)
		{
			$stts = array('1', '2', '3');
			$this->db->select('p.id_penguji, p.nip, p.status_tim,p.usulan_dosbing, p.status, pg.nama');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
			$this->db->where_in('p.status', $stts);
			$this->db->where('u.status', 1);
			$this->db->where('u.id_ujian', $id_ujian);
			$this->db->order_by('p.status_tim', 'asc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_aktif($id_ujian)
		{
			$stts = array('1', '2');
			$this->db->select('p.id_penguji, p.nip, p.status_tim,p.usulan_dosbing, p.status, pg.nama');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
			$this->db->where_in('p.status', $stts);
			$this->db->where('u.id_ujian', $id_ujian);
			$this->db->order_by('p.status_tim', 'asc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_semua($id_ujian, $jenis_ujian)
		{
			$this->db->select('p.id_penguji, p.nip, p.status_tim,p.usulan_dosbing, p.status, pg.nama,pg.ttd');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
			$this->db->where('u.jenis_ujian', $jenis_ujian);
			$this->db->where('u.id_ujian', $id_ujian);
			$this->db->order_by('p.status_tim', 'asc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_ujian($id_ujian, $jenis_ujian)
		{
			$this->db->select('p.id_penguji, p.nip, p.status_tim,p.usulan_dosbing, p.status,pg.nip identitas, pg.nama,pg.ttd');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
			$this->db->where('p.status', 2);
			$this->db->where('u.jenis_ujian', $jenis_ujian);
			$this->db->where('u.id_ujian', $id_ujian);
			$this->db->order_by('p.status_tim', 'asc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_pengujiketua($id_ujian)
		{
			$stts = array('1', '2');
			$this->db->select('p.*,pg.nama,pg.ttd');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('p.status_tim', 1);
			$this->db->where_in('p.status', $stts);

			$query = $this->db->get();
			return $query->row();
		}

		public function read_pengujipembimbing($id_ujian)
		{
			$this->db->select('pg.nama');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_ujian', $id_ujian);
			$this->db->where('p.usulan_dosbing', 2);
			$this->db->where('p.status', 2);
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_pengujianggota($id_ujian)
		{
			$stts = array('1', '2');
			$this->db->select('p.*,pg.nama,pg.ttd');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_ujian', $id_ujian);
			$this->db->where('p.status_tim', 2);
			$this->db->where_in('p.status', $stts);

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_pengujibentrok($tanggal, $id_jam, $nip)
		{
			$stts = array('1', '2');
			$this->db->select('u.id_ujian');
			$this->db->from('ujian u');
			$this->db->join('penguji p', 'u.id_ujian = p.id_ujian');
			$this->db->where('u.tanggal', $tanggal);
			$this->db->where('u.id_jam', $id_jam);
			$this->db->where('p.nip', $nip);
			$this->db->where('u.status', 1);
			$this->db->where_in('p.status', $stts);

			$query = $this->db->get();
			return $query->row();
		}

		public function cek_penguji($data)
		{
			$stts = array('1', '2');
			$this->db->select('p.id_penguji');
			$this->db->from('penguji p');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
			$this->db->where('u.id_ujian', $data['id_ujian']);
			$this->db->where('p.nip', $data['nip']);
			$this->db->where('u.status', 1);
			$this->db->where_in('p.status', $stts);
			$query = $this->db->get();
			return $query->row();
		}


		public function count_penguji($id_ujian)
		{
			$stts = array('0', '3');
			$this->db->where_not_in('p.status', $stts);
			$this->db->where('u.status', 1);
			$this->db->where('u.id_ujian', $id_ujian);
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');

			$query = $this->db->count_all_results();
			return $query;
		}

		public function count_penguji_approve($id_ujian)
		{
			$stts = array('2');
			$this->db->where_in('p.status', $stts);
			$this->db->where('u.status', 1);
			$this->db->where('u.id_ujian', $id_ujian);
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');

			$query = $this->db->count_all_results();
			return $query;
		}

		public function semua_penguji_setuju($id_ujian)
		{
			$jumlah_penguji = $this->count_penguji($id_ujian);
			$jumlah_setuju = $this->count_penguji_approve($id_ujian);
			if ($jumlah_penguji == $jumlah_setuju) {
				return true;
			} else {
				return false;
			}
		}

		public function copy_penguji($pengujis, $id_ujian_baru)
		{
			foreach ($pengujis as $penguji) {
				$data = array(
					'id_ujian' => $id_ujian_baru,
					'nip' => $penguji['nip'],
					'status_tim' => $penguji['status_tim'],
					'status' => $penguji['status'],
					'usulan_dosbing' => $penguji['usulan_dosbing'],
				);
				$this->save_penguji($data);
			}
		}

		public function update_penguji($data, $id_penguji)
		{
			$this->db->where('id_penguji', $id_penguji);
			$this->db->update('penguji', $data);
		}

		public function save_penguji($data)
		{
			$this->db->insert('penguji', $data);
		}

		public function update_nilai($data, $id_skripsi)
		{
			$this->db->where('id_skripsi', $id_skripsi);
			$this->db->update('skripsi', $data);
		}

		public function read_wadek()
		{
			$this->db->select('pg.nip, pg.nama,pg.ttd');
			$this->db->from('pegawai pg');
			$this->db->join('struktural st', 'pg.nip = st.nip');
			$this->db->where('st.id_struktur', STRUKTUR_WADEK_1);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_gelombangaktif()
		{
			$this->db->select('g.id_gelombang, g.no_sk, g.tgl_sk, g.gelombang,sr.semester');
			$this->db->from('gelombang_skripsi g');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->where('g.status_berjalan', 1);
			$this->db->where('g.status', 1);

			$query = $this->db->get();
			return $query->row();
		}

		// Status

		public function read_status_ujian($jenis)
		{
			if ($jenis == UJIAN_SKRIPSI_PROPOSAL) {
				return [
					['value' => '0', 'text' => 'Belum Ujian'],
					['value' => '1', 'text' => 'Layak'],
					['value' => '2', 'text' => 'Tidak Layak'],
				];
			} else {
				return [
					['value' => '0', 'text' => 'Belum Ujian'],
					['value' => '1', 'text' => 'Lulus'],
					['value' => '2', 'text' => 'Mengulang Kembali'],
				];
			}
		}

		public function get_status_ujian($status_ujian, $jenis)
		{
			$result = '';
			$status_ujians = $this->read_status_ujian($jenis);
			foreach ($status_ujians as $s) {
				if ($s['value'] == $status_ujian) {
					$result = $s['text'];
				}
			}
			return $result;
		}

		public function get_id_status_ujian_by_text($status_ujian, $jenis)
		{
			$result = '';
			$status_ujians = $this->read_status_ujian($jenis);
			foreach ($status_ujians as $s) {
				if ($s['text'] == $status_ujian) {
					$result = $s['value'];
				}
			}
			return $result;
		}

		public function read_status_tahapan($urutan)
		{
			if ($urutan == TAHAPAN_SKRIPSI_PROPOSAL) {
				return [
					[
						'value' => 0,
						'text' => 'Belum Pengajuan',
						'keterangan' => '',
						'color' => 'bg-gray'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_PENGAJUAN,
						'text' => 'Pengajuan',
						'keterangan' => 'Pengajuan oleh mahasiswa',
						'color' => 'bg-blue'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_SETUJUI_KADEP,
						'text' => 'Disetujui Kadep',
						'keterangan' => 'Disetujui oleh Kepala Bagian',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_DIJADWALKAN,
						'text' => 'Dijadwalkan',
						'keterangan' => 'Dijadwalkan, diajukan Penguji dan Pembimbing oleh Kepala Bagian',
						'color' => 'bg-navy'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_SETUJUI_PENGUJI,
						'text' => 'Disetujui Penguji',
						'keterangan' => 'Disetujui oleh semua penguji (3)',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_CETAK_DOKUMEN,
						'text' => 'Cetak Dokumen',
						'keterangan' => 'BAA Cetak semua berkas Ujian menunggu penilaian para dosen',
						'color' => 'bg-orange'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_UJIAN,
						'text' => 'Ujian',
						'keterangan' => 'Sedang menunggu masa jadwal Ujian',
						'color' => 'bg-purple'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_PEMBIMBING,
						'text' => 'Konfirmasi Pembimbing',
						'keterangan' => 'Ketua Bagian menentukan pembimbing',
						'color' => 'bg-maroon-active'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_SELESAI,
						'text' => 'Ujian Selesai',
						'keterangan' => 'Selesai, hasil sudah ditentukan oleh ketua penguji',
						'color' => 'bg-red'
					],
				];
			} else if ($urutan == TAHAPAN_SKRIPSI_UJIAN) {
				return [
					[
						'value' => 0,
						'text' => 'Belum Pengajuan',
						'keterangan' => '',
						'color' => 'bg-gray'
					],
					[
						'value' => STATUS_SKRIPSI_UJIAN_PENGAJUAN,
						'text' => 'Pengajuan',
						'keterangan' => 'Pengajuan oleh mahasiswa, syarat berkas turnitin, toefl, dan Bimbingan 8 kali',
						'color' => 'bg-blue'
					],
					[
						'value' => STATUS_SKRIPSI_UJIAN_SETUJUI_BAA,
						'text' => 'Persetujuan BAA',
						'keterangan' => 'Disetujui oleh BAA',
						'color' => 'bg-blue'
					],
					[
						'value' => STATUS_SKRIPSI_UJIAN_SETUJUI_PEMBIMMBING,
						'text' => 'Disetujui Pembimbing',
						'keterangan' => 'Disetujui oleh Pembimbing, pengajuan penguji',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_SKRIPSI_UJIAN_DIJADWALKAN,
						'text' => 'Dijadwalkan',
						'keterangan' => 'Dijadwalkan oleh Kepala Bagian, pengajuan penguji',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_SKRIPSI_UJIAN_SETUJUI_PENGUJI,
						'text' => 'Disetujui Penguji',
						'keterangan' => 'Disetujui oleh semua penguji (5)',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_SKRIPSI_UJIAN_SETUJUI_KPS,
						'text' => 'Disetujui KPS',
						'keterangan' => 'Disetujui Oleh Ketua Program Studi',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_SKRIPSI_UJIAN_UJIAN,
						'text' => 'Ujian',
						'keterangan' => 'Sedang menunggu masa jadwal Ujian',
						'color' => 'bg-purple'
					],
					[
						'value' => STATUS_SKRIPSI_UJIAN_SELESAI,
						'text' => 'Ujian Selesai',
						'keterangan' => 'Selesai, Penilaian Ketuan Penguji',
						'color' => 'bg-maroon-active'
					],
				];
			}
		}

		public function get_status_tahapan($status_tahapan, $jenis)
		{
			$result = '';
			$statuses = $this->read_status_tahapan($jenis);
			foreach ($statuses as $status) {
				if ($status['value'] == $status_tahapan) {
					$result = $status;
				}
			}
			return $result;
		}

		// Penilaian

		public function get_nilai_huruf($nilai_angka)
		{
			$nilai_huruf  ='-';
			$range_nilais = [
				[
					'batas_bawah' => 40,
					'batas_atas' => 55,
					'nilai_huruf' => 'Tidak Lulus'
				],
				[
					'batas_bawah' => 55,
					'batas_atas' => 60,
					'nilai_huruf' => 'C'
				],
				[
					'batas_bawah' => 60,
					'batas_atas' => 65,
					'nilai_huruf' => 'BC'
				],
				[
					'batas_bawah' => 65,
					'batas_atas' => 70,
					'nilai_huruf' => 'B'
				],
				[
					'batas_bawah' => 70,
					'batas_atas' => 75,
					'nilai_huruf' => 'AB'
				],
				[
					'batas_bawah' => 75,
					'batas_atas' => 100,
					'nilai_huruf' => 'A'
				]
			];
			foreach ($range_nilais as $range_nilai) {
				if ($nilai_angka >= $range_nilai['batas_bawah'] && $nilai_angka < $range_nilai['batas_atas']) {
					$nilai_huruf = $range_nilai['nilai_huruf'];
				}
			}
			return $nilai_huruf;
		}

	}

?>
