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
		if($this->session_data['sebagai'] != 2 OR $this->session_data['role'] != 2)
		{
			redirect('logout','refresh');
		}
	}
	//END SESS
		
	//START MODEL
	//END MODEL
	}

	public function index()
	{
		$data=array(
		// PAGE //
		'title'	=> 'Selamat Datang, '.$this->session_data['nama'],
		'subtitle'	=> 'BAA',
		'section'	=> 'backend/baa/home',
		
		);
			
		$this->load->view('backend/index_sidebar',$data);	
	}

}
?>