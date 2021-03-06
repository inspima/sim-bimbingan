<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kps_skripsi_data extends CI_Controller {

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
    $this->load->model('backend/administrator/master/departemen_model','departemen');
    $this->load->model('backend/dosen/skripsi/Kps_skripsi_model','skripsi');
    $this->load->model('backend/administrator/master/ruang_model','ruang');
    $this->load->model('backend/administrator/master/jam_model','jam');
    $this->load->model('backend/dosen/master/Dosen_model','dosen');
	//END MODEL
	}

	public function index()
	{
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        
        if($struktural->id_struktur == '6')
        {
            $year = date("Y");
            $data=array(
                // PAGE //
                'title'	=> 'Data Skripsi',
                'subtitle'	=> 'Data Skripsi',
                'section'	=> 'backend/dosen/skripsi/kps_skripsi_data',
                // DATA //
                'skripsi'  => $this->skripsi->read_data()
                );
                //print_r($data['proposal']);die();
                $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardd');
        }
    }
    

}
?>