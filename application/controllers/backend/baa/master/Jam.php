<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Jam extends CI_Controller
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
			$this->load->model('backend/master/jam_model', 'jam');
			$this->load->model('backend/master/prodi', 'prodi');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Master Jam',
				'subtitle' => 'Data Jam',
				'section' => 'backend/baa/master/jam/jam',
				// DATA //
				'jam' => $this->jam->read(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function add()
		{
			$data = array(
				// PAGE //
				'title' => 'Master Jam',
				'subtitle' => 'Tambah Data Jam',
				'section' => 'backend/baa/master/jam/add',
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$data = array(
					'jam' => $this->input->post('jam', true),
				);

				$this->jam->save($data);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil disimpan');
				redirect('baa/master/jam');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/master/jam');
			}
		}

		public function edit()
		{
			$id = $this->uri->segment(5);

			$data = array(
				// PAGE //
				'title' => 'Jam',
				'subtitle' => 'Edit',
				'section' => 'backend/baa/master/jam/edit',
				// DATA //
				'jam' => $this->jam->detail($id),
				'jam_prodis' => $this->jam->readJamProdi($id),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function update()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_jam', true);
				$prodis = $this->input->post('prodis', true);

				$data = array(
					'jam' => $this->input->post('jam', true),
				);

				$this->jam->update($data, $id);
				$this->jam->updateJamProdi($prodis, $id);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect('baa/master/jam');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/master/jam');
			}
		}

		public function update_aktif()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_jam', true);

				$data = array(
					'status' => '0',
				);
				$this->jam->update($data,$id);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect('baa/master/jam');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/master/jam');
			}
		}

	}

?>
