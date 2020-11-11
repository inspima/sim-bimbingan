<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kadep_pengajuan_model extends CI_Model {

	public function read($id_departemen)
	{
		$this->db->select('s.id_skripsi, s.tgl_pengajuan, s.judul, s.berkas_proposal, ,s.keterangan_proposal, dn.departemen, sr.semester, m.nim, m.nama ');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.id_departemen', $id_departemen);
        $this->db->where('s.jenis',1);
        $this->db->where('s.status_proposal',1);
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
    
    public function detail($id_departemen, $id_skripsi)
	{
		$this->db->select('s.id_skripsi, s.tgl_pengajuan, s.judul, s.berkas_proposal, s.id_departemen, s.status_proposal, ,s.keterangan_proposal,dn.departemen, sr.semester, m.nim, m.nama ');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.id_departemen', $id_departemen);
        $this->db->where('s.jenis',1);
        $this->db->where('s.status_proposal',1);
        $this->db->where('s.id_skripsi', $id_skripsi);

		$query = $this -> db -> get();
		return $query->row();
    }
    
    public function update($data, $id_skripsi)
	{
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('skripsi', $data);
    }
	
}
?>