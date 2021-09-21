<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jam_model extends CI_Model {

	public function read_aktif()
	{
		$this->db->select('id_jam, jam');
        $this->db->from('jam');
        $this->db->where('status',1);
		$this->db->order_by('id_jam','asc');

		$query = $this -> db -> get();
		return $query->result_array();
	}

	public function read()
	{
		$this->db->select('id_jam, jam, status');
		$this->db->from('jam');
		$this->db->where('status', 1);
		$query = $this -> db -> get();

		return $query->result_array();
	}

	public function read_aktif_by_jenjang($jenjang)
	{
		$this->db->select('j.id_jam, j.jam');
		$this->db->from('jam j');
		$this->db->join('jam_jenjang jj', 'jj.id_jam = j.id_jam');
		$this->db->where('j.status',1);
		$this->db->where('jj.id_jenjang',$jenjang);
		$this->db->order_by('j.jam','asc');

		$query = $this -> db -> get();
		return $query->result_array();
	}
	
	
}
?>
