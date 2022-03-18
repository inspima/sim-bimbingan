<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Laporan_mahasiswa_model extends CI_Model
	{

		public function __construct()
		{
			parent::__construct();
		}

		public function read_laporan_mahasiswa_skripsi_proposal()
		{
			$this->db->select('s.*, dn.departemen, sr.semester, m.nim, m.nama, g.gelombang,jud.judul');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.status_proposal>=', STATUS_SKRIPSI_PROPOSAL_PENGAJUAN);
			$this->db->where('s.status_proposal<', STATUS_SKRIPSI_PROPOSAL_SELESAI);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_skripsi_ujian()
		{
			$this->db->select('s.*, dn.departemen, sr.semester, m.nim, m.nama, g.gelombang,jud.judul');
			$this->db->from('skripsi s');
			$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
			$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
			$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->where('s.status_proposal>=', STATUS_SKRIPSI_PROPOSAL_SELESAI);
			$this->db->where('s.status_skripsi>=', STATUS_SKRIPSI_UJIAN_PENGAJUAN);
			$this->db->where('s.status_skripsi<', STATUS_SKRIPSI_UJIAN_SELESAI);
			$this->db->order_by('s.id_skripsi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_tesis_judul()
		{
			$this->db->select('s.*, jd.judul, d.departemen ,m.*, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen','left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat','left');
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			$this->db->where('s.status_judul>=', STATUS_TESIS_JUDUL_PENGAJUAN);
			$this->db->where('s.status_judul!=', STATUS_TESIS_JUDUL_DITOLAK);
			$this->db->where('s.status_proposal<', STATUS_TESIS_PROPOSAL_PENGAJUAN);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_tesis_proposal()
		{
			$this->db->select('s.*, jd.judul, d.departemen ,m.*, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen','left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat','left');
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			$this->db->where('s.status_proposal>=', STATUS_TESIS_PROPOSAL_PENGAJUAN);
			$this->db->where('s.status_proposal<', STATUS_TESIS_PROPOSAL_UJIAN_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_tesis_mkpt()
		{
			$this->db->select('s.*, jd.judul, d.departemen ,m.*, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen','left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat','left');
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			$this->db->where('s.status_mkpt>=', STATUS_TESIS_MKPT_PENGAJUAN);
			$this->db->where('s.status_mkpt<', STATUS_TESIS_MKPT_UJIAN_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_tesis_ujian()
		{
			$this->db->select('s.*, jd.judul, d.departemen ,m.*, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen','left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat','left');
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			$this->db->where('s.status_tesis>=', STATUS_TESIS_UJIAN_PENGAJUAN);
			$this->db->where('s.status_tesis<', STATUS_TESIS_UJIAN_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_disertasi_kualifikasi()
		{
			$this->db->select('s.*,jd.judul, d.departemen ,m.*');
			$this->db->from('disertasi s');
			$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_kualifikasi>=', STATUS_DISERTASI_KUALIFIKASI_PENGAJUAN);
			$this->db->where('s.status_kualifikasi<', STATUS_DISERTASI_KUALIFIKASI_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_disertasi_promotor()
		{
			$this->db->select('s.*,jd.judul, d.departemen ,m.*');
			$this->db->from('disertasi s');
			$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_promotor>=', STATUS_DISERTASI_PROMOTOR_PENGAJUAN);
			$this->db->where('s.status_promotor<', STATUS_DISERTASI_PROMOTOR_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_disertasi_mkpkk()
		{
			$this->db->select('s.*,jd.judul, d.departemen ,m.*');
			$this->db->from('disertasi s');
			$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_mpkk>=', STATUS_DISERTASI_MPKK_PENGAJUAN);
			$this->db->where('s.status_mpkk<', STATUS_DISERTASI_MPKK_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_disertasi_proposal()
		{
			$this->db->select('s.*,jd.judul, d.departemen ,m.*');
			$this->db->from('disertasi s');
			$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_proposal>=', STATUS_DISERTASI_PROPOSAL_PENGAJUAN);
			$this->db->where('s.status_proposal<', STATUS_DISERTASI_PROPOSAL_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_disertasi_mkpd()
		{
			$this->db->select('s.*,jd.judul, d.departemen ,m.*');
			$this->db->from('disertasi s');
			$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_mkpd>=', STATUS_DISERTASI_MKPD_PENGAJUAN);
			$this->db->where('s.status_mkpd<', STATUS_DISERTASI_MKPD_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_disertasi_kelayakan()
		{
			$this->db->select('s.*,jd.judul, d.departemen ,m.*');
			$this->db->from('disertasi s');
			$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_kelayakan>=', STATUS_DISERTASI_KELAYAKAN_PENGAJUAN);
			$this->db->where('s.status_kelayakan<', STATUS_DISERTASI_KELAYAKAN_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_disertasi_tertutup()
		{
			$this->db->select('s.*,jd.judul, d.departemen ,m.*');
			$this->db->from('disertasi s');
			$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_tertutup>=', STATUS_DISERTASI_TERTUTUP_PENGAJUAN);
			$this->db->where('s.status_tertutup<', STATUS_DISERTASI_TERTUTUP_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_mahasiswa_disertasi_terbuka()
		{
			$this->db->select('s.*,jd.judul, d.departemen ,m.*');
			$this->db->from('disertasi s');
			$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_terbuka>=', STATUS_DISERTASI_TERBUKA_PENGAJUAN);
			$this->db->where('s.status_terbuka<', STATUS_DISERTASI_TERBUKA_SELESAI);
			$query = $this->db->get();
			return $query->result_array();
		}


	}

?>
