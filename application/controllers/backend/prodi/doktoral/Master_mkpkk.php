<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Master_mkpkk extends CI_Controller
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
			$this->load->model('backend/master/mkpkk_model', 'mkpkk');
			$this->load->model('backend/master/prodi', 'prodi');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			$this->load->model('backend/baa/master/departemen_model', 'departemen');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Master MKPKK',
				'subtitle' => 'Data MKPKK',
				'section' => 'backend/prodi/doktoral/master/mkpkk/index',
				// DATA //
				'mkpkk' => $this->mkpkk->read(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function add()
		{
			$data = array(
				// PAGE //
				'title' => 'Master Jam',
				'subtitle' => 'Tambah Data Jam',
				'section' => 'backend/prodi/doktoral/master/mkpkk/add',
				// DATA //
				'departemen' => $this->departemen->read(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$data = array(
					'id_departemen' => $this->input->post('id_departemen', true),
					'kode' => $this->input->post('kode', true),
					'nama' => $this->input->post('nama', true),
					'sks' => $this->input->post('sks', true),
				);

				$this->mkpkk->save($data);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil disimpan');
				redirect('prodi/doktoral/master/mkpkk');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('prodi/doktoral/master/mkpkk');
			}
		}

		public function edit()
		{
			$id = $this->uri->segment(6);

			$data = array(
				// PAGE //
				'title' => 'Jam',
				'subtitle' => 'Edit',
				'section' => 'backend/prodi/doktoral/master/mkpkk/edit',
				'use_back' => true,
				'back_link' => 'prodi/doktoral/master/mkpkk',
				// DATA //
				'mdosen' => $this->dosen->read_aktif_alldep(),
				'mkpkk' => $this->mkpkk->detail($id),
				'mkpkk_pengampu' => $this->mkpkk->read_pengampu($id),
				'departemen' => $this->departemen->read(),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function update()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_mkpkk', true);

				$data = array(
					'id_departemen' => $this->input->post('id_departemen', true),
					'kode' => $this->input->post('kode', true),
					'nama' => $this->input->post('nama', true),
					'sks' => $this->input->post('sks', true),
				);

				$this->mkpkk->update($data, $id);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect('prodi/doktoral/master/mkpkk');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('prodi/doktoral/master/mkpkk');
			}
		}

		public function update_aktif()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_mkpkk', true);

				$data = array(
					'status' => $this->input->post('status', true),
				);

				$this->mkpkk->update($data, $id);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect('prodi/doktoral/master/mkpkk');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('prodi/doktoral/master/mkpkk');
			}
		}

		public function save_pengampu()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_mkpkk', true);
				$nip = $this->input->post('nip', true);

				if ($this->mkpkk->cek_pengampu($id, $nip)) {
					$data = array(
						'id_mkpkk' => $this->input->post('id_mkpkk', true),
						'nip' => $this->input->post('nip', true),
					);

					$this->mkpkk->save_pengampu($data, $id);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil simpan');
					redirect_back();
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'pengampu sudah terdaftar');
					redirect_back();
				}


			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_pengampu_pjmk()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_mkpkk_pengampu', true);

				$data = array(
					'pjmk' => $this->input->post('pjmk', true),
				);

				$this->mkpkk->update_pengampu($data, $id);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_pengampu_status()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_mkpkk_pengampu', true);

				$data = array(
					'status' => $this->input->post('status', true),
				);

				$this->mkpkk->update_pengampu($data, $id);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function delete_pengampu()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id_mkpkk_pengampu', true);
				$this->mkpkk->delete_pengampu( $id);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil dihapus');
				redirect_back();

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


	}

?>
