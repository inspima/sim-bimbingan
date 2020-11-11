<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skripsi_belum_daftar extends CI_Controller {

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
    $this->load->model('backend/baa/skripsi/Skripsi_belum_daftar_model','skripsi');
    $this->load->model('backend/administrator/master/Departemen_model','departemen');
	//END MODEL
	}

	public function index()
	{
	    $id_departemen = $this->input->get('dept') ?: '';
	    $skripsi = array();
	    if ($id_departemen) {
            $skripsi = $this->skripsi->read_departemen($id_departemen) ?: array();
	    }else {
            $skripsi = $this->skripsi->read();
	    }
        
        $data=array(
            // PAGE //
            'title'		=> 'Skripsi Belum Daftar',
            'subtitle'	=> 'Data Skripsi (Mahasiswa Belum Daftar)',
            'section'	=> 'backend/baa/skripsi/skripsi_belum_daftar',
            // DATA //
            // 'skripsi'  => $this->skripsi->read(),
            'skripsi' => $skripsi,
            'list_departemen' => $this->departemen->read(),
            'id_departemen' => $id_departemen,
        );

        //$data['skripsi'] = $this->skripsi->read($data['departemen_berjalan']->id_departemen);
        $this->load->view('backend/index_sidebar',$data);
    }
    
    /*public function departemen()
    {
        
            $id_departemen = $this->input->post('id_departemen',TRUE);
            $id = $this->input->post('id_departemen',TRUE);
            $data=array(
                // PAGE //
                'title'	=> 'Skripsi Belum Daftar',
                'subtitle'	=> 'Data Skripsi (Mahasiswa Belum Daftar)',
                'section'	=> 'backend/baa/skripsi/skripsi_belum_daftar',
                // DATA //
                'departemen' => $this->departemen->read(),
                'departemen_berjalan' => $this->departemen->detail($id),
                );

                $data['skripsi'] = $this->skripsi->read_departemen($id_departemen);
                $this->load->view('backend/index_sidebar',$data);	
    }*/

}
?>