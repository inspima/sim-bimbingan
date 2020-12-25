<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Disertasi extends CI_Model {

    // DISERTASI

    public function read_mahasiswa($username) {
        $this->db->select('s.*,pg.nip nip_penasehat,pg.nama nama_penasehat, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('pegawai pg', 'pg.nip = s.nip_penasehat', 'left');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->row_array();
    }

    public function read_kualifikasi_mahasiswa($username) {
        $this->db->select('s.*,pg.nip nip_penasehat,pg.nama nama_penasehat, d.departemen ');
        $this->db->from('disertasi s');
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
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_kualifikasi >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_promotor() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_promotor >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mpkk_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_mpkk >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mpkk() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_mpkk >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_proposal_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_proposal >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_proposal() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_proposal >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mkpd_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_mkpd >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mkpd() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_mkpd >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_kelayakan_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_kelayakan >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_kelayakan() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_kelayakan >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_tertutup_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_tertutup >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_tertutup() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_tertutup >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_terbuka_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.status_terbuka >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_terbuka() {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.status_terbuka >', 0);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read($username) {
        $this->db->select('s.id_disertasi, s.id_departemen, s.tgl_pengajuan,s.status_kualifikasi,  s.berkas_proposal, s.status_proposal, d.departemen');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.jenis', 1);
        $this->db->order_by('s.id_disertasi', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    function read_aktif($username) {
        $stts = array('1', '2');
        $this->db->select('s.id_disertasi, s.id_departemen, s.tgl_pengajuan,s.status_kualifikasi, s.berkas_proposal, s.status_proposal, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('s.nim', $username);
        $this->db->where('s.jenis', 1);
        $this->db->where_in('s.status_kualifikasi', $stts);
        $this->db->limit(1);
        $this->db->order_by('s.id_disertasi', 'desc');

        $query = $this->db->get();
        return $query->row();
    }

    public function save($data) {
        $this->db->insert('disertasi', $data);
    }

    function detail($id) {
        $this->db->select('s.*,pg.nama nama_penasehat,pg.nip nip_penasehat, dn.departemen, m.nim, m.nama,jd.judul,pr.nm_prodi,jn.jenjang');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('departemen dn', 's.id_departemen = dn.id_departemen', 'left');
        $this->db->join('pegawai pg', 'pg.nip = s.nip_penasehat', 'left');
        $this->db->join('mahasiswa m', 's.nim = m.nim');
        $this->db->join('prodi pr', 'pr.id_prodi= m.id_prodi', 'left');
        $this->db->join('jenjang jn', 'jn.id_jenjang= m.id_jenjang', 'left');
        $this->db->where('s.id_disertasi', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function update($data, $id_disertasi) {
        $this->db->where('id_disertasi', $id_disertasi);
        $this->db->update('disertasi', $data);
    }

    // JUDUL DISERTASI

    public function read_judul($id_disertasi) {
        $this->db->select('j.judul');
        $this->db->from('judul_disertasi j');
        $this->db->join('disertasi s', 'j.id_disertasi = s.id_disertasi');
        $this->db->where('j.id_disertasi', $id_disertasi);
        $this->db->order_by('j.id_judul', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function save_judul($data) {
        $this->db->insert('judul_disertasi', $data);
    }

    // PENGUJI

    public function read_permintaan_penguji($username, $jenis) {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama,uj.id_ujian');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->join('ujian_disertasi uj', 'uj.id_disertasi = s.id_disertasi');
        $this->db->where('uj.jenis_ujian', $jenis);
        $this->db->where('`uj`.`id_ujian` IN (SELECT `id_ujian` from `penguji_disertasi` where `status` in (1,2) and `nip`=\'' . $username . '\')', NULL, FALSE);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_penguji($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama, pg.ttd');
        $this->db->from('penguji_disertasi p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_ujian', $id_ujian);
        $this->db->where_in('p.status', $stts);
        $this->db->order_by('p.status_tim', 'asc');
        $this->db->order_by('pg.nama', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cek_penguji($data) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji');
        $this->db->from('penguji_disertasi p');
        $this->db->join('ujian_disertasi u', 'p.id_ujian = u.id_ujian');
        $this->db->where('u.id_ujian', $data['id_ujian']);
        $this->db->where('p.nip', $data['nip']);
        $this->db->where('u.status', 1);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function read_penguji_ketua($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama, pg.ttd');
        $this->db->from('penguji_disertasi p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_ujian', $id_ujian);
        $this->db->where_in('p.status', $stts);
        $this->db->where('status_tim', 1);

        $query = $this->db->get();
        return $query->row();
    }

    public function read_penguji_anggota($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('id_penguji');
        $this->db->from('penguji_disertasi');
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
        $this->db->from('ujian_disertasi u');
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
        $this->db->from('penguji_disertasi p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('ujian_disertasi u', 'p.id_ujian = u.id_ujian');
        $this->db->where_in('p.status', $stts);
        $this->db->where('u.status', 1);
        $this->db->where('u.id_ujian', $id_ujian);

        $query = $this->db->count_all_results();
        return $query;
    }

    public function semua_penguji_setuju($id_ujian) {

        $jumlah_penguji = $this->count_penguji($id_ujian);
        $stts = array('2');
        $this->db->from('penguji_disertasi p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('ujian_disertasi u', 'p.id_ujian = u.id_ujian');
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
        $this->db->insert('penguji_disertasi', $data);
    }

    public function update_penguji($data, $id_penguji) {
        $this->db->where('id_penguji', $id_penguji);
        $this->db->update('penguji_disertasi', $data);
    }

    // PENASEHAT AKADEMIK
    public function read_permintaan_penasehat($username) {
        $this->db->select('s.*,jd.judul,pg.nama nama_penasehat,pg.nip nip_penasehat, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('pegawai pg', 'pg.nip = s.nip_penasehat', 'left');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('`s`.`id_disertasi` IN (SELECT `id_disertasi` from `disertasi` where `nip_penasehat`=\'' . $username . '\')', NULL, FALSE);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    // Promotor

    public function read_permintaan_promotor($username) {
        $this->db->select('s.*,jd.judul, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('judul_disertasi jd', 'jd.id_disertasi=s.id_disertasi and jd.status=\'1\'');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
        $this->db->where('`s`.`id_disertasi` IN (SELECT `id_disertasi` from `promotor` where `status` in (1,2) and `nip`=\'' . $username . '\')', NULL, FALSE);
        $this->db->where('s.status_promotor >=', STATUS_DISERTASI_PROMOTOR_SETUJUI_KPS);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_promotor_kopromotor($id_disertasi) {
        $stts = array('1', '2');
        $this->db->select('p.id_promotor, p.nip, p.status_tim, p.status, pg.nama');
        $this->db->from('promotor p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_disertasi', $id_disertasi);
        $this->db->where_in('p.status', $stts);
        $this->db->order_by('p.status_tim', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_status_promotor($id_disertasi, $nip) {
        $stts = array('1', '2');
        $this->db->select('p.*');
        $this->db->from('promotor p');
        $this->db->join('disertasi d', 'd.id_disertasi = p.id_disertasi');
        $this->db->where('d.id_disertasi', $id_disertasi);
        $this->db->where('p.nip', $nip);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_promotor_ada($id_disertasi) {
        $stts = array('1', '2');
        $this->db->select('p.id_promotor');
        $this->db->from('promotor p');
        $this->db->join('disertasi d', 'd.id_disertasi = p.id_disertasi');
        $this->db->where('d.id_disertasi', $id_disertasi);
        $this->db->where('p.status_tim', 1);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_promotor_kopromotor($data) {
        $stts = array('1', '2');
        $this->db->select('p.id_promotor');
        $this->db->from('promotor p');
        $this->db->join('disertasi d', 'd.id_disertasi = p.id_disertasi');
        $this->db->where('d.id_disertasi', $data['id_disertasi']);
        $this->db->where('p.nip', $data['nip']);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->row();
    }

    public function count_promotor($id_disertasi) {
        $stts = array('1', '2');
        $this->db->from('promotor p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('disertasi d', 'p.id_disertasi = d.id_disertasi');
        $this->db->where_in('p.status', $stts);
        $this->db->where('d.id_disertasi', $id_disertasi);

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

    public function semua_promotor_setujui($id_disertasi) {
        $jumlah_promotor = $this->count_promotor($id_disertasi);
        $stts = array('2');
        $this->db->from('promotor p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('disertasi u', 'p.id_disertasi = u.id_disertasi');
        $this->db->where_in('p.status', $stts);
        $jumlah_setuju = $this->db->count_all_results();
        if ($jumlah_promotor == $jumlah_setuju) {
            return true;
        } else {
            return false;
        }
    }

    // JADWAL

    public function read_jadwal($id_disertasi, $jenis_ujian) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_disertasi u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_disertasi', $id_disertasi);
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
        $this->db->from('ujian_disertasi u');
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

    public function detail_ujian_by_disertasi($id_disertasi, $jenis) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_disertasi u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_disertasi', $id_disertasi);
        $this->db->where('u.jenis_ujian', $jenis);
        $query = $this->db->get();
        return $query->row();
    }

    public function detail_ujian($id_ujian) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_disertasi u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_ujian', $id_ujian);
        $query = $this->db->get();
        return $query->row();
    }

    public function save_ujian($data) {
        $this->db->insert('ujian_disertasi', $data);
    }

    public function update_ujian($data, $id_ujian) {
        $this->db->where('id_ujian', $id_ujian);
        $this->db->update('ujian_disertasi', $data);
    }

    // MKPKK
    public function read_mkpkk() {
        $this->db->select('*');
        $this->db->from('mkpkk m');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_mkpkk_pengampu($id_mkpkk) {
        $this->db->select('m.*,p.nama');
        $this->db->from('mkpkk_pengampu m');
        $this->db->join('pegawai p', 'p.nip = m.nip');
        $this->db->where('m.id_mkpkk', $id_mkpkk);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_disertasi_mkpkk($id_disertasi) {
        $this->db->select('*');
        $this->db->from('disertasi_mkpkk m');
        $this->db->where('m.id_disertasi', $id_disertasi);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function detail_mkpkk($id) {
        $this->db->select('*');
        $this->db->from('mkpkk m');
        $this->db->where('id_mkpkk', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function save_disertasi_mkpkk($data) {
        $this->db->insert('disertasi_mkpkk', $data);
    }

    public function update_disertasi_mkpkk($data, $id_ujian) {
        $this->db->where('id_disertasi_mkpkk', $id_ujian);
        $this->db->update('disertasi_mkpkk', $data);
    }

    public function delete_disertasi_mkpkk($id_disertasi) {
        $this->db->where('id_disertasi', $id_disertasi);
        $this->db->delete('disertasi_mkpkk');
    }

    // STATUS

    public function read_status_ujian($jenis) {
        if ($jenis == UJIAN_DISERTASI_KUALIFIKASI) {
            return [
                ['value' => '0', 'text' => 'Belum Ujian'],
                ['value' => '1', 'text' => 'Lulus'],
                ['value' => 'u', 'text' => 'Mengulang Kembali'],
                ['value' => 'g', 'text' => 'Gagal Studi'],
            ];
        } else if ($jenis == UJIAN_DISERTASI_PROPOSAL) {
            return [
                ['value' => '0', 'text' => 'Belum Ujian'],
                ['value' => '1', 'text' => 'Dilanjutkan'],
                ['value' => 'u', 'text' => 'Mengulang Kembali'],
                ['value' => 't', 'text' => 'Ditolak'],
                ['value' => 'g', 'text' => 'Gagal Studi'],
            ];
        } else if ($jenis == UJIAN_DISERTASI_KELAYAKAN) {
            return [
                ['value' => '0', 'text' => 'Belum Ujian'],
                ['value' => '1', 'text' => 'Dilanjutkan'],
                ['value' => 'u', 'text' => 'Mengulang Kembali'],
            ];
        } else if ($jenis == UJIAN_DISERTASI_TERTUTUP) {
            return [
                ['value' => '0', 'text' => 'Belum Ujian'],
                ['value' => '1', 'text' => 'Dilanjutkan'],
                ['value' => 'u', 'text' => 'Mengulang Kembali'],
            ];
        } else if ($jenis == UJIAN_DISERTASI_TERBUKA) {
            return [
                ['value' => '0', 'text' => 'Belum Ujian'],
                ['value' => '1', 'text' => 'Lulus'],
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
        if ($urutan == TAHAPAN_DISERTASI_KUALIFIKASI) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_DISERTASI_KUALIFIKASI_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa, Upload Berkas Ujian Kualifikasi',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_DISERTASI_KUALIFIKASI_DIJADWALKAN,
                    'text' => 'Dijadwalkan',
                    'keterangan' => 'Telah dijadwalkan Oleh Penasehat Akademik untuk Ujian dan pengajuan dosen penguji',
                    'color' => 'bg-navy'
                ],
                [
                    'value' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PENGUJI,
                    'text' => 'Disetujui Penguji',
                    'keterangan' => 'Disetujui  oleh semua penguji',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_SPS,
                    'text' => 'Disetujui SPS',
                    'keterangan' => 'Disetujui Sekertaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_KPS,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_KUALIFIKASI_UJIAN,
                    'text' => 'Ujian',
                    'keterangan' => 'Sedang menunggu masa jadwal Ujian',
                    'color' => 'bg-purple'
                ],
				[
					'value' => STATUS_DISERTASI_KUALIFIKASI_CETAK_DOKUMEN,
					'text' => 'Persetujuan Berkas',
					'keterangan' => 'BAA Cetak semua berkas Ujian menunggu persetujuan para dosen',
					'color' => 'bg-orange'
				],
                [
                    'value' => STATUS_DISERTASI_KUALIFIKASI_SELESAI,
                    'text' => 'Selesai',
                    'keterangan' => 'Ujian selesai, lanjut pengajuan promotor',
                    'color' => 'bg-red'
                ],
            ];
        } else if ($urutan == TAHAPAN_DISERTASI_PROMOTOR) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_DISERTASI_PROMOTOR_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_DISERTASI_PROMOTOR_SETUJUI,
                    'text' => 'Disetujui Promotor&Ko-promotor',
                    'keterangan' => 'Disetujui Oleh Promotor/Ko-promotor dan mengisi form Mata Kuliah',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_PROMOTOR_SETUJUI_KPS,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_PROMOTOR_SELESAI,
                    'text' => 'Selesai',
                    'keterangan' => '',
                    'color' => 'bg-red'
                ],
            ];
        } else if ($urutan == TAHAPAN_DISERTASI_MPKK) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_DISERTASI_MPKK_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa, Upload Bukti Transkrip & Blanko MPKK',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_DISERTASI_MPKK_SETUJUI_KPS,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_MPKK_SETUJUI_PROMOTOR,
                    'text' => 'Disetujui Promotor&Ko-promotor',
                    'keterangan' => 'Disetujui Oleh Promotor/Ko-promotor dan mengisi form Mata Kuliah',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_MPKK_SELESAI,
                    'text' => 'Selesai',
                    'keterangan' => '',
                    'color' => 'bg-red'
                ],
            ];
        } else if ($urutan == TAHAPAN_DISERTASI_PROPOSAL) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_DISERTASI_PROPOSAL_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa syarat min sks 16, Upload Bukti Transkrip, TOFL 500 dan TOEFL pendamping, Upload Bukti Transkrip dan Pembayaran SPP',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_DISERTASI_PROPOSAL_SETUJUI_BAA,
                    'text' => 'Diterima BAA',
                    'keterangan' => 'Disetujui oleh BAA',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_PROPOSAL_SETUJUI_PROMOTOR,
                    'text' => 'Disetujui Promotor&Ko-promotor',
                    'keterangan' => 'Disetujui oleh Promotor/Ko-Promotor',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_PROPOSAL_DIJADWALKAN,
                    'text' => 'Dijadwalkan',
                    'keterangan' => 'Telah dijadwalkan Oleh Promotor/Ko-Promotor untuk Ujian dan pengajuan dosen penguji',
                    'color' => 'bg-navy'
                ],
                [
                    'value' => STATUS_DISERTASI_PROPOSAL_SETUJUI_PENGUJI,
                    'text' => 'Disetujui Penguji',
                    'keterangan' => 'Disetujui  oleh semua penguji',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_PROPOSAL_SETUJUI_SPS,
                    'text' => 'Disetujui SPS',
                    'keterangan' => 'Disetujui Sekertaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_PROPOSAL_SETUJUI_KPS,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_PROPOSAL_UJIAN,
                    'text' => 'Ujian',
                    'keterangan' => 'Sedang menunggu masa jadwal Ujian',
                    'color' => 'bg-purple'
                ],
                [
                    'value' => STATUS_DISERTASI_PROPOSAL_SELESAI,
                    'text' => 'Selesai',
                    'keterangan' => 'Hasil Ujian telah ditentukan',
                    'color' => 'bg-red'
                ],
            ];
        } else if ($urutan == TAHAPAN_DISERTASI_MKPD) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_DISERTASI_MKPD_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa, Upload Form MKPD',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_DISERTASI_MKPD_SETUJUI_PROMOTOR,
                    'text' => 'Disetujui Promotor&Ko-promotor',
                    'keterangan' => 'Disetujui Oleh Promotor/Ko-promotor dan mengisi form Mata Kuliah',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_MKPD_SETUJUI_SPS,
                    'text' => 'Disetujui SPS',
                    'keterangan' => 'Disetujui Sekertaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_MKPD_SETUJUI_KPS,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_MKPD_SELESAI,
                    'text' => 'Selesai',
                    'keterangan' => '',
                    'color' => 'bg-red'
                ],
            ];
        } else if ($urutan == TAHAPAN_DISERTASI_KELAYAKAN) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_DISERTASI_KELAYAKAN_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa syarat jangka waktu Ujian 1 dan Proposal Minimal 6 Bulan, Nilai MKPD lengkap beserta Transkrip',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_DISERTASI_KELAYAKAN_SETUJUI_PROMOTOR,
                    'text' => 'Disetujui Promotor&Ko-promotor',
                    'keterangan' => 'Disetujui oleh Promotor/Ko-Promotor',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_KELAYAKAN_DIJADWALKAN,
                    'text' => 'Dijadwalkan',
                    'keterangan' => 'Telah dijadwalkan Oleh Promotor/Ko-Promotor untuk Ujian dan pengajuan dosen penguji',
                    'color' => 'bg-navy'
                ],
                [
                    'value' => STATUS_DISERTASI_KELAYAKAN_SETUJUI_PENGUJI,
                    'text' => 'Disetujui Penguji',
                    'keterangan' => 'Disetujui  oleh semua penguji',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_KELAYAKAN_SETUJUI_SPS,
                    'text' => 'Disetujui SPS',
                    'keterangan' => 'Disetujui Sekertaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_KELAYAKAN_SETUJUI_KPS,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_KELAYAKAN_UJIAN,
                    'text' => 'Ujian',
                    'keterangan' => 'Sedang menunggu masa jadwal Ujian',
                    'color' => 'bg-purple'
                ],
                [
                    'value' => STATUS_DISERTASI_KELAYAKAN_SELESAI,
                    'text' => 'Selesai',
                    'keterangan' => 'Hasil Ujian telah ditentukan',
                    'color' => 'bg-red'
                ],
            ];
        } else if ($urutan == TAHAPAN_DISERTASI_TERTUTUP) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_DISERTASI_TERTUTUP_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa syarat Upload Naskah Ujian Kelayakan',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_DISERTASI_TERTUTUP_SETUJUI_PROMOTOR,
                    'text' => 'Disetujui Promotor&Ko-promotor',
                    'keterangan' => 'Disetujui oleh Promotor/Ko-Promotor',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_TERTUTUP_DIJADWALKAN,
                    'text' => 'Dijadwalkan',
                    'keterangan' => 'Telah dijadwalkan Oleh Promotor/Ko-Promotor untuk Ujian dan pengajuan dosen penguji',
                    'color' => 'bg-navy'
                ],
                [
                    'value' => STATUS_DISERTASI_TERTUTUP_SETUJUI_PENGUJI,
                    'text' => 'Disetujui Penguji',
                    'keterangan' => 'Disetujui  oleh semua penguji',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_TERTUTUP_SETUJUI_SPS,
                    'text' => 'Disetujui SPS',
                    'keterangan' => 'Disetujui Sekertaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_TERTUTUP_SETUJUI_KPS,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_TERTUTUP_UJIAN,
                    'text' => 'Ujian',
                    'keterangan' => 'Sedang menunggu masa jadwal Ujian',
                    'color' => 'bg-purple'
                ],
                [
                    'value' => STATUS_DISERTASI_TERTUTUP_SELESAI,
                    'text' => 'Selesai',
                    'keterangan' => 'Hasil Ujian telah ditentukan',
                    'color' => 'bg-red'
                ],
            ];
        } else if ($urutan == TAHAPAN_DISERTASI_TERBUKA) {
            return [
                [
                    'value' => 0,
                    'text' => 'Belum Pengajuan',
                    'keterangan' => '',
                    'color' => 'bg-gray'
                ],
                [
                    'value' => STATUS_DISERTASI_TERBUKA_PENGAJUAN,
                    'text' => 'Pengajuan',
                    'keterangan' => 'Diajukan oleh mahasiswa syarat Form perbaikan Ujian Tertutup & Validasi Jurnal',
                    'color' => 'bg-blue'
                ],
                [
                    'value' => STATUS_DISERTASI_TERBUKA_SETUJUI_PROMOTOR,
                    'text' => 'Disetujui Promotor&Ko-promotor',
                    'keterangan' => 'Disetujui oleh Promotor/Ko-Promotor',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_TERBUKA_DIJADWALKAN,
                    'text' => 'Dijadwalkan',
                    'keterangan' => 'Telah dijadwalkan Oleh Promotor/Ko-Promotor untuk Ujian',
                    'color' => 'bg-navy'
                ],
                [
                    'value' => STATUS_DISERTASI_TERBUKA_SETUJUI_SPS,
                    'text' => 'Disetujui SPS',
                    'keterangan' => 'Disetujui Sekertaris Prodi',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_TERBUKA_SETUJUI_KPS,
                    'text' => 'Disetujui KPS',
                    'keterangan' => 'Disetujui Ketua Prodi pengajuan dosen penguji',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_TERBUKA_SETUJUI_PENGUJI,
                    'text' => 'Disetujui Penguji',
                    'keterangan' => 'Disetujui  oleh semua penguji',
                    'color' => 'bg-green'
                ],
                [
                    'value' => STATUS_DISERTASI_TERBUKA_UJIAN,
                    'text' => 'Ujian',
                    'keterangan' => 'Sedang menunggu masa jadwal Ujian',
                    'color' => 'bg-purple'
                ],
                [
                    'value' => STATUS_DISERTASI_TERBUKA_SELESAI,
                    'text' => 'Selesai',
                    'keterangan' => 'Hasil Ujian telah ditentukan',
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
