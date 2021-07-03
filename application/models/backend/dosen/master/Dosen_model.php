<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Dosen_model extends CI_Model
	{

		public function detail($username)
		{
			$this->db->select('p.*');
			$this->db->from('pegawai p');
			$this->db->where('p.status', 1);
			$this->db->where('p.nip', $username);

			$query = $this->db->get();
			return $query->row();
		}

		public function read_aktif($id_departemen)
		{
			$this->db->select('p.id_pegawai, p.id_departemen, p.nip, p.nama, p.email, p.status_berjalan, d.departemen');
			$this->db->from('pegawai p');
			$this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
			$this->db->where('p.status', 1);
			$this->db->where('p.status_berjalan', 1);
			$this->db->where('p.jenis_pegawai', 1);
			$this->db->where('p.id_departemen', $id_departemen);
			$this->db->order_by('p.nama', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_aktif_alldep()
		{
			$this->db->select('p.id_pegawai, p.id_departemen, p.nip, p.nama, p.email, p.status_berjalan, d.departemen');
			$this->db->from('pegawai p');
			$this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
			$this->db->where('p.status', 1);
			$this->db->where('p.status_berjalan', 1);
			$this->db->where('p.jenis_pegawai', 1);
			$this->db->order_by('p.nama', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_aktif_alldep_s2()
		{
			$this->db->select('p.id_pegawai, p.id_departemen, p.nip, p.nama, p.email, p.status_berjalan, d.departemen');
			$this->db->from('pegawai p');
			$this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
			$this->db->where('p.status', 1);
			$this->db->where('p.status_berjalan', 1);
			$this->db->where('p.jenis_pegawai', 1);
			$this->db->where('p.id_jenjang', 2);
			$this->db->order_by('p.nama', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_aktif_alldep_s3()
		{
			$this->db->select('p.id_pegawai, p.id_departemen, p.nip, p.nama, p.email, p.status_berjalan, d.departemen,p.external');
			$this->db->from('pegawai p');
			$this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
			$this->db->where('p.status', 1);
			$this->db->where('p.status_berjalan', 1);
			$this->db->where('p.jenis_pegawai', 1);
			$this->db->where('p.id_jenjang', 3);
			$this->db->order_by('p.nama', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function get_kadep($id_departemen)
		{
			$this->db->select('p.id_pegawai, p.id_departemen, p.nip, p.nama, p.email, p.status_berjalan, d.departemen');
			$this->db->from('struktural s');
			$this->db->join('pegawai p', 'p.nip = s.nip');
			$this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
			$this->db->where('s.id_struktur', STRUKTUR_KETUA_BAGIAN);
			$this->db->where('p.status', 1);
			$this->db->where('p.status_berjalan', 1);
			$this->db->where('p.jenis_pegawai', 1);
			$this->db->where('p.id_departemen', $id_departemen);
			$this->db->order_by('p.nama', 'asc');

			$query = $this->db->get();
			return $query->row();
		}

		public function read_pembimbing_aktif($jenjang)
		{
			$this->db->select('p.id_pegawai, p.id_departemen, p.nip, p.nama, p.email, p.status_berjalan, d.departemen');
			$this->db->from('pegawai p');
			$this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
			$this->db->where('p.status', 1);
			$this->db->where('p.status_berjalan', 1);
			$this->db->where('p.jenis_pegawai', 1);
			$this->db->where('`p`.`nip` IN (SELECT `nip` from `dosen_aktif` where `pembimbing`=1 and `id_jenjang`=\'' . $jenjang . '\')', null, false);
			$this->db->order_by('p.nama', 'asc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_aktif($jenjang)
		{
			$this->db->select('p.id_pegawai, p.id_departemen, p.nip, p.nama, p.email, p.status_berjalan, d.departemen');
			$this->db->from('pegawai p');
			$this->db->join('departemen d', 'd.id_departemen = p.id_departemen');
			$this->db->where('p.status', 1);
			$this->db->where('p.status_berjalan', 1);
			$this->db->where('p.jenis_pegawai', 1);
			$this->db->where('`p`.`nip` IN (SELECT `nip` from `dosen_aktif` where `penguji`=1 and `id_jenjang`=\'' . $jenjang . '\')', null, false);
			$this->db->order_by('p.nama', 'asc');
			$query = $this->db->get();
			return $query->result_array();
		}

	}

?>
