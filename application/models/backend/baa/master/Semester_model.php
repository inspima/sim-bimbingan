<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Semester_model extends CI_Model {

	public function read()
	{
		$this->db->select('id_semester, semester, berjalan');
        $this->db->from('semester');
        $this->db->where('status',1);
		$this->db->order_by('id_semester','desc');

		$query = $this -> db -> get();
		return $query->result_array();
	}
	
	
    public function save($data)
    {
        $this->db->insert('semester', $data);
    }

    public function detail($id)
    {
        $this->db->select('id_semester, semester');
        $this->db->from('semester');
        $this->db->where('status',1);
        $this->db->where('id_semester',$id);

		$query = $this -> db -> get();
		return $query->row();
    }

    public function update_all($datas)
    {
        $this->db->update('semester', $datas);
    }

    public function update($data, $id_semester)
    {
        $this->db->where('id_semester', $id_semester);
        $this->db->update('semester', $data);
    }

}
?>