<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Skripsi_belum_daftar_model extends CI_Model {

	public function read()
	{
		$this->db->select('s.*, dn.departemen, m.nim, m.nama, j.judul');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->join('judul j','j.id_skripsi = s.id_skripsi');
		$this->db->where('s.jenis', TAHAPAN_SKRIPSI_PROPOSAL);
		$this->db->where('s.status_skripsi <', STATUS_SKRIPSI_UJIAN_PENGAJUAN);
		$this->db->where('s.status_proposal >=', STATUS_SKRIPSI_PROPOSAL_SELESAI);
		$this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->result_array();
    }

    public function read_departemen($id_departemen)
	{
		$this->db->select('s.id_skripsi, s.turnitin, dn.departemen, m.nim, m.nama, j.judul');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->join('judul j','j.id_skripsi = s.id_skripsi');
        $this->db->where('s.jenis',2);
        $this->db->where('dn.id_departemen',$id_departemen);
        $this->db->where_in('s.status_skripsi',0,1);
		$this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->result_array();
    }
}
?>
