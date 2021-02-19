<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends CI_Controller {

		public function __construct(){
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if(!$this->session_data)
			{
				redirect('logout','refresh');
			}
			else
			{
				if($this->session_data['sebagai'] != 2 OR $this->session_data['role'] != ROLE_UP4I)
				{
					redirect('logout','refresh');
				}
			}
			//END SESS

			//START MODEL
			//$this->load->model('backend/menu_model','menu');
			//END MODEL
		}

		public function index()
		{
			//echo $this->session_data['username'];die();

			$data=array(
				// PAGE //
				'title'	=> 'Selamat Datang, '.$this->session_data['nama'],
				'subtitle'	=> 'UP4I',
				'section'	=> 'backend/up4i/home',

			);

			$this->load->view('backend/index_sidebar',$data);
		}

	}
?>
