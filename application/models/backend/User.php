<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model {

	function login($username){
		$this->db->select('u.id_user, u.username, u.sebagai');
		$this->db->from('user u');
		$this->db->where('u.username', $username);
		$this->db->where('u.status',1);
		$this->db->limit(1);

		$query = $this -> db -> get();
		if($query -> num_rows() == 1){
			return $query->row();
		}
		else
		{
			return false;
		}
    }
    
    function read_tendikdosen($username){
		$this->db->select('u.id_user, u.username, u.sebagai, u.role, u.password, p.id_departemen, p.nama, p.email');
      	$this->db->from('user u');
      	$this->db->join('pegawai p','p.nip = u.username');
		$this->db->where('u.username', $username);
      	$this->db->where('u.status',1);
      	$this->db->where('p.status',1);
		$this->db->limit(1);

		$query = $this -> db -> get();
		if($query -> num_rows() == 1){
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	function read_mhs($username){
		$this->db->select('u.id_user, u.username, u.sebagai, u.role, u.password, m.nama, m.email');
      	$this->db->from('user u');
      	$this->db->join('mahasiswa m','m.nim = u.username');
		$this->db->where('u.username', $username);
      	$this->db->where('u.status',1);
      	$this->db->where('m.status',1);
		$this->db->limit(1);

		$query = $this -> db -> get();
		if($query -> num_rows() == 1){
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	function read_user($username){
		$this->db->select('u.id_user, u.username, u.password');
		$this->db->from('user u');
		$this->db->where('u.username', $username);
		$this->db->where('u.status',1);
		$this->db->limit(1);

		$query = $this -> db -> get();	
		return $query->row();
	}

	function update_p($datap, $id_user)
	{
		$this->db->where('id_user', $id_user);
		$this->db->update('user', $datap);
	}

}
?>