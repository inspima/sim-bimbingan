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
			$this->db->select('s.*,p.id_penguji, p.status_tim,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.*, d.departemen,jud.judul');
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
			$this->db->select('s.*,p.id_penguji, p.status_tim,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.*,jud.judul');
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
			$this->db->select('s.*,p.id_penguji, p.status_tim,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.*,jud.judul');
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

		public function read_laporan_dosen_skripsi()
		{
			$query = $this->db->query("
			SELECT
				p.nama,
				p.nip,
				( SELECT COUNT(*) FROM pembimbing WHERE nip = p.nip AND STATUS = '2' ) pembimbing_utama,
				0 pembimbing_anggota,
				( SELECT COUNT(*) FROM penguji WHERE nip = p.nip AND STATUS = '2' AND status_tim = '1' ) penguji_utama,
				( SELECT COUNT(*) FROM penguji WHERE nip = p.nip AND STATUS = '2' AND status_tim = '2' ) penguji_anggota 
			FROM
				pegawai p 
			WHERE
				p.jenis_pegawai = 1 
			GROUP BY
				p.nama,
				p.nip 
			ORDER BY
				p.nama
			");

			return $query->result_array();
		}

		public function read_detail_laporan_skripsi($nip, $tipe)
		{
			if ($tipe == 'pembimbing_utama') {
				$this->db->select('s.*, m.*, d.departemen,jud.judul, d.departemen, sr.semester,g.gelombang');
				$this->db->from('skripsi s');
				$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
				$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
				$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1  and jud.persetujuan=1');
				$this->db->join('pembimbing pem', 'pem.id_skripsi = s.id_skripsi');
				$this->db->join('mahasiswa m', 's.nim = m.nim');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
				$this->db->where('pem.nip', $nip);
				$this->db->where('pem.status', 2);
			} else if ($tipe == 'pembimbing_anggota') {

			} else if ($tipe == 'penguji_utama') {
				$this->db->select('s.*,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.*, d.departemen,jud.judul, d.departemen, sr.semester,g.gelombang');
				$this->db->from('skripsi s');
				$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
				$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
				$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1  and jud.persetujuan=1');
				$this->db->join('ujian u', 's.id_skripsi = u.id_skripsi');
				$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
				$this->db->join('jam j', 'u.id_jam = j.id_jam');
				$this->db->join('penguji peng', 'peng.id_ujian = u.id_ujian');
				$this->db->join('mahasiswa m', 's.nim = m.nim');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
				$this->db->where('peng.nip', $nip);
				$this->db->where('peng.status', 2);
				$this->db->where('peng.status_tim', 1);
			} else if ($tipe == 'penguji_anggota') {
				$this->db->select('s.*,u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.*, d.departemen,jud.judul, d.departemen, sr.semester,g.gelombang');
				$this->db->from('skripsi s');
				$this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
				$this->db->join('semester sr', 'g.id_semester = sr.id_semester');
				$this->db->join('judul jud', 'jud.id_skripsi = s.id_skripsi and jud.status=1  and jud.persetujuan=1');
				$this->db->join('ujian u', 's.id_skripsi = u.id_skripsi');
				$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
				$this->db->join('jam j', 'u.id_jam = j.id_jam');
				$this->db->join('penguji peng', 'peng.id_ujian = u.id_ujian');
				$this->db->join('mahasiswa m', 's.nim = m.nim');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
				$this->db->where('peng.nip', $nip);
				$this->db->where('peng.status', 2);
				$this->db->where('peng.status_tim', 2);
			}

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_dosen_tesis()
		{
			$query = $this->db->query("
			SELECT
				p.nama,
				nip,
				( SELECT COUNT(*) FROM tesis WHERE nip_pembimbing_satu = p.nip ) pembimbing_utama,
				( SELECT COUNT(*) FROM tesis WHERE nip_pembimbing_dua = p.nip ) pembimbing_anggota,
				( SELECT COUNT(*) FROM penguji_tesis WHERE nip = p.nip AND STATUS = '2' AND status_tim = '1' ) penguji_utama,
				( SELECT COUNT(*) FROM penguji_tesis WHERE nip = p.nip AND STATUS = '2' AND status_tim = '2' ) penguji_anggota 
			FROM
				pegawai p 
			WHERE
				p.jenis_pegawai = 1 
			GROUP BY
				p.nama,
				p.nip 
			ORDER BY
				p.nama
			");

			return $query->result_array();
		}

		public function read_detail_laporan_tesis($nip, $tipe)
		{
			if ($tipe == 'pembimbing_utama') {
				$this->db->select('s.*, jd.judul, d.departemen ,m.*, mt.nm_minat');
				$this->db->from('tesis s');
				$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
				$this->db->join('mahasiswa m', 'm.nim= s.nim');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen','left');
				$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat','left');
				$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
				$this->db->where('s.nip_pembimbing_satu',$nip);
			} else if ($tipe == 'pembimbing_anggota') {
				$this->db->select('s.*, jd.judul, d.departemen ,m.*, mt.nm_minat');
				$this->db->from('tesis s');
				$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
				$this->db->join('mahasiswa m', 'm.nim= s.nim');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen','left');
				$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat','left');
				$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
				$this->db->where('s.nip_pembimbing_dua',$nip);
			} else if ($tipe == 'penguji_utama') {
				$this->db->select('s.*, jd.judul, d.departemen ,m.*, mt.nm_minat');
				$this->db->from('tesis s');
				$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
				$this->db->join('mahasiswa m', 'm.nim= s.nim');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen','left');
				$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat','left');
				$this->db->join('ujian_tesis uj', 'uj.id_tesis = s.id_tesis');
				$this->db->join('penguji_tesis pt', 'uj.id_ujian = pt.id_ujian');
				$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
				$this->db->where('pt.nip',$nip);
				$this->db->where('pt.status','2');
				$this->db->where('pt.status_tim','1');
			} else if ($tipe == 'penguji_anggota') {
				$this->db->select('s.*, jd.judul, d.departemen ,m.*, mt.nm_minat');
				$this->db->from('tesis s');
				$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
				$this->db->join('mahasiswa m', 'm.nim= s.nim');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen','left');
				$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat','left');
				$this->db->join('ujian_tesis uj', 'uj.id_tesis = s.id_tesis');
				$this->db->join('penguji_tesis pt', 'uj.id_ujian = pt.id_ujian');
				$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
				$this->db->where('pt.nip',$nip);
				$this->db->where('pt.status','2');
				$this->db->where('pt.status_tim','2');
			}

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_laporan_dosen_disertasi()
		{
			$query = $this->db->query("
			SELECT
				p.nama,
				nip,
				( SELECT COUNT(*) FROM disertasi WHERE nip_penasehat = p.nip) penasehat,
				( SELECT COUNT(*) FROM promotor WHERE nip = p.nip and status='2' and status_tim='1') promotor,
				( SELECT COUNT(*) FROM promotor WHERE nip = p.nip and status='2' and status_tim='2') co_promotor,
				( SELECT COUNT(*) FROM penguji_disertasi WHERE nip = p.nip AND STATUS = '2' AND status_tim = '1' ) penguji_utama,
				( SELECT COUNT(*) FROM penguji_disertasi WHERE nip = p.nip AND STATUS = '2' AND status_tim = '2' ) penguji_anggota 
			FROM
				pegawai p 
			WHERE
				p.jenis_pegawai = 1 
			GROUP BY
				p.nama,
				p.nip 
			ORDER BY
				p.nama
			");

			return $query->result_array();
		}

		public function read_detail_laporan_disertasi($nip, $tipe)
		{
			if ($tipe == 'penasehat') {
				$this->db->select('s.*,jd.judul, d.departemen ,m.*');
				$this->db->from('disertasi s');
				$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
				$this->db->join('mahasiswa m', 'm.nim= s.nim');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
				$this->db->where('s.nip_penasehat', $nip);
				$this->db->order_by('s.tgl_pengajuan', 'desc');
			} else if ($tipe == 'promotor') {
				$this->db->select('s.*,jd.judul, d.departemen ,m.*');
				$this->db->from('disertasi s');
				$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
				$this->db->join('mahasiswa m', 'm.nim= s.nim');
				$this->db->join('promotor pr', 's.id_disertasi= pr.id_disertasi');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
				$this->db->where('pr.nip', $nip);
				$this->db->where('pr.status', 2);
				$this->db->where('pr.status_tim', 1);
				$this->db->order_by('s.tgl_pengajuan', 'desc');
			} else if ($tipe == 'co_promotor') {
				$this->db->select('s.*,jd.judul, d.departemen ,m.*');
				$this->db->from('disertasi s');
				$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
				$this->db->join('mahasiswa m', 'm.nim= s.nim');
				$this->db->join('promotor pr', 's.id_disertasi= pr.id_disertasi');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
				$this->db->where('pr.nip', $nip);
				$this->db->where('pr.status', 2);
				$this->db->where('pr.status_tim', 2);
				$this->db->order_by('s.tgl_pengajuan', 'desc');
			} else if ($tipe == 'penguji_utama') {
				$this->db->select('s.*,jd.judul, d.departemen ,m.*');
				$this->db->from('disertasi s');
				$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
				$this->db->join('mahasiswa m', 'm.nim= s.nim');
				$this->db->join('ujian_disertasi u', 's.id_disertasi= u.id_disertasi');
				$this->db->join('penguji_disertasi pr', 'u.id_ujian= pr.id_ujian');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
				$this->db->where('pr.nip', $nip);
				$this->db->where('pr.status', 2);
				$this->db->where('pr.status_tim', 1);
			} else if ($tipe == 'penguji_anggota') {
				$this->db->select('s.*,jd.judul, d.departemen ,m.*');
				$this->db->from('disertasi s');
				$this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
				$this->db->join('mahasiswa m', 'm.nim= s.nim');
				$this->db->join('ujian_disertasi u', 's.id_disertasi= u.id_disertasi');
				$this->db->join('penguji_disertasi pr', 'u.id_ujian= pr.id_ujian');
				$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
				$this->db->where('pr.nip', $nip);
				$this->db->where('pr.status', 2);
				$this->db->where('pr.status_tim', 2);
			}

			$query = $this->db->get();
			return $query->result_array();
		}

	}

?>
