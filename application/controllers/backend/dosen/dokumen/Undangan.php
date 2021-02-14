<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Undangan extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 1 and $this->session_data['role'] != 0) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/transaksi/dokumen', 'dokumen');
			$this->load->model('backend/utility/notification', 'notifikasi');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/user', 'user');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Undangan',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/dokumen/undangan/index',
				// DATA //
				'dokumens' => $this->dokumen->read_persetujuan_dosen($this->session_data['username'], 'undangan'),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function riwayat()
		{
			$data = array(
				// PAGE //
				'title' => 'Undangan',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/dokumen/undangan/index',
				// DATA //
				'dokumens' => $this->dokumen->read_persetujuan_dosen_riwayat($this->session_data['username'], 'undangan'),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

	}

?>
