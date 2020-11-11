<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gelombang_model extends CI_Model {

	public function read()
	{
		$this->db->select('g.id_gelombang, g.no_sk, g.tgl_sk, g.gelombang, g.status_berjalan,  g.status, g.id_semester, s.semester');
        $this->db->from('gelombang_skripsi g');
        $this->db->join('semester s','g.id_semester = s.id_semester');
        $this->db->where('g.status',1);
		$this->db->order_by('g.id_gelombang','desc');

		$query = $this -> db -> get();
		return $query->result_array();
	}
	
	
    public function save($data)
    {
        $this->db->insert('gelombang_skripsi', $data);
    }

    public function detail($id)
    {
        $this->db->select('g.id_gelombang, g.no_sk, g.tgl_sk, g.gelombang, g.status_berjalan,  g.status, g.id_semester, s.semester');
        $this->db->from('gelombang_skripsi g');
        $this->db->join('semester s','g.id_semester = s.id_semester');
        $this->db->where('g.status',1);
        $this->db->where('g.id_gelombang',$id);

		$query = $this -> db -> get();
		return $query->row();
    }

    public function update_all($datas)
    {
        $this->db->update('gelombang_skripsi', $datas);
    }

    public function update($data, $id_gelombang)
    {
        $this->db->where('id_gelombang', $id_gelombang);
        $this->db->update('gelombang_skripsi', $data);
    }

    public function read_berjalan()
    {
        $this->db->select('g.id_gelombang, g.no_sk, g.tgl_sk, g.gelombang, g.status_berjalan,  g.status, g.id_semester, s.semester');
        $this->db->from('gelombang_skripsi g');
        $this->db->join('semester s','g.id_semester = s.id_semester');
        $this->db->where('g.status',1);
        $this->db->where('g.status_berjalan',1);
        $this->db->limit(1);

		$query = $this -> db -> get();
		return $query->row();
    }

}
?>