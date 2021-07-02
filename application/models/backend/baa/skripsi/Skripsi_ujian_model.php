<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	class Skripsi_ujian_model extends CI_Model
	{

		public function read()
		{
			$this->db->select('u.id_ujian, u.id_skripsi, u.status_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, s.status_skripsi, g.gelombang, sr.semester, d.departemen, s.turnitin');
			$this->db->from('ujian u');
			$this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('u.jenis_ujian', 2);
			$this->db->where('u.status', 1);
			$this->db->where('s.jenis', 2);
			$this->db->where('s.status_skripsi >=', STATUS_SKRIPSI_UJIAN_SETUJUI_PENGUJI);
			$this->db->order_by('u.tanggal', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function detail($id_ujian)
		{
			$this->db->select('u.id_ujian, u.id_skripsi, u.status_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, m.alamat, m.telp, s.status_skripsi, s.nilai, g.gelombang, sr.semester, d.departemen');
			$this->db->from('ujian u');
			$this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('u.jenis_ujian', 2);
			$this->db->where('u.status', 1);
			$this->db->where('s.jenis', 2);
			$this->db->where('s.status_skripsi >=', STATUS_SKRIPSI_UJIAN_DIJADWALKAN);
			$this->db->where('u.id_ujian', $id_ujian);
			$this->db->order_by('u.id_ujian', 'asc');

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

		public function read_pembimbing($id_skripsi)
		{
			$stts = array('2');
			$sttsb = array('2', '3');
			$this->db->select('p.id_pembimbing, p.id_skripsi, pg.nip, pg.nama, p.status ');
			$this->db->from('pembimbing p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_skripsi', $id_skripsi);
			$this->db->where_in('p.status_bimbingan', $sttsb);
			$this->db->where_in('p.status', $stts);
			$this->db->limit(1);
			$this->db->order_by('p.id_pembimbing', 'desc');
			$query = $this->db->get();
			return $query->row();
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

		public function update_skripsi($data, $id_skripsi)
		{
			$this->db->where('id_skripsi', $id_skripsi);
			$this->db->update('skripsi', $data);
		}

		//=====
		public function read_pengujiketua($id_ujian)
		{
			$this->db->select('pg.nama, pg.nip');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_ujian', $id_ujian);
			$this->db->where('p.status_tim', 1);
			$this->db->where('p.status', 2);
			$this->db->limit(1);
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
			$this->db->select('pg.nama');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_ujian', $id_ujian);
			$this->db->where('p.status_tim', 2);
			$this->db->where('p.usulan_dosbing !=', 2);
			$this->db->where('p.status_tim !=', 1);
			$this->db->where('p.status', 2);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_wadek()
		{
			$this->db->select('pg.nip, pg.nama, pg.ttd');
			$this->db->from('pegawai pg');
			$this->db->join('struktural st', 'pg.nip = st.nip');
			$this->db->where('st.id_struktur', 2);
			$query = $this->db->get();
			return $query->row();
		}

	}

?>
