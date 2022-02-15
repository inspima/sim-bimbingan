<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Disertasi_mkpkk extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != ROLE_ADMIN_PRODI) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/master/setting', 'setting');
			$this->load->model('backend/master/semester', 'semester');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/administrator/master/ruang_model', 'ruang');
			$this->load->model('backend/administrator/master/jam_model', 'jam');
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			//END MODEL
			// LIBRARY
			$this->load->library('encryption');
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - MKPKK',
				'subtitle' => 'Data',
				'section' => 'backend/prodi/doktoral/mkpkk/index',
				// DATA //
				'disertasi' => $this->disertasi->read_mpkk(),
				'struktural' => $this->struktural->read_struktural($this->session_data['username']),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function cetak_sk()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$no_sk = $this->input->post('no_sk', true);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$disertasi_mkpkks = $this->disertasi->read_disertasi_mkpkk($id_disertasi);
				// Jika Status belum cetak SK
				if ($disertasi->status_mpkk < STATUS_DISERTASI_MPKK_CETAK_SK) {
					$data = array(
						'status_mpkk' => STATUS_DISERTASI_MPKK_CETAK_SK,
					);
					$data = array(
						'status_mpkk' => STATUS_DISERTASI_MPKK_PENILAIAN,
					);
					$this->disertasi->update($data, $id_disertasi);
				}

				$data = array(
					'no_sk' => $no_sk,
					'semester' => $this->semester->detail_berjalan(),
					'disertasi' => $disertasi,
					'wadek' => $this->struktural->read_wadek1(),
					'kps_s3' => $this->struktural->read_kps_s3(),
					'disertasi_mkpkks' => $disertasi_mkpkks,
				);

				$page = 'backend/prodi/doktoral/mkpkk/cetak-sk';
				$size = 'a4';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "SURAT KEPUTUSAN - PENGAJAR MKPKK - " . $disertasi->nim . '.pdf';
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function cetak()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_mkpkk = $this->input->post('id_mkpkk', true);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$mkpkk = $this->disertasi->detail_mkpkk($id_mkpkk);
				$disertasi_mkpkk = $this->disertasi->detail_disertasi_mkpkk($id_disertasi, $id_mkpkk);
				$pjmk_mkpkk = $this->disertasi->detail_mkpkk_pengampu_pjmk($id_mkpkk);
				$data = [
					'disertasi' => $disertasi,
					'mkpkk' => $mkpkk,
					'disertasi_mkpkk' => $disertasi_mkpkk,
					'pjma_mkpkk' => $pjmk_mkpkk,
				];
				$page = 'backend/prodi/doktoral/mkpkk/cetak';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "PENILAIAN MKPKK - " . $disertasi->nim . " - " . $mkpkk->nama . '.pdf';
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


	}

?>
