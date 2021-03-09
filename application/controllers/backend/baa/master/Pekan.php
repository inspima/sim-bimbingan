<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Pekan extends CI_Controller
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
			$this->load->model('backend/master/pekan_model', 'pekan_model');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Master Data',
				'subtitle' => 'Data Pekan',
				'section' => 'backend/baa/master/pekan/index',
				// DATA //
				'pekans' => $this->pekan_model->read(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function add()
		{
			$data = array(
				// PAGE //
				'title' => 'Master Data',
				'subtitle' => 'Tambah Pekan',
				'section' => 'backend/baa/master/pekan/add',
				'use_back' => true,
				'back_link' => 'baa/master/pekan',
				// DATA //
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_jenjang = '';
				$status = 0;
				$jenis = $this->input->post('jenis', true);
				$periode_awal = $this->input->post('periode_awal', true);
				$periode_awal = date('Y-m-d', strtotime($periode_awal));
				$periode_akhir = $this->input->post('periode_akhir', true);
				$periode_akhir = date('Y-m-d', strtotime($periode_akhir));
				if ($jenis == 'skripsi') {
					$id_jenjang = JENJANG_S1;
				} else if ($jenis == 'tesis') {
					$id_jenjang = JENJANG_S2;
				} else if ($jenis == 'disertasi') {
					$id_jenjang = JENJANG_S3;
				}
				if (date('Y-m-d') <= $periode_akhir && date('Y-m-d') >= $periode_awal) {
					$status = 1;
				}
				$data = array(
					'nama' => $this->input->post('nama', true),
					'jenis' => $jenis,
					'id_jenjang' => $id_jenjang,
					'tgl_awal' => $periode_awal,
					'tgl_akhir' => $periode_akhir,
					'status'=>$status
				);

				$this->pekan_model->save($data);
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil disimpan');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function edit()
		{
			$id = $this->uri->segment(5);

			$data = array(
				// PAGE //
				'title' => 'Master Data',
				'subtitle' => 'Edit Pekan',
				'section' => 'backend/baa/master/pekan/edit',
				'use_back' => true,
				'back_link' => 'baa/master/pekan',
				// DATA //
				'pekan' => $this->pekan_model->detail($id)
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function update()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_jenjang = '';
				$status = 0;
				$id_pekan = $this->input->post('id_pekan', true);
				$jenis = $this->input->post('jenis', true);
				$periode_awal = $this->input->post('periode_awal', true);
				$periode_awal = date('Y-m-d', strtotime($periode_awal));
				$periode_akhir = $this->input->post('periode_akhir', true);
				$periode_akhir = date('Y-m-d', strtotime($periode_akhir));
				if ($jenis == 'skripsi') {
					$id_jenjang = JENJANG_S1;
				} else if ($jenis == 'tesis') {
					$id_jenjang = JENJANG_S2;
				} else if ($jenis == 'disertasi') {
					$id_jenjang = JENJANG_S3;
				}
				if (date('Y-m-d') <= $periode_akhir && date('Y-m-d') >= $periode_awal) {
					$status = 1;
				}
				$data = array(
					'nama' => $this->input->post('nama', true),
					'jenis' => $jenis,
					'id_jenjang' => $id_jenjang,
					'tgl_awal' => $periode_awal,
					'tgl_akhir' => $periode_akhir,
					'status'=>$status
				);
				$this->pekan_model->update($data, $id_pekan);
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}
	}

?>
