<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Penguji_skripsi extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 1) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS

			//START MODEL
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/transaksi/Skripsi', 'skripsi');
			$this->load->model('backend/transaksi/Revisi_skripsi', 'revisi_skripsi');
			$this->load->model('backend/user', 'user');
			//END MODEL
		}

		public function index_proposal()
		{
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Skripsi - Proposal',
				'subtitle' => 'Permintaan Penguji',
				'section' => 'backend/dosen/skripsi/proposal/penguji_pengajuan',
				// DATA //
				'penguji' => $this->skripsi->read_penguji_pengajuan_proposal($username)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function riwayat_proposal()
		{
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Skripsi - Proposal',
				'subtitle' => 'Proses Pengujian',
				'section' => 'backend/dosen/skripsi/proposal/penguji_riwayat',
				// DATA //
				'penguji' => $this->skripsi->read_penguji_proposal($username)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function revisi_proposal($id_skripsi, $id_ujian)
		{
			$username = $this->session_data['username'];
			$skripsi = $this->skripsi->detail_by_id($id_skripsi);
			$ujian = $this->skripsi->read_jadwal_by_id($id_ujian);
			$pegawai = $this->user->detail_pegawai_by_username($username);
			$riwayat_revisis = $this->revisi_skripsi->readRiwayatRevisiDosen($ujian->id_ujian, $pegawai->id_pegawai);
			$detail_penguji = $this->revisi_skripsi->detailPengujiRevisiByUjianNip($ujian->id_ujian,$this->session_data['username']);

			$data = array(
				// PAGE //
				'title' => 'Skripsi - Proposal',
				'subtitle' => 'Revisi',
				'section' => 'backend/dosen/skripsi/proposal/revisi_proposal',
				'use_back' => true,
				'back_link' => 'dosen/sarjana/proposal/penguji_riwayat',
				// DATA //
				'proposal' => $skripsi,
				'ujian' => $ujian,
				'riwayat_revisis' => $riwayat_revisis,
				'detail_penguji'=>$detail_penguji,
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function index_skripsi()
		{
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Skripsi Ujian',
				'subtitle' => 'Permintaan Penguji',
				'section' => 'backend/dosen/skripsi/ujian/pengajuan_penguji',
				// DATA //
				'penguji' => $this->skripsi->read_penguji_pengajuan_skripsi($username)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function riwayat_skripsi()
		{
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Skripsi Ujian',
				'subtitle' => 'Proses Pengujian',
				'section' => 'backend/dosen/skripsi/ujian/riwayat_penguji',
				// DATA //
				'penguji' => $this->skripsi->read_penguji_skripsi($username)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function update_penguji()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_penguji = $this->input->post('id_penguji', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$id_skripsi = $this->input->post('id_skripsi', true);

				$data = array(
					'status' => $this->input->post('status', true),
				);
				$this->skripsi->update_penguji($data, $id_penguji);
				// Cek semua Penguji Approve
				$semua_approve = $this->skripsi->semua_penguji_setuju($id_ujian);
				if ($semua_approve) {
					$data_skripsi = [
						'status_proposal' => STATUS_SKRIPSI_PROPOSAL_SETUJUI_PENGUJI
					];
					$this->skripsi->update($data_skripsi, $id_skripsi);
				}
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update proses.');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


		public function update_nilai()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_ujian = $this->input->post('id_ujian', true);
				$id_skripsi = $this->input->post('id_skripsi', true);
				$status_tim = $this->skripsi->read_pengujiketua($id_ujian);
				if (!empty($status_tim)) {
					$data = array(
						'status_skripsi' => STATUS_SKRIPSI_UJIAN_SELESAI,
						'nilai' => $this->input->post('nilai', true),
					);
					$this->skripsi->update_nilai($data, $id_skripsi);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update nilai.');
					redirect_back();
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
					redirect_back();
				}


			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_riwayat_revisi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_bimbingan_revisi = $this->input->post('id_revisi', true);

				$data = array(
					'status_persetujuan' => 1,
					'waktu_persetujuan' => date('Y-m-d H:i:s'),
				);
				$this->revisi_skripsi->updateRevisi($data, $id_bimbingan_revisi);
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil menyimpan.');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_revisi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_penguji = $this->input->post('id_penguji', true);

				$data = array(
					'revisi' => $this->input->post('revisi', true),
				);
				$this->revisi_skripsi->updatePengujiRevisi($data, $id_penguji);
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil menyimpan.');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function setujui_revisi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_penguji = $this->input->post('id_penguji', true);

				$data = array(
					'status_revisi' => 1,
					'waktu_persetujuan_revisi' => date('Y-m-d H:i:s'),
				);
				$this->revisi_skripsi->updatePengujiRevisi($data,$id_penguji);
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil menyimpan.');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


	}

?>
