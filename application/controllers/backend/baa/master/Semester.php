<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semester extends CI_Controller {

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
	$this->load->model('backend/baa/master/semester_model','semester');
	//END MODEL
	}

	public function index()
	{
		$data=array(
		// PAGE //
		'title'		=> 'Master Semester',
		'subtitle'	=> 'Data Semester',
		'section'	=> 'backend/baa/master/semester',
        // DATA //
		'semester'      => $this->semester->read(),
		);
		$this->load->view('backend/index_sidebar',$data);	
    }
    
    public function add()
    {
        $data=array(
            // PAGE //
            'title'		=> 'Master Semester',
            'subtitle'	=> 'Tambah Semester',
            'section'	=> 'backend/baa/master/semester_add',
            // DATA //
            );
            $this->load->view('backend/index_sidebar',$data);	
    }

	public function save()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$data = array(
			'semester'	=> $this->input->post('semester',TRUE),
			'status'	=> 1
			);
        
			$this->semester->save($data);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil disimpan');
			redirect('dashboardb/master/semester');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/semester');
		}
	}

	public function edit()
	{
		$id = $this->uri->segment(5);

		$data=array(
			// PAGE //
			'title'		=> 'Master Semester',
			'subtitle'	=> 'Edit Semester',
			'section'	=> 'backend/baa/master/semester_edit',
			// DATA //
			'semester'      => $this->semester->detail($id)
			);
			
		if($data['semester'])
        {
            $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $data['section'] = 'backend/notification/danger';
            $data['msg']	 = 'Tidak ditemukan';
            $data['linkback']= 'dashboarda/master/semester';
			$this->load->view('backend/index_sidebar',$data);	
		}	
	}

	public function update()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_semester = $this->input->post('id_semester',TRUE);

			$data = array(
			'semester'	=> $this->input->post('semester',TRUE),
			);
        
			$this->semester->update($data, $id_semester);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update');
			redirect('dashboardb/master/semester');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/semester');
		}
	}

	public function update_berjalan()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_semester = $this->input->post('id_semester',TRUE);

			$datas = array(
			'berjalan'	=> '0',
			);
			$this->semester->update_all($datas);
			
			$data = array(
			'berjalan'	=> $this->input->post('berjalan',TRUE),
			);
			$this->semester->update($data, $id_semester);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update');
			redirect('dashboardb/master/semester');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/semester');
		}
	}

}
?>