<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Jurnal_doktoral extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != ROLE_UP4I) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/transaksi/jurnal', 'jurnal');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'UP4I',
				'subtitle' => 'Doktoral - Validasi Jurnal',
				'section' => 'backend/up4i/doktoral/index',
				// DATA //
				'data' => $this->jurnal->read_validasi_doktoral()
			);

			$this->load->view('backend/index_sidebar', $data);
		}


		public function validasi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_jurnal = $this->input->post('id_jurnal', true);
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = [
					'status' => '1',
					'validator' => $this->session_data['nama'],
					'validation_date' => date('Y-m-d')
				];
				$this->jurnal->update($data, $id_jurnal);

				$data_disertasi = [
					'status_terbuka' => STATUS_DISERTASI_TERBUKA_SETUJUI_UP4I,
				];
				$this->disertasi->update($data_disertasi, $id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil divaliadsi');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function cetak_absensi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);

				$data = array(
					'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_TERBUKA),
					'disertasi' => $this->disertasi->detail($id_disertasi)
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$page = 'backend/prodi/doktoral/terbuka/cetak_absensi';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "disertasi_absensi.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('prodi/doktoral/disertasi/terbuka/');
			}
		}

	}

?>
