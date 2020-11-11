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
	
	
}
?>