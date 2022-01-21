<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	class Kps_proposal_model extends CI_Model
	{

		public function read()
		{
			$this->db->select('s.id_skripsi, s.tgl_pengajuan, s.judul, s.berkas_proposal, ,s.keterangan_proposal, s.status_ujian_proposal, dn.departemen, sr.semester, m.nim, m.nama, g.gelombang ');
			$this->db->from('skripsi s');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.jenis', 1);
			$this->db->where('s.status_proposal', 2);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_gelombang($id_gelombang)
		{
			$this->db->select('s.id_skripsi, s.tgl_pengajuan, s.judul, s.berkas_proposal, ,s.keterangan_proposal, s.status_ujian_proposal, dn.departemen, sr.semester, m.nim, m.nama, g.gelombang ');
			$this->db->from('skripsi s');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.jenis', 1);
			$this->db->where('s.id_gelombang', $id_gelombang);
			$this->db->where('s.status_proposal', 2);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_by_status($status)
		{
			$this->db->select('s.*, dn.departemen, sr.semester, m.nim, m.nama, g.gelombang ');
			$this->db->from('skripsi s');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.jenis', 1);
			if ($status == 'baru'||empty($status)) {
				$this->db->where('s.status_proposal<=', STATUS_SKRIPSI_PROPOSAL_SETUJUI_PENGUJI);
			} else if ($status == 'ujian') {
				$this->db->where('s.status_proposal>', STATUS_SKRIPSI_PROPOSAL_SETUJUI_PENGUJI);
				$this->db->where('s.status_proposal<', STATUS_SKRIPSI_PROPOSAL_SELESAI);
			} else if ($status == 'selesai') {
				$this->db->where('s.status_proposal>=', STATUS_SKRIPSI_PROPOSAL_SELESAI);
			}
			$this->db->order_by('s.id_skripsi', 'desc');

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

		public function read_penguji($id_skripsi)
		{
			$stts = array(
				'1',
				'2'
			);
			$this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama');
			$this->db->from('penguji p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
			$this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
			$this->db->where_in('p.status', $stts);
			$this->db->where('u.status', 1);
			$this->db->where('s.id_skripsi', $id_skripsi);
			$this->db->order_by('p.status_tim', 'asc');
			$query = $this->db->get();
			return $query->result_array();
		}


	}

?>
