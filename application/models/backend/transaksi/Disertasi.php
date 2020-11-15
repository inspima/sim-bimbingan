<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Disertasi extends CI_Model {

    public function read_kualifikasi_mahasiswa($username) {
        $this->db->select('s.*, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen');
        $this->db->where('s.nim', $username);
        $this->db->where('s.jenis', 1);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_kualifikasi() {
        $this->db->select('s.*, d.departemen ,m.nama');
        $this->db->from('disertasi s');
        $this->db->join('mahasiswa m', 'm.nim= s.nim');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen');
        $this->db->where('s.jenis', 1);
        $this->db->order_by('s.tgl_pengajuan', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function read($username) {
        $this->db->select('s.id_disertasi, s.id_departemen, s.tgl_pengajuan,s.status_kualifikasi,  s.berkas_proposal, s.status_proposal, d.departemen');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen');
        $this->db->where('s.nim', $username);
        $this->db->where('s.jenis', 1);
        $this->db->order_by('s.id_disertasi', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    function read_aktif($username) {
        //$stts = array('1','2','3');
        $stts = array('1', '2');
        $this->db->select('s.id_disertasi, s.id_departemen, s.tgl_pengajuan,s.status_kualifikasi, s.berkas_proposal, s.status_proposal, d.departemen ');
        $this->db->from('disertasi s');
        $this->db->join('departemen d', 's.id_departemen = d.id_departemen');
        $this->db->where('s.nim', $username);
        $this->db->where('s.jenis', 1);
        $this->db->where_in('s.status_kualifikasi', $stts);
        $this->db->limit(1);
        $this->db->order_by('s.id_disertasi', 'desc');

        $query = $this->db->get();
        return $query->row();
    }

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

    public function read_jadwal($id_disertasi, $jenis_ujian) {
        $this->db->select('u.*, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian_disertasi u');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('u.id_disertasi', $id_disertasi);
        $this->db->where('u.jenis_ujian', $jenis_ujian); //proposal
        $this->db->where('u.deleted_at is null');
        $query = $this->db->get();
        return $query->row();
    }

    public function read_penguji($id_ujian) {
        $stts = array('1', '2');
        $this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama');
        $this->db->from('penguji p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_ujian', $id_ujian);
        $this->db->where_in('p.status', $stts);
        $this->db->order_by('p.status_tim', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_pembimbing($id_skripsi) {
        $stts = array('1', '2', '3');
        $this->db->select('p.id_pembimbing, p.id_skripsi, pg.nama, p.status ');
        $this->db->from('pembimbing p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->where('p.id_skripsi', $id_skripsi);
        $this->db->where_in('p.status', $stts);
        $query = $this->db->get();
        return $query->result_array();
    }

    function detail($id) {
        $this->db->select('s.*, dn.departemen, m.nim, m.nama');
        $this->db->from('disertasi s');
        $this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
        $this->db->join('mahasiswa m', 's.nim = m.nim');
        $this->db->where('s.id_disertasi', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function save($data) {
        $this->db->insert('disertasi', $data);
    }

    public function save_judul($data) {
        $this->db->insert('judul_disertasi', $data);
    }

    function update($data, $id_disertasi) {
        $this->db->where('id_disertasi', $id_disertasi);
        $this->db->update('disertasi', $data);
    }

    function ujian($id, $username) {
        $stts = array('2', '3');
        $this->db->select('u.id_ujian, u.id_disertasi, u.id_ruang, u.id_jam, u.tanggal, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian u');
        $this->db->join('disertasi s', 'u.id_disertasi = s.id_disertasi');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('s.id_disertasi', $id);
        $this->db->where('s.nim', $username);
        $this->db->where_in('s.status_proposal', $stts);
        $this->db->where('u.status', 1);
        $this->db->where('u.jenis_ujian', 1);

        $query = $this->db->get();
        return $query->row();
    }

}

?>