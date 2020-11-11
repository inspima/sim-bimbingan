<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gelombang extends CI_Controller {

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
	$this->load->model('backend/baa/master/semester_model','semester');
	//END MODEL
	}

	public function index()
	{
		$data=array(
		// PAGE //
		'title'		=> 'Master Gelombang',
		'subtitle'	=> 'Data Gelombang',
		'section'	=> 'backend/baa/master/gelombang',
        // DATA //
		'gelombang'      => $this->gelombang->read(),
		);
		$this->load->view('backend/index_sidebar',$data);	
    }
    
    public function add()
    {
        $data=array(
            // PAGE //
            'title'		=> 'Master Gelombang',
            'subtitle'	=> 'Tambah Data Gelombang',
            'section'	=> 'backend/baa/master/gelombang_add',
			// DATA //
			'semester'	=> $this->semester->read()
            );
        $this->load->view('backend/index_sidebar',$data);	
    }

	public function save()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$data = array(
			'id_semester'	=> $this->input->post('id_semester',TRUE),
			'gelombang'		=> $this->input->post('gelombang',TRUE),
			'no_sk'			=> $this->input->post('no_sk',TRUE),
			'tgl_sk'		=> todb($this->input->post('tgl_sk',TRUE)),
			);
        
			$this->gelombang->save($data);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil disimpan');
			redirect('dashboardb/master/gelombang');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/gelombang');
		}
	}

	public function edit()
	{
		$id = $this->uri->segment(5);
		
		$data=array(
			// PAGE //
			'title'		=> 'Edit Gelombang',
			'subtitle'	=> 'BAA',
			'section'	=> 'backend/baa/master/gelombang_edit',
			// DATA //
			'gelombang'      => $this->gelombang->detail($id),
			'semester'	=> $this->semester->read()
			);
			
		if($data['gelombang'])
        {
            $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $data['section'] = 'backend/notification/danger';
            $data['msg']	 = 'Tidak ditemukan';
            $data['linkback']= 'dashboardb/master/gelombang';
			$this->load->view('backend/index_sidebar',$data);	
		}	
	}

	public function update()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_gelombang = $this->input->post('id_gelombang',TRUE);

			$data = array(
				'id_semester'	=> $this->input->post('id_semester',TRUE),
				'gelombang'		=> $this->input->post('gelombang',TRUE),
				'no_sk'			=> $this->input->post('no_sk',TRUE),
				'tgl_sk'		=> todb($this->input->post('tgl_sk',TRUE)),
			);
        
			$this->gelombang->update($data, $id_gelombang);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update');
			redirect('dashboardb/master/gelombang');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/gelombang');
		}
	}

	public function update_berjalan()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_gelombang = $this->input->post('id_gelombang',TRUE);

			$datas = array(
			'status_berjalan'	=> '0',
			);
			$this->gelombang->update_all($datas);
			
			$data = array(
			'status_berjalan'	=> $this->input->post('status_berjalan',TRUE),
			);
			$this->gelombang->update($data, $id_gelombang);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update');
			redirect('dashboardb/master/gelombang');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/gelombang');
		}
	}

}
?>