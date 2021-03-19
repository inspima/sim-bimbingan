<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Dashboard extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//END SESS
			//START MODEL
			$this->load->model('backend/master/setting', 'setting');
			$this->load->model('backend/transaksi/skripsi', 'skripsi');
			//END MODEL
		}

		public function jadwal_kalender()
		{
			$data = array(
				// PAGE //
				'title' => 'Dashboard ',
				'subtitle' => 'Jadwal Ujian',
				'section' => 'frontend/dashboard/jadwal_kalender',
				// DATA //
			);
			$this->load->view('frontend/index-fluid', $data);
		}
	}

?>
