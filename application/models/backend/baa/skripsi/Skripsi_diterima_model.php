<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Skripsi_diterima_model extends CI_Model {

	public function read()
	{
        $this->db->select('s.id_skripsi, s.tgl_pengajuan, s.turnitin, s.toefl, dn.departemen, m.nim, m.nama, s.status_skripsi, s.berkas_skripsi, s.nilai ');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.jenis',2);
        $this->db->where('s.status_skripsi >=',STATUS_SKRIPSI_UJIAN_SETUJUI_BAA);
		$this->db->where('s.status_skripsi <',STATUS_SKRIPSI_UJIAN_UJIAN);
		$this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->result_array();
    }

    public function read_judul($id_skripsi)
    {
        $this->db->select('j.judul');
        $this->db->from('judul j');
        $this->db->join('skripsi s','j.id_skripsi = s.id_skripsi');
        $this->db->where('j.id_skripsi',$id_skripsi);
        $this->db->order_by('j.id_judul','desc');
        $this->db->limit(1);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_pembimbing($id_skripsi)
    {
        $this->db->select('p.id_pembimbing, pg.nama');
        $this->db->from('pembimbing p');
        $this->db->join('skripsi s','p.id_skripsi = s.id_skripsi');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where('p.status',2);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_bimbingan($id)
    {
        $stts = array('1','2');
        $this->db->select('b.id_bimbingan, b.id_skripsi, b.tanggal, b.hal, b.status');
        $this->db->from('bimbingan b');
        $this->db->join('skripsi s','b.id_skripsi = s.id_skripsi');
        $this->db->where('s.id_skripsi', $id);
        $this->db->where_in('b.status',$stts);
        $query = $this -> db -> get();
		return $query->result_array();
    }

    function detail($id)
    {
        $this->db->select('s.id_skripsi, s.id_departemen, s.tgl_pengajuan,  s.berkas_proposal, s.status_proposal, s.turnitin, s.toefl, m.nama, s.nim,d.departemen ');
        $this->db->from('skripsi s');
        $this->db->join('departemen d','s.id_departemen = d.id_departemen');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.jenis',2);
        $this->db->where('s.id_skripsi',$id);
        $this->db->limit(1);
        $this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->row();
    }

    function update($data, $id_skripsi)
    {
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('skripsi', $data);
    }

    function update_pembimbing($datab, $id_pembimbing)
    {
        $this->db->where('id_pembimbing', $id_pembimbing);
        $this->db->update('pembimbing', $datab);
    }
    
    
}
?>
