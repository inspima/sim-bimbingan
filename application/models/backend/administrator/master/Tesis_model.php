<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tesis_model extends CI_Model {

	public function read($id_prodi)
	{
		$this->db->select('s.id_skripsi, s.tgl_pengajuan, s.judul, s.berkas_proposal, ,s.keterangan_proposal, dn.departemen, sr.semester, m.nim, m.nama ');
        $this->db->from('tesis s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('m.id_prodi', $id_prodi);
        $this->db->where('s.jenis',1);
        $this->db->where('s.status_proposal',1);
		$this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->result_array();
    }
    
    public function read_proposal_acc($id_prodi)
	{
		$this->db->select('s.id_skripsi, s.tgl_pengajuan, s.judul, s.berkas_proposal, ,s.keterangan_proposal, dn.departemen, sr.semester, m.nim, m.nama ');
        $this->db->from('tesis s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('m.id_prodi', $id_prodi);
        $this->db->where('s.jenis',1);
        $this->db->where('s.status_proposal',2);
		$this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->result_array();
    }


    public function read_judul($id_skripsi)
    {
        $this->db->select('j.judul');
        $this->db->from('judul_tesis j');
        $this->db->join('tesis s','j.id_skripsi = s.id_skripsi');
        $this->db->where('j.id_skripsi',$id_skripsi);
        $this->db->order_by('j.id_judul','desc');
        $this->db->limit(1);
        $query = $this -> db -> get();
		return $query->row();
    }
    
     function approval_proposal($id_skripsi)
    {
        $data = array(
        'status_proposal' => '2'
        );
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('tesis', $data);
    }
    
    function reject_proposal($id_skripsi)
    {
        $data = array(
        'status_proposal' => '3'
        );
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('tesis', $data);
    }
    
    function detail_proposal($id)
    {
        $this->db->select('s.id_skripsi, s.tgl_pengajuan, s.judul, s.berkas_proposal, s.id_departemen, s.status_proposal, s.status_ujian_proposal, s.keterangan_proposal, dn.departemen, sr.semester, m.nim, m.nama ');
        $this->db->from('tesis s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.jenis',1);
        $this->db->where('s.status_proposal',2);
        $this->db->where('s.id_skripsi', $id);

		$query = $this -> db -> get();
		return $query->row();
		$query = $this -> db -> get();
		return $query->row();
    }
    
    public function read_ujian($id_skripsi)
    {
        $this->db->select('u.id_ujian, u.tanggal, u.id_ruang, u.id_jam, u.id_skripsi, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian u');
        $this->db->join('ruang r','u.id_ruang = r.id_ruang');
        $this->db->join('jam j','u.id_jam = j.id_jam');
        $this->db->where('u.id_skripsi', $id_skripsi);
        $this->db->where('u.id_jenjang', 2);
        $this->db->where('u.jenis_ujian', 1);//proposal
        $this->db->where('u.status',1);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_pembimbing($id_skripsi)
    {
        $stts = array('1','2','3');
        $this->db->select('p.id_pembimbing, p.id_skripsi, pg.nama, p.status, pg.nip');
        $this->db->from('pembimbing p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->where('p.id_skripsi', $id_skripsi);
        $this->db->where('id_jenjang', 2);
        $this->db->where_in('p.status', $stts);
        $query = $this -> db -> get();
		return $query->result_array();
    }
    
    public function read_bimbingan($username)
    {
        $stts = array('1','2','3');
        $this->db->select('p.*, m.nim, m.nama, jt.judul, t.berkas_proposal');
        $this->db->from('pembimbing p');
        $this->db->join('tesis t','t.id_skripsi = p.id_skripsi', 'left');
        $this->db->join('mahasiswa m','m.nim = t.nim', 'left');
        $this->db->join('judul_tesis jt','jt.id_skripsi = t.id_skripsi', 'left');
        $this->db->where('p.id_jenjang', 2);
        $this->db->where('jt.status', 1);
        $this->db->where('p.nip', $username);
        $query = $this -> db -> get();
		return $query->result_array();
    }
    
     public function read_pengujiketua($id_ujian)
    {
        $stts = array('1','2');
        $this->db->select('id_penguji');
        $this->db->from('penguji');
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('status_tim',1);
        $this->db->where('id_jenjang',2);
        $this->db->where_in('status', $stts);

        $query = $this -> db -> get();
		return $query->row();
    }
    
    public function read_penguji($id_ujian)
    {
        $stts = array('1','2','3');
        $this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama');
        $this->db->from('penguji p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
        $this->db->where_in('p.status',$stts);
        $this->db->where('u.status',1);
        $this->db->where('u.id_ujian', $id_ujian);
        $this->db->order_by('p.status_tim','asc');
        $query = $this -> db -> get();
		return $query->result_array();
    }
    
     public function count_penguji_approve($id_ujian)
    {
        $stts = array('2');
        $this->db->where_in('p.status',$stts);
        $this->db->where('u.status',1);
        $this->db->where('u.id_ujian', $id_ujian);
        $this->db->from('penguji p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
    
		$query = $this->db->count_all_results(); 
        return $query;
    }
    
    
    
    public function hitung_bimbingan_aktif($nip)
    {
        $stts = array('2');
        $this->db->where_in('p.status_bimbingan',$stts);
        $this->db->where('p.nip',$nip);    
        $this->db->where('s.jenis',2);
        $this->db->where('p.id_jenjang',2);
        $this->db->join('tesis s','p.id_skripsi = s.id_skripsi');
        $this->db->from('pembimbing p');
		$query = $this->db->count_all_results(); 
        return $query;
    }
    
     public function save_pembimbing($datap)
    {
        $this->db->insert('pembimbing', $datap);
    }
    
    public function cek_pembimbing($id_skripsi)
    {
        $stts = array('1','2');
        $this->db->select('p.id_pembimbing, p.nip');
        $this->db->from('pembimbing p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->where('p.id_skripsi', $id_skripsi);
        $this->db->where('p.id_jenjang', 2);
        $this->db->where_in('p.status', $stts);
        $query = $this -> db -> get();
		return $query->row();
    }
    
     public function cek_ruang_terpakai($data)
    {
        $this->db->select('u.id_ujian');
        $this->db->from('ujian u');
        $this->db->join('ruang r','u.id_ruang = r.id_ruang');
        $this->db->join('jam j','u.id_jam = j.id_jam');
        $this->db->where('u.tanggal', $data['tanggal']);
        $this->db->where('u.id_ruang', $data['id_ruang']);
        $this->db->where('u.id_jam', $data['id_jam']);
        $this->db->where('u.status',1);
        $query = $this -> db -> get();
		return $query->row();
    }
    
    public function save_ujian($data)
    {
        $this->db->insert('ujian', $data);
    }
    
    public function update_ujian($data, $id_ujian)
    {
        $this->db->where('id_ujian', $id_ujian);
        $this->db->update('ujian', $data);
    }

    
   /* public function detail($id_departemen, $id_skripsi)
	{
		$this->db->select('s.id_skripsi, s.tgl_pengajuan, s.judul, s.berkas_proposal, s.id_departemen, s.status_proposal, ,s.keterangan_proposal,dn.departemen, sr.semester, m.nim, m.nama ');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.id_departemen', $id_departemen);
        $this->db->where('s.jenis',1);
        $this->db->where('s.status_proposal',1);
        $this->db->where('s.id_skripsi', $id_skripsi);

		$query = $this -> db -> get();
		return $query->row();
    }
    
    public function update($data, $id_skripsi)
	{
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('skripsi', $data);
    }
    * 
    */
	
}
?>