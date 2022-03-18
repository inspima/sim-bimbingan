<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Laporan_dosen extends CI_Controller
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
			$this->load->model('backend/laporan/Laporan_dosen_model', 'laporan');
			$this->load->model('backend/transaksi/Skripsi', 'skripsi');
			$this->load->model('backend/transaksi/tesis', 'tesis');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/master/tugas_akhir', 'tugas_akhir', TRUE);
			$this->load->model('backend/user', 'user');
			//END MODEL
		}

		public function penguji_sarjana()
		{
			//echo $this->session_data['username'];die();
			$username=$this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Laporan Penguji',
				'subtitle' => 'Sarjana',
				'section' => 'backend/dosen/laporan/penguji',
				// DATA //
				'penguji' => $this->laporan->read_penguji_skripsi($username),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function penguji_magister()
		{
			//echo $this->session_data['username'];die();
			$username=$this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Laporan Penguji',
				'subtitle' => 'Magister',
				'section' => 'backend/dosen/laporan/penguji',
				// DATA //
				'penguji' => $this->laporan->read_penguji_tesis($username),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function penguji_doktor()
		{
			//echo $this->session_data['username'];die();
			$username=$this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Laporan Penguji',
				'subtitle' => 'Doktor',
				'section' => 'backend/dosen/laporan/penguji',
				// DATA //
				'penguji' => $this->laporan->read_penguji_disertasi($username),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function index_skripsi()
		{
			//echo $this->session_data['username'];die();
			$username=$this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Laporan Dosen',
				'subtitle' => 'Keaktifan dosen skripsi',
				'section' => 'backend/laporan/dosen/index-skripsi',
				// DATA //

				'laporans' => $this->laporan->read_laporan_dosen_skripsi(),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function detail_skripsi($nip)
		{
			$tipe = $this->input->get('tipe');

			$data = array(
				// PAGE //
				'title' => 'Laporan Dosen',
				'subtitle' => 'Dosen Skripsi sebagai',
				'section' => 'backend/laporan/dosen/detail-skripsi',
				'use_back' => true,
				'back_link' => 'laporan/dosen/skripsi',
				// DATA //
				'pegawai'=>$this->user->detail_pegawai_by_username($nip),
				'sebagai'=>ucfirst(str_replace('_',' ',$tipe)),
				'laporans' => $this->laporan->read_detail_laporan_skripsi($nip,$tipe),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function index_tesis()
		{
			//echo $this->session_data['username'];die();
			$username=$this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Laporan Dosen',
				'subtitle' => 'Keaktifan dosen tesis',
				'section' => 'backend/laporan/dosen/index-tesis',
				// DATA //

				'laporans' => $this->laporan->read_laporan_dosen_tesis(),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function detail_tesis($nip)
		{
			$tipe = $this->input->get('tipe');

			$data = array(
				// PAGE //
				'title' => 'Laporan Dosen',
				'subtitle' => 'Dosen Tesis sebagai',
				'section' => 'backend/laporan/dosen/detail-tesis',
				'use_back' => true,
				'back_link' => 'laporan/dosen/tesis',
				// DATA //
				'pegawai'=>$this->user->detail_pegawai_by_username($nip),
				'sebagai'=>ucfirst(str_replace('_',' ',$tipe)),
				'laporans' => $this->laporan->read_detail_laporan_tesis($nip,$tipe),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function index_disertasi()
		{
			//echo $this->session_data['username'];die();
			$username=$this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Laporan Dosen',
				'subtitle' => 'Keaktifan dosen disertasi',
				'section' => 'backend/laporan/dosen/index-disertasi',
				// DATA //

				'laporans' => $this->laporan->read_laporan_dosen_disertasi(),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function detail_disertasi($nip)
		{
			$tipe = $this->input->get('tipe');

			$data = array(
				// PAGE //
				'title' => 'Laporan Dosen',
				'subtitle' => 'Dosen Disertasi sebagai',
				'section' => 'backend/laporan/dosen/detail-disertasi',
				'use_back' => true,
				'back_link' => 'laporan/dosen/disertasi',
				// DATA //
				'pegawai'=>$this->user->detail_pegawai_by_username($nip),
				'sebagai'=>ucfirst(str_replace('_',' ',$tipe)),
				'laporans' => $this->laporan->read_detail_laporan_disertasi($nip,$tipe),
			);

			$this->load->view('backend/index_sidebar', $data);
		}


	}

?>
