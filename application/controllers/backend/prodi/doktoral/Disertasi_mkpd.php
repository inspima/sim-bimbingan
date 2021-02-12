<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Disertasi_mkpd extends CI_Controller
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

		public function index() {
			$data = array(
				// PAGE //
				'title' => 'Disertasi - MKPD',
				'subtitle' => 'Data',
				'section' => 'backend/prodi/doktoral/mkpd/index',
				// DATA //
				'disertasi' => $this->disertasi->read_mkpd(),
				'struktural' => $this->struktural->read_struktural($this->session_data['username']),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function cetak()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_disertasi_mkpd = $this->input->post('id_disertasi_mkpd', true);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$disertasi_mkpd = $this->disertasi->detail_disertasi_mkpd($id_disertasi_mkpd);
				$pjmk_mkpd = $this->disertasi->detail_mkpd_pengampu_pjmk($id_disertasi_mkpd);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$data = [
					'disertasi' => $disertasi,
					'disertasi_mkpd' => $disertasi_mkpd,
					'pjma_mkpd' => $pjmk_mkpd,
				];
				$page = 'backend/prodi/doktoral/mkpd/cetak';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "PENILAIAN MKPD - ".$disertasi->nim." - ".$disertasi_mkpd->mkpd.'.pdf';
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


	}

?>
