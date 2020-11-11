<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pembimbing_model extends CI_Model {

	public function jumlah_bimbingan($nip)
	{
		$this->db->select('count(p.id_pembimbing) as jumlah');
		$this->db->from('pembimbing p');
		$this->db->join('skripsi s','p.id_skripsi = s.id_skripsi');
		$this->db->where('s.jenis',2);//skripsi
		$this->db->where('p.status',2);//approve
		$this->db->where('p.status_bimbingan',2);//aktif
		$this->db->where('p.nip',$nip);//1aktif,2hapus
		$query = $this -> db -> get();
		
		return $query->row();
	}
	

}
?>