<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembimbing extends CI_Controller {

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
        $this->load->model('backend/administrator/master/tesis_model','pembimbing');
        $this->load->model('backend/dosen/master/Dosen_model','dosen');
        
    $this->load->model('backend/administrator/master/departemen_model','departemen');
    $this->load->model('backend/administrator/master/ruang_model','ruang');
    $this->load->model('backend/administrator/master/jam_model','jam');
	//END MODEL
	}

	public function index()
	{
        $username = $this->session_data['username'];
        $data=array(
            // PAGE //
            'title'	=> 'Data Bimbingan Mahasiswa',
            'subtitle'	=> 'Data Pembimbing',
            'section'	=> 'backend/dosen/proposal_tesis/pembimbing',
            // DATA //
            'pembimbing'  => $this->pembimbing->read_bimbingan($username)
        );
        $this->load->view('backend/index_sidebar',$data);	
	}
        
        public function pembimbing2()
	{
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
            $id_skripsi = $this->uri->segment('5');
            
            $data=array(
                // PAGE //
                'title'	=> 'Setting Proposal Tesis (Modul Ketua Program Studi)',
                'subtitle'	=> 'Setting Ujian',
                'section'	=> 'backend/dosen/proposal_tesis/pembimbing2',
                // DATA //
                'proposal'  => $this->pembimbing->detail_proposal($id_skripsi),
                'mruang'    => $this->ruang->read_aktif(),
                'mjam'      => $this->jam->read_aktif(),
                'mdosen'    => $this->dosen->read_aktif_alldep(),
                'ujian'     => $this->pembimbing->read_ujian($id_skripsi),
                'pembimbing'    => $this->pembimbing->read_pembimbing($id_skripsi),
            );
            //var_dump($data['proposal']);
           
                $this->load->view('backend/index_sidebar',$data);	
            
            	
                
        
    }
	
    

    
}
?>