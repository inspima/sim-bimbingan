<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penguji_approve extends CI_Controller {

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
    $this->load->model('backend/dosen/proposal/Penguji_model','penguji');
    
	//END MODEL
	}

	public function index()
	{
        $username = $this->session_data['username'];
        $data=array(
            // PAGE //
            'title'	=> 'Proposal Skripsi (Penguji Approve)',
            'subtitle'	=> 'Data Proposal Skripsi(Penguji Approve)',
            'section'	=> 'backend/dosen/skripsi/proposal/penguji_approve',
            // DATA //
            'penguji'  => $this->penguji->read_approve($username)
        );
        $this->load->view('backend/index_sidebar',$data);	
	}
	
	public function update_penguji()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_penguji = $this->input->post('id_penguji',TRUE);
			
			$data = array(
            'status'	=> $this->input->post('status',TRUE),
			);
			$this->penguji->update_penguji($data, $id_penguji);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update proses.');
			redirect('dashboardd/proposal/penguji_pengajuan');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardd/proposal/penguji_pengajuan');
		}
	}
    

    
}
?>
