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
			$this->db->where('s.jenis', 1);
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
			$this->db->where('s.jenis', 1);
			$this->db->where('s.status_proposal >=', STATUS_SKRIPSI_PROPOSAL_SETUJUI_KADEP);
			$this->db->where('s.status_proposal <', STATUS_SKRIPSI_PROPOSAL_SELESAI);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_kadep_selesai($id_departemen)
		{
			$status_ujians = ['1', '2'];
			$this->db->select('s.*, dn.departemen, sr.semester, m.nim, m.nama ,jud.judul');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.id_departemen', $id_departemen);
			$this->db->where_in('s.status_ujian_proposal', $status_ujians);
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
			$this->db->where('s.jenis', 1);
			$this->db->where('s.status_proposal', STATUS_SKRIPSI_PROPOSAL_DITOLAK);
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

		function detail_proposal($id_skripsi)
		{
			$this->db->select('s.id_skripsi, s.tgl_pengajuan, jud.judul, s.berkas_proposal, s.id_departemen, s.status_proposal, s.status_ujian_proposal, s.keterangan_proposal, dn.departemen, sr.semester, m.nim, m.nama ');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
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
			$this->db->where('s.jenis', 2);
			$this->db->limit(1);
			$this->db->order_by('s.id_skripsi', 'desc');

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
			$this->db->select('pg.nama');
			$this->db->from('pegawai pg');
			$this->db->join('pembimbing p', 'pg.nip = p.nip');
			$this->db->join('skripsi s', 'p.id_skripsi = s.id_skripsi');
			$this->db->where('s.id_skripsi', $id_skripsi);
			$this->db->where('p.status', 2);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_pembimbing($id_skripsi)
		{
			$this->db->select('p.id_pembimbing, p.id_skripsi, pg.nama, p.status ');
			$this->db->from('pembimbing p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_skripsi', $id_skripsi);
			$this->db->where('p.status !=', 4);
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

		// Ujian

		public function read_ujian_proposal($id_skripsi)
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
			$this->db->where('u.jenis_ujian', 1);
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
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
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
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
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

		public function read_pengujiketua($id_ujian)
		{
			$stts = array('1', '2');
			$this->db->select('id_penguji');
			$this->db->from('penguji');
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('status_tim', 1);
			$this->db->where_in('status', $stts);

			$query = $this->db->get();
			return $query->row();
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

		public function update_penguji($data, $id_penguji)
		{
			$this->db->where('id_penguji', $id_penguji);
			$this->db->update('penguji', $data);
		}

		// Status

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
						'keterangan' => 'Disetujui oleh Kepala Departemen',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_DIJADWALKAN,
						'text' => 'Dijadwalkan',
						'keterangan' => 'Dijadwalkan, diajukan Penguji dan Pembimbing oleh Kepala Departemen',
						'color' => 'bg-navy'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_SETUJUI_PENGUJI,
						'text' => 'Disetujui Penguji',
						'keterangan' => 'Disetujui oleh semua penguji (3)',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_UJIAN,
						'text' => 'Ujian',
						'keterangan' => 'Sedang menunggu masa jadwal Ujian',
						'color' => 'bg-purple'
					],
					[
						'value' => STATUS_SKRIPSI_PROPOSAL_SELESAI,
						'text' => 'Ujian Selesai',
						'keterangan' => 'Selesai, hasil sudah ditentukan oleh Kepala Departemen',
						'color' => 'bg-maroon-active'
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
						'text' => 'Pengajuan',
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
						'keterangan' => 'Dijadwalkan oleh Kepala Departemen, pengajuan penguji',
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

	}

?>
