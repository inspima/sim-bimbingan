<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ruang_model extends CI_Model {

	public function read_aktif()
	{
		$this->db->select('id_ruang, ruang, gedung');
        $this->db->from('ruang');
        $this->db->where('status',1);
		$this->db->order_by('id_ruang','asc');

		$query = $this -> db -> get();
		return $query->result_array();
	}

	public function read_ujian()
	{
		$jenis = 'ujian';
		$this->db->select('id_ruang, ruang, gedung, jenis, status');
		$this->db->from('ruang');
		$this->db->where('jenis',$jenis);
		$this->db->where('status', 1);
		$query = $this -> db -> get();

		return $query->result_array();
	}
	
	
}
?>