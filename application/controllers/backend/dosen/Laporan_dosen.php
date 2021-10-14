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
			//END MODEL
		}

		public function penguji_sarjana()
		{
			//echo $this->session_data['username'];die();
			$username=$this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Laporan Penguji Sarjana',
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
				'title' => 'Laporan Penguji Sarjana',
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
				'title' => 'Laporan Penguji Sarjana',
				'subtitle' => 'Doktor',
				'section' => 'backend/dosen/laporan/penguji',
				// DATA //
				'penguji' => $this->laporan->read_penguji_disertasi($username),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

	}

?>
