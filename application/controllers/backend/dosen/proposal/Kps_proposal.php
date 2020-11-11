<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kps_proposal extends CI_Controller {

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
    $this->load->model('backend/baa/master/gelombang_model','gelombang');
    $this->load->model('backend/dosen/proposal/Kps_proposal_model','proposal');
    $this->load->model('backend/dosen/master/Dosen_model','dosen');
    
	//END MODEL
	}

	public function index()
	{
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        if($struktural->id_struktur == '6')
        {

            $data=array(
                // PAGE //
                'title'	=> 'Proposal Skripsi (Modul KPS)',
                'subtitle'	=> 'Data Proposal Skripsi',
                'section'	=> 'backend/dosen/proposal/kps_proposal',
                // DATA //
                'gelombang' => $this->gelombang->read(),
                'gelombang_berjalan' => $this->gelombang->read_berjalan(),
                );

                $data['proposal'] = $this->proposal->read($data['gelombang_berjalan']->id_gelombang);
                $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardd');
        }
    }
    
    public function gelombang()
    {
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        if($struktural->id_struktur == '6')
        {
            
            $id_gelombang = $this->input->post('id_gelombang',TRUE);
            $id = $this->input->post('id_gelombang',TRUE);
            $data=array(
                // PAGE //
                'title'	=> 'Proposal Skripsi (Modul KPS)',
                'subtitle'	=> 'Data Proposal Skripsi',
                'section'	=> 'backend/dosen/proposal/kps_proposal',
                // DATA //
                'gelombang' => $this->gelombang->read(),
                'gelombang_berjalan' => $this->gelombang->detail($id),
                );

                $data['proposal'] = $this->proposal->read_gelombang($id_gelombang);
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