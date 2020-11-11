<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jadwal_model extends CI_Model {

	public function read_tanggal($tanggal,$id_jam, $id_ruang)
	{
		$this->db->select('s.id_skripsi, s.nim, m.nama, pr.jenis_ujian');
		$this->db->from('ujian pr');
		$this->db->join('skripsi s','pr.id_skripsi = s.id_skripsi');
		$this->db->join('mahasiswa m','s.nim = m.nim');
		$this->db->where('pr.tanggal', $tanggal);
		$this->db->where('pr.id_ruang',$id_ruang);
		$this->db->where('pr.id_jam',$id_jam);
		$this->db->where('pr.status',1);//1aktif,2hapus
		$query = $this -> db -> get();
		
		return $query->row();
	}

	public function read_penguji_proposal($id_skripsi)
	{
		$stat = array('1','2');
		$this->db->select('d.nama, sp.status_tim as tim, sp.status');
		$this->db->from('penguji sp');
		$this->db->join('ujian u','sp.id_ujian = u.id_ujian');
		$this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
		$this->db->join('pegawai d','sp.nip = d.nip');
		$this->db->where('s.id_skripsi',$id_skripsi);
		$this->db->where_in('sp.status',$stat);
		$this->db->order_by('sp.status_tim','desc');
		$query = $this -> db -> get();
		
		return $query->result_array();
	}

	public function read_penguji_skripsi($id_skripsi)
	{
		$stat = array('1','2');
		$this->db->select('d.nama, sp.status_tim as tim, sp.status');
		$this->db->from('penguji sp');
		$this->db->join('ujian u','sp.id_ujian = u.id_ujian');
		$this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
		$this->db->join('pegawai d','sp.nip = d.nip');
		$this->db->where('s.id_skripsi',$id_skripsi);
		$this->db->where_in('sp.status',$stat);
		$this->db->order_by('sp.status_tim','desc');
		$query = $this -> db -> get();
		
		return $query->result_array();
	}

	public function read_penguji_thesis($id_skripsi)
	{
		$stat = array('1','2');
		$this->db->select('d.nama, sp.status_tim as tim, sp.status');
		$this->db->from('penguji sp');
		$this->db->join('ujian u','sp.id_ujian = u.id_ujian');
		$this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
		$this->db->join('pegawai d','sp.nip = d.nip');
		$this->db->where('s.id_skripsi',$id_skripsi);
		$this->db->where_in('sp.status',$stat);
		$this->db->order_by('sp.status_tim','desc');
		$query = $this -> db -> get();
		
		return $query->result_array();
	}
	

}
?>