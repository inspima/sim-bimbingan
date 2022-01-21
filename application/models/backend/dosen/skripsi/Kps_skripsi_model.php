<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	class Kps_skripsi_model extends CI_Model
	{

		public function read($year)
		{
			$this->db->select('u.id_ujian, u.id_skripsi, u.status_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, s.status_skripsi, g.gelombang, sr.semester, d.departemen');
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
			$this->db->order_by('u.id_ujian', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_filter($year)
		{
			$this->db->select('u.id_ujian, u.id_skripsi, u.status_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, s.status_skripsi, g.gelombang, sr.semester, d.departemen');
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
			$this->db->where('YEAR(u.tanggal)', $year);
			$this->db->order_by('u.id_ujian', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_by_status($status)
		{
			$this->db->select('s.*,u.id_ujian, u.id_skripsi, u.status_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, s.status_skripsi, g.gelombang, sr.semester, d.departemen');
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
			if($status=='persetujuan'||empty($status)){
				$this->db->where('s.status_skripsi =', STATUS_SKRIPSI_UJIAN_SETUJUI_PENGUJI);
			}else if($status=='ujian'){
				$this->db->where('s.status_skripsi >', STATUS_SKRIPSI_UJIAN_SETUJUI_PENGUJI);
				$this->db->where('s.status_skripsi <', STATUS_SKRIPSI_UJIAN_SELESAI);
			}else if($status=='selesai'){
				$this->db->where('s.status_skripsi >=', STATUS_SKRIPSI_UJIAN_SELESAI);
			}
			$this->db->order_by('u.id_ujian', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_data()
		{
			$stts = array('3', '4');
			$this->db->select('u.id_ujian, u.id_skripsi, u.status_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, s.status_skripsi, g.gelombang, sr.semester, d.departemen');
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
			$this->db->order_by('u.id_ujian', 'desc');

			$query = $this->db->get();
			return $query->result_array();
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

		public function unapprove($id_skripsi,$id_ujian){
			// Delete Dokumen , Dokumen Tujuan & Persetujuan
			$this->db->query("delete from dokumen_tujuan where id_dokumen IN(select id_dokumen from dokumen where id_jadwal='{$id_ujian}')");
			$this->db->query("delete from dokumen_persetujuan where id_dokumen IN(select id_dokumen from dokumen where id_jadwal='{$id_ujian}')");
			$this->db->query("delete from dokumen where id_jadwal='{$id_ujian}'");
			// Delete penguji dan jadwal
			$this->db->query("delete from penguji where id_ujian='{$id_ujian}'");
			$this->db->query("delete from ujian where id_ujian='{$id_ujian}'");

		}

	}

?>
