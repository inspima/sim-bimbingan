<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Laporan_mahasiswa extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			}
			//END SESS

			//START MODEL
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/dosen/proposal/Kps_proposal_model', 'proposal');
			$this->load->model('backend/transaksi/Skripsi', 'skripsi');
			$this->load->model('backend/transaksi/tesis', 'tesis');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/laporan/Laporan_mahasiswa_model', 'laporan');
			$this->load->model('backend/master/tugas_akhir', 'tugas_akhir', TRUE);
			//END MODEL
		}

		public function index_skripsi()
		{

			$data = array(
				// PAGE //
				'title' => 'Laporan Mahasiswa',
				'subtitle' => 'Proposal dan Ujian Skripsi',
				'section' => 'backend/laporan/mahasiswa/index-skripsi',
				// DATA //

				'proposals' => $this->laporan->read_laporan_mahasiswa_skripsi_proposal(),
				'ujians' => $this->laporan->read_laporan_mahasiswa_skripsi_ujian(),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function index_tesis()
		{

			$data = array(
				// PAGE //
				'title' => 'Laporan Mahasiswa',
				'subtitle' => 'Judul, Proposal, MKPT dan Ujian Tesis',
				'section' => 'backend/laporan/mahasiswa/index-tesis',
				// DATA //
				'juduls' => $this->laporan->read_laporan_mahasiswa_tesis_judul(),
				'proposals' => $this->laporan->read_laporan_mahasiswa_tesis_proposal(),
				'mkpts' => $this->laporan->read_laporan_mahasiswa_tesis_mkpt(),
				'ujians' => $this->laporan->read_laporan_mahasiswa_tesis_ujian(),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function index_disertasi()
		{

			$data = array(
				// PAGE //
				'title' => 'Laporan Mahasiswa',
				'subtitle' => 'Kualifikasi, Pengajuan Promotor, MKPKK, Proposal, MKPD, Kelayakan, Tertutup dan Terbuka',
				'section' => 'backend/laporan/mahasiswa/index-disertasi',
				// DATA //
				'kualifikasis' => $this->laporan->read_laporan_mahasiswa_disertasi_kualifikasi(),
				'promotors' => $this->laporan->read_laporan_mahasiswa_disertasi_promotor(),
				'mpkks' => $this->laporan->read_laporan_mahasiswa_disertasi_mkpkk(),
				'proposals' => $this->laporan->read_laporan_mahasiswa_disertasi_proposal(),
				'mkpds' => $this->laporan->read_laporan_mahasiswa_disertasi_mkpd(),
				'kelayakans' => $this->laporan->read_laporan_mahasiswa_disertasi_kelayakan(),
				'tertutups' => $this->laporan->read_laporan_mahasiswa_disertasi_tertutup(),
				'terbukas' => $this->laporan->read_laporan_mahasiswa_disertasi_terbuka(),
			);

			$this->load->view('backend/index_sidebar', $data);
		}


	}

?>
