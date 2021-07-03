<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Kps_skripsi extends CI_Controller
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
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/dosen/skripsi/Kps_skripsi_model', 'skripsi');
			$this->load->model('backend/transaksi/skripsi', 'transaksi_skripsi');
			$this->load->model('backend/administrator/master/ruang_model', 'ruang');
			$this->load->model('backend/administrator/master/jam_model', 'jam');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			$this->load->model('backend/utility/notification', 'notifikasi');
			//END MODEL
		}

		public function index()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			if ($struktural->id_struktur == STRUKTUR_KPS_S1) {
				$year = date("Y");
				$data = array(
					// PAGE //
					'title' => 'Skripsi',
					'subtitle' => 'Data Skripsi',
					'section' => 'backend/dosen/skripsi/ujian/kps_skripsi',
					// DATA //
					'skripsi' => $this->skripsi->read($year),
					'post_year' => $year,
				);
				//print_r($data['proposal']);die();
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function filter_tahun()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);

			if ($struktural->id_struktur == '6') {
				$year = $this->input->post('tahun', true);
				$data = array(
					// PAGE //
					'title' => 'Skripsi',
					'subtitle' => 'Data Skripsi',
					'section' => 'backend/dosen/skripsi/ujian/kps_skripsi',
					// DATA //
					'skripsi' => $this->skripsi->read_filter($year),
					'post_year' => $year,
				);
				//print_r($data['proposal']);die();
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}


		public function approve()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$data = array(
					'status_skripsi' => STATUS_SKRIPSI_UJIAN_SETUJUI_KPS, //app kps
				);
				$data = array(
					'status_skripsi' => STATUS_SKRIPSI_UJIAN_UJIAN, //app kps
				);
				$this->skripsi->update_skripsi($data, $id_skripsi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil approve');
				redirect('dashboardd/skripsi/kps_skripsi');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/skripsi/kps_skripsi');
			}
		}

		public function unapprove()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$data_skripsi = $this->transaksi_skripsi->detail_by_id($id_skripsi);
				$ujian_skripsi = $this->transaksi_skripsi->read_ujian_skripsi($id_skripsi);
				// Batalkan approve
				$this->skripsi->unapprove($id_skripsi,$ujian_skripsi->id_ujian);
				// Update status skripsi
				$data = array(
					'status_skripsi' => STATUS_SKRIPSI_UJIAN_DIJADWALKAN, //app kps
				);
				$this->skripsi->update_skripsi($data, $id_skripsi);
				// Kirim Wa ke kadep
				$kadep = $this->dosen->get_kadep($data_skripsi->id_departemen);
				$judul_notifikasi = 'Pembatalan Jadwal Skripsi oleh KPS';
				$isi_notifikasi = 'Mohon kesediaanya untuk melakukan penjadwalan ulang mahasiswa dengan Nim ' . $data_skripsi->nim . ' pada sistem IURIS';
				$this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 1, $kadep->nip);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil dibatalkan, notifikasi telah dikirimkan ke ketua bagian untuk penjadwalan ulang');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


	}

?>
