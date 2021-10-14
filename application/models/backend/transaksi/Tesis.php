<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Tesis extends CI_Model
	{

		// Tesis

		public function cek_prodi($id)
		{
			$this->db->select('s.*,m.*');
			$this->db->from('tesis s');
			$this->db->join('mahasiswa m', 'm.nim = s.nim', 'left');
			$this->db->where('s.id_tesis', $id);

			$query = $this->db->get();
			return $query->row()->id_prodi;
		}

		public function read_mahasiswa($username)
		{
			$this->db->select('s.*,pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.nim', $username);
			//$this->db->order_by('s.tgl_pengajuan', 'desc');
			$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->row_array();
		}

		public function read_judul_mahasiswa($username)
		{
			$this->db->select('s.*,pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua,
            d.departemen, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('s.nim', $username);
			$this->db->where('s.status_judul >=', 0);
			//$this->db->order_by('s.tgl_pengajuan', 'desc');
			$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_proposal_mahasiswa($username)
		{
			$this->db->select('s.*,pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua,
            d.departemen, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('s.nim', $username);
			$this->db->where('s.status_proposal >', 0);
			//$this->db->order_by('s.tgl_pengajuan', 'desc');
			$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_proposal($username)
		{
			$this->db->select('s.*, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, m.telp, m.id_prodi');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('prodi ps', 'ps.id_prodi = m.id_prodi', 'left');
			$this->db->join('pegawai pg3', 'pg3.id_prodi = ps.id_prodi', 'left');
			$this->db->where('s.status_proposal >', 0);
			$this->db->where('pg3.nip', $username);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and jenis=2 and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and jenis=2 and status=\'1\')');
			//$this->db->order_by('s.tgl_pengajuan', 'desc');
			$this->db->order_by('s.tgl_pengajuan_proposal', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_judul_tesis($username)
		{
			$this->db->select('s.*, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, m.telp');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('prodi ps', 'ps.id_prodi = m.id_prodi', 'left');
			$this->db->join('pegawai pg3', 'pg3.id_prodi = ps.id_prodi', 'left');
			$this->db->where('s.status_judul >', 0);
			$this->db->where('s.status_judul !=', STATUS_TESIS_JUDUL_DITOLAK);
			$this->db->where('pg3.nip', $username);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and jenis=1 and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and jenis=1 and status=\'1\')');
			$this->db->order_by('s.tgl_pengajuan', 'desc');
			//$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_judul_prodi($id)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('s.status_judul >', 0);
			$this->db->where('s.status_judul <', STATUS_TESIS_JUDUL_DITOLAK);
			$this->db->where('m.id_prodi =', $id);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_judul_prodi_pembimbing($id)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('s.status_judul >=', STATUS_TESIS_JUDUL_SETUJUI_SPS);
			$this->db->where('m.id_prodi =', $id);
			$this->db->where('s.nip_pembimbing_satu IS NOT NULL');
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_judul_prodi_status($id, $status)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('m.id_prodi =', $id);
			if ($status == STATUS_TESIS_JUDUL_SETUJUI_SPS) {
				$this->db->where('s.status_judul >=', STATUS_TESIS_JUDUL_SETUJUI_SPS);
				$this->db->where('s.status_judul <', STATUS_TESIS_JUDUL_DITOLAK);
			} else {
				$this->db->where('s.status_judul =', $status);
			}
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_proposal_prodi($id)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_proposal >', 0);
			$this->db->where('m.id_prodi =', $id);
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_proposal_prodi_status($id, $status_proposal)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			if ($id_prodi == S2_ILMU_HUKUM && $status_proposal == MIH_STATUS_TESIS_PROPOSAL_SETUJUI_SPS) {
				$this->db->where('s.status_proposal >=', $status_proposal);
			} else if ($id_prodi == S2_KENOTARIATAN && $status_proposal == MKN_STATUS_TESIS_PROPOSAL_SETUJUI_SPS) {
				$this->db->where('s.status_proposal >=', $status_proposal);
			} else {
				$this->db->where('s.status_proposal =', $status_proposal);
			}
			$this->db->where('m.id_prodi =', $id);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_proposal_departemen($id_departemen)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_proposal >', 0);
			$this->db->where('d.id_departemen =', $id_departemen);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_judul_departemen($id_departemen)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_judul =', STATUS_TESIS_JUDUL_SETUJUI_SPS);
			$this->db->where('d.id_departemen =', $id_departemen);
			$this->db->where('s.nip_pembimbing_satu IS NULL');
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_judul_departemen_pembimbing($id_departemen)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.status_judul >=', STATUS_TESIS_JUDUL_SETUJUI_SPS);
			$this->db->where('d.id_departemen =', $id_departemen);
			$this->db->where('s.nip_pembimbing_satu IS NOT NULL');
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_prodi_s2()
		{
			$this->db->select('j.*, ps.*');
			$this->db->from('prodi ps');
			$this->db->join('jenjang j', 'j.id_jenjang = ps.id_jenjang', 'left');
			$this->db->where('j.id_jenjang =', 2);
			$this->db->order_by('ps.id_prodi', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_max_prodi_s2()
		{
			$this->db->select('max(ps.id_prodi) as id_prodi');
			$this->db->from('prodi ps');
			$this->db->join('jenjang j', 'j.id_jenjang = ps.id_jenjang', 'left');
			$this->db->where('j.id_jenjang =', 2);
			$this->db->order_by('ps.id_prodi', 'desc');

			$query = $this->db->get();
			return $query->row()->id_prodi;
		}

		public function read_mkpt_mahasiswa($username)
		{
			$this->db->select('s.*, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, d.departemen ');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('s.nim', $username);
			$this->db->where('s.status_mkpt >', 0);
			//$this->db->order_by('s.tgl_pengajuan', 'desc');
			$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_mkpt($username)
		{
			$this->db->select('s.*, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, m.telp');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('prodi ps', 'ps.id_prodi = m.id_prodi', 'left');
			$this->db->join('pegawai pg3', 'pg3.id_prodi = ps.id_prodi', 'left');
			$this->db->where('s.status_mkpt >', 0);
			$this->db->where('pg3.nip', $username);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and jenis=3 and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and jenis=3 and jd.status=\'1\')');
			//$this->db->order_by('s.tgl_pengajuan', 'desc');
			$this->db->order_by('s.tgl_pengajuan_mkpt', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_ujian_mahasiswa($username)
		{
			$this->db->select('s.*, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, d.departemen, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('s.nim', $username);
			$this->db->where('s.status_tesis >', 0);
			//$this->db->order_by('s.tgl_pengajuan', 'desc');
			$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_ujian($username)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, mt.nm_minat, m.telp, m.id_prodi');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->join('prodi ps', 'ps.id_prodi = m.id_prodi', 'left');
			$this->db->join('pegawai pg3', 'pg3.id_prodi = ps.id_prodi', 'left');
			$this->db->where('s.status_tesis >', 0);
			$this->db->where('s.status_tesis !=', STATUS_TESIS_UJIAN_DITOLAK);
			$this->db->where('pg3.nip', $username);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and jenis=4 and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and jd.jenis=4 and jd.status=\'1\')');
			//$this->db->order_by('s.tgl_pengajuan', 'desc');
			$this->db->order_by('s.tgl_pengajuan_tesis', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_ujian_belum_approve($username)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->join('prodi ps', 'ps.id_prodi = m.id_prodi', 'left');
			$this->db->join('pegawai pg3', 'pg3.id_prodi = ps.id_prodi', 'left');
			$this->db->where('s.status_tesis >', 0);
			$this->db->where('s.status_tesis =', STATUS_TESIS_UJIAN_PENGAJUAN);
			$this->db->where('pg3.nip', $username);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and jenis=4 and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and jd.jenis=4 and jd.status=\'1\')');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_ujian_sudah_approve($username)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->join('prodi ps', 'ps.id_prodi = m.id_prodi', 'left');
			$this->db->join('pegawai pg3', 'pg3.id_prodi = ps.id_prodi', 'left');
			$this->db->where('s.status_tesis >', 0);
			$this->db->where('s.status_tesis >=', STATUS_TESIS_UJIAN_SETUJUI_BAA);
			$this->db->where('pg3.nip', $username);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and jenis=4 and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and jd.jenis=4 and jd.status=\'1\')');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_ujian_prodi($id, $jenis)
		{
			$this->db->select('s.*, pg1.nip nip_pemabimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, jd.judul, d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('s.status_tesis >', 0);
			$this->db->where('m.id_prodi =', $id);
			$this->db->where('jd.jenis =', $jenis);
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		function approval_judul($id_tesis)
		{
			$data = array(
				'status_judul' => STATUS_TESIS_JUDUL_SETUJUI_SPS,
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		function batal_judul($id_tesis)
		{
			$data = array(
				'status_judul' => STATUS_TESIS_JUDUL_PENGAJUAN,
				'keterangan_judul' => null,
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		function reject_judul($id_tesis, $keterangan)
		{
			$data = array(
				'status_judul' => STATUS_TESIS_JUDUL_DITOLAK,
				'keterangan_judul' => $keterangan,
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		function batal_pembimbing($id_tesis)
		{
			$data = array(
				'nip_pembimbing_satu' => null,
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		/*function approval_proposal($id_tesis)
		{
			$data = array(
				'status_proposal' => STATUS_TESIS_PROPOSAL_SETUJUI_SPS
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		function batal_proposal($id_tesis)
		{
			$data = array(
				'status_proposal' => STATUS_TESIS_PROPOSAL_PENGAJUAN
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		function reject_proposal($id_tesis)
		{
			$data = array(
				'status_proposal' => '4'
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}*/

		function approval_pembimbing_proposal($id_tesis)
		{
			$this->db->select('tesis.*');
			$this->db->from('tesis');
			$this->db->where('id_tesis', $id_tesis);
			$query = $this->db->get();
			$tesis = $query->row();

			if ($tesis->nip_pembimbing_satu == $this->session_data['username']) {
				$data = array(
					'status_pembimbing_satu' => '1'
				);
				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);

			}

			if ($tesis->nip_pembimbing_dua == $this->session_data['username']) {
				$data = array(
					'status_pembimbing_dua' => '1'
				);
				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);

			}

			$this->db->select('tesis.*');
			$this->db->from('tesis');
			$this->db->where('id_tesis', $id_tesis);
			$query = $this->db->get();
			$tesis_setelah_proses = $query->row();

			if ($tesis_setelah_proses->status_pembimbing_satu == '1' && $tesis_setelah_proses->status_pembimbing_dua == '1') {
				$data = array(
					'status_judul' => STATUS_TESIS_JUDUL_SETUJUI_PEMBIMBING
				);
				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);

			}
		}

		function reject_pembimbing_proposal($id_tesis)
		{
			$this->db->select('tesis.*');
			$this->db->from('tesis');
			$this->db->where('id_tesis', $id_tesis);
			$query = $this->db->get();
			$tesis = $query->row();

			if ($tesis->nip_pembimbing_satu == $this->session_data['username']) {
				$data = array(
					'status_pembimbing_satu' => '2',
					'status_judul' => STATUS_TESIS_JUDUL_SETUJUI_SPS,
				);
			}
			if ($tesis->nip_pembimbing_dua == $this->session_data['username']) {
				$data = array(
					'status_pembimbing_dua' => '2',
					'status_judul' => STATUS_TESIS_JUDUL_SETUJUI_SPS,
				);
			}

			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);

		}

		function batal_pembimbing_proposal($id_tesis)
		{
			$this->db->select('tesis.*');
			$this->db->from('tesis');
			$this->db->where('id_tesis', $id_tesis);
			$query = $this->db->get();
			$tesis = $query->row();

			if ($tesis->nip_pembimbing_satu == $this->session_data['username']) {
				$data = array(
					'status_pembimbing_satu' => null,
					'status_judul' => STATUS_TESIS_JUDUL_SETUJUI_SPS,
				);
			}
			if ($tesis->nip_pembimbing_dua == $this->session_data['username']) {
				$data = array(
					'status_pembimbing_dua' => null,
					'status_judul' => STATUS_TESIS_JUDUL_SETUJUI_SPS,
				);
			}

			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);

		}

		function approval_pengampu_mkpt($id_tesis_mkpt_pengampu)
		{
			$this->db->select('tesis.*, tmp.*');
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);
			$query = $this->db->get();
			$tesis = $query->row();

			if ($tesis->nip == $this->session_data['username']) {
				$data = array(
					'status' => '1'
				);
				$this->db->from('tesis_mkpt_pengampu');
				$this->db->where('id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);
				$this->db->update('tesis_mkpt_pengampu', $data);
			}

			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tesis.id_tesis', $tesis->id_tesis);

			$hitung_mkpt = $this->db->count_all_results();

			$stts = '1';
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tesis.id_tesis', $tesis->id_tesis);
			$this->db->where('tmp.status', $stts);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_mkpt == $hitung_approve) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_UJIAN
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else if ($hitung_approve < $hitung_mkpt && $hitung_approve > 0) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_DISETUJUI_DOSEN_MKPT
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_DISETUJUI_DOSEN_MKPT
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function reject_pengampu_mkpt($id_tesis_mkpt_pengampu)
		{
			$this->db->select('tesis.*, tmp.*');
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);
			$query = $this->db->get();
			$tesis = $query->row();

			if ($tesis->nip == $this->session_data['username']) {
				$data = array(
					'status' => '2'
				);
				$this->db->from('tesis_mkpt_pengampu');
				$this->db->where('id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);
				$this->db->update('tesis_mkpt_pengampu', $data);
			}

			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt', $tesis->id_tesis_mkpt);

			$hitung_penguji = $this->db->count_all_results();

			$stts = '1';
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt', $tesis->id_tesis_mkpt);
			$this->db->where('tmp.status', $stts);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_mkpt == $hitung_approve) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_UJIAN
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else if ($hitung_approve < $hitung_mkpt && $hitung_approve > 0) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_DISETUJUI_DOSEN_MKPT
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_DISETUJUI_DOSEN_MKPT
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function batal_pengampu_mkpt($id_tesis_mkpt_pengampu)
		{
			$this->db->select('tmp.*, tmp.*');
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);
			$query = $this->db->get();
			$tesis = $query->row();

			if ($tesis->nip == $this->session_data['username']) {
				$data = array(
					'status' => null
				);
				$this->db->from('tesis_mkpt_pengampu');
				$this->db->where('id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);
				$this->db->update('tesis_mkpt_pengampu', $data);
			}

			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt', $tesis->id_tesis_mkpt);

			$hitung_penguji = $this->db->count_all_results();

			$stts = '1';
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt', $tesis->id_tesis_mkpt);
			$this->db->where('tmp.status', $stts);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_mkpt == $hitung_approve) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_UJIAN
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else if ($hitung_approve < $hitung_mkpt && $hitung_approve > 0) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_DISETUJUI_DOSEN_MKPT
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_DISETUJUI_DOSEN_MKPT
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function publish_nilai_mkpt($id_tesis_mkpt_pengampu)
		{
			$this->db->select('tesis.*, tmp.*');
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);
			$query = $this->db->get();
			$tesis = $query->row();

			if ($tesis->nip == $this->session_data['username']) {
				$data = array(
					'nilai_publish' => $tesis->nilai_angka,
					'waktu_update' => date('Y-m-d H:i:s')
				);
				$this->db->from('tesis_mkpt');
				$this->db->where('id_tesis_mkpt', $tesis->id_tesis_mkpt);
				$this->db->update('tesis_mkpt', $data);
			}

			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tesis.id_tesis', $tesis->id_tesis);

			$hitung_mkpt = $this->db->count_all_results();

			$stts = '1';
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tesis.id_tesis', $tesis->id_tesis);
			$this->db->where('tm.nilai_publish', $stts);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_mkpt == $hitung_approve) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_UJIAN
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else if ($hitung_approve < $hitung_mkpt && $hitung_approve > 0) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_UJIAN
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_UJIAN
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function batal_publish_nilai_mkpt($id_tesis_mkpt_pengampu)
		{
			$this->db->select('tmp.*, tmp.*');
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);
			$query = $this->db->get();
			$tesis = $query->row();

			if ($tesis->nip == $this->session_data['username']) {
				$data = array(
					'nilai_publish' => null
				);
				$this->db->from('tesis_mkpt');
				$this->db->where('id_tesis_mkpt', $tesis->id_tesis_mkpt);
				$this->db->update('tesis_mkpt', $data);
			}

			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt', $tesis->id_tesis_mkpt);

			$hitung_penguji = $this->db->count_all_results();

			$stts = '1';
			$this->db->from('tesis');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis = tesis.id_tesis', 'left');
			$this->db->join('tesis_mkpt_pengampu tmp', 'tmp.id_tesis_mkpt = tm.id_tesis_mkpt', 'left');
			$this->db->where('tmp.id_tesis_mkpt', $tesis->id_tesis_mkpt);
			$this->db->where('tm.nilai_publish', $stts);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_mkpt == $hitung_approve) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_UJIAN
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else if ($hitung_approve < $hitung_mkpt && $hitung_approve > 0) {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_UJIAN
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			} else {
				$data = array(
					'status_mkpt' => STATUS_TESIS_MKPT_UJIAN
				);

				$this->db->where('id_tesis', $tesis->id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function reject_penguji_temp_proposal($id_tesis, $nip, $status)
		{
			$data = array(
				'status' => $status
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->where('nip', $nip);
			$this->db->update('penguji_tesis_temp', $data);
		}

		function approval_penguji_proposal($id_tesis, $id_ujian, $username)
		{
			$data = array(
				'status' => '2'
			);
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('status !=', '0');
			$this->db->where('nip', $username);
			$this->db->update('penguji_tesis', $data);

			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where_not_in('p.status', array('0'));
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_penguji = $this->db->count_all_results();

			$stts = '2';
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.status', $stts);
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_penguji == $hitung_approve) {
				$data = array(
					'status_proposal' => STATUS_TESIS_PROPOSAL_UJIAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve > 0)) {
				$data = array(
					'status_proposal' => STATUS_TESIS_PROPOSAL_SETUJUI_PENGUJI
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve == 0)) {
				$data = array(
					'status_proposal' => STATUS_TESIS_PROPOSAL_DIJADWALKAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function reject_penguji_proposal($id_tesis, $id_ujian, $username, $keterangan)
		{
			$data = array(
				'status' => '3',
				'keterangan' => $keterangan,
			);
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('status !=', '0');
			$this->db->where('nip', $username);
			$this->db->update('penguji_tesis', $data);

			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where_not_in('p.status', array('0'));
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_penguji = $this->db->count_all_results();

			$stts = '2';
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.status', $stts);
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_penguji == $hitung_approve) {
				$data = array(
					'status_proposal' => STATUS_TESIS_PROPOSAL_UJIAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve > 0)) {
				$data = array(
					'status_proposal' => STATUS_TESIS_PROPOSAL_SETUJUI_PENGUJI
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve == 0)) {
				$data = array(
					'status_proposal' => STATUS_TESIS_PROPOSAL_DIJADWALKAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function batal_penguji_proposal($id_tesis, $id_ujian, $username)
		{
			$data = array(
				'status' => '1'
			);
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('status !=', '0');
			$this->db->where('nip', $username);
			$this->db->update('penguji_tesis', $data);

			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where_not_in('p.status', array('0'));
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_penguji = $this->db->count_all_results();

			$stts = '2';
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.status', $stts);
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_penguji == $hitung_approve) {
				$data = array(
					'status_proposal' => STATUS_TESIS_PROPOSAL_UJIAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve > 0)) {
				$data = array(
					'status_proposal' => STATUS_TESIS_PROPOSAL_SETUJUI_PENGUJI
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve == 0)) {
				$data = array(
					'status_proposal' => STATUS_TESIS_PROPOSAL_DIJADWALKAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function approval_penguji_tesis($id_tesis, $id_ujian, $username)
		{
			/*$this->db->select('ujian_tesis.*, pt.*');
			$this->db->from('ujian_tesis');
			$this->db->join('penguji_tesis pt', 'pt.id_ujian=ujian_tesis.id_ujian');
			$this->db->where('id_tesis', $id_tesis);
			$this->db->where('nip', $username);
			$query = $this->db->get();
			$tesis = $query->row();*/

			$data = array(
				'status' => '2'
			);
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('status !=', '0');
			$this->db->where('nip', $username);
			$this->db->update('penguji_tesis', $data);

			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where_not_in('p.status', array('0'));
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_penguji = $this->db->count_all_results();

			$stts = '2';
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.status', $stts);
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_penguji == $hitung_approve) {
				$data = array(
					'status_tesis' => STATUS_TESIS_UJIAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve > 0)) {
				$data = array(
					'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_PENGUJI
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve == 0)) {
				$data = array(
					'status_tesis' => STATUS_TESIS_UJIAN_DIJADWALKAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function reject_penguji_tesis($id_tesis, $id_ujian, $username, $keterangan)
		{
			/*$this->db->select('ujian_tesis.*, pt.*');
			$this->db->from('ujian_tesis');
			$this->db->join('penguji_tesis pt', 'pt.id_ujian=ujian_tesis.id_ujian');
			$this->db->where('id_tesis', $id_tesis);
			$this->db->where('nip', $username);
			$query = $this->db->get();
			$tesis = $query->row();*/

			$data = array(
				'status' => '3',
				'keterangan' => $keterangan,
			);
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('status !=', '0');
			$this->db->where('nip', $username);
			$this->db->update('penguji_tesis', $data);

			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where_not_in('p.status', array('0'));
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_penguji = $this->db->count_all_results();

			$stts = '2';
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.status', $stts);
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_penguji == $hitung_approve) {
				$data = array(
					'status_tesis' => STATUS_TESIS_UJIAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve > 0)) {
				$data = array(
					'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_PENGUJI
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve == 0)) {
				$data = array(
					'status_tesis' => STATUS_TESIS_UJIAN_DIJADWALKAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function batal_penguji_tesis($id_tesis, $id_ujian, $username)
		{
			/*$this->db->select('ujian_tesis.*, pt.*');
			$this->db->from('ujian_tesis');
			$this->db->join('penguji_tesis pt', 'pt.id_ujian=ujian_tesis.id_ujian');
			$this->db->where('id_tesis', $id_tesis);
			$this->db->where('nip', $username);
			$query = $this->db->get();
			$tesis = $query->row();*/

			$data = array(
				'status' => '1'
			);
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('status !=', '0');
			$this->db->where('nip', $username);
			$this->db->update('penguji_tesis', $data);

			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where_not_in('p.status', array('0'));
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_penguji = $this->db->count_all_results();

			$stts = '2';
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.status', $stts);
			$this->db->where('p.id_ujian', $id_ujian);

			$hitung_approve = $this->db->count_all_results();

			if ($hitung_penguji == $hitung_approve) {
				$data = array(
					'status_tesis' => STATUS_TESIS_UJIAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve > 0)) {
				$data = array(
					'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_PENGUJI
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			} else if (($hitung_approve < $hitung_penguji) && ($hitung_approve == 0)) {
				$data = array(
					'status_tesis' => STATUS_TESIS_UJIAN_DIJADWALKAN
				);

				$this->db->where('id_tesis', $id_tesis);
				$this->db->update('tesis', $data);
			}
		}

		function approval_tesis($id_tesis)
		{
			$data = array(
				'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_BAA
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		function batal_tesis($id_tesis)
		{
			$data = array(
				'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		function reject_tesis($id_tesis, $keterangan)
		{
			$data = array(
				'status_tesis' => STATUS_TESIS_UJIAN_DITOLAK,
				'keterangan_tesis' => $keterangan,
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		function batal_verifikasi_jadwal_proposal($id_tesis)
		{
			$data = array(
				'status_apv_kaprodi' => null
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->where('status', 1);
			$this->db->update('ujian_tesis', $data);

			$penguji = $this->read_penguji($id_ujian);

           	if ($penguji) {
           		$ujian = $this->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);
           		$data_penguji = array(
					'status' => '1'
				);
				$this->db->where('id_ujian', $ujian->id_ujian);
				$this->db->update('penguji_tesis', $data_penguji);	
           	}

			$data_tesis = array(
				'status_proposal' => STATUS_TESIS_PROPOSAL_PENGAJUAN
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data_tesis);
		}

		function batal_verifikasi_jadwal_tesis($id_tesis)
		{
			$data = array(
				'status_apv_kaprodi' => null
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('ujian_tesis', $data);

			$data_tesis = array(
				'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_BAA
			);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data_tesis);
		}

		public function read($username)
		{
			$this->db->select('s.id_tesis, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, s.id_departemen, s.tgl_pengajuan, s.status_proposal,  s.berkas_proposal, d.departemen');
			$this->db->from('tesis s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', 1);
			$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		function read_aktif($username)
		{
			$stts = array('0', '1', '2', '3');
			$this->db->select('s.id_tesis, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, s.id_departemen, s.tgl_pengajuan, s.status_proposal, s.berkas_proposal, d.departemen');
			$this->db->from('tesis s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', TAHAPAN_TESIS_JUDUL);
			//$this->db->where_in('s.status_proposal', $stts);
			$this->db->where_in('s.status_judul', $stts);
			$this->db->limit(1);
			$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->row();
		}

		function read_aktif_mkpt($username)
		{
			$stts = array('1', '2', '3');
			$this->db->select('s.id_tesis, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, s.id_departemen, s.tgl_pengajuan, s.status_proposal, s.berkas_proposal, d.departemen');
			$this->db->from('tesis s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', TAHAPAN_TESIS_MKPT);
			//$this->db->where_in('s.status_proposal', $stts);
			$this->db->where_in('s.status_mkpt', $stts);
			$this->db->limit(1);
			$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->row();
		}

		function read_aktif_tesis($username)
		{
			$stts = array('1', '2', '3', '4', '5', '6');
			$this->db->select('s.id_tesis, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, s.id_departemen, s.tgl_pengajuan, s.status_proposal, s.berkas_proposal, d.departemen');
			$this->db->from('tesis s');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->where('s.nim', $username);
			$this->db->where('s.jenis', TAHAPAN_TESIS_UJIAN);
			//$this->db->where_in('s.status_proposal', $stts);
			$this->db->where_in('s.status_tesis', $stts);
			$this->db->limit(1);
			$this->db->order_by('s.id_tesis', 'desc');

			$query = $this->db->get();
			return $query->row();
		}

		public function save($data)
		{
			$this->db->insert('tesis', $data);
		}

		function detail($id)
		{
			$this->db->select('s.*,pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            dn.departemen, m.nim, m.nama,m.id_prodi,jd.judul,pr.nm_prodi,jn.jenjang, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('departemen dn', 's.id_departemen = dn.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			//$this->db->join('pegawai pg', 'pg.nip = s.nip_penasehat', 'left');
			$this->db->join('mahasiswa m', 's.nim = m.nim');
			$this->db->join('prodi pr', 'pr.id_prodi= m.id_prodi', 'left');
			$this->db->join('jenjang jn', 'jn.id_jenjang= m.id_jenjang', 'left');
			$this->db->where('s.id_tesis', $id);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis, pg1.nip, pg1.nama, pg2.nip,pg2.nama, dn.departemen, m.nim, m.nama,jd.judul,pr.nm_prodi,jn.jenjang');

			$query = $this->db->get();
			return $query->row();
		}

		function update($data, $id_tesis)
		{
			$this->db->where('id_tesis', $id_tesis);
			$this->db->update('tesis', $data);
		}

		// JUDUL TESIS

		public function read_judul($id_tesis, $jenis)
		{
			$aktif = '1';
			$this->db->select('j.*');
			$this->db->from('judul_tesis j');
			$this->db->join('tesis s', 'j.id_tesis = s.id_tesis');
			$this->db->where('j.id_tesis', $id_tesis);
			$this->db->where('j.jenis', $jenis);
			$this->db->where('j.status', $aktif);
			$this->db->order_by('j.id_judul', 'desc');
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}

		public function save_judul($data)
		{
			$this->db->insert('judul_tesis', $data);
		}

		public function save_penilaian($data)
		{
			$this->db->insert('penilaian_tesis', $data);
		}

		function update_judul($data, $id_tesis, $jenis)
		{
			$this->db->where('id_tesis', $id_tesis);
			$this->db->where('jenis', $jenis);
			$this->db->update('judul_tesis', $data);
		}

		function update_penilaian($data, $id)
		{
			$this->db->where('id', $id);
			$this->db->update('penilaian_tesis', $data);
		}

		// PENGUJI

		public function read_permintaan_penguji($username, $jenis)
		{
			$this->db->select('s.*, pt.status as status_penguji,jd.judul, pt.status, d.departemen ,m.nama,uj.id_ujian');
			$this->db->from('tesis s');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('ujian_tesis uj', 'uj.id_tesis = s.id_tesis');
			$this->db->join('penguji_tesis pt', 'uj.id_ujian = pt.id_ujian', 'left');
			$this->db->where('uj.jenis_ujian', $jenis);
			$this->db->where('`nip`=\'' . $username . '\'', null, false);
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_permintaan_penguji_prodi($username, $jenis, $id)
		{
			$this->db->select('s.*, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, pt.id_penguji, pt.status as status_penguji, pt.status_tim, jd.judul, pt.status, d.departemen ,m.nama,uj.id_ujian, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->join('ujian_tesis uj', 'uj.id_tesis = s.id_tesis');
			$this->db->join('penguji_tesis pt', 'uj.id_ujian = pt.id_ujian', 'left');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->where('m.id_prodi', $id);
			$this->db->where('uj.jenis_ujian', $jenis);
			$this->db->where('pt.status !=', 0);
			$this->db->where('pt.nip=\'' . $username . '\'', null, false);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis, pg1.nip,pg1.nama, pg2.nip,pg2.nama, pt.id_penguji, pt.status, pt.status_tim, jd.judul, pt.status, d.departemen ,m.nama, uj.id_ujian');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji($id_ujian)
		{
			$stts = array('1', '2', '3');
			$this->db->select('p.id_penguji, p.nip, p.status_tim, p.keterangan, p.status, pg.nama, pg.ttd');
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_ujian', $id_ujian);
			$this->db->where_in('p.status', $stts);
			$this->db->order_by('p.status_tim', 'asc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_id($id_penguji)
		{
			$stts = array('1', '2');
			$this->db->select('p.id_penguji, p.nip, p.status_tim, p.status, pg.nama, pg.ttd');
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_penguji', $id_penguji);
			$this->db->where_in('p.status', $stts);
			$this->db->order_by('p.status_tim', 'asc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_temp($id_tesis, $asal_pengusul)
		{
			$stts = array('1', '2', '3', '4');
			$this->db->select('p.id_penguji, p.nip, p.status, pg.nama');
			$this->db->from('penguji_tesis_temp p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where('p.id_tesis', $id_tesis);
			$this->db->where('p.asal_pengusul', $asal_pengusul);
			$this->db->where_in('p.status', $stts);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penguji_temp_belum_resmi($id_tesis, $jenis_ujian, $id_ujian, $asal_pengusul)
		{
			$stts = array('1', '2');
			$this->db->select('p.id_penguji, p.nip, p.status, pg.nama');
			$this->db->from('penguji_tesis_temp p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian_tesis u', 'u.id_tesis = p.id_tesis', 'left');
			$this->db->join('penguji_tesis pt', 'pt.id_ujian = u.id_ujian and p.nip = pt.nip', 'left');
			$this->db->where('p.id_tesis', $id_tesis);
			$this->db->where('p.asal_pengusul', $asal_pengusul);
			$this->db->where("(pt.nip is null or pt.status = 0)");
			$this->db->where('u.jenis_ujian', $jenis_ujian);
			if ($id_ujian != '') {
				$this->db->where('u.id_ujian', $id_ujian);
			}
			$this->db->where_in('p.status', $stts);
			$this->db->group_by('p.id_penguji, p.nip, p.status, pg.nama');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function cek_penguji($data)
		{
			$stts = array('1', '2', '3');
			$this->db->select('p.id_penguji');
			$this->db->from('penguji_tesis p');
			$this->db->join('ujian_tesis u', 'p.id_ujian = u.id_ujian');
			$this->db->where('u.id_ujian', $data['id_ujian']);
			$this->db->where('p.nip', $data['nip']);
			$this->db->where('u.status', 1);
			$this->db->where_in('p.status', $stts);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_penguji_ketua($id_ujian)
		{
			$stts = array('1', '2');
			$this->db->select('id_penguji');
			$this->db->from('penguji_tesis');
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('status_tim', 1);
			$this->db->where_in('status', $stts);

			$query = $this->db->get();
			return $query->row();
		}

		public function read_penguji_anggota($id_ujian)
		{
			$stts = array('1', '2');
			$this->db->select('id_penguji');
			$this->db->from('penguji_tesis');
			$this->db->where('id_ujian', $id_ujian);
			$this->db->where('status_tim', 2);
			$this->db->where_in('status', $stts);

			$query = $this->db->get();
			return $query->row();
		}

		public function read_pengujibentrok($tanggal, $id_jam, $nip)
		{
			$stts = array('1', '2');
			$this->db->select('u.id_ujian');
			$this->db->from('ujian u');
			$this->db->join('penguji p', 'u.id_ujian = p.id_ujian');
			$this->db->where('u.tanggal', $tanggal);
			$this->db->where('u.id_jam', $id_jam);
			$this->db->where('p.nip', $nip);
			$this->db->where('u.status', 1);
			$this->db->where_in('p.status', $stts);
			$s1 = $this->db->get();
			$s1->row();

			$this->db->select('u.id_ujian');
			$this->db->from('ujian_tesis u');
			$this->db->join('penguji_tesis p', 'u.id_ujian = p.id_ujian');
			$this->db->where('u.tanggal', $tanggal);
			$this->db->where('u.id_jam', $id_jam);
			$this->db->where('p.nip', $nip);
			$this->db->where('u.status', 1);
			$this->db->where_in('p.status', $stts);
			$s2 = $this->db->get();
			$s2->row();

			$this->db->select('u.id_ujian');
			$this->db->from('ujian_disertasi u');
			$this->db->join('penguji_disertasi p', 'u.id_ujian = p.id_ujian');
			$this->db->where('u.tanggal', $tanggal);
			$this->db->where('u.id_jam', $id_jam);
			$this->db->where('p.nip', $nip);
			$this->db->where('u.status', 1);
			$this->db->where_in('p.status', $stts);
			$s3 = $this->db->get();
			$s3->row();

			if (empty($s1->row()) && empty($s2->row()) && empty($s3->row())) {
				return true;
			} else {
				return false;
			}
		}

		public function count_penguji($id_ujian)
		{
			$stts = array('1', '2');
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian_tesis u', 'p.id_ujian = u.id_ujian');
			$this->db->where_in('p.status', $stts);
			$this->db->where('u.status', 1);
			$this->db->where('u.id_ujian', $id_ujian);

			$query = $this->db->count_all_results();
			return $query;
		}

		public function count_penguji_temp($id_tesis, $asal_pengusul)
		{
			$stts = array('1', '2');
			$this->db->from('penguji_tesis_temp p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->where_in('p.status', $stts);
			$this->db->where('p.id_tesis', $id_tesis);
			$this->db->where('p.asal_pengusul', $asal_pengusul);

			$query = $this->db->count_all_results();
			return $query;
		}

		public function semua_penguji_setuju($id_ujian)
		{

			$jumlah_penguji = $this->count_penguji($id_ujian);
			$stts = array('2');
			$this->db->from('penguji_tesis p');
			$this->db->join('pegawai pg', 'p.nip = pg.nip');
			$this->db->join('ujian_tesis u', 'p.id_ujian = u.id_ujian');
			$this->db->where_in('p.status', $stts);
			$this->db->where('u.status', 1);
			$this->db->where('u.id_ujian', $id_ujian);
			$jumlah_setuju = $this->db->count_all_results();
			if ($jumlah_penguji == $jumlah_setuju) {
				return true;
			} else {
				return false;
			}
		}

		public function save_penguji($data)
		{
			$this->db->insert('penguji_tesis', $data);
		}

		public function save_penguji_temp($data)
		{
			$this->db->insert('penguji_tesis_temp', $data);
		}

		public function update_penguji($data, $id_penguji)
		{
			$this->db->where('id_penguji', $id_penguji);
			$this->db->update('penguji_tesis', $data);
		}

		public function update_penguji_temp($data, $id_penguji)
		{
			$this->db->where('id_penguji', $id_penguji);
			$this->db->update('penguji_tesis_temp', $data);
		}


		public function read_permintaan_pembimbing($username)
		{
			$this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->where('(s.id_tesis IN (SELECT id_tesis from tesis where nip_pembimbing_satu=\'' . $username . '\') OR s.id_tesis IN (SELECT id_tesis from tesis where nip_pembimbing_dua=\'' . $username . '\'))', null, false);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_permintaan_pembimbing_prodi($username, $id)
		{
			$this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('m.id_prodi =', $id);
			$this->db->where('(s.id_tesis IN (SELECT id_tesis from tesis where nip_pembimbing_satu=\'' . $username . '\') OR s.id_tesis IN (SELECT `id_tesis` from `tesis` where nip_pembimbing_dua=\'' . $username . '\'))', null, false);
			$this->db->where('jd.id_judul = (SELECT MAX(id_judul) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penjadwalan($username)
		{
			$this->db->select('struktural.*');
			$this->db->from('struktural');
			$this->db->where('struktural.nip', $username);
			$query_s = $this->db->get();
			$struktural = $query_s->row();

			$this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('`m`.`id_prodi` =\'' . $struktural->id_prodi . '\'', null, false);
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penjadwalan_prodi($username, $id, $jenis)
		{
			$this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->where('m.id_prodi', $id);
			$this->db->where('s.jenis', $jenis);
			$this->db->where('jd.jenis', $jenis);
			//$this->db->where('jd.jenis = (SELECT MAX(jenis) from judul_tesis WHERE id_tesis=s.id_tesis and status=\'1\')');
			//$this->db->group_by('s.id_tesis,jd.judul, pg1.nip,pg1.nama, pg2.nip,pg2.nama');
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penjadwalan_prodi_proposal_status($username, $id, $jenis, $status)
		{
			$this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->join('ujian_tesis u', 'u.id_tesis = s.id_tesis', 'left');
			$this->db->where('m.id_prodi', $id);
			$this->db->where('s.jenis', $jenis);
			$this->db->where('jd.jenis', $jenis);
			$this->db->where('u.jenis_ujian', UJIAN_TESIS_PROPOSAL);
			if ($status == STATUS_TESIS_PROPOSAL_DIJADWALKAN) {
				$this->db->where('s.status_proposal >=', $status);
				$this->db->where('s.status_proposal <', STATUS_TESIS_PROPOSAL_UJIAN_SELESAI);
				$this->db->where('s.status_ujian_proposal =', 0);
			} else if ($status == STATUS_TESIS_PROPOSAL_UJIAN_SELESAI) {
				$this->db->where('s.status_proposal >=', $status);
				$this->db->where('s.status_ujian_proposal !=', 0);
			} else if ($status == 'anyar') {
				//$this->db->where('u.id_ujian =', null);
				$this->db->where('s.status_proposal', STATUS_TESIS_PROPOSAL_PENGAJUAN);
			} else {
				$this->db->where('u.id_ujian !=', null);
				//$this->db->where('u.status_apv_kaprodi !=', 1);
				$this->db->where('s.status_proposal', $status);
			}
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penjadwalan_prodi_tesis_status($username, $id, $jenis, $status)
		{
			$this->db->select('s.*,jd.judul, pg1.nip nip_pembimbing_satu,pg1.nama nama_pembimbing_satu,  
            pg2.nip nip_pembimbing_dua,pg2.nama nama_pembimbing_dua, 
            d.departemen ,m.nama, mt.nm_minat');
			$this->db->from('tesis s');
			$this->db->join('pegawai pg1', 'pg1.nip = s.nip_pembimbing_satu', 'left');
			$this->db->join('pegawai pg2', 'pg2.nip = s.nip_pembimbing_dua', 'left');
			$this->db->join('judul_tesis jd', 'jd.id_tesis=s.id_tesis and jd.status=\'1\'');
			$this->db->join('mahasiswa m', 'm.nim= s.nim');
			$this->db->join('departemen d', 's.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 's.id_minat = mt.id_minat', 'left');
			$this->db->join('ujian_tesis u', 'u.id_tesis = s.id_tesis', 'left');
			$this->db->where('m.id_prodi', $id);
			$this->db->where('s.jenis', $jenis);
			$this->db->where('jd.jenis', $jenis);
			//$this->db->where('u.jenis_ujian', UJIAN_TESIS_UJIAN);
			if ($status == STATUS_TESIS_UJIAN_DIJADWALKAN) {
				$this->db->where('u.jenis_ujian', UJIAN_TESIS_UJIAN);
				$this->db->where('s.status_tesis >=', $status);
				$this->db->where('s.status_tesis <', STATUS_TESIS_UJIAN_SELESAI);
				$this->db->where('s.status_tesis >=', STATUS_TESIS_UJIAN_DIJADWALKAN);
				$this->db->where('s.status_ujian_tesis =', NULL);
			} else if ($status == STATUS_TESIS_UJIAN_SELESAI) {
				$this->db->where('u.jenis_ujian', UJIAN_TESIS_UJIAN);
				$this->db->where('s.status_tesis >=', $status);
				$this->db->where('s.status_ujian_tesis !=', 0);
			} else if ($status == 'anyar') {
				$this->db->where('u.id_ujian =', null);
				//$this->db->where('s.status_tesis', STATUS_TESIS_UJIAN_PENGAJUAN);
				$this->db->where('s.status_tesis <=',STATUS_TESIS_UJIAN_PENGAJUAN);
				$this->db->where('s.id_tesis NOT IN (SELECT id_tesis FROM ujian_tesis WHERE jenis_ujian = '.UJIAN_TESIS_UJIAN.')');
			} else {
				$this->db->where('u.jenis_ujian', UJIAN_TESIS_UJIAN);
				$this->db->where('u.id_ujian !=', null);
				//$this->db->where('u.status_apv_kaprodi !=', 1);
				$this->db->where('s.status_tesis', $status);
			}
			$this->db->order_by('s.tgl_pengajuan', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}

		// JADWAL
		public function read_jadwal_all()
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian_tesis u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_jadwal_by_id($id_ujian)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian_tesis u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_ujian', $id_ujian);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_jadwal($id_tesis, $jenis_ujian)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian_tesis u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_tesis', $id_tesis);
			$this->db->where('u.jenis_ujian', $jenis_ujian);
			$this->db->where('u.status', 1);
			$this->db->where('u.status_ujian', 1);
			$query = $this->db->get();
			return $query->row();
		}

		public function read_jadwal_ujian_ulang($id_tesis, $jenis_ujian)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian_tesis u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_tesis', $id_tesis);
			$this->db->where('u.jenis_ujian', $jenis_ujian);
			$this->db->where('u.status', 1);
			$this->db->where('u.status_ujian', 2);
			$this->db->where('u.hasil_ujian', 0);// Belum Ujian
			$query = $this->db->get();
			return $query->row();
		}

		public function cek_ruang_terpakai($data)
		{
			$this->db->select('u.id_ujian');
			$this->db->from('ujian u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.tanggal', $data['tanggal']);
			$this->db->where('u.id_ruang', $data['id_ruang']);
			$this->db->where('u.id_jam', $data['id_jam']);
			$this->db->where('u.status', 1);
			$s1 = $this->db->get();
			$s1->row();

			$this->db->select('u.id_ujian');
			$this->db->from('ujian_tesis u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.tanggal', $data['tanggal']);
			$this->db->where('u.id_ruang', $data['id_ruang']);
			$this->db->where('u.id_jam', $data['id_jam']);
			$this->db->where('u.status', 1);
			$s2 = $this->db->get();
			$s2->row();

			$this->db->select('u.id_ujian');
			$this->db->from('ujian_disertasi u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.tanggal', $data['tanggal']);
			$this->db->where('u.id_ruang', $data['id_ruang']);
			$this->db->where('u.id_jam', $data['id_jam']);
			$this->db->where('u.status', 1);
			$s3 = $this->db->get();
			$s3->row();

			if ((empty($s1->row()) && empty($s2->row()) && empty($s3->row())) or $data['id_ruang'] == 11) {
				return true;
			} else {
				return false;
			}
		}

		public function read_tesis_mkpt_pengampu_prodi($username, $id)
		{
			$this->db->select('m.*, t.*, tm.*, d.departemen, mhs.nim, mhs.nama as nama_mhs, p.nip as nip_pengampu_mkpt, p.nama as nama_pengampu_mkpt, m.status as status_pengampu_mkpt, mt.nm_minat');
			$this->db->from('tesis_mkpt_pengampu m');
			$this->db->join('pegawai p', 'p.nip = m.nip');
			$this->db->join('tesis_mkpt tm', 'tm.id_tesis_mkpt = m.id_tesis_mkpt', 'left');
			$this->db->join('tesis t', 't.id_tesis = tm.id_tesis', 'left');
			$this->db->join('mahasiswa mhs', 'mhs.nim= t.nim', 'left');
			$this->db->join('departemen d', 't.id_departemen = d.id_departemen', 'left');
			$this->db->join('minat_tesis mt', 't.id_minat = mt.id_minat', 'left');
			$this->db->where('mhs.id_prodi', $id);
			$this->db->where('m.nip', $username);
			$this->db->order_by('m.id_tesis_mkpt_pengampu desc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_tesis_mkpt($id_tesis)
		{
			$this->db->select('*');
			$this->db->from('tesis_mkpt m');
			$this->db->where('m.id_tesis', $id_tesis);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function detail_tesis_mkpt($id_tesis_mkpt)
		{
			$this->db->select('*');
			$this->db->from('tesis_mkpt m');
			$this->db->where('m.id_tesis_mkpt', $id_tesis_mkpt);
			$query = $this->db->get();
			return $query->row();
		}

		public function detail_tesis_mkpt_by_data($data)
		{
			$this->db->select('*');
			$this->db->from('tesis_mkpt m');
			$this->db->where('m.id_tesis', $data['id_tesis']);
			//$this->db->where('m.kode', $data['kode']);
			$this->db->where('m.mkpt', $data['mkpt']);
			$query = $this->db->get();
			return $query->row();
		}

		public function save_tesis_mkpt($data)
		{
			$this->db->insert('tesis_mkpt', $data);
		}

		public function update_tesis_mkpt($data, $id_tesis_mkpt)
		{
			$this->db->where('id_tesis_mkpt', $id_tesis_mkpt);
			$this->db->update('tesis_mkpt', $data);
		}

		public function delete_tesis_mkpt($id_tesis_mkpt)
		{
			$this->db->where('id_tesis_mkpt', $id_tesis_mkpt);
			$this->db->delete('tesis_mkpt');
		}

		public function delete_tesis_mkpt_by_tesis($id_tesis)
		{
			$this->delete_tesis_mkpt_pengampu($id_tesis);
			$this->db->where('id_tesis', $id_tesis);
			$this->db->delete('tesis_mkpt');
		}

		public function read_tesis_mkpt_pengampu($id_tesis_mkpt)
		{
			$this->db->select('m.*,p.nama');
			$this->db->from('tesis_mkpt_pengampu m');
			$this->db->join('pegawai p', 'p.nip = m.nip');
			$this->db->where('m.id_tesis_mkpt', $id_tesis_mkpt);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function detail_tesis_mkpt_pengampu($id)
		{
			$this->db->select('m.*,p.nama');
			$this->db->from('tesis_mkpt_pengampu m');
			$this->db->join('pegawai p', 'p.nip = m.nip');
			$this->db->where('m.id_tesis_mkpt_pengampu', $id);
			$query = $this->db->get();
			return $query->row();
		}

		public function cek_mkpt_pengampu_pjmk($id_tesis_mkpt, $nip)
		{
			$this->db->select('m.*,p.nama');
			$this->db->from('tesis_mkpt_pengampu m');
			$this->db->join('pegawai p', 'p.nip = m.nip');
			$this->db->where('m.id_tesis_mkpt', $id_tesis_mkpt);
			$this->db->where('m.nip', $nip);
			$query = $this->db->get();
			$result = $query->row();
			if (!empty($result)) {
				if ($result->pjmk == '1') {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public function cek_mkpt_ada_pjmk($id_tesis_mkpt)
		{
			$this->db->select('m.*');
			$this->db->from('tesis_mkpt_pengampu m');
			$this->db->where('m.id_tesis_mkpt', $id_tesis_mkpt);
			$this->db->where('m.pjmk', 1);
			$query = $this->db->get();
			$result = $query->num_rows();
			if ($result > 0) {
				return true;
			} else {
				return false;
			}
		}

		public function detail_mkpt_pengampu_pjmk($id_tesis_mkpt)
		{
			$this->db->select('m.*,p.nama');
			$this->db->from('tesis_mkpt_pengampu m');
			$this->db->join('pegawai p', 'p.nip = m.nip');
			$this->db->where('m.id_tesis_mkpt', $id_tesis_mkpt);
			$this->db->where('pjmk', 1);
			$query = $this->db->get();
			return $query->row();
		}

		public function save_tesis_mkpt_pengampu($data)
		{
			$this->db->insert('tesis_mkpt_pengampu', $data);
		}

		public function update_tesis_mkpt_pengampu($data, $id_tesis_mkpt_pengampu)
		{
			$this->db->where('id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);
			$this->db->update('tesis_mkpt_pengampu', $data);

			$this->db->select('tesis_mkpt_pengampu.*');
			$this->db->from('tesis_mkpt_pengampu');
			$this->db->where('id_tesis_mkpt_pengampu', $id_tesis_mkpt_pengampu);

			$query = $this->db->get();
			$tesis_mkpt_pengampu = $query->row();

			$this->db->select('tesis_mkpt.*, tesis_mkpt_pengampu.nip');
			$this->db->from('tesis_mkpt_pengampu');
			$this->db->join('tesis_mkpt', 'tesis_mkpt.id_tesis_mkpt = tesis_mkpt_pengampu.id_tesis_mkpt');
			$this->db->where('tesis_mkpt_pengampu.id_tesis_mkpt', $tesis_mkpt_pengampu->id_tesis_mkpt);

			$hitung_pengampu = $this->db->count_all_results();

			$this->db->select('tesis_mkpt.*, tesis_mkpt_pengampu.nip');
			$this->db->from('tesis_mkpt_pengampu');
			$this->db->join('tesis_mkpt', 'tesis_mkpt.id_tesis_mkpt = tesis_mkpt_pengampu.id_tesis_mkpt');
			$this->db->where('tesis_mkpt_pengampu.id_tesis_mkpt', $tesis_mkpt_pengampu->id_tesis_mkpt);
			$this->db->where_in('tesis_mkpt_pengampu.status_ujian', array('1', '2'));

			$hitung_status_ujian = $this->db->count_all_results();

			if($hitung_pengampu == $hitung_status_ujian){
				$data = array(
                    'status_mkpt' => STATUS_TESIS_MKPT_UJIAN_SELESAI,
                );
                $this->tesis->update($data, $tesis_mkpt_pengampu->id_tesis);
			}
			else {
				$data = array(
                    'status_mkpt' => STATUS_TESIS_MKPT_UJIAN,
                );
                $this->tesis->update($data, $tesis_mkpt_pengampu->id_tesis);
			}
		}

		public function delete_tesis_mkpt_pengampu($id_tesis)
		{
			$this->db->where('id_tesis', $id_tesis);
			$this->db->delete('tesis_mkpt_pengampu');
		}

		public function rata_nilai_tesis_mkpt($id_tesis_mkpt)
		{
			$this->db->select_avg('nilai_angka');
			$this->db->from('tesis_mkpt_pengampu m');
			$this->db->where('id_tesis_mkpt', $id_tesis_mkpt);
			$query = $this->db->get();
			$result = $query->row();
			if (!empty($result)) {
				return $result->nilai_angka;
			} else {
				return 0;
			}
		}

		public function cek_mkpt_sudah_publish($id_tesis)
		{
			$jumlah_tesis_mkpt = count($this->read_tesis_mkpt($id_tesis));
			$this->db->select('m.*');
			$this->db->from('tesis_mkpt m');
			$this->db->where('m.id_tesis', $id_tesis);
			$this->db->where('m.nilai_publish', 1);
			$query = $this->db->get();
			$result = $query->num_rows();
			if ($result == $jumlah_tesis_mkpt) {
				return true;
			} else {
				return false;
			}
		}

		// UJIAN

		public function detail_ujian_by_tesis($id_tesis, $jenis)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian_tesis u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_tesis', $id_tesis);
			$this->db->where('u.jenis_ujian', $jenis);
			$query = $this->db->get();
			return $query->row();
		}

		public function detail_ujian($id_ujian)
		{
			$this->db->select('u.*, r.ruang, r.gedung, j.jam');
			$this->db->from('ujian_tesis u');
			$this->db->join('ruang r', 'u.id_ruang = r.id_ruang');
			$this->db->join('jam j', 'u.id_jam = j.id_jam');
			$this->db->where('u.id_ujian', $id_ujian);
			$query = $this->db->get();
			return $query->row();
		}

		public function save_ujian($data)
		{
			$this->db->insert('ujian_tesis', $data);
		}

		public function update_ujian($data, $id_ujian)
		{
			$this->db->where('id_ujian', $id_ujian);
			$this->db->update('ujian_tesis', $data);
		}

		public function read_status_ujian($jenis)
		{
			if ($jenis == UJIAN_TESIS_PROPOSAL) {
				return [
					['value' => '0', 'text' => 'Belum Ujian'],
					['value' => '1', 'text' => 'Layak'],
					//['value' => '2', 'text' => 'Layak dengan Catatan'],
					['value' => '3', 'text' => 'Tidak Layak'],
				];
			} else if ($jenis == UJIAN_TESIS_MKPT) {
				return [
					['value' => '0', 'text' => 'Belum Ujian'],
					['value' => '1', 'text' => 'Syarat Lengkap'],
					//['value' => '2', 'text' => 'Syarat Lengkap dengan Catatan'],
					['value' => '3', 'text' => 'Syarat Tidak Lengkap'],
				];
			} else if ($jenis == UJIAN_TESIS_UJIAN) {
				return [
					['value' => '0', 'text' => 'Belum Ujian'],
					['value' => '1', 'text' => 'Lulus'],
					//['value' => '2', 'text' => 'Layak dengan Catatan'],
					['value' => '3', 'text' => 'Tidak Lulus / Mengulang'],
				];
			}
		}

		public function read_kriteria_nilai()
		{
			$this->db->select('k.*');
			$this->db->from('kriteria_penilaian_tesis k');
			$this->db->where('k.status_aktif', 1);

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_penilaian($id_penguji, $id_kriteria_penilaian)
		{
			$this->db->select('p.*');
			$this->db->from('penilaian_tesis p');
			$this->db->where('p.id_penguji', $id_penguji);
			$this->db->where('p.id_kriteria_penilaian', $id_kriteria_penilaian);
			$query = $this->db->get();
			return $query->row();
		}

		public function get_status_ujian($status_ujian, $jenis)
		{
			$result = '';
			$status_ujians = $this->read_status_ujian($jenis);
			foreach ($status_ujians as $s) {
				if ($s['value'] == $status_ujian) {
					$result = $s['text'];
				}
			}
			return $result;
		}

		public function read_status_tahapan($urutan)
		{
			if ($urutan == TAHAPAN_TESIS_JUDUL) {
				return [
					[
						'value' => 0,
						'text' => 'Belum Pengajuan',
						'keterangan' => '',
						'color' => 'bg-gray'
					],
					[
						'value' => STATUS_TESIS_JUDUL_PENGAJUAN,
						'text' => 'Judul - Pengajuan',
						'keterangan' => 'Diajukan oleh Mahasiswa',
						'color' => 'bg-blue'
					],
					[
						'value' => STATUS_TESIS_JUDUL_SETUJUI_SPS,
						'text' => 'Judul - Disetujui Sekretaris Prodi',
						'keterangan' => 'Disetujui oleh Sekretaris Prodi',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_TESIS_JUDUL_SETUJUI_PEMBIMBING,
						'text' => 'Judul - Disetujui Pembimbing',
						'keterangan' => 'Disetujui oleh Dosen Pembimbing',
						'color' => 'bg-navy'
					],
					[
						'value' => STATUS_TESIS_JUDUL_DITOLAK,
						'text' => 'Judul - Ditolak Sekretaris Prodi',
						'keterangan' => 'Ditolak oleh Sekretaris Prodi',
						'color' => 'bg-red'
					],
				];
			} else if ($urutan == TAHAPAN_TESIS_PROPOSAL) {
				return [
					[
						'value' => 0,
						'text' => 'Belum Pengajuan',
						'keterangan' => '',
						'color' => 'bg-gray'
					],
					[
						'value' => STATUS_TESIS_PROPOSAL_PENGAJUAN,
						'text' => 'Proposal - Pengajuan',
						'keterangan' => 'Diajukan oleh Mahasiswa',
						'color' => 'bg-blue'
					],
					[
						'value' => STATUS_TESIS_PROPOSAL_DIJADWALKAN,
						'text' => 'Proposal - Dijadwalkan',
						'keterangan' => 'Dijadwalkan Oleh Pembimbing Utama dan KPS',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_TESIS_PROPOSAL_SETUJUI_PENGUJI,
						'text' => 'Proposal - Disetujui Penguji',
						'keterangan' => 'Disetujui oleh Dosen Penguji',
						'color' => 'bg-navy'
					],
					[
						'value' => STATUS_TESIS_PROPOSAL_UJIAN,
						'text' => 'Proposal - Ujian',
						'keterangan' => 'Sedang menunggu masa jadwal Ujian',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_TESIS_PROPOSAL_UJIAN_SELESAI,
						'text' => 'Proposal - Ujian Selesai',
						'keterangan' => 'Telah menyelesaikan Ujian',
						'color' => 'bg-green'
					],
				];
			} else if ($urutan == TAHAPAN_TESIS_MKPT) {
				return [
					[
						'value' => 0,
						'text' => 'Belum Pengajuan',
						'keterangan' => '',
						'color' => 'bg-gray'
					],
					[
						'value' => STATUS_TESIS_MKPT_PENGAJUAN,
						'text' => 'MKPT - Pengajuan',
						'keterangan' => 'Diajukan oleh Mahasiswa',
						'color' => 'bg-blue'
					],
					[
						'value' => STATUS_TESIS_MKPT_DISETUJUI_DOSEN_MKPT,
						'text' => 'MKPT - Disetujui Dosen MKPT',
						'keterangan' => 'Disetujui oleh Dosen MKPT',
						'color' => 'bg-green'
					],
					/*[
						'value' => STATUS_TESIS_MKPT_DIJADWALKAN,
						'text' => 'MKPT - Dijadwalkan',
						'keterangan' => 'Dijadwalkan',
						'color' => 'bg-navy'
					],
					[
						'value' => STATUS_TESIS_MKPT_SETUJUI_PENGUJI,
						'text' => 'MKPT - Disetujui Penguji',
						'keterangan' => 'Disetujui Dosen Penguji',
						'color' => 'bg-green'
					],*/
					[
						'value' => STATUS_TESIS_MKPT_UJIAN,
						'text' => 'MKPT - Pembimbingan',
						'keterangan' => 'Sedang menunggu penilain dari Dosen MKPT',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_TESIS_MKPT_UJIAN_SELESAI,
						'text' => 'MKPT - Ujian Selesai',
						'keterangan' => 'Telah menyelesaikan Ujian',
						'color' => 'bg-green'
					],
				];
			} else if ($urutan == TAHAPAN_TESIS_UJIAN) {
				return [
					[
						'value' => 0,
						'text' => 'Tesis - Belum Pengajuan',
						'keterangan' => '',
						'color' => 'bg-gray'
					],
					[
						'value' => STATUS_TESIS_UJIAN_PENGAJUAN,
						'text' => 'Tesis - Pengajuan',
						'keterangan' => 'Diajukan oleh Mahasiswa',
						'color' => 'bg-blue'
					],
					[
						'value' => STATUS_TESIS_UJIAN_SETUJUI_BAA,
						'text' => 'Tesis - Disetujui Admin Prodi',
						'keterangan' => 'Disetujui oleh Admin Prodi',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_TESIS_UJIAN_DIJADWALKAN,
						'text' => 'Tesis - Dijadwalkan',
						'keterangan' => 'Dijadwalkan oleh Pembimbing Utama dan KPS',
						'color' => 'bg-navy'
					],
					[
						'value' => STATUS_TESIS_UJIAN_SETUJUI_PENGUJI,
						'text' => 'Tesis - Disetujui Penguji',
						'keterangan' => 'Disetujui Dosen Penguji',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_TESIS_UJIAN,
						'text' => 'Tesis - Ujian',
						'keterangan' => 'Sedang menunggu masa jadwal Ujian',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_TESIS_UJIAN_SELESAI,
						'text' => 'Tesis - Ujian Selesai',
						'keterangan' => 'Telah menyelesaikan Ujian',
						'color' => 'bg-green'
					],
					[
						'value' => STATUS_TESIS_UJIAN_DITOLAK,
						'text' => 'Tesis - Ditolak Admin Prodi',
						'keterangan' => 'Ditolak oleh Admin Prodi',
						'color' => 'bg-red'
					],
				];
			}
		}

		public function get_status_tahapan($status_tahapan, $jenis)
		{
			$result = '';
			$statuses = $this->read_status_tahapan($jenis);
			foreach ($statuses as $status) {
				if ($status['value'] == $status_tahapan) {
					$result = $status;
				}
			}
			return $result;
		}

	}

?>
