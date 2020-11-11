<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Penguji_model extends CI_Model {

	public function read_pengajuan($username)
	{
        $this->db->select('p.id_penguji, p.status_tim, u.tanggal, r.ruang, r.gedung, j.jam, m.nama,m.nim, s.id_skripsi, s.berkas_proposal, d.departemen');
        $this->db->from('penguji p');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->join('ruang r','u.id_ruang = r.id_ruang');
        $this->db->join('jam j','u.id_jam = j.id_jam');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->join('departemen d','s.id_departemen = d.id_departemen');
        $this->db->where('p.nip', $username);
        $this->db->where('p.status',1);
        $this->db->where('u.jenis_ujian',2);
        $this->db->where('u.status',1);

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

    public function update_penguji($data, $id_penguji)
    {
      $this->db->where('id_penguji', $id_penguji);
      $this->db->update('penguji', $data);
    }

    public function read_approve($username)
	  {
	   
      $this->db->select('p.id_penguji, p.status_tim, u.id_ujian, u.tanggal, r.ruang, r.gedung, j.jam, m.nama,m.nim, s.status_skripsi, s.id_skripsi, s.berkas_proposal,s.nilai, d.departemen,s.turnitin');
      $this->db->from('penguji p');
      $this->db->join('ujian u','p.id_ujian = u.id_ujian');
      $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
      $this->db->join('ruang r','u.id_ruang = r.id_ruang');
      $this->db->join('jam j','u.id_jam = j.id_jam');
      $this->db->join('mahasiswa m','s.nim = m.nim');
      $this->db->join('departemen d','s.id_departemen = d.id_departemen');
      $this->db->where('p.nip', $username);
      $this->db->where('p.status',2);
      $this->db->where('u.jenis_ujian',2);
      $this->db->where('u.status',1);
      $this->db->order_by('u.tanggal','desc');

      $query = $this -> db -> get();
      return $query->result_array();

  }

  public function read_ketuapenguji($username, $id_ujian)
	  {
      $this->db->select('p.status_tim');
      $this->db->from('penguji p');
      $this->db->join('ujian u','p.id_ujian = u.id_ujian');
      $this->db->where('p.nip', $username);
      $this->db->where('p.id_ujian',$id_ujian);
      $this->db->where('p.status',2);
      $this->db->where('u.jenis_ujian',2);
      $this->db->where('u.status',1);

      $query = $this -> db -> get();
      return $query->row();
  }

  public function update_nilai($data, $id_skripsi)
    {
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('skripsi', $data);
    }

}
?>