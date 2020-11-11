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
		if($this->session_data['sebagai'] != 1)
		{
			redirect('logout','refresh');
		}
	}
	//END SESS
		
	//START MODEL
	$this->load->model('backend/administrator/master/struktural_model','struktural');
	$this->load->model('backend/dosen/modul/Berita_model','berita');
	//END MODEL
	}

	public function index()
	{
		//echo $this->session_data['username'];die();

		$data=array(
		// PAGE //
		'title'	=> 'Selamat Datang, '.$this->session_data['nama'],
		'subtitle'	=> 'Dosen',
		'section'	=> 'backend/dosen/home',
		// DATA //
		'berita'	=> $this->berita->read()
		);
			
		$this->load->view('backend/index_sidebar',$data);	
	}

}
?>