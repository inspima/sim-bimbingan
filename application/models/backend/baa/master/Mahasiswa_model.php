<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mahasiswa_model extends CI_Model {

	public function read()
	{
		$this->db->select('m.id_mahasiswa, m.nama, m.alamat, m.telp,  m.nim, m.email, m.status');
        $this->db->from('mahasiswa m');
        $this->db->join('user u','m.nim = u.username','left');
        
		$this->db->order_by('m.id_mahasiswa','desc');

		$query = $this -> db -> get();
		return $query->result_array();
	}

    public function save_mahasiswa($data)
    {
        $this->db->insert('mahasiswa', $data);
    }

    public function save_user($datas)
    {
        $this->db->insert('user', $datas);
    }

    public function detail($id)
	{
		$this->db->select('m.id_mahasiswa, m.nama, m.alamat, m.telp,  m.nim, m.email, u.id_user');
        $this->db->from('mahasiswa m');
        $this->db->join('user u','m.nim = u.username');
        $this->db->where('m.status',1);
        $this->db->where('m.id_mahasiswa',$id);

		$query = $this -> db -> get();
		return $query->row();
    }
    
    public function update_mahasiswa($data, $id_mahasiswa)
    {
        $this->db->where('id_mahasiswa', $id_mahasiswa);
        $this->db->update('mahasiswa', $data);
    }

    public function update_user($datas, $id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $datas);
    }

    public function read_aktif($username)
	{
		$this->db->select('m.id_mahasiswa, m.nama, m.alamat, m.telp,  m.nim, m.email, u.id_user');
        $this->db->from('mahasiswa m');
        $this->db->join('user u','m.nim = u.username');
        $this->db->where('m.status',1);
        $this->db->where('u.username',$username);

		$query = $this -> db -> get();
		return $query->row();
    }

    public function detail_mhs($id_mahasiswa)//belum_aktif
	{
		$this->db->select('m.id_mahasiswa, m.nama, m.alamat, m.telp,  m.nim, m.email');
        $this->db->from('mahasiswa m');
        $this->db->where('m.status',0);
        $this->db->where('m.id_mahasiswa',$id_mahasiswa);

		$query = $this -> db -> get();
		return $query->row();
    }
    
    public function cek_mahasiswa($nim)
    {
        $this->db->select('m.nim');
        $this->db->from('mahasiswa m');
        $this->db->where('m.status',1);
        $this->db->where('m.nim',$nim);

		$query = $this -> db -> get();
		return $query->row();
        
    }
}
?>