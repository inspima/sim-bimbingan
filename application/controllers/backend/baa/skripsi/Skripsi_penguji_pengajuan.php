<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skripsi_penguji_pengajuan extends CI_Controller {

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
		if($this->session_data['sebagai'] != 2 AND $this->session_data['role'] != 2)
		{
			redirect('logout','refresh');
		}
	}
	//END SESS
		
	//START MODEL
    $this->load->model('backend/baa/master/gelombang_model','gelombang');
    $this->load->model('backend/baa/skripsi/Skripsi_penguji_pengajuan_model','penguji');
	//END MODEL
	}

	public function index()
	{
        $data=array(
        // PAGE //
        'title'		=> 'Penguji Pengajuan',
        'subtitle'	=> 'Data Penguji (Belum Approve)',
        'section'	=> 'backend/baa/skripsi/skripsi_penguji_pengajuan',
        // DATA //
        'penguji'  => $this->penguji->read()
        );

        $this->load->view('backend/index_sidebar',$data);	
    }
    

}
?>