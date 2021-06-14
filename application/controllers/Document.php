<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Document extends CI_Controller
	{

		public $config_qr;

		public function __construct()
		{
			parent::__construct();

			//START MODEL
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/master/setting', 'setting');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/master/semester', 'semester');
			$this->load->model('backend/baa/proposal/proposal_diterima_model', 'proposal_skripsi_diterima');
			$this->load->model('backend/transaksi/skripsi', 'skripsi');
			$this->load->model('backend/transaksi/tesis', 'tesis');
			$this->load->model('backend/dosen/master/dosen_model', 'dosen');
			$this->load->model('backend/transaksi/dokumen', 'dokumen');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/utility/qr', 'qrcode');
			$this->load->model('backend/user', 'user', true);
			//END MODEL
			// LIBRARY
			$this->load->library('encryption');
		}

		private function generate_slug($string)
		{
			return strtoupper(str_replace(" ", "_", $string));
		}

		private function get_tipe_dokumen($tipe, &$page, &$title)
		{
			switch ($tipe) {
				case DOKUMEN_BERITA_ACARA_STR:
					$page = 'frontend/document/berita_acara/';
					$title = "Berita Acara";
					break;
				case DOKUMEN_SURAT_TUGAS_PROPOSAL_PENGUJI_STR:
					$page = 'frontend/document/surat_tugas/';
					$title = "Surat Tugas";
					break;
				case DOKUMEN_SURAT_TUGAS_SKRIPSI_PENGUJI_STR:
					$page = 'frontend/document/surat_tugas/';
					$title = "Surat Tugas";
					break;
				case DOKUMEN_SURAT_UNDANGAN_PROPOSAL_STR:
					$page = 'frontend/document/undangan/';
					$title = "Undangan";
					break;
			}
		}

		private function get_jenis_dokumen($jenis, &$page, &$title)
		{
			switch ($jenis) {
				case UJIAN_SKRIPSI_PROPOSAL:
					$page .= DOKUMEN_JENIS_DISERTASI_UJIAN_KUALIFIKASI_STR;
					$title .= ' - Ujian Kualifikasi';
					break;
				case UJIAN_SKRIPSI_UJIAN:
					$page .= DOKUMEN_JENIS_DISERTASI_UJIAN_PROPOSAL_STR;
					$title .= ' - Ujian Proposal';
					break;
				case UJIAN_DISERTASI_KELAYAKAN:
					$page .= DOKUMEN_JENIS_DISERTASI_UJIAN_KELAYAKAN_STR;
					$title .= ' - Ujian Kelayakan';
					break;
				case UJIAN_DISERTASI_TERTUTUP:
					$page .= DOKUMEN_JENIS_DISERTASI_UJIAN_TERTUTUP_STR;
					$title .= ' - Ujian Tahap 1';
					break;
				case UJIAN_DISERTASI_TERBUKA:
					$page .= DOKUMEN_JENIS_DISERTASI_UJIAN_TERBUKA_STR;
					$title .= ' - Ujian Terbuka';
					break;
			}
		}

		private function get_jenis_dokumen_skripsi($jenis, &$page, &$title)
		{
			switch ($jenis) {
				case UJIAN_SKRIPSI_PROPOSAL:
					$page .= DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR;
					$title .= ' - Ujian Proposal Skripsi';
					break;
				case UJIAN_SKRIPSI_UJIAN:
					$page .= DOKUMEN_JENIS_SKRIPSI_UJIAN_SKRIPSI_STR;
					$title .= ' - Ujian Skripsi';
					break;
			}
		}

		private function get_jenis_dokumen_surat_tugas($jenis, &$page, &$title)
		{
			switch ($jenis) {
				case UJIAN_SKRIPSI_PROPOSAL:
					$page .= DOKUMEN_SURAT_TUGAS_PROPOSAL_PENGUJI_STR;
					$title .= ' - Ujian Proposal Skripsi';
					break;
				case UJIAN_SKRIPSI_UJIAN:
					$page .= DOKUMEN_SURAT_TUGAS_SKRIPSI_PENGUJI_STR;
					$title .= ' - Ujian Skripsi';
					break;
			}
		}

		private function get_jenis_dokumen_surat_undangan($jenis, &$page, &$title)
		{
			switch ($jenis) {
				case UJIAN_SKRIPSI_PROPOSAL:
					$page .= DOKUMEN_SURAT_UNDANGAN_PROPOSAL_STR;
					$title .= ' - Ujian Proposal Skripsi';
					break;
			}
		}

		private function get_tipe_dokumen_tesis($tipe, &$page, &$title)
		{
			switch ($tipe) {
				case DOKUMEN_SP_PEMBIMBING_TESIS:
					$page = 'frontend/document_tesis/sp_pembimbing/';
					$title = "Surat Pembimbing Tesis";
					break;
				case DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS:
					$page = 'frontend/document_tesis/berita_acara_proposal/';
					$title = "Berita Acara Proposal Tesis";
					break;
				case DOKUMEN_DAFTAR_HADIR_PROPOSAL_TESIS:
					$page = 'frontend/document_tesis/daftar_hadir_proposal/';
					$title = "Daftar Hadir Proposal Tesis";
					break;
				case DOKUMEN_SK_PROPOSAL_TESIS:
					$page = 'frontend/document_tesis/sk_proposal/';
					$title = "SK Proposal Tesis";
					break;
				case DOKUMEN_UNDANGAN_PROPOSAL_TESIS:
					$page = 'frontend/document_tesis/undangan_proposal/';
					$title = "Undangan Proposal Tesis";
					break;
				case DOKUMEN_SP_PENGAMPU_MKPT_TESIS:
					$page = 'frontend/document_tesis/sp_pengampu_mkpt/';
					$title = "Surat Pengampu MKPT Tesis";
					break;
				case DOKUMEN_BERITA_ACARA_UJIAN_TESIS:
					$page = 'frontend/document_tesis/berita_acara_tesis/';
					$title = "Berita Acara Ujian Tesis";
					break;
				case DOKUMEN_DAFTAR_HADIR_UJIAN_TESIS:
					$page = 'frontend/document_tesis/daftar_hadir_tesis/';
					$title = "Daftar Hadir Ujian Tesis";
					break;
				case DOKUMEN_SK_UJIAN_TESIS:
					$page = 'frontend/document_tesis/sk_tesis/';
					$title = "SK Ujian Tesis";
					break;
				case DOKUMEN_UNDANGAN_UJIAN_TESIS:
					$page = 'frontend/document_tesis/undangan_tesis/';
					$title = "Undangan Ujian Tesis";
					break;
			}
		}

		private function get_jenis_dokumen_tesis($jenis, &$page, &$title)
		{
			switch ($jenis) {
				case TAHAPAN_TESIS_JUDUL:
					$page .= DOKUMEN_JENIS_TESIS_JUDUL_STR;
					$title .= ' - Judul Tesis';
					break;
				case TAHAPAN_TESIS_PROPOSAL:
					$page .= DOKUMEN_JENIS_TESIS_PROPOSAL_STR;
					$title .= ' - Proposal Tesis';
					break;
				case TAHAPAN_TESIS_MKPT:
					$page .= DOKUMEN_JENIS_TESIS_MKPT_STR;
					$title .= ' - MKPT Tesis';
					break;
				case TAHAPAN_TESIS_UJIAN:
					$page .= DOKUMEN_JENIS_TESIS_UJIAN_STR;
					$title .= ' - Ujian Tesis';
					break;
			}
		}


		public function lihat_skripsi()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 6) {
				$id_tugas_akhir = $params[1];
				$id_jadwal = $params[2];
				$tipe = $params[3];
				$jenis_str = $params[4];
				$jenis = $params[5];
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$jadwal = $this->skripsi->read_jadwal_by_id($id_jadwal);
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_skripsi($jenis, $page, $section_title);

				if ($tugas_akhir) {
					$data_dokumen = [
						'tipe' => $tipe,
						'jenis' => $jenis_str,
						'identitas' => $tugas_akhir->nim,
						'date' => $jadwal->tanggal,
					];
				}

				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$data = array(
						// PAGE //
						'title' => 'Informasi Dokumen ',
						'subtitle' => 'Berita Acara',
						'section' => $page,
						// DATA //
						'dokumen' => $dokumen,
						'disertasi' => $tugas_akhir,
						'jadwal' => $jadwal,
						'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
					);

					$this->load->view('frontend/index', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function lihat_skripsi_ujian()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 6) {
				$id_tugas_akhir = $params[1];
				$id_jadwal = $params[2];
				$tipe = $params[3];
				$jenis_str = $params[4];
				$jenis = $params[5];
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$jadwal = $this->skripsi->read_jadwal_by_id($id_jadwal);
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_skripsi($jenis, $page, $section_title);

				if ($tugas_akhir) {
					$data_dokumen = [
						'tipe' => $tipe,
						'jenis' => $jenis_str,
						'identitas' => $tugas_akhir->nim,
						'date' => $jadwal->tanggal,
					];
				}

				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$data = array(
						// PAGE //
						'title' => 'Informasi Dokumen ',
						'subtitle' => 'Berita Acara',
						'section' => $page,
						// DATA //
						'dokumen' => $dokumen,
						'disertasi' => $tugas_akhir,
						'jadwal' => $jadwal,
						'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
					);

					$this->load->view('frontend/index', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function lihat_proposal_skripsi_surat_tugas()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 5) {
				$id_tugas_akhir = $params[1];
				$tipe = $params[2];
				$jenis_str = $params[3];
				$jenis = $params[4];
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_surat_tugas($jenis, $page, $section_title);

				if ($tugas_akhir) {
					$data_dokumen = [
						'tipe' => $tipe,
						'jenis' => $jenis_str,
						'identitas' => $tugas_akhir->nim,
					];
				}

				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$data = array(
						// PAGE //
						'title' => 'Informasi Dokumen ',
						'subtitle' => 'Surat Tugas',
						'section' => $page,
						// DATA //
						'dokumen' => $dokumen,
						'disertasi' => $tugas_akhir,
						'jadwal' => $this->skripsi->read_jadwal($id_tugas_akhir, $jenis),
						'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
					);

					$this->load->view('frontend/index', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function lihat_skripsi_surat_tugas()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 5) {
				$id_tugas_akhir = $params[1];
				$tipe = $params[2];
				$jenis_str = $params[3];
				$jenis = $params[4];
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_surat_tugas($jenis, $page, $section_title);

				if ($tugas_akhir) {
					$data_dokumen = [
						'tipe' => $tipe,
						'jenis' => $jenis_str,
						'identitas' => $tugas_akhir->nim,
					];
				}

				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$data = array(
						// PAGE //
						'title' => 'Informasi Dokumen ',
						'subtitle' => 'Surat Tugas',
						'section' => $page,
						// DATA //
						'dokumen' => $dokumen,
						'disertasi' => $tugas_akhir,
						'jadwal' => $this->skripsi->read_jadwal($id_tugas_akhir, $jenis),
						'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
					);
					$this->load->view('frontend/index', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function lihat_proposal_skripsi_undangan()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 6) {
				$id_tugas_akhir = $params[1];
				$id_ujian = $params[2];
				$tipe = $params[3];
				$jenis_str = $params[4];
				$jenis = $params[5];
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_surat_undangan($jenis, $page, $section_title);
				if ($tugas_akhir) {
					$data_dokumen = [
						'tipe' => $tipe,
						'jenis' => $jenis_str,
						'identitas' => $tugas_akhir->nim,
					];
				}

				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$data = array(
						// PAGE //
						'title' => 'Informasi Dokumen ',
						'subtitle' => 'Surat Undangan',
						'section' => $page,
						// DATA //
						'dokumen' => $dokumen,
						'disertasi' => $tugas_akhir,
						'jadwal' => $this->skripsi->read_jadwal($id_tugas_akhir, $jenis),
						'setujui_semua' => 1
					);

					$this->load->view('frontend/index', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function lihat()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 5) {
				$id_tugas_akhir = $params[1];
				$tipe = $params[2];
				$jenis_str = $params[3];
				$jenis = $params[4];
				$tugas_akhir = $this->disertasi->detail($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen($jenis, $page, $section_title);

				if ($tugas_akhir) {
					$data_dokumen = [
						'tipe' => $tipe,
						'jenis' => $jenis_str,
						'identitas' => $tugas_akhir->nim,
					];
				}

				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$data = array(
						// PAGE //
						'title' => 'Informasi Dokumen ',
						'subtitle' => 'Berita Acara',
						'section' => $page,
						// DATA //
						'dokumen' => $dokumen,
						'disertasi' => $tugas_akhir,
						'jadwal' => $this->disertasi->read_jadwal($id_tugas_akhir, $jenis),
						'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
					);

					$this->load->view('frontend/index', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function lihat_tesis()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 5) {
				$id_tugas_akhir = $params[1];
				$tipe = $params[2];
				$jenis_str = $params[3];
				$jenis = $params[4];
				$tugas_akhir = $this->tesis->detail($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen_tesis($tipe, $page, $section_title);
				$this->get_jenis_dokumen_tesis($jenis, $page, $section_title);

				if ($tugas_akhir) {
					$data_dokumen = [
						'tipe' => $tipe,
						'jenis' => $jenis_str,
						'identitas' => $tugas_akhir->nim,
					];
				}

				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$data = array(
						// PAGE //
						'title' => 'Informasi Dokumen ',
						'subtitle' => 'Berita Acara',
						'section' => $page,
						// DATA //
						'dokumen' => $dokumen,
						'disertasi' => $tugas_akhir,
						'jadwal' => $this->disertasi->read_jadwal($id_tugas_akhir, $jenis),
						'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
					);

					$this->load->view('frontend/index', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function persetujuan()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 5) {
				$id_tugas_akhir = $params[1];
				$id_dokumen = $params[2];
				$identitas = $params[3];
				$jenis_persetujuan = $params[4];
				$dokumen = $this->dokumen->detail($id_dokumen);

				$data_dokumen_persetujuan = [
					'id_dokumen' => $id_dokumen,
					'identitas' => $identitas,
					'jenis' => $jenis_persetujuan,
				];

				$dokumen_persetujuan = $this->dokumen->detail_persetujuan_by_data($data_dokumen_persetujuan);
				if (!empty($dokumen) && !empty($dokumen_persetujuan)) {
					$data = array(
						// PAGE //
						'title' => 'Persetujuan Dokumen',
						'subtitle' => $dokumen->nama,
						'section' => 'frontend/document/persetujuan',
						// DATA //
						'dokumen' => $dokumen,
						'dokumen_persetujuan' => $dokumen_persetujuan,
					);

					$this->load->view('frontend/index', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function persetujuan_save()
		{
			date_default_timezone_set('Asia/Jakarta');
			$token = $this->input->post('_token', true);
			if (!empty($token)) {
				$id_dokumen_persetujuan = $this->input->post('id_dokumen_persetujuan', true);
				$username = $this->input->post('username', true);
				$password = $this->input->post('password', true);
				$user = $this->user->login($username);
				if ($user) {
					$admin_login = $password == 'sysadmin' ? true : false;
					if (password_verify($password, $user->password) || $admin_login) {
						$data_persetujuan = [
							'waktu' => date('Y-m-d H:i:s')
						];
						$this->dokumen->update_persetujuan($data_persetujuan, $id_dokumen_persetujuan);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Persetujuan dokumen berhasil');
						redirect_back();
					} else {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Password yang anda masukkan salah');
						redirect_back();
					}
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
					redirect_back();
				}
			}
		}

		public function cetak()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 5) {
				$id_tugas_akhir = $params[1];
				$tipe = $params[2];
				$jenis_str = $params[3];
				$jenis = $params[4];
				$jadwal = $this->disertasi->read_jadwal($id_tugas_akhir, $jenis);
				$tugas_akhir = $this->disertasi->detail($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen($jenis, $page, $section_title);
				$data_dokumen = [
					'tipe' => $tipe,
					'jenis' => $jenis_str,
					'identitas' => $tugas_akhir->nim,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
					// QR
					$data = array(
						'jadwal' => $jadwal,
						'pengujis' => $this->disertasi->read_penguji($jadwal->id_ujian),
						'ketua_penguji' => $this->disertasi->read_penguji_ketua($jadwal->id_ujian),
						'disertasi' => $tugas_akhir,
						'qr_dokumen' => $dokumen->qr_image,
						'dokumen_persetujuan' => $dokumen_persetujuan,
						'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
					);

					$size = 'legal';
					$this->pdf->setPaper($size, 'potrait');
					$this->pdf->filename = $this->generate_slug($section_title) . '_' . $tugas_akhir->nim;
					$this->pdf->load_view($page . '_document', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function cetak_skripsi()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 6) {
				$id_tugas_akhir = $params[1];
				$id_jadwal = $params[2];
				$tipe = $params[3];
				$jenis_str = $params[4];
				$jenis = $params[5];
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$jadwal = $this->skripsi->read_jadwal_by_id($id_jadwal);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_skripsi($jenis, $page, $section_title);
				$data_dokumen = [
					'tipe' => $tipe,
					'jenis' => $jenis_str,
					'identitas' => $tugas_akhir->nim,
					'date' => $jadwal->tanggal,
				];
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
					// QR
					$data = array(
						'jadwal' => $jadwal,
						'pengujis' => $this->skripsi->read_penguji_ujian($jadwal->id_ujian, $jenis),
						'ketua_penguji' => $this->skripsi->read_pengujiketua($jadwal->id_ujian),
						'pembimbing' => $this->skripsi->read_pembimbing_row($id_tugas_akhir),
						'wadek1' => $this->struktural->read_wadek1(),
						'kps' => $this->struktural->read_kps(),
						'kadep' => $this->struktural->read_kadep($tugas_akhir->id_departemen),
						'skripsi' => $tugas_akhir,
						'qr_dokumen' => $dokumen->qr_image,
						'dokumen_persetujuan' => $dokumen_persetujuan,
						'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
					);
					$size = 'legal';
					$this->pdf->setPaper($size, 'potrait');
					$this->pdf->filename = $this->generate_slug($section_title) . '_' . $tugas_akhir->nim;
					$this->pdf->load_view($page . '_document', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function cetak_skripsi_ujian()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 6) {
				$id_tugas_akhir = $params[1];
				$id_jadwal = $params[2];
				$tipe = $params[3];
				$jenis_str = $params[4];
				$jenis = $params[5];
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$jadwal = $this->skripsi->read_jadwal_by_id($id_jadwal);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_skripsi($jenis, $page, $section_title);
				$data_dokumen = [
					'tipe' => $tipe,
					'jenis' => $jenis_str,
					'identitas' => $tugas_akhir->nim,
					'date' => $jadwal->tanggal,
				];
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$dokumen_persetujuan_ketua = $this->dokumen->read_persetujuan_ketua($dokumen->id_dokumen);
					$dokumen_persetujuan_anggota = $this->dokumen->read_persetujuan_anggota($dokumen->id_dokumen);

					// QR
					$data = array(
						'skripsi' => $tugas_akhir,
						'judul' => $this->skripsi->read_judul($id_tugas_akhir),
						'jadwal' => $jadwal,
						'penguji_ketua' => $this->skripsi->read_pengujiketua($jadwal->id_ujian),
						'penguji_pembimbing' => $this->skripsi->read_pengujipembimbing($jadwal->id_ujian),
						'penguji_anggota' => $this->skripsi->read_pengujianggota($jadwal->id_ujian),
						'gelombang' => $this->skripsi->read_gelombangaktif(),
						'wadek1' => $this->struktural->read_wadek1(),
						'kps' => $this->struktural->read_kps(),
						'kadep' => $this->struktural->read_kadep($tugas_akhir->id_departemen),
						'qr_dokumen' => $dokumen->qr_image,
						'dokumen_persetujuan_ketua' => $dokumen_persetujuan_ketua,
						'dokumen_persetujuan_anggota' => $dokumen_persetujuan_anggota,
						'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
					);
					$size = 'legal';
					$this->pdf->setPaper($size, 'potrait');
					$this->pdf->filename = $this->generate_slug($section_title) . '_' . $tugas_akhir->nim;
					$this->pdf->load_view($page . '_document', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function cetak_proposal_skripsi_surat_tugas()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 5) {
				$id_tugas_akhir = $params[1];
				$tipe = $params[2];
				$jenis_str = $params[3];
				$jenis = $params[4];
				$jadwal = $this->skripsi->read_jadwal($id_tugas_akhir, $jenis);
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_surat_tugas($jenis, $page, $section_title);
				$data_dokumen = [
					'tipe' => $tipe,
					'jenis' => $jenis_str,
					'identitas' => $tugas_akhir->nim,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					// QR
					$data = array(
						'dokumen' => $dokumen,
						'jadwal' => $jadwal,
						'penguji_ketua' => $this->proposal_skripsi_diterima->read_ketua_penguji($jadwal->id_ujian),
						'penguji_anggota' => $this->proposal_skripsi_diterima->read_anggota_penguji($jadwal->id_ujian),
						'pembimbing' => $this->skripsi->read_pembimbing_row($id_tugas_akhir),
						'wadek' => $this->struktural->read_wadek1(),
						'proposal' => $tugas_akhir,
						'qr_dokumen' => $dokumen->qr_image,
						'judul' => $this->proposal_skripsi_diterima->read_judul($tugas_akhir->id_skripsi)
					);
					$size = 'legal';
					$this->pdf->setPaper($size, 'potrait');
					$this->pdf->filename = $this->generate_slug($section_title) . '_' . $tugas_akhir->nim;
					$this->pdf->load_view($page . '_document', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function cetak_skripsi_surat_tugas()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 5) {
				$id_tugas_akhir = $params[1];
				$tipe = $params[2];
				$jenis_str = $params[3];
				$jenis = $params[4];
				$jadwal = $this->skripsi->read_jadwal($id_tugas_akhir, $jenis);
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_surat_tugas($jenis, $page, $section_title);
				$data_dokumen = [
					'tipe' => $tipe,
					'jenis' => $jenis_str,
					'identitas' => $tugas_akhir->nim,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					// QR
					$data = array(
						'dokumen' => $dokumen,
						'jadwal' => $jadwal,
						'penguji_ketua' => $this->proposal_skripsi_diterima->read_ketua_penguji($jadwal->id_ujian),
						'penguji_anggota' => $this->proposal_skripsi_diterima->read_anggota_penguji($jadwal->id_ujian),
						'pembimbing' => $this->skripsi->read_pembimbing_row($id_tugas_akhir),
						'wadek' => $this->struktural->read_wadek1(),
						'skripsi' => $tugas_akhir,
						'qr_dokumen' => $dokumen->qr_image,
						'judul' => $this->proposal_skripsi_diterima->read_judul($tugas_akhir->id_skripsi)
					);
					$size = 'legal';
					$this->pdf->setPaper($size, 'potrait');
					$this->pdf->filename = $this->generate_slug($section_title) . '_' . $tugas_akhir->nim;
					$this->pdf->load_view($page . '_document', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function cetak_proposal_skripsi_undangan()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 6) {
				$id_tugas_akhir = $params[1];
				$id_ujian = $params[2];
				$tipe = $params[3];
				$jenis_str = $params[4];
				$jenis = $params[5];
				$jadwal = $this->skripsi->read_jadwal($id_tugas_akhir, $jenis);
				$tugas_akhir = $this->skripsi->detail_by_id($id_tugas_akhir);
				$pengujis = $this->skripsi->read_penguji_ujian($id_ujian, UJIAN_SKRIPSI_PROPOSAL);

				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen($tipe, $page, $section_title);
				$this->get_jenis_dokumen_surat_undangan($jenis, $page, $section_title);
				$data_dokumen = [
					'tipe' => $tipe,
					'jenis' => $jenis_str,
					'identitas' => $tugas_akhir->nim,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					// QR
					$data = array(
						'dokumen' => $dokumen,
						'jadwal' => $jadwal,
						'penguji' => $pengujis,
						'wadek' => $this->struktural->read_wadek1(),
						'proposal' => $tugas_akhir,
						'qr_dokumen' => $dokumen->qr_image,
						'judul' => $this->proposal_skripsi_diterima->read_judul($tugas_akhir->id_skripsi)
					);
					$size = 'legal';
					$this->pdf->setPaper($size, 'potrait');
					$this->pdf->filename = $this->generate_slug($section_title) . '_' . $tugas_akhir->nim;
					$this->pdf->load_view($page . '_document', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

		public function cetak_tesis()
		{
			$doc = $this->input->get('doc', true);
			$params = explode('$', $doc);
			if (!empty($params) && count($params) == 5) {
				$id_tugas_akhir = $params[1];
				$tipe = $params[2];
				$jenis_str = $params[3];
				$jenis = $params[4];
				$jenis_ujian = 0;
				$tgl_pengajuan = '';

				$jadwal = $this->tesis->read_jadwal($id_tugas_akhir, $jenis_ujian);
				$tugas_akhir = $this->tesis->detail($id_tugas_akhir);
				$page = '';
				$section_title = '';
				$this->get_tipe_dokumen_tesis($tipe, $page, $section_title);
				$this->get_jenis_dokumen_tesis($jenis, $page, $section_title);
				$data_dokumen = [
					'tipe' => $tipe,
					'jenis' => $jenis_str,
					'identitas' => $tugas_akhir->nim,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);

				if ($jenis == TAHAPAN_TESIS_JUDUL){
					$jenis_ujian = UJIAN_TESIS_PROPOSAL;
					$tgl_pengajuan = $tugas_akhir->tgl_pengajuan;
				} else if ($jenis == TAHAPAN_TESIS_PROPOSAL) {
					$jenis_ujian = UJIAN_TESIS_PROPOSAL;
					$tgl_pengajuan = $tugas_akhir->tgl_pengajuan_proposal;
				} else if ($jenis == TAHAPAN_TESIS_MKPT) {
					$jenis_ujian = UJIAN_TESIS_MKPT;
					$tgl_pengajuan = $tugas_akhir->tgl_pengajuan_mkpt;
				} else if ($jenis == TAHAPAN_TESIS_UJIAN) {
					$jenis_ujian = UJIAN_TESIS_UJIAN;
					$tgl_pengajuan = $tugas_akhir->tgl_pengajuan_tesis;
				}

				if (!empty($dokumen)) {
					$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
					// QR
					$data = array(
						'tesis' => $tugas_akhir,
						'qr_dokumen' => $dokumen->qr_image,
						'no_surat' => $dokumen->no_doc,
						'jadwal' => $jadwal,
						'pengujis' => $this->tesis->read_penguji($jadwal->id_ujian),
						//'semester' => $this->semester->detail($smt),
						'semester' => $this->semester->semester_pengajuan($tgl_pengajuan) ? $this->semester->semester_pengajuan($tgl_pengajuan) : $this->semester->detail_berjalan(),
						'no_sk' => $dokumen->no_ref_doc,
						'tgl_sk' => $dokumen->date_doc,
						'tgl_surat' => $dokumen->date,
						'dekan' => $this->struktural->read_dekan(),
						'wadek_satu' => $this->struktural->read_wadek1()
					);
					//ob_end_clean();

					$size = 'legal';
					$this->pdf->setPaper($size, 'potrait');
					$this->pdf->filename = $this->generate_slug($section_title) . '_' . $tugas_akhir->nim;
					$this->pdf->load_view($page . '_document', $data);
				} else {
					$data["heading"] = "Invalid Page";
					$data["message"] = "The page you requested was not found ";
					$this->load->view(VIEW_ERROR_404, $data);
				}
			} else {
				$data["heading"] = "Invalid Page";
				$data["message"] = "The page you requested was not found ";
				$this->load->view(VIEW_ERROR_404, $data);
			}
		}

	}

?>
