<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proposal_selesai_model extends CI_Model {

    public function read() {
        $this->db->select('s.id_skripsi, s.tgl_pengajuan, s.judul, s.berkas_proposal, ,s.keterangan_proposal, dn.departemen, g.gelombang, sr.semester, m.nim, m.nama,u.id_ujian, u.tanggal, r.ruang, r.gedung,ju.judul, ja.jam,u.id_ujian, u.tanggal, r.ruang, r.gedung, ja.jam ');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr', 'g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m', 's.nim = m.nim');
        $this->db->join('ujian u', 'u.id_skripsi = s.id_skripsi and u.status=1 and u.jenis_ujian=1');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam ja', 'u.id_jam = ja.id_jam');
        $this->db->join('judul ju', 'ju.id_skripsi = s.id_skripsi');
        $this->db->where('s.jenis', 1);
        $this->db->where('s.status_proposal', 3);
        $this->db->order_by('s.id_skripsi', 'desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function detail($id_skripsi) {
        $stts = array('2', '3');
        $this->db->select('s.id_skripsi, s.tgl_pengajuan, s.id_departemen, s.judul, s.berkas_proposal, ,s.keterangan_proposal, dn.departemen, g.gelombang, sr.semester, m.nim, m.nama, m.telp, ju.judul ');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn', 's.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g', 's.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr', 'g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m', 's.nim = m.nim');
        $this->db->where('s.jenis', 1);
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where_in('s.status_proposal', $stts);
        $this->db->order_by('s.id_skripsi', 'desc');

        $query = $this->db->get();
        return $query->row();
    }

    public function read_judul($id_skripsi) {
        $this->db->select('j.judul');
        $this->db->from('judul j');
        $this->db->join('skripsi s', 'j.id_skripsi = s.id_skripsi');
        $this->db->where('j.id_skripsi', $id_skripsi);
        $this->db->order_by('j.id_judul', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function read_ujian($id_skripsi) {
        $this->db->select('u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian u');
        $this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
        $this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
        $this->db->join('jam j', 'u.id_jam = j.id_jam');
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where('u.jenis_ujian', 1);
        $this->db->where('u.status', 1);
        $query = $this->db->get();
        return $query->row();
    }

    public function read_pembimbing($id_skripsi) {
        $this->db->select('pg.nama');
        $this->db->from('pegawai pg');
        $this->db->join('pembimbing p', 'pg.nip = p.nip');
        $this->db->join('skripsi s', 'p.id_skripsi = s.id_skripsi');
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where('p.status', 2);
        $query = $this->db->get();
        return $query->row();
    }

    public function read_penguji($id_skripsi) {
        $stts = array('1', '2');
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

    public function count_penguji($id_skripsi) {
        $stts = array('2');
        $this->db->where_in('p.status', $stts);
        $this->db->where('u.status', 1);
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->from('penguji p');
        $this->db->join('pegawai pg', 'p.nip = pg.nip');
        $this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
        $this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');

        $query = $this->db->count_all_results();
        return $query;
    }

    public function read_pengujiketua($id_skripsi) {
        $stts = array('2');
        $this->db->select('p.id_penguji');
        $this->db->from('penguji p');
        $this->db->join('ujian u', 'p.id_ujian = u.id_ujian');
        $this->db->join('skripsi s', 'u.id_skripsi = s.id_skripsi');
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where('p.status_tim', 1);
        $this->db->where_in('p.status', $stts);

        $query = $this->db->get();
        return $query->row();
    }

}

?>