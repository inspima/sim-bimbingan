<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller {

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
	$this->load->model('backend/administrator/master/ruang_model','ruang');
	$this->load->model('backend/administrator/master/jam_model','jam');
	$this->load->model('backend/baa/monitoring/jadwal_model','jadwal');
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
                'title'		=> 'Modul',
                'subtitle'	=> 'Jadwal',
                
                'section'	=> 'backend/dosen/monitoring/jadwal',
                'boxtitle'	=> 'Jadwal',
                // DATA	
                //'jadwal'	=> $this->jadwal->read_all(),
                'ruang'		=> $this->ruang->read_ujian(),
                'jam'		=> $this->jam->read()
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

	public function show()
	{
        $session_data = $this->session->userdata('logged_in');
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
        if($struktural->id_struktur == '5')
        {
            $session_data = $this->session->userdata('logged_in');
            //$tanggal = todb($this->input->post('tanggal',TRUE));
            //echo $tanggal;die();
            $data=array(
                // PAGE //
                'title'		=> 'Modul',
                'subtitle'	=> 'Jadwal',
                'section'	=> 'backend/dosen/monitoring/jadwal_tanggal',
                'boxtitle'	=> 'Jadwal',
                // DATA	
                //'jadwal'	=> $this->jadwal->read_tanggal($tanggal),
                'ruang'		=> $this->ruang->read_ujian(),
                'jam'		=> $this->jam->read(),
                'tanggal'	=> todb($this->input->post('tanggal',TRUE))
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