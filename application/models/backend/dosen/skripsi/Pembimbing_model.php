<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	class Pembimbing_model extends CI_Model
	{

		public function read_pengajuan($username)
		{
			$this->db->select('p.id_pembimbing, p.id_skripsi, p.nip, m.nim, m.nama, d.departemen');
			$this->db->from('pembimbing p');
			$this->db->join('skripsi s', 'p.id_skripsi = s.id_skripsi');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('p.nip', $username);
			$this->db->where('p.status', 2);
			$this->db->where('p.status_bimbingan', 2);
			$this->db->where('s.status_proposal >=', STATUS_SKRIPSI_PROPOSAL_SELESAI);

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_judul($id_skripsi)
		{
			$this->db->select('j.judul');
			$this->db->from('judul j');
			$this->db->join('skripsi s', 'j.id_skripsi = s.id_skripsi');
			$this->db->where('j.id_skripsi', $id_skripsi);
			$this->db->order_by('j.id_judul', 'desc');
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}

		public function hitung_bimbingan_aktif($username)
		{
			$stts = array('2');
			$this->db->where_in('p.status_bimbingan', $stts);
			$this->db->where('p.nip', $username);
			$this->db->where('s.jenis', 2);
			$this->db->join('skripsi s', 'p.id_skripsi = s.id_skripsi');
			$this->db->from('pembimbing p');
			$query = $this->db->count_all_results();
			return $query;
		}

		public function update_pembimbing($data, $id_pembimbing)
		{
			$this->db->where('id_pembimbing', $id_pembimbing);
			$this->db->update('pembimbing', $data);
		}

		public function update_skripsi($data, $id_skripsi)
		{
			$this->db->where('id_skripsi', $id_skripsi);
			$this->db->update('skripsi', $data);
		}

		public function read_approve($username)
		{
			$this->db->select('p.id_pembimbing, p.id_skripsi, p.nip, m.nim, m.nama, d.departemen');
			$this->db->from('pembimbing p');
			$this->db->join('skripsi s', 'p.id_skripsi = s.id_skripsi');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('p.nip', $username);
			$this->db->where('p.status', 2);
			$this->db->where('p.status_bimbingan', 2);
			$this->db->where('s.status_proposal >=', STATUS_SKRIPSI_PROPOSAL_SELESAI);

			$query = $this->db->get();
			return $query->result_array();
		}

		public function detail_approve($username, $id_skripsi)
		{
			$this->db->select('p.id_pembimbing, p.id_skripsi, p.nip, m.nim, m.nama, d.departemen, s.status_skripsi');
			$this->db->from('pembimbing p');
			$this->db->join('skripsi s', 'p.id_skripsi = s.id_skripsi');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen');
			$this->db->where('p.nip', $username);
			$this->db->where('p.status', 2);
			$this->db->where('p.status_bimbingan', 2);
			$this->db->where('s.status_proposal >=', STATUS_SKRIPSI_PROPOSAL_SELESAI);
			$this->db->where('p.id_skripsi', $id_skripsi);

			$query = $this->db->get();
			return $query->row();
		}

		public function pembimbingDetail($id_pembimbing)
		{
			$this->db->select('*');
			$this->db->from('pembimbing b');
			$this->db->where('id_pembimbing', $id_pembimbing);
			$query = $this->db->get();
			return $query->row();
		}

		public function bimbingan($id_skripsi)
		{
			$stts = array('1', '2');
			$this->db->select('b.id_bimbingan, b.id_skripsi, b.tanggal, b.hal, b.status,b.file');
			$this->db->from('bimbingan b');
			$this->db->where('b.id_skripsi', $id_skripsi);
			$this->db->where_in('b.status', $stts);
			$this->db->order_by('id_bimbingan', 'desc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function update_bimbingan($data, $id_bimbingan)
		{
			$this->db->where('id_bimbingan', $id_bimbingan);
			$this->db->update('bimbingan', $data);
		}

		public function read_pengujitemp($id_skripsi)
		{
			$this->db->select('p.id_penguji, pg.nip, pg.nama');
			$this->db->from('penguji_temp p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('skripsi s', 'p.id_skripsi = s.id_skripsi');
			$this->db->where('p.id_skripsi', $id_skripsi);
			$this->db->where('p.status', 1);
			$this->db->order_by('p.id_penguji', 'desc');
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}

		public function save_penguji($dataj)
		{
			$this->db->insert('penguji_temp', $dataj);
		}

		public function cek_penguji($id_skripsi)
		{
			$this->db->select('id_penguji');
			$this->db->from('penguji_temp');
			$this->db->where('id_skripsi', $id_skripsi);
			$this->db->Where('status', 1);
			$query = $this->db->get();
			return $query->result_array();
		}


	}

?>
