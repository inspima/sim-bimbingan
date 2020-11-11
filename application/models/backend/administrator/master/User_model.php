<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {

	public function read()
	{
		$this->db->select('u.id_user, u.username, u.sebagai, u.role, u.status, p.nama');
        $this->db->from('user u');
		$this->db->join('pegawai p','u.username = p.nip');
		$this->db->where('u.status',1);
		$this->db->order_by('u.id_user','asc');
		$query1 = $this -> db -> get();
		$result1 = $query1->result_array();

		$this->db->select('u.id_user, u.username, u.sebagai, u.role, u.status, m.nama');
      	$this->db->from('user u');
      	$this->db->join('mahasiswa m','m.nim = u.username');
      	$this->db->where('u.status',1);
		$this->db->order_by('u.id_user','asc');
		$query2 = $this -> db -> get();
		$result2 = $query2->result_array();
		return array_merge($result1, $result2);
	}
	
    public function save($data)
    {
        $this->db->insert('user', $data);
    }

    public function detail($id)
    {
        $this->db->select('id_user, username, sebagai, role, status');
        $this->db->from('user');
        $this->db->where('id_user',$id);

		$query = $this -> db -> get();
		return $query->row();
    }

    public function update($data, $id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $data);
    }

    
    function direct_login($username){
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
		$this->db->select('u.id_user, u.username, u.sebagai, u.role, p.id_departemen, p.nama, p.email');
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
		$this->db->select('u.id_user, u.username, u.sebagai, u.role, m.nama, m.email');
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

	function read_alldosen()
	{
		$this->db->select('u.id_user, u.username, u.sebagai, u.role, p.id_departemen, p.nama, p.email');
      	$this->db->from('user u');
      	$this->db->join('pegawai p','p.nip = u.username');
      	$this->db->where('u.status',1);
		$this->db->where('p.status',1);
		$this->db->where('p.jenis_pegawai',1);
		$query = $this -> db -> get();
		return $query->result_array();
	}

	

}
?>