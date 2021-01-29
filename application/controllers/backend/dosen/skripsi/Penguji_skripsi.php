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
			//END MODEL
		}

		public function index_proposal()
		{
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Skripsi - Proposal',
				'subtitle' => 'Pengajuan Penguji',
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
				'subtitle' => 'Riwayat Penguji',
				'section' => 'backend/dosen/skripsi/proposal/penguji_riwayat',
				// DATA //
				'penguji' => $this->skripsi->read_penguji_proposal($username)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function index_skripsi()
		{
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Skripsi ',
				'subtitle' => 'Pengajuan Penguji',
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
				'title' => 'Skripsi',
				'subtitle' => 'Riwayat Penguji',
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
						'status_proposal' => STATUS_SKRIPSI_PROPOSAL_UJIAN
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
			$id_ujian = $this->input->post('id_ujian', true);
			$id_skripsi = $this->input->post('id_skripsi', true);
			$username = $this->session_data['username'];
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$status_tim = $this->penguji->read_ketuapenguji($username, $id_ujian);
				if ($status_tim->status_tim == '1') {
					$id_skripsi = $this->input->post('id_skripsi', true);

					$data = array(
						'status_skripsi' => STATUS_SKRIPSI_UJIAN_SELESAI,
						'nilai' => $this->input->post('nilai', true),
					);
					$this->penguji->update_nilai($data, $id_skripsi);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update nilai.');
					redirect('dashboardd/skripsi/penguji_approve');
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
					redirect('dashboardd/skripsi/penguji_approve');
				}


			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/skripsi/penguji_approve');
			}
		}


	}

?>
