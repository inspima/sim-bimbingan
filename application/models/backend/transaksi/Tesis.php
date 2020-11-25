<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tesis extends CI_Model {

    // TESIS

    public function read_kualifikasi_mahasiswa($username) {
        $this->db->select('s.*,pg.nip nip_penasehat,pg.nama nama_penasehat, d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg', 'pg.nip = s.nip_penasehat', 'left');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_kualifikasi >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_kualifikasi() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_kualifikasi >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mpkk_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_mpkk >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mpkk() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_mpkk >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_proposal_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_proposal >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_proposal() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_proposal >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mkpd_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_mkpd >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mkpd() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_mkpd >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_kelayakan_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_kelayakan >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_kelayakan() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_kelayakan >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_tertutup_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_tertutup >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_tertutup() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_tertutup >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_terbuka_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_terbuka >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_terbuka() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_terbuka >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read($username) {
        $this->db->select('s.id_skripsi, s.id_departemen, s.tgl_pengajuan,s.status_kualifikasi,  s.berkas_proposal, s.status_proposal, d.departemen');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.jenis', 1);
        $this->db->order_by('s.id_skripsi', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    function read_aktif($username) {
        $stts = array('1', '2');
        $this->db->select('s.id_skripsi, s.id_departemen, s.tgl_pengajuan,s.status_kualifikasi, s.berkas_proposal, s.status_proposal, d.departemen ');
        $this->db->from('tesis s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.jenis', 1);
        $this->db->where_in('s.status_kualifikasi', $stts);
        $this->db->limit(1);
        $this->db->order_by('s.id_skripsi', 'desc');

        $query = $this->db->get();
        return $query->row();
    }

    public function save($data) {
        $this->db->insert('tesis', $data);
    }

    function detail($id) {
        $this->db->select('s.*,dn.departemen, m.nim, m.nama,jd.judul,pr.nm_prodi,jn.jenjang');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('departemen dn', 's.id_departemen = dn.id_departemen', 'left');
        //$this->db->join('pegawai pg', 'pg.nip = s.nip_penasehat', 'left');
        $this->db->join('mahasiswa m', 's.nim = m.nim');
        $this->db->join('prodi pr', 'pr.id_prodi= m.id_prodi', 'left');
        $this->db->join('jenjang jn', 'jn.id_jenjang= m.id_jenjang', 'left');
        $this->db->where('s.id_skripsi', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function update($data, $id_skripsi) {
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('tesis', $data);
    }

    // JUDUL TESIS

    public function read_judul($id_skripsi) {
        $this->db->select('j.judul');
        $this->db->from('judul_tesis j');
        $this->db->join('tesis s', 'j.id_skripsi = s.id_skripsi');
        $this->db->where('j.id_skripsi', $id_skripsi);
        $this->db->order_by('j.id_judul', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function save_judul($data) {
        $this->db->insert('judul_tesis', $data);
    }

    // PENGUJI

    public function read_permintaan_penguji($username, $jenis) {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama,uj.id_ujian');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen');
        $this->db->join('ujian_tesis uj', 'uj.id_skripsi = s.id_skripsi');
        $this->db->where('uj.jenis_ujian', $jenis);
        $this->db->where('`uj`.`id_ujian` IN (SELECT `id_ujian` from `penguji_tesis` where `status` in (1,2) and `nip`=\'' . $username . '\')', NULL, FALSE);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_penguji($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_ujian', $id_ujian);
        $this->db->where_in('p.status', $stts);
        $this->db->order_by('p.status_tim', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cek_penguji($data) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji');
        $this->db->from('penguji_tesis p');
        $this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
        $this->db->where('u.id_ujian', $data['id_ujian']);
        $this->db->where('p.nip', $data['nip']);
        $this->db->where('u.status', 1);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function read_penguji_ketua($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('id_penguji');
        $this->db->from('penguji_tesis');
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('status_tim', 1);
        $this->db->where_in('status', $stts);

        $query = $this->db->get();
        return $query->row();
    }

    public function read_penguji_anggota($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('id_penguji');
        $this->db->from('penguji_tesis');
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('status_tim', 2);
        $this->db->where_in('status', $stts);

        $query = $this->db->get();
        return $query->row();
    }

    public function read_pengujibentrok($tanggal, $id_jam, $nip) {
        $stts = array('1', '2');
        $this->db->select('u.id_ujian');
        $this->db->from('ujian u');
        $this->db->join('penguji p', 'u.id_ujian = p.id_ujian');
        $this->db->where('u.tanggal', $tanggal);
        $this->db->where('u.id_jam', $id_jam);
        $this->db->where('p.nip', $nip);
        $this->db->where('u.status', 1);
        $this->db->where_in('p.status', $stts);
        $s1_s2 = $this->db->get();
        $s1_s2->row();

        $this->db->select('u.id_ujian');
        $this->db->from('ujian_tesis u');
        $this->db->join('penguji p', 'u.id_ujian = p.id_ujian');
        $this->db->where('u.tanggal', $tanggal);
        $this->db->where('u.id_jam', $id_jam);
        $this->db->where('p.nip', $nip);
        $this->db->where('u.status', 1);
        $this->db->where_in('p.status', $stts);
        $s3 = $this->db->get();
        $s3->row();

        if (empty($s1_s2) && empty($s3)) {
            return true;
        } else {
            return false;
        }
    }

    public function count_penguji($id_ujian) {
        $stts = array('1', '2');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('ujian_tesis u', 'p.id_ujian = u.id_ujian');
        $this->db->where_in('p.status', $stts);
        $this->db->where('u.status', 1);
        $this->db->where('u.id_ujian', $id_ujian);

        $query = $this->db->count_all_results();
        return $query;
    }

    public function semua_penguji_setuju($id_ujian) {

        $jumlah_penguji = $this->count_penguji($id_ujian);
        $stts = array('2');
        $this->db->from('penguji_tesis p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('ujian_tesis u', 'p.id_ujian = u.id_ujian');
        $this->db->where_in('p.status', $stts);
        $this->db->where('u.status', 1);
        $this->db->where('u.id_ujian', $id_ujian);
        $jumlah_setuju = $this->db->count_all_results();
        if ($jumlah_penguji == $jumlah_setuju) {
            return true;
        } else {
            return false;
        }
    }

    public function save_penguji($data) {
        $this->db->insert('penguji_tesis', $data);
    }

    public function update_penguji($data, $id_penguji) {
        $this->db->where('id_penguji', $id_penguji);
        $this->db->update('penguji_tesis', $data);
    }

    // PENASEHAT AKADEMIK
    public function read_permintaan_penasehat($username) {
        $this->db->select('s.*,jd.judul,pg.nama nama_penasehat,pg.nip nip_penasehat, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('pegawai pg', 'pg.nip = s.nip_penasehat', 'left');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('`s`.`id_skripsi` IN (SELECT `id_skripsi` from `tesis` where `nip_penasehat`=\'' . $username . '\')', NULL, FALSE);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    // Promotor

    public function read_permintaan_promotor($username) {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('tesis s');
        $this->db->join('judul_tesis jd', 'jd.id_skripsi=s.id_skripsi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen');
        $this->db->where('`s`.`id_skripsi` IN (SELECT `id_skripsi` from `promotor` where `status` in (1,2) and `nip`=\'' . $username . '\')', NULL, FALSE);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_promotor_kopromotor($id_skripsi) {
        $stts = array('1', '2');
        $this->db->select('p.id_pembimbing, p.nip, p.status_bimbingan, p.status, pg.nama');
        $this->db->from('pembimbing p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_skripsi', $id_skripsi);
        $this->db->where_in('p.status', $stts);
        $this->db->order_by('p.status_bimbingan', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_status_promotor($id_skripsi, $nip) {
        $stts = array('1', '2');
        $this->db->select('p.*');
        $this->db->from('pembimbing p');
        $this->db->join('tesis d', 'd.id_skripsi = p.id_skripsi');
        $this->db->where('d.id_skripsi', $id_skripsi);
        $this->db->where('p.nip', $nip);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_promotor_ada($id_skripsi) {
        $stts = array('1', '2');
        $this->db->select('p.id_promotor');
        $this->db->from('promotor p');
        $this->db->join('tesis d', 'd.id_skripsi = p.id_skripsi');
        $this->db->where('d.id_skripsi', $id_skripsi);
        $this->db->where('p.status_tim', 1);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_promotor_kopromotor($data) {
        $stts = array('1', '2');
        $this->db->select('p.id_promotor');
        $this->db->from('promotor p');
        $this->db->join('tesis d', 'd.id_skripsi = p.id_skripsi');
        $this->db->where('d.id_skripsi', $data['id_skripsi']);
        $this->db->where('p.nip', $data['nip']);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function count_promotor($id_skripsi) {
        $stts = array('1', '2');
        $this->db->from('promotor p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('tesis d', 'p.id_skripsi = d.id_skripsi');
        $this->db->where_in('p.status', $stts);
        $this->db->where('d.id_skripsi', $id_skripsi);

        $query = $this->db->count_all_results();
        return $query;
    }

    public function save_promotor($data) {
        $this->db->insert('promotor', $data);
    }

    public function update_promotor($data, $id_promotor) {
        $this->db->where('id_promotor', $id_promotor);
        $this->db->update('promotor', $data);
    }

    // JADWAL

    public function read_jadwal($id_skripsi, $jenis_ujian) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_tesis u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_skripsi', $id_skripsi);
        $this->db->where('u.jenis_ujian', $jenis_ujian);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_ruang_terpakai($data) {
        $this->db->select('u.id_ujian');
        $this->db->from('ujian u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.tanggal', $data['tanggal']);
        $this->db->where('u.id_ruang', $data['id_ruang']);
        $this->db->where('u.id_jam', $data['id_jam']);
        $this->db->where('u.status', 1);
        $s1_s2 = $this->db->get();
        $s1_s2->row();

        $this->db->select('u.id_ujian');
        $this->db->from('ujian_tesis u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.tanggal', $data['tanggal']);
        $this->db->where('u.id_ruang', $data['id_ruang']);
        $this->db->where('u.id_jam', $data['id_jam']);
        $this->db->where('u.status', 1);
        $s3 = $this->db->get();
        $s3->row();

        if (empty($s1_s2) && empty($s3)) {
            return true;
        } else {
            return false;
        }
    }

    // UJIAN

    public function detail_ujian_by_tesis($id_skripsi, $jenis) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_tesis u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_skripsi', $id_skripsi);
        $this->db->where('u.jenis_ujian', $jenis);
        $query = $this->db->get();
        return $query->row();
    }

    public function detail_ujian($id_ujian) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_tesis u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_ujian', $id_ujian);
        $query = $this->db->get();
        return $query->row();
    }

    public function save_ujian($data) {
        $this->db->insert('ujian_tesis', $data);
    }

    public function update_ujian($data, $id_ujian) {
        $this->db->where('id_ujian', $id_ujian);
        $this->db->update('ujian_tesis', $data);
    }

    public function read_status_ujian($jenis) {
        if ($jenis == 1) {
            return [
                ['value' => '0', 'text' => 'Belum Ujian'],
                ['value' => '1', 'text' => 'Lulus'],
                ['value' => 'u', 'text' => 'Mengulang Kembali'],
                ['value' => 'g', 'text' => 'Gagal Studi'],
            ];
        } else if ($jenis == 2) {
            return [
                ['value' => '0', 'text' => 'Belum Ujian'],
                ['value' => '1', 'text' => 'Dilanjutkan'],
                ['value' => 'u', 'text' => 'Mengulang Kembali'],
                ['value' => 't', 'text' => 'Ditolak'],
                ['value' => 'g', 'text' => 'Gagal Studi'],
            ];
        } 
    }

    public function get_status_ujian($status_ujian, $jenis) {
        $result = '';
        $status_ujians = $this->read_status_ujian($jenis);
        foreach ($status_ujians as $s) {
            if ($s['value'] == $status_ujian) {
                $result = $s['text'];
            }
        }
        return $result;
    }

    public function read_status_tahapan($urutan) {
        if ($urutan == 1) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => 1,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => 2,
                    'text' => 'Disetujui PA',
                    'keterangan' => 'Disetujui oleh Penasehat Akademik',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 4,
                    'text' => 'Dijadwalkan',
                    'keterangan' => 'Telah dijadwalkan Oleh Penasehat Akademik untuk Ujian dan pengajuan dosen penguji',
                    'color' => 'bg-navy'
                ],
                [
                    'value' => 5,
                    'text' => 'Disetujui Penguji',
                    'keterangan' => 'Disetujui  oleh semua penguji',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 6,
                    'text' => 'Disetujui SPS',
                    'keterangan' => 'Disetujui Sekertaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 7,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 8,
                    'text' => 'Ujian',
                    'keterangan' => 'Sedang menunggu masa jadwal Ujian',
                    'color' => 'bg-purple'
                ],
                [
                    'value' => 9,
                    'text' => 'Ujian Selesai',
                    'keterangan' => 'Telah menyelesaikan Ujian',
                    'color' => 'bg-maroon-active'
                ],
                [
                    'value' => 10,
                    'text' => 'Pengajuan Promotor',
                    'keterangan' => 'Pengajuan Promotor Dan Ko-Promotor Oleh Mahasiswa',
                    'color' => 'bg-aqua'
                ],
                [
                    'value' => 11,
                    'text' => 'Disetujui Promotor',
                    'keterangan' => 'Disetujui oleh semua Promotor & Ko-Promotor',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 12,
                    'text' => 'Selesai',
                    'keterangan' => '',
                    'color' => 'bg-red'
                ],
            ];
        } else if ($urutan == 2) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => 1,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => 2,
                    'text' => 'Disetujui Promotor',
                    'keterangan' => 'Disetujui Oleh Promotor/Ko-promotor dan mengisi form Mata Kuliah',
                    'color' => 'bg-grren'
                ],
                [
                    'value' => 3,
                    'text' => 'Disetujui SPS',
                    'keterangan' => 'Disetujui Sekertaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 4,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => 5,
                    'text' => 'Selesai',
                    'keterangan' => '',
                    'color' => 'bg-red'
                ],
            ];
        }
    }

    public function get_status_tahapan($status_tahapan, $jenis) {
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
 