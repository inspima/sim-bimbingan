<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

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
	$this->load->model('backend/baa/master/dosen_model','dosen');
	//END MODEL
	}

	public function index()
	{
		$data=array(
		// PAGE //
		'title'		=> 'Master Dosen',
		'subtitle'	=> 'Data Dosen',
		'section'	=> 'backend/baa/master/dosen',
        // DATA //
		'dosen'      => $this->dosen->read(),
		);
		$this->load->view('backend/index_sidebar',$data);	
    }
    
    public function update_berjalan()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_pegawai = $this->input->post('id_pegawai',TRUE);
			
			$data = array(
			'status_berjalan'	=> $this->input->post('status_berjalan',TRUE),
			);
			$this->dosen->update($data, $id_pegawai);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update');
			redirect('dashboardb/master/dosen');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/dosen');
		}
	}

}
?>