<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Dosen extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != 2) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS

			//START MODEL
			$this->load->model('backend/baa/master/departemen_model', 'departemen');
			$this->load->model('backend/baa/master/dosen_model', 'dosen');
			$this->load->model('backend/master/prodi', 'prodi');
			$this->load->model('backend/master/jabatan', 'jabatan');
			$this->load->model('backend/master/pangkat', 'pangkat');
			$this->load->model('backend/master/golongan', 'golongan');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Master Dosen',
				'subtitle' => 'Data Dosen',
				'section' => 'backend/baa/master/dosen',
				// DATA //
				'dosen' => $this->dosen->read(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function edit()
		{
			$id_pegawai = $this->uri->segment('5');
			$data = array(
				// PAGE //
				'title' => 'Master Dosen',
				'subtitle' => 'Edit',
				'section' => 'backend/baa/master/dosen_edit',
				'use_back' => true,
				'back_link' => 'baa/master/dosen',
				// DATA //
				'departemen' => $this->departemen->read(),
				'jenjang' => $this->prodi->read_jenjang(),
				'jabatan' => $this->jabatan->read(),
				'pangkat' => $this->pangkat->read(),
				'golongan' => $this->golongan->read(),
				'dosen' => $this->dosen->detail($id_pegawai),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function update()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_pegawai = $this->input->post('id_pegawai', true);
				$external = $this->input->post('external', true);

				$data = array(
					'nama' => $this->input->post('nama', true),
					'email' => $this->input->post('email', true),
					'id_departemen' => $this->input->post('id_departemen', true),
					'id_jenjang' => $this->input->post('id_jenjang', true),
					'jabatan' => $this->input->post('jabatan', true),
					'pangkat' => $this->input->post('pangkat', true),
					'golongan' => $this->input->post('golongan', true),
					'external' => !empty($external) ? $external : "0",
				);
				$this->dosen->update($data, $id_pegawai);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_berjalan()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_pegawai = $this->input->post('id_pegawai', true);

				$data = array(
					'status_berjalan' => $this->input->post('status_berjalan', true),
				);
				$this->dosen->update($data, $id_pegawai);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect('dashboardb/master/dosen');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboarda/master/dosen');
			}
		}

	}

?>
