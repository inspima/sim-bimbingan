<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Kadep_pengajuan extends CI_Controller
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

			$this->load->model('backend/transaksi/skripsi', 'skripsi');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/dosen/proposal/Kadep_pengajuan_model', 'proposal');
			//END MODEL
		}

		public function index()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {

				$data = array(
					// PAGE //
					'title' => 'Pengajuan Proposal (Modul Kepala Bagian)',
					'subtitle' => 'Data Pengajuan Proposal',
					'section' => 'backend/dosen/proposal/kadep_pengajuan',
					// DATA //
					'proposal' => $this->proposal->read($id_departemen)
				);
				//print_r($data['proposal']);die();
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function edit()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {
				$id_skripsi = $this->uri->segment('5');

				$data = array(
					// PAGE //
					'title' => 'Pengajuan Proposal (Modul Kepala Bagian)',
					'subtitle' => 'Data Pengajuan Proposal',
					'section' => 'backend/dosen/proposal/kadep_pengajuan_detail',
					// DATA //
					'proposal' => $this->proposal->detail($id_departemen, $id_skripsi),
					'departemen' => $this->departemen->read()
				);

				$this->load->view('backend/index_sidebar', $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function update_proses()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_judul = $this->input->post('id_judul', true);
				$status_proposal = $this->input->post('status_proposal', true);
				if ($status_proposal == STATUS_SKRIPSI_PROPOSAL_DITOLAK) {
					$data_judul = [
						'persetujuan' => 2,
						'persetujuan_keterangan' => $this->input->post('keterangan_proposal', true),
					];
					$this->proposal->update_judul($data_judul, $id_judul);
				} else {
					$data = array(
						'status_proposal' => $this->input->post('status_proposal', true),
						'keterangan_proposal' => $this->input->post('keterangan_proposal', true),
					);
					$this->proposal->update($data, $id_skripsi);
					$data_judul = [
						'persetujuan' => 1,
						'status' => 1,
					];
					$this->proposal->update_judul($data_judul, $id_judul);
				};

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update proses');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_departemen()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);

				$data = array(
					'id_departemen' => $this->input->post('id_departemen', true),
				);
				$this->proposal->update($data, $id_skripsi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update departemen. Data pengajuan proposal akan berpindah ke departemen yang dituju.');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

	}

?>
