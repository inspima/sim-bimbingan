<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Disertasi_promotor extends CI_Controller
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
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/administrator/master/Struktural_model', 'struktural');
			$this->load->model('backend/administrator/master/ruang_model', 'ruang');
			$this->load->model('backend/administrator/master/jam_model', 'jam');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/transaksi/dokumen', 'dokumen');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/utility/qr', 'qrcode');
			//END MODEL
			// LIBRARY
			$this->load->library('encryption');
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Admin Prodi',
				'subtitle' => 'Disertasi - Promotor',
				'section' => 'backend/prodi/doktoral/promotor/index',
				// DATA //
				'disertasi' => $this->disertasi->read_promotor(),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function cetak_sk_promotor()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$no_sk = $this->input->post('no_sk', true);
				$disertasi =$this->disertasi->detail($id_disertasi);

				// Jika Status belum cetak SK
				if ($disertasi->status_promotor < STATUS_DISERTASI_PROMOTOR_CETAK_SK) {
					$data = array(
						'status_promotor' => STATUS_DISERTASI_PROMOTOR_SELESAI,
					);
					$this->disertasi->update($data, $id_disertasi);
				}

				$data = array(
					'no_sk' => $no_sk,
					'semester' => $this->semester->detail_berjalan(),
					'disertasi' => $disertasi,
					'dekan' => $this->struktural->read_dekan(),
					'kps_s3' => $this->struktural->read_kps_s3(),
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$header = 'backend/widgets/common/pdf_header';
				$page = 'backend/prodi/doktoral/promotor/cetak_sk_promotor';
				$size = 'a4';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "SURAT KEPUTUSAN - PROMOTOR & KO-PROMOTOR - ".$disertasi->nim.'.pdf';
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

	}

?>
