<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembimbing extends CI_Controller {

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
    $this->load->model('backend/dosen/master/dosen_model','dosen');
    $this->load->model('backend/administrator/master/struktural_model','struktural');
    $this->load->model('backend/dosen/monitoring/pembimbing_model','pembimbing');
	}

	public function index()
	{
		$session_data = $this->session->userdata('logged_in');
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
        if($struktural->id_struktur == '5')
        {
            $data=array(
                
                // PAGE //
                'title'		=> 'Monitoring',
                'subtitle'	=> 'Pembimbing',
                
                'section'	=> 'backend/dosen/monitoring/pembimbing',
                'boxtitle'	=> 'Pembimbing',
                // DATA	
                //'jadwal'	=> $this->jadwal->read_all(),
                'dosen'		=> $this->dosen->read_aktif($id_departemen),
                );

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