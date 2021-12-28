<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Ruang extends CI_Controller
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
			$this->load->model('backend/master/ruang_model', 'ruang');
			$this->load->model('backend/master/prodi', 'prodi');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Master Ruang',
				'subtitle' => 'Data Ruang',
				'section' => 'backend/baa/master/ruang/ruang',
				// DATA //
				'ruang' => $this->ruang->read(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function add()
		{
			$data = array(
				// PAGE //
				'title' => 'Master Ruang',
				'subtitle' => 'Tambah Data Ruang',
				'section' => 'backend/baa/master/ruang/add',
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$data = array(
					'ruang' => $this->input->post('ruang', true),
					'gedung' => $this->input->post('gedung', true),
				);

				$this->ruang->save($data);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil disimpan');
				redirect('baa/master/ruang');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/master/ruang');
			}
		}

		public function edit()
		{
			$id = $this->uri->segment(5);

			$data = array(
				// PAGE //
				'title' => 'Ruang',
				'subtitle' => 'Edit',
				'section' => 'backend/baa/master/ruang/edit',
				// DATA //
				'ruang' => $this->ruang->detail($id),
				'ruang_prodis' => $this->ruang->readRuangProdi($id),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function update()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_ruang', true);
				$prodis = $this->input->post('prodis', true);

				$data = array(
					'ruang' => $this->input->post('ruang', true),
					'gedung' => $this->input->post('gedung', true),
				);

				$this->ruang->update($data, $id);
				$this->ruang->updateRuangProdi($prodis, $id);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect('baa/master/ruang');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/master/ruang');
			}
		}

		public function update_aktif()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_ruang', true);
				$status = $this->input->post('status', true);

				$data = array(
					'status' => $status,
				);
				$this->ruang->update($data,$id);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect('baa/master/ruang');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/master/ruang');
			}
		}

	}

?>
