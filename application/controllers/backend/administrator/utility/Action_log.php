<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Action_log extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != 1) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/user');
			$this->load->model('backend/utility/ActionLog', 'alog');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Log Perubahan',
				'subtitle' => 'Administrator',
				'section' => 'backend/administrator/utility/action_log',
				// DATA //
				'user' => $this->user->read(),
				'logs'=>$this->alog->read(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}



	}

?>
