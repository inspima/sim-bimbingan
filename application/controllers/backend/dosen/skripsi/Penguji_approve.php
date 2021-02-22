<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Penguji_approve extends CI_Controller
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
			$this->load->model('backend/dosen/skripsi/Penguji_model', 'penguji');

			//END MODEL
		}

		public function index()
		{
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Skripsi (Penguji Approve)',
				'subtitle' => 'Data Skripsi(Penguji Approve)',
				'section' => 'backend/dosen/skripsi/penguji_approve',
				// DATA //
				'penguji' => $this->penguji->read_approve($username)
			);
			$this->load->view('backend/index_sidebar', $data);
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

	}

?>
