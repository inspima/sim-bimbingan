<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural extends CI_Controller {

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
		if($this->session_data['sebagai'] != 2 AND $this->session_data['role'] != 1)
		{
			redirect('logout','refresh');
		}
	}
	//END SESS
		
	//START MODEL
    $this->load->model('backend/administrator/master/struktural_model','struktural');
    $this->load->model('backend/administrator/master/user_model','user');
	//END MODEL
	}

	public function index()
	{
		$data=array(
		// PAGE //
		'title'		=> 'Master Struktural',
		'subtitle'	=> 'Administrator',
		'section'	=> 'backend/administrator/master/struktural',
        // DATA //
		'struktural'      => $this->struktural->read(),
		);
		$this->load->view('backend/index_sidebar',$data);	
	}

	public function detail()
	{
		$id = $this->uri->segment(5);

		$data=array(
			// PAGE //
			'title'		=> 'Master Struktural',
			'subtitle'	=> 'Administrator',
			'section'	=> 'backend/administrator/master/struktural_detail',
			// DATA //
            'struktural'      => $this->struktural->detail($id),
            'user'            => $this->user->read_alldosen()
			);
			
		if($data['struktural'])
        {
            $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $data['section'] = 'backend/notification/danger';
            $data['msg']	 = 'Tidak ditemukan';
            $data['linkback']= 'dashboarda/master/struktural';
			$this->load->view('backend/index_sidebar',$data);	
		}	
	
	}

	public function update()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19')
		{
			
			$id_struktural = $this->input->post('id_struktural', TRUE);
			$data = array(
			'nip'	=> $this->input->post('nip',TRUE)
			);
			
			$this->struktural->update($data, $id_struktural);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update Struktural');
			redirect('dashboarda/master/struktural/');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/user/struktural/');
		}
	}


}
?>