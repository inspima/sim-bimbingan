<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Prodi_doktoral extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != 3) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/user');
			$this->load->model('backend/master/prodi');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			//END MODEL
		}

		public function cetak_sk()
		{
			$data = array(
				// PAGE //
				'title' => 'Admin Prodi',
				'subtitle' => 'Doktoral',
				'section' => 'backend/prodi/doktoral/cetak_sk',
				// DATA //
				'disertasi' => $this->disertasi->read_admin_prodi(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

	}

?>
