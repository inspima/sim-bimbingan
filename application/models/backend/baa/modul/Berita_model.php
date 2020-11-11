<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Berita_model extends CI_Model {

	public function read()
	{
		$this->db->select('id_berita, isi_berita, tanggal_berita, status');
        $this->db->from('berita');
		$this->db->order_by('id_berita','desc');

		$query = $this -> db -> get();
		return $query->result_array();
	}
	
	
    public function save($data)
    {
        $this->db->insert('berita', $data);
    }

    public function read_kategori()
	{
		$this->db->select('id_kategori, kategori');
		$this->db->from('berita_kategori');
		$this->db->order_by('id_kategori','asc');
		$query = $this->db->get();
		return $query->result_array();
	}


	public function cekpostkategori($datas)
	{
		$this->db->select('id_berita_detail, status');
		$this->db->from('berita_detail');
		$this->db->where('id_berita', $datas['id_berita']);
		$this->db->where('id_kategori',$datas['id_kategori']);

		$query = $this -> db -> get();
		
		return $query->row();
	}
	
	public function updatepostkategori($datasub)
	{
		$this->db->where('id_berita_detail', $datasub['id_berita_detail']);
		$this->db->update('berita_detail', $datasub);
	}
	
	public function savepostkategori($datasuba)
	{
		$this->db->insert('berita_detail', $datasuba);
	}
	/* HERE */
	public function read_kategori_berita($id)
	{
		$this->db->select('bk.kategori');
		$this->db->from('berita_kategori bk');
		$this->db->join('berita_detail bd','bd.id_kategori = bk.id_kategori');
		$this->db->join('berita b','bd.id_berita = b.id_berita');
		$this->db->where('b.id_berita', $id);
		$this->db->where('bd.status',1);

		$query = $this -> db -> get();
		
		return $query->result_array();
	}
	
	public function update($data)
	{
		$this->db->where('id_berita', $data['id_berita']);
		$this->db->update('berita', $data);
	}
	
	public function detail($id)
	{
		$this->db->select('id_berita,isi_berita,tanggal_berita,status');
		$this->db->from('berita');
		$this->db->where('id_berita',$id);
		$query = $this -> db -> get();
		
		return $query->row();
	}
	
	public function berita_kategori($id)
	{
		$this->db->select('bd.id_berita_detail,bd.id_berita, bd.id_kategori, bk.kategori');
		$this->db->from('berita_detail bd');
		$this->db->join('berita_kategori bk','bd.id_kategori = bk.id_kategori');
		$this->db->join('berita b','bd.id_berita = b.id_berita');
		$this->db->where('bd.status',1);
		$this->db->where('bd.id_berita',$id);
		$this->db->order_by('bk.id_kategori','desc');

		$query = $this -> db -> get();
		
		return $query->result_array();
	}
	
	public function delete_post_kategori($id, $id_kategori)
	{
		$this->db->set('status', 0);
		$this->db->where('id_berita', $id);
		$this->db->where_not_in('id_kategori', $id_kategori);
		$this->db->update('berita_detail');
	}
}
?>