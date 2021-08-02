<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kadep_selesai extends CI_Controller {

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
	$this->load->model('backend/dosen/proposal/Kadep_selesai_model','proposal');
	//END MODEL
	}

	public function index()
	{
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
        if($struktural->id_struktur == '5')
        {

            $data=array(
                // PAGE //
                'title'	=> 'Pengajuan Proposal (Modul Kepala Bagian)',
                'subtitle'	=> 'Data Pengajuan Proposal (Selesai)',
                'section'	=> 'backend/dosen/proposal/kadep_selesai',
                // DATA //
                'proposal'  => $this->proposal->read($id_departemen)
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
    
    public function edit()
    {
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
        if($struktural->id_struktur == '5')
        {
            $id_skripsi = $this->uri->segment('5');
            
            $data=array(
                // PAGE //
                'title'	=> 'Pengajuan Proposal (Modul Kepala Bagian)',
                'subtitle'	=> 'Data Pengajuan Proposal (Selesai)',
                'section'	=> 'backend/dosen/proposal/kadep_selesai_detail',
                // DATA //
                'proposal'  => $this->proposal->detail($id_departemen, $id_skripsi),
                'departemen'=> $this->departemen->read()
            );
            
            if($data['proposal'])
            {
                $this->load->view('backend/index_sidebar',$data);	
            }
            else
            {
                $data['section'] = 'backend/notification/danger';
                $data['msg']	 = 'Tidak ditemukan';
                $data['linkback']= 'dashboardd/proposal/kadep_ditolak';
                $this->load->view('backend/index_sidebar',$data);	
            }	
                
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
