<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Dokumen extends CI_Model
	{

		public function __construct()
		{
			parent::__construct();

			//START MODEL
			$this->load->model('backend/utility/qr', 'qrcode');
			//END MODEL
			// LIBRARY
			$this->load->library('encryption');
		}

		private function generate_slug($string)
		{
			return strtoupper(str_replace(" ", "-", $string));
		}

		// DOKUMEN

		public function generate_kode($tipe, $jenis, $identitas, $tgl)
		{
			$kode = '';
			$this->db->from('dokumen d');
			$this->db->where('d.status', 1);
			$count_dokumen = $this->db->count_all_results();
			$kode .= str_pad($count_dokumen + 1, 6, '0', STR_PAD_LEFT);
			$kode .= CODE_DELIMITER . $this->generate_slug($tipe);
			$kode .= CODE_DELIMITER . $this->generate_slug($jenis);
			$kode .= CODE_DELIMITER . $this->generate_slug($identitas);
			$kode .= CODE_DELIMITER . date('m/y', strtotime($tgl));
			$kode .= CODE_DELIMITER . rand(100, 999);
			return $kode;
		}

		public function detail($id)
		{
			$this->db->select('d.*,m.nama nama_mhs');
			$this->db->from('dokumen d');
			$this->db->join('mahasiswa m', 'm.nim= d.identitas');
			$this->db->where('d.id_dokumen', $id);
			$this->db->where('d.status', 1);

			$query = $this->db->get();
			return $query->row();
		}

		public function detail_by_data($data)
		{
			$this->db->select('*');
			$this->db->from('dokumen');
			$this->db->where('identitas', $data['identitas']);
			$this->db->where('tipe', $data['tipe']);
			$this->db->where('jenis', $data['jenis']);
			$this->db->order_by('id_dokumen', 'desc');
			$this->db->where('status', 1);

			$query = $this->db->get();
			return $query->row();
		}

		public function check_by_data($data)
		{
			$this->db->select('*');
			$this->db->from('dokumen');
			$this->db->where('identitas', $data['identitas']);
			$this->db->where('tipe', $data['tipe']);
			$this->db->where('jenis', $data['jenis']);
			$this->db->where('date', $data['date']);
			$this->db->where('status', 1);

			$query = $this->db->get();
			return $query->row();
		}

		public function save($data)
		{
			$this->db->insert('dokumen', $data);
		}

		public function update($data, $id)
		{
			$this->db->where('id_dokumen', $id);
			$this->db->update('dokumen', $data);
		}

		public function delete($id)
		{
			$this->db->where('id_dokumen', $id);
			$this->db->delete('dokumen');

			$this->db->where('id_dokumen', $id);
			$this->db->delete('dokumen_persetujuan');

			$this->db->where('id_dokumen', $id);
			$this->db->delete('dokumen_tujuan');
		}

		// DOKUMEN PERSETUJUAN

		public function generate_persetujuan($datas, $id_dokumen, $id_jenjang, $id_tugas_akhir, $jenis_persetujuan)
		{
			if ($id_jenjang == JENJANG_S3) {
				foreach ($datas as $data):
					$link_dokumen = base_url() . 'document/persetujuan?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tugas_akhir . '$' . $id_dokumen . '$' . $data['nip'] . '$' . $jenis_persetujuan;
					// QR
					$qr_image = $this->qrcode->generateQrImageName('Persetujuan Dokumen Berita Acara', 'Kualifikasi', $data['nip'], date('Y-m-d'));
					$qr_content = 'Persetujuan dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
					$this->qrcode->generateQr($qr_image, $qr_content);
					$data_dokumen_persetujuan = [
						'id_dokumen' => $id_dokumen,
						'identitas' => $data['nip'],
						'nama' => $data['nama'],
						'link' => $link_dokumen,
						'jenis' => $jenis_persetujuan,
						'qr_image' => PATH_FILE_QR . $qr_image,
					];
					$dokumen_persetujuan = $this->detail_persetujuan_by_data($data_dokumen_persetujuan);
					if (empty($dokumen_persetujuan)) {
						$this->save_persetujuan($data_dokumen_persetujuan);
					}
				endforeach;
			}
			if ($id_jenjang == JENJANG_S2) {
				foreach ($datas as $data):
					$link_dokumen = base_url() . 'document/persetujuan?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tugas_akhir . '$' . $id_dokumen . '$' . $data['nip'] . '$' . $jenis_persetujuan;
					// QR
					$qr_image = $this->qrcode->generateQrImageName('Persetujuan Dokumen Berita Acara', 'Tesis', $data['nip'], date('Y-m-d'));
					$qr_content = 'Persetujuan dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
					$this->qrcode->generateQr($qr_image, $qr_content);
					$data_dokumen_persetujuan = [
						'id_dokumen' => $id_dokumen,
						'identitas' => $data['nip'],
						'nama' => $data['nama'],
						'link' => $link_dokumen,
						'jenis' => $jenis_persetujuan,
						'qr_image' => PATH_FILE_QR . $qr_image,
					];
					$dokumen_persetujuan = $this->detail_persetujuan_by_data($data_dokumen_persetujuan);
					if (empty($dokumen_persetujuan)) {
						$this->save_persetujuan($data_dokumen_persetujuan);
					}
				endforeach;
			}
		}

		public function generate_persetujuan_berita_acara($datas, $id_dokumen, $id_jenjang, $id_tugas_akhir)
		{
			$dokumen = $this->detail($id_dokumen);
			if ($id_jenjang == JENJANG_S3) {
				foreach ($datas as $data):
					$link_dokumen = base_url() . 'document/persetujuan?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tugas_akhir . '$' . $id_dokumen . '$' . $data['nip'];
					// QR
					$qr_image = $this->qrcode->generateQrImageName('Persetujuan Dokumen Berita Acara', $dokumen->jenis, $data['nip'], date('Y-m-d'));
					$qr_content = 'Persetujuan dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
					$this->qrcode->generateQr($qr_image, $qr_content);
					$data_dokumen_persetujuan = [
						'id_dokumen' => $id_dokumen,
						'identitas' => $data['nip'],
						'nama' => $data['nama'],
						'link' => $link_dokumen,
						'jenis' => $data['status_tim'] == '1' ? '1' : '0',
						'qr_image' => PATH_FILE_QR . $qr_image,
					];
					$dokumen_persetujuan = $this->detail_persetujuan_by_data($data_dokumen_persetujuan);
					if (empty($dokumen_persetujuan)) {
						$this->save_persetujuan($data_dokumen_persetujuan);
					}
				endforeach;
			} else if ($id_jenjang == JENJANG_S1) {
				foreach ($datas as $data):
					$link_dokumen = base_url() . 'document/persetujuan?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tugas_akhir . '$' . $id_dokumen . '$' . $data['nip'];
					// QR
					$qr_image = $this->qrcode->generateQrImageName('Persetujuan Dokumen Berita Acara', $dokumen->jenis, $data['nip'], date('Y-m-d'));
					$qr_content = 'Persetujuan dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
					$this->qrcode->generateQr($qr_image, $qr_content);
					$data_dokumen_persetujuan = [
						'id_dokumen' => $id_dokumen,
						'identitas' => $data['nip'],
						'nama' => $data['nama'],
						'link' => $link_dokumen,
						'jenis' => $data['status_tim'] == '1' ? '1' : '0',
						'qr_image' => PATH_FILE_QR . $qr_image,
					];
					$dokumen_persetujuan = $this->detail_persetujuan_by_data($data_dokumen_persetujuan);
					if (empty($dokumen_persetujuan)) {
						$this->save_persetujuan($data_dokumen_persetujuan);
					}
				endforeach;
			}
		}

		public function generate_persetujuan_surat_tugas_skripsi($datas, $id_dokumen, $id_jenjang, $id_tugas_akhir)
		{
			$dokumen = $this->detail($id_dokumen);
			if ($id_jenjang == JENJANG_S1) {
				foreach ($datas as $data):
					$link_dokumen = base_url() . 'document/persetujuan?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tugas_akhir . '$' . $id_dokumen . '$' . $data['nip'];
					// QR
					$qr_image = $this->qrcode->generateQrImageName('Persetujuan Dokumen Surat Tugas Penguji Proposal Skripsi', $dokumen->jenis, $data['nip'], date('Y-m-d'));
					$qr_content = 'Persetujuan dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
					$this->qrcode->generateQr($qr_image, $qr_content);
					$data_dokumen_persetujuan = [
						'id_dokumen' => $id_dokumen,
						'identitas' => $data['nip'],
						'nama' => $data['nama'],
						'link' => $link_dokumen,
						'jenis' => $data['status_tim'] == '1' ? '1' : '0',
						'qr_image' => PATH_FILE_QR . $qr_image,
						'waktu' => date('Y-m-d H:i:s')
					];
					$dokumen_persetujuan = $this->detail_persetujuan_by_data($data_dokumen_persetujuan);
					if (empty($dokumen_persetujuan)) {
						$this->save_persetujuan($data_dokumen_persetujuan);
					}
				endforeach;
			}
		}

		public function generate_tujuan_dokumen($datas, $id_dokumen, $jenis, $tujuan)
		{
			foreach ($datas as $data):
				$data_dokumen_tujuan = [
					'id_dokumen' => $id_dokumen,
					'identitas' => $data['identitas'],
					'nama' => $data['nama'],
					'jenis' => $jenis,
					'tujuan' => $tujuan,
					'waktu' => date('Y-m-d H:i:s')
				];
				$dokumen_tujuan = $this->detail_tujuan_by_data($data_dokumen_tujuan);
				if (!empty($dokumen_tujuan)) {
					$this->delete_tujuan($dokumen_tujuan->id_dokumen_tujuan);
				}
				$this->save_tujuan($data_dokumen_tujuan);
			endforeach;
		}

		public function read_persetujuan($id_dokumen)
		{
			$this->db->select('*');
			$this->db->from('dokumen_persetujuan');
			$this->db->where('id_dokumen', $id_dokumen);
			$this->db->order_by('jenis', 'desc');
			$this->db->order_by('id_dokumen_persetujuan', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_persetujuan_ketua($id_dokumen)
		{
			$this->db->select('*');
			$this->db->from('dokumen_persetujuan');
			$this->db->where('id_dokumen', $id_dokumen);
			$this->db->where('jenis', 1);
			$this->db->order_by('id_dokumen_persetujuan', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_persetujuan_anggota($id_dokumen)
		{
			$this->db->select('*');
			$this->db->from('dokumen_persetujuan');
			$this->db->where('id_dokumen', $id_dokumen);
			$this->db->where('jenis', 0);
			$this->db->order_by('id_dokumen_persetujuan', 'asc');

			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_persetujuan_dosen($username, $tipe)
		{
			$this->db->select('d.*,m.nama nama_mhs');
			$this->db->from('dokumen d');
			$this->db->join('mahasiswa m', 'm.nim= d.identitas');
			$this->db->where('d.tipe', $tipe);
			$this->db->where('`d`.`id_dokumen` IN (SELECT `id_dokumen` from `dokumen_persetujuan` where `waktu` is null and `identitas`=\'' . $username . '\')', null, false);
			$this->db->order_by('date', 'desc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function read_persetujuan_dosen_riwayat($username, $tipe)
		{
			$this->db->select('d.*,m.nama nama_mhs');
			$this->db->from('dokumen d');
			$this->db->join('mahasiswa m', 'm.nim= d.identitas');
			$this->db->where('d.tipe', $tipe);
			$this->db->where('`d`.`id_dokumen` IN (SELECT `id_dokumen` from `dokumen_persetujuan` where `waktu` is not null and `identitas`=\'' . $username . '\')', null, false);
			$this->db->order_by('date', 'desc');
			$query = $this->db->get();
			return $query->result_array();
		}

		public function cek_dokumen_setujui_semua($id_dokumen)
		{
			$this->db->select('*');
			$this->db->from('dokumen_persetujuan');
			$this->db->where('id_dokumen', $id_dokumen);
			$this->db->where('waktu is NULL', null, false);

			$count = $this->db->count_all_results();
			if ($count > 0) {
				return false;
			} else {
				return true;
			}
		}

		public function detail_persetujuan_by_data($data)
		{
			$this->db->select('*');
			$this->db->from('dokumen_persetujuan');
			$this->db->where('identitas', $data['identitas']);
			$this->db->where('id_dokumen', $data['id_dokumen']);

			$query = $this->db->get();
			return $query->row();
		}

		public function detail_persetujuan($id)
		{
			$this->db->select('*');
			$this->db->from('dokumen_persetujuan');
			$this->db->where('id_dokumen_persetujuan', $id);

			$query = $this->db->get();
			return $query->row();
		}

		public function save_persetujuan($data)
		{
			$this->db->insert('dokumen_persetujuan', $data);
		}

		public function update_persetujuan($data, $id)
		{
			$this->db->where('id_dokumen_persetujuan', $id);
			$this->db->update('dokumen_persetujuan', $data);
		}

		// Dokumen Tujuan

		public function detail_tujuan($id)
		{
			$this->db->select('*');
			$this->db->from('dokumen_persetujuan');
			$this->db->where('id_dokumen_persetujuan', $id);
			$query = $this->db->get();
			return $query->row();
		}

		public function detail_tujuan_by_data($data)
		{
			$this->db->select('*');
			$this->db->from('dokumen_tujuan');
			$this->db->where('identitas', $data['identitas']);
			$this->db->where('id_dokumen', $data['id_dokumen']);
			$this->db->where('jenis', $data['jenis']);
			$this->db->where('tujuan', $data['tujuan']);

			$query = $this->db->get();
			return $query->row();
		}

		public function save_tujuan($data)
		{
			$this->db->insert('dokumen_tujuan', $data);
		}

		public function update_tujuan($data, $id)
		{
			$this->db->where('id_dokumen_tujuan', $id);
			$this->db->update('dokumen_tujuan', $data);
		}

		public function delete_tujuan($id)
		{
			$this->db->where('id_dokumen_tujuan', $id);
			$this->db->delete('dokumen_tujuan');
		}

	}

?>
