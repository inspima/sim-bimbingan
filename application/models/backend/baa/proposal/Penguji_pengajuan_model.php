<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Penguji_pengajuan_model extends CI_Model {

	public function read()
	{
		$this->db->select('pg.nama as nama_dosen, s.nim, m.nama, s.id_skripsi');
        $this->db->from('penguji p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.jenis',1);
        $this->db->where('p.status',1);
        $this->db->order_by('p.id_penguji','desc');

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
    
    public function read_ujian($id_skripsi)
    {
        $this->db->select('u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian u');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->join('ruang r','u.id_ruang = r.id_ruang');
        $this->db->join('jam j','u.id_jam = j.id_jam');
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where('u.jenis_ujian',1);
        $this->db->where('u.status',1);
        $query = $this -> db -> get();
		return $query->row();
    }
}
?>