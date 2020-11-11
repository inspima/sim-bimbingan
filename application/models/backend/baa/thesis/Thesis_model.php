<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Thesis_model extends CI_Model {

	public function read()
	{
		$this->db->distinct();
		$this->db->select('s.id_skripsi, m.nim, m.nama');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.jenis',3);
        $this->db->where('m.status',1);
		$this->db->order_by('s.id_skripsi','desc');

		$query = $this -> db -> get();
		return $query->result_array();
    }

    public function save_skripsi($datas)
    {
        $this->db->insert('skripsi',$datas);
    }
    
    public function cek_mahasiswan($nim)
    {
        
		$this->db->select('id_mahasiswa');
        $this->db->from('mahasiswa');
        $this->db->where('nim',$nim);
		$this->db->limit(1);

		$query = $this -> db -> get();
		return $query->row();
		
    }

    public function save_mahasiswa($datam)
    {
        $this->db->insert('mahasiswa',$datam);
    }

    public function save_judul($dataj)
    {
        $this->db->insert('judul', $dataj);
    }

    public function save_ujian($datau)
    {
        $this->db->insert('ujian', $datau);
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

    public function read_ujian($id_skripsi)
    {
        $this->db->select('u.id_ujian, u.tanggal, r.id_ruang, r.ruang, r.gedung, j.id_jam, j.jam');
        $this->db->from('ujian u');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->join('ruang r','u.id_ruang = r.id_ruang');
        $this->db->join('jam j','u.id_jam = j.id_jam');
        $this->db->where('s.id_skripsi', $id_skripsi);
        $this->db->where('u.jenis_ujian',3);
        $this->db->where('u.status',1);
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

    public function read_penguji_single($id_skripsi)
    {
        $stts = array('1','2');
        $this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama');
        $this->db->from('penguji p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
        $this->db->join('skripsi s','u.id_skripsi = s.id_skripsi');
        $this->db->where_in('p.status',$stts);
        $this->db->where('u.status',1);
        $this->db->where('s.id_skripsi',$id_skripsi);
        $this->db->order_by('p.status_tim','asc');
        $query = $this -> db -> get();
		return $query->result_array();
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

    public function update_ujian($data, $id_ujian)
    {
        $this->db->where('id_ujian', $id_ujian);
        $this->db->update('ujian', $data);
    }

    function detail($id_skripsi)
    {
        $this->db->select('s.id_skripsi, m.nim, m.nama');
        $this->db->from('skripsi s');
        $this->db->join('departemen dn','s.id_departemen = dn.id_departemen');
        $this->db->join('mahasiswa m','s.nim = m.nim');
        $this->db->where('s.jenis',3);
        $this->db->where('s.id_skripsi', $id_skripsi);

		$query = $this -> db -> get();
		return $query->row();
    }

    function update($data, $id_skripsi)
    {
        $this->db->where('id_skripsi', $id_skripsi);
        $this->db->update('skripsi', $data);
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

    public function count_penguji($id_ujian)
    {
        $stts = array('1','2','3');
        $this->db->where_in('p.status',$stts);
        $this->db->where('u.status',1);
        $this->db->where('u.id_ujian', $id_ujian);
        $this->db->from('penguji p');
        $this->db->join('pegawai pg','p.nip = pg.nip');
        $this->db->join('ujian u','p.id_ujian = u.id_ujian');
    
		$query = $this->db->count_all_results(); 
        return $query;
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
    
    public function save_penguji($data)
    {
        $this->db->insert('penguji', $data);
    }

    public function update_penguji($data, $id_penguji)
    {
        $this->db->where('id_penguji', $id_penguji);
        $this->db->update('penguji', $data);
    }
    
    
}
?>