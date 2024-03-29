<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Penguji_pengajuan extends CI_Controller
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
			$this->load->model('backend/dosen/proposal/Penguji_model', 'penguji');
			$this->load->model('backend/transaksi/Skripsi', 'skripsi');
			$this->load->model('backend/utility/ActionLog', 'action_log');
			//END MODEL
		}

		public function index()
		{
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Proposal Skripsi ',
				'subtitle' => 'Permintaan Penguji ',
				'section' => 'backend/dosen/skripsi/proposal/penguji_pengajuan',
				// DATA //
				'penguji' => $this->skripsi->read_penguji_pengajuan_proposal($username)
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
				$status = $this->input->post('status', true);

				$data = array(
					'status' => $status,
				);
				$this->penguji->update_penguji($data, $id_penguji);
				// Save Log
				$this->action_log->saveActionLogByIdSkripsi($id_skripsi, $this->session_data['username'], ACTION_VERB_PENGUJI, ACTION_OBJECT_PROPOSAL_SKRIPSI, $status == 2);
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


	}

?>
