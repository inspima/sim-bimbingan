<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends CI_Controller {

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
    $this->load->model('backend/administrator/master/tesis_model','proposal');
	//END MODEL
	}

	public function index()
	{
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        var_dump ($id_prodi);
        if($struktural->id_struktur == '7')
            
        {

            $data=array(
                // PAGE //
                'title'	=> 'Pengajuan Proposal Tesis (Modul Sekertaris Prodi)',
                'subtitle'	=> 'Data Pengajuan Proposal Tesis (Pengajuan)',
                'section'	=> 'backend/dosen/proposal_tesis/pengajuan',
                // DATA //
                'proposal'  => $this->proposal->read($id_prodi)
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
    
    public function app()
	{
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        //var_dump ($id_prodi);
        if($struktural->id_struktur == '7')
            
        {

            $data=array(
                // PAGE //
                'title'	=> 'Pengajuan Proposal Tesis (Modul Sekertaris Prodi)',
                'subtitle'	=> 'Data Pengajuan Proposal Tesis (Diterima)',
                'section'	=> 'backend/dosen/proposal_tesis/app',
                // DATA //
                'proposal'  => $this->proposal->read_proposal_acc($id_prodi)
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
    
    public function approve() {
        $id = $this->uri->segment(5);
        $this->proposal->approval_proposal($id);
        redirect('dashboardd/proposal_tesis/pengajuan');
        
        
    }
    
    public function reject() {
        $id = $this->uri->segment(5);
        $this->proposal->reject_proposal($id);
        redirect('dashboardd/proposal_tesis/pengajuan');
        
        
    }

}
?>