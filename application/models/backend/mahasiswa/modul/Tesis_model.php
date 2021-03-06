<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tesis_model extends CI_Model {

	public function read($username)
	{
		$this->db->select('s.id_skripsi, s.id_departemen, s.tgl_pengajuan,  s.berkas_proposal, s.status_skripsi, s.turnitin, s.toefl, s.nilai, d.departemen, s.berkas_skripsi ');
        $this->db->from('skripsi s');
        $this->db->join('departemen d','s.id_departemen = d.id_departemen');
        $this->db->where('s.nim',$username);
        $this->db->where('s.jenis',2);
		$this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->result_array();
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

    public function read_pembimbing($id_skripsi)
    {
        $this->db->select('pg.nama');
        $this->db->from('pegawai pg');
        $this->db->join('pembimbing p','pg.nip = p.nip');
        $this->db->join('skripsi s','p.id_skripsi = s.id_skripsi');
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where('p.status',2);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_bimbingan($id)
    {
        $stts = array('1','2');
        $this->db->select('b.id_bimbingan, b.id_skripsi, b.tanggal, b.hal, b.status');
        $this->db->from('bimbingan b');
        $this->db->join('skripsi s','b.id_skripsi = s.id_skripsi');
        $this->db->where('s.id_skripsi', $id);
        $this->db->where_in('b.status',$stts);
        $query = $this -> db -> get();
		return $query->result_array();
    }

    public function save_bimbingan($data)
    {
        $this->db->insert('bimbingan', $data);
    }

    function update_bimbingan($data, $id_bimbingan)
    {
        $this->db->where('id_bimbingan', $id_bimbingan);
        $this->db->update('bimbingan', $data);
    }

    public function read_gelombang($id_skripsi)
    {
        $this->db->select('g.gelombang, st.semester');
        $this->db->from('skripsi s');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester st','g.id_semester = st.id_semester');
        $this->db->where('s.id_skripsi',$id_skripsi);
        $this->db->where('s.jenis',2);
        $query = $this -> db -> get();
		return $query->row();
    }

    function detail($id, $username)
    {
        $this->db->select('s.id_skripsi, s.id_departemen, s.tgl_pengajuan,  s.berkas_proposal, s.status_proposal, s.turnitin, s.toefl, d.departemen ');
        $this->db->from('skripsi s');
        $this->db->join('departemen d','s.id_departemen = d.id_departemen');
        $this->db->where('s.nim',$username);
        $this->db->where('s.jenis',2);
        $this->db->where('s.id_skripsi',$id);
        $this->db->limit(1);
        $this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->row();
    }

    function update($data, $id_skripsi)
    {
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('skripsi', $data);
    }

    public function save_judul($dataj)
    {
        $this->db->insert('judul', $dataj);
    }

    public function jumlah_bimbingan($id_skripsi)
    {
        $stts = array('2');
        $this->db->where_in('b.status',$stts);
        $this->db->where('b.id_skripsi',$id_skripsi);    
        $this->db->where('s.jenis',2);
        $this->db->join('skripsi s','b.id_skripsi = s.id_skripsi');
        $this->db->from('bimbingan b');
		$query = $this->db->count_all_results(); 
        return $query;
    }

    public function awal_bimbingan($id_skripsi)
    {
        $this->db->select('tanggal');
        $this->db->from('bimbingan');
        $this->db->where('id_skripsi',$id_skripsi);
        $this->db->where('status',2);
        $this->db->order_by('tanggal','asc');
        $this->db->limit(1);
        $query = $this -> db -> get();
		return $query->row();
    }

    ////
    
    function read_aktif($username)
    {
        $stts = array('1','2','3');
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

    function ujian($id_skripsi, $username)
    {
        $this->db->select('u.id_ujian, u.id_skripsi, u.id_ruang, u.id_jam, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, g.id_gelombang, g.gelombang, d.departemen, sr.semester');
        $this->db->from('ujian u');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->join('ruang r','u.id_ruang = r.id_ruang');
        $this->db->join('jam j','u.id_jam = j.id_jam');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('departemen d','s.id_departemen = d.id_departemen');
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where('s.nim', $username);
        $this->db->where('u.jenis_ujian', 2);
        $this->db->where_in('s.status_skripsi',4);//app kps
        $this->db->where('u.status',1);

        $query = $this -> db -> get();
		return $query->result_array();
    }

    function ujiana($id_skripsi, $username)
    {
        $stts = array('1','2','3','4','5');
        $this->db->select('u.id_ujian, u.id_skripsi, u.id_ruang, u.id_jam, u.tanggal, r.ruang, r.gedung, j.jam, m.nim, m.nama, g.id_gelombang, g.gelombang, d.departemen, sr.semester');
        $this->db->from('ujian u');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->join('ruang r','u.id_ruang = r.id_ruang');
        $this->db->join('jam j','u.id_jam = j.id_jam');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('departemen d','s.id_departemen = d.id_departemen');
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where('s.nim', $username);
        $this->db->where('u.jenis_ujian', 2);
        $this->db->where_in('s.status_skripsi',$stts);//app kps
        $this->db->where('u.status',1);

        $query = $this -> db -> get();
		return $query->result_array();
    }

    public function read_penguji($id_ujian)
    {
        $stts = array('1','2','3');
        $this->db->select('p.id_penguji, p.nip, p.status_tim,p.usulan_dosbing, p.status, pg.nama');
        $this->db->from('penguji p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
        $this->db->where_in('p.status',$stts);
        $this->db->where('u.status',1);
        $this->db->where('u.id_ujian', $id_ujian);
        $this->db->order_by('p.status_tim','asc');
        $query = $this -> db -> get();
		return $query->result_array();
    }

    public function count_penguji_approve($id_ujian)
    {
        $stts = array('2');
        $this->db->where_in('p.status',$stts);
        $this->db->where('u.status',1);
        $this->db->where('u.id_ujian', $id_ujian);
        $this->db->from('penguji p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
    
		$query = $this->db->count_all_results(); 
        return $query;
    }

    
	
}
?>