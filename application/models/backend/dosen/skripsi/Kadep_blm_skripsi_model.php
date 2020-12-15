<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kadep_blm_skripsi_model extends CI_Model {

	public function read($id_departemen)
	{   
        $stts = array('2','3');
		$this->db->select('s.id_skripsi, dn.departemen, g.gelombang, sr.semester, m.nim, m.nama ');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.id_departemen', $id_departemen);
        $this->db->where('s.jenis',2);
        //$this->db->where_in('s.status_skripsi',3);
        $this->db->where_in('s.status_skripsi',$stts);
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
    
    public function detail($id_departemen, $id_skripsi)
	{
		$stts = array('3','4','5');
		$this->db->select('s.id_skripsi, s.status_skripsi, dn.departemen, g.gelombang, sr.semester, m.nim, m.nama ');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('gelombang_skripsi g','s.id_gelombang = g.id_gelombang');
        $this->db->join('semester sr','g.id_semester = sr.id_semester');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.id_departemen', $id_departemen);
        $this->db->where('s.jenis',2);
        $this->db->where_in('s.status_skripsi',$stts);
        $this->db->where('s.id_skripsi', $id_skripsi);

		$query = $this -> db -> get();
		return $query->row();
    }
    
    public function update($data, $id_skripsi)
	{
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('skripsi', $data);
    }

    public function read_ujian($id_skripsi)
    {
        $this->db->select('u.id_ujian, u.id_skripsi, u.id_jam, u.tanggal, u.id_skripsi, u.status_ujian');
        $this->db->from('ujian u');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->where('u.id_skripsi', $id_skripsi);
        $this->db->where('s.jenis', 2);
        $this->db->where('u.jenis_ujian', 2);
        $this->db->where('u.status',1);
        $this->db->order_by('u.status_ujian desc, u.id_ujian desc',1);
        $query = $this -> db -> get();
		return $query->result_array();
    }

    public function read_ujian_row($id_skripsi)
    {
        $this->db->select('u.id_ujian, u.id_skripsi, u.id_jam, u.tanggal, u.id_skripsi, u.status_ujian');
        $this->db->from('ujian u');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->where('u.id_skripsi', $id_skripsi);
        $this->db->where('s.jenis', 2);
        $this->db->where('u.jenis_ujian', 2);
        $this->db->where('u.status',1);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function cek_id_ujian($id_ujian , $id_skripsi)
    {
        $this->db->select('id_ujian');
        $this->db->from('ujian');
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('id_skripsi', $id_skripsi);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function detail_ujian($id_ujian)
    {
        $this->db->select('u.id_ujian, u.id_ruang, u.id_jam, u.tanggal, r.ruang, r.gedung, j.jam');
        $this->db->from('ujian u');
        $this->db->join('jam j','u.id_jam = j.id_jam');
        $this->db->join('ruang r','u.id_ruang = r.id_ruang');
        $this->db->where('u.id_ujian', $id_ujian);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_ujian($id_skripsi)
    {
        $this->db->select('id_ujian, id_skripsi, status_ujian');
        $this->db->from('ujian');
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->where('status',1);
        $query = $this -> db -> get();
		return $query->result_array();
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

    public function save_ujian($datau)
    {
        $this->db->insert('ujian', $datau);
    }

    public function update_ujian($data, $id_ujian)
    {
        $this->db->where('id_ujian', $id_ujian);
        $this->db->update('ujian', $data);
    }

    public function read_penguji($id_ujian)
    {
        $stts = array('1','2','3');
        $this->db->select('p.id_penguji, p.nip, p.status_tim,p.usulan_dosbing, p.status, pg.nama');
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

    public function read_penguji_tanpatolak($id_ujian)
    {
        $stts = array('1','2');
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

    public function count_penguji($id_ujian)
    {
        $stts = array('1','2');
        $this->db->where_in('p.status',$stts);
        $this->db->where('u.status',1);
        $this->db->where('u.id_ujian', $id_ujian);
        $this->db->from('penguji p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
    
		$query = $this->db->count_all_results(); 
        return $query;
    }

    public function save_penguji($data)
    {
        $this->db->insert('penguji', $data);
    }

    public function save_pengujip($datap)
    {
        $this->db->insert('penguji', $datap);
    }

    public function update_penguji($data, $id_penguji)
    {
        $this->db->where('id_penguji', $id_penguji);
        $this->db->update('penguji', $data);
    }

    public function cek_penguji($data)
    {
        $stts = array('1','2');
        $this->db->select('p.id_penguji');
        $this->db->from('penguji p');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
        $this->db->where('u.id_ujian', $data['id_ujian']);
        $this->db->where('p.nip', $data['nip']);
        $this->db->where('u.status', 1);
        $this->db->where_in('p.status', $stts);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_pengujibentrok($tanggal, $id_jam, $nip)
    {
        $stts = array('1','2');
        $this->db->select('u.id_ujian');
        $this->db->from('ujian u');
        $this->db->join('penguji p','u.id_ujian = p.id_ujian');
        $this->db->where('u.tanggal',$tanggal);
        $this->db->where('u.id_jam', $id_jam);
        $this->db->where('p.nip',$nip);
        $this->db->where('u.status',1);
        $this->db->where_in('p.status', $stts);

        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_pengujiketua($id_ujian)
    {
        $stts = array('1','2');
        $this->db->select('id_penguji');
        $this->db->from('penguji');
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('status_tim',1);
        $this->db->where_in('status', $stts);

        $query = $this -> db -> get();
		return $query->row();
    }

    public function cekskripsi($nim)
    {
        $stts = array('0','1','2','3');
        $this->db->select('s.id_skripsi');
        $this->db->from('skripsi s');
        $this->db->where('s.nim',$nim);
        $this->db->where('s.jenis',2);
        $this->db->where_in('s.status_skripsi',$stts);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function save_skripsi($datas)
    {
        $this->db->insert('skripsi', $datas);
    }

    public function read_pembimbing($id_skripsi)
    {
        $stts = array('2');
        $sttsb = array('2','3');
        $this->db->select('p.id_pembimbing, p.id_skripsi, pg.nip, pg.nama, p.status ');
        $this->db->from('pembimbing p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->where('p.id_skripsi', $id_skripsi);
        $this->db->where_in('p.status_bimbingan', $sttsb);
        $this->db->where_in('p.status', $stts);
        $this->db->limit(1);
        $this->db->order_by('p.id_pembimbing','desc');
        $query = $this -> db -> get();
		return $query->row();
    }

    public function cek_pembimbing($id_skripsi)
    {
        $stts = array('1','2');
        $this->db->select('p.id_pembimbing, p.nip');
        $this->db->from('pembimbing p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->where('p.id_skripsi', $id_skripsi);
        $this->db->where_in('p.status', $stts);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function hitung_bimbingan_aktif($nip)
    {
        $stts = array('2');
        $this->db->where_in('p.status_bimbingan',$stts);
        $this->db->where('p.nip',$nip);    
        $this->db->where('s.jenis',2);
        $this->db->join('skripsi s','p.id_skripsi = s.id_skripsi');
        $this->db->from('pembimbing p');
		$query = $this->db->count_all_results(); 
        return $query;
    }

    public function save_pembimbing($datap)
    {
        $this->db->insert('pembimbing', $datap);
    }
    

    public function read_pengujipembimbing($id_ujian)
    {
        $stts = array('1','2');
        $this->db->select('p.id_penguji');
        $this->db->from('penguji p');
        $this->db->where('p.id_ujian', $id_ujian);
        $this->db->where('p.usulan_dosbing',2);
        $this->db->where_in('p.status',$stts);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_pengujipengajuanpembimbing($id_ujian)
    {
        $stts = array('1','2');
        $this->db->select('p.id_penguji');
        $this->db->from('penguji p');
        $this->db->where('p.id_ujian', $id_ujian);
        $this->db->where('p.usulan_dosbing',1);
        $this->db->where_in('p.status',$stts);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_pengujitemp($id_skripsi)
    {
        $this->db->select('p.nip');
        $this->db->from('penguji_temp p');
        $this->db->where('p.id_skripsi', $id_skripsi);
        $this->db->where('p.status',1);
        $this->db->order_by('p.id_penguji','desc');
        $this->db->limit(1);
        $query = $this -> db -> get();
		return $query->row();
    }

    public function read_pembimbinglama($id_skripsi)
    {
        $this->db->select('p.id_pembimbing');
        $this->db->from('pembimbing p');
        $this->db->where('p.id_skripsi', $id_skripsi);
        $query = $this -> db -> get();
		return $query->result_array();
    }

    public function nonaktif_pembimbing($id_pembimbing, $data)
    {
        $this->db->where('id_pembimbing', $id_pembimbing);
        $this->db->update('pembimbing', $data);
    }
	
}
?>