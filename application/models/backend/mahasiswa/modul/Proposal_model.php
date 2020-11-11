<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Proposal_model extends CI_Model {

	public function read($username)
	{
		$this->db->select('s.id_skripsi, s.id_departemen, s.id_gelombang, s.tgl_pengajuan,  s.berkas_proposal, s.status_proposal, d.departemen, g.gelombang, t.semester ');
        $this->db->from('skripsi s');
        $this->db->join('departemen d','s.id_departemen = d.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester t','g.id_semester = t.id_semester');
        $this->db->where('s.nim',$username);
        $this->db->where('s.jenis',1);
		$this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->result_array();
    }
    
    function read_aktif($username)
    {
        //$stts = array('1','2','3');
        $stts = array('1','2');
        $this->db->select('s.id_skripsi, s.id_departemen, s.id_gelombang, s.tgl_pengajuan, s.berkas_proposal, s.status_proposal, d.departemen, g.gelombang, t.semester ');
        $this->db->from('skripsi s');
        $this->db->join('departemen d','s.id_departemen = d.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester t','g.id_semester = t.id_semester');
        $this->db->where('s.nim',$username);
        $this->db->where('s.jenis',1);
        $this->db->where_in('s.status_proposal',$stts);
        $this->db->limit(1);
		$this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->row();
    }

    function save($data)
    {
        $this->db->insert('skripsi', $data);
    }

    function save_judul($dataj)
    {
        $this->db->insert('judul', $dataj);
    }

    public function read_judul($id_skripsi)
    {
        $this->db->select('j.judul');
        $this->db->from('judul j');
        $this->db->join('skripsi s','j.id_skripsi = s.id_skripsi');
        $this->db->where('j.id_skripsi',$id_skripsi);
        $this->db->order_by('j.id_judul','desc');
        $this->db->limit(1);
        $query = $this -> db -> get();
		return $query->row();
    }

    function detail($id, $username)
    {
        $this->db->select('s.id_skripsi, s.id_departemen, s.id_gelombang, s.tgl_pengajuan, s.judul, s.berkas_proposal, s.status_ujian_proposal, s.status_proposal, d.departemen, g.gelombang, t.semester ');
        $this->db->from('skripsi s');
        $this->db->join('departemen d','s.id_departemen = d.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester t','g.id_semester = t.id_semester');
        $this->db->where('s.nim',$username);
        $this->db->where('s.id_skripsi',$id);
        $this->db->where('s.jenis',1);
        $this->db->limit(1);

		$query = $this -> db -> get();
		return $query->row();
    }

    function update($data, $id_skripsi)
    {
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('skripsi', $data);
    }

    function ujian($id, $username)
    {
        $stts = array('2','3');
        $this->db->select('u.id_ujian, u.id_skripsi, u.id_ruang, u.id_jam, u.tanggal, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian u');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->join('ruang r','u.id_ruang = r.id_ruang');
        $this->db->join('jam j','u.id_jam = j.id_jam');
        $this->db->where('s.id_skripsi', $id);
        $this->db->where('s.nim', $username);
        $this->db->where_in('s.status_proposal', $stts);
        $this->db->where('u.status',1);
        $this->db->where('u.jenis_ujian',1);

        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_penguji($id_ujian)
    {
        $stts = array('1','2');
        $this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama');
        $this->db->from('penguji p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->where('p.id_ujian', $id_ujian);
        $this->db->where_in('p.status',$stts);
        $this->db->order_by('p.status_tim','asc');
        $query = $this -> db -> get();
		return $query->result_array();
    }
	
}
?>