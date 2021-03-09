<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Struktural_model extends CI_Model
	{

		public function read()
		{
			$this->db->select('l.id_struktural, l.id_struktur, l.nama, p.id_departemen, l.nip, s.nama_struktur, d.departemen, p.nama as nama_dosen');
			$this->db->from('struktural l');
			$this->db->join('struktur s', 'l.id_struktur = s.id_struktur');
			$this->db->join('pegawai p', 'l.nip = p.nip');
			$this->db->join('departemen d', 'p.id_departemen = d.id_departemen');
			$this->db->order_by('l.id_struktur', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function detail($id)
		{
			$this->db->select('l.id_struktural, l.id_struktur, l.nama, p.id_departemen, l.nip, s.nama_struktur, d.departemen, p.nama as nama_dosen');
			$this->db->from('struktural l');
			$this->db->join('struktur s', 'l.id_struktur = s.id_struktur');
			$this->db->join('pegawai p', 'l.nip = p.nip');
			$this->db->join('departemen d', 'p.id_departemen = d.id_departemen');
			$this->db->where('l.id_struktural', $id);

			$query = $this->db->get();
			return $query->row();
		}

		function update($data, $id_struktural)
		{
			$this->db->where('id_struktural', $id_struktural);
			$this->db->update('struktural', $data);
		}

		function read_struktural($username)
		{
			$this->db->select('l.id_struktural, l.id_struktur, l.nama, p.id_departemen, l.nip, s.nama_struktur, d.departemen, p.nama as nama_dosen, l.id_prodi');
			$this->db->from('struktural l');
			$this->db->join('struktur s', 'l.id_struktur = s.id_struktur');
			$this->db->join('pegawai p', 'l.nip = p.nip');
			$this->db->join('departemen d', 'p.id_departemen = d.id_departemen');
			$this->db->where('l.nip', $username);
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->row();
		}

		function read_wadek1()
		{
			$this->db->select('l.id_struktural, l.id_struktur, l.nama, l.nip, s.nama_struktur, p.nama as nama_dosen,p.ttd');
			$this->db->from('struktural l');
			$this->db->join('struktur s', 'l.id_struktur = s.id_struktur');
			$this->db->join('pegawai p', 'l.nip = p.nip');
			$this->db->where('s.id_struktur', 2);
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->row();
		}

		function read_dekan()
		{
			$this->db->select('l.id_struktural, l.id_struktur, l.nama, l.nip, s.nama_struktur, p.nama as nama_dosen, p.ttd');
			$this->db->from('struktural l');
			$this->db->join('struktur s', 'l.id_struktur = s.id_struktur');
			$this->db->join('pegawai p', 'l.nip = p.nip');
			$this->db->where('s.id_struktur', 1);
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->row();
		}

		function read_kps()
		{
			$this->db->select('l.id_struktural, l.id_struktur, l.nama, l.nip, s.nama_struktur, p.nama as nama_dosen,p.ttd');
			$this->db->from('struktural l');
			$this->db->join('struktur s', 'l.id_struktur = s.id_struktur');
			$this->db->join('pegawai p', 'l.nip = p.nip');
			$this->db->where('s.id_struktur', STRUKTUR_KPS_S1);
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->row();
		}

		function read_kps_s3()
		{
			$this->db->select('l.id_struktural, l.id_struktur, l.nama, l.nip, s.nama_struktur, p.nama as nama_dosen');
			$this->db->from('struktural l');
			$this->db->join('struktur s', 'l.id_struktur = s.id_struktur');
			$this->db->join('pegawai p', 'l.nip = p.nip');
			$this->db->where('s.id_struktur', STRUKTUR_KPS_S3);
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->row();
		}

		function read_kadep($id_departemen)
		{
			$this->db->select('l.id_struktural, l.id_struktur, l.nama, l.nip, s.nama_struktur, p.nama as nama_dosen,p.ttd');
			$this->db->from('struktural l');
			$this->db->join('struktur s', 'l.id_struktur = s.id_struktur');
			$this->db->join('pegawai p', 'l.nip = p.nip');
			$this->db->where('p.id_departemen', $id_departemen);
			$this->db->where('s.id_struktur', 5);
			$this->db->limit(1);

			$query = $this->db->get();
			return $query->row();
		}

	}

?>
