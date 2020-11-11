<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjadwalan extends CI_Controller {

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
    $this->load->model('backend/administrator/master/tesis_model','proposal');
    $this->load->model('backend/administrator/master/ruang_model','ruang');
    $this->load->model('backend/administrator/master/jam_model','jam');
    $this->load->model('backend/dosen/master/Dosen_model','dosen');
	//END MODEL
	}

	public function index()
	{
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        var_dump ($id_prodi);
        if($struktural->id_struktur == '8') //KPS S2
            
        {

            $data=array(
                // PAGE //
                'title'	=> 'Pengajuan Proposal Tesis (Modul Sekertaris Prodi)',
                'subtitle'	=> 'Data Pengajuan Proposal Tesis',
                'section'	=> 'backend/dosen/proposal_tesis/penjadwalan',
                // DATA //
                'proposal'  => $this->proposal->read_proposal_acc($id_prodi)
                );
                //print_r($data['proposal']);die();
                $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardd');
        }
    }
    
    public function detail()
    {
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
        if($struktural->id_struktur == '8') //KPS S2
        {
            $id_skripsi = $this->uri->segment('5');
            
            $data=array(
                // PAGE //
                'title'	=> 'Setting Proposal Tesis (Modul Ketua Program Studi)',
                'subtitle'	=> 'Setting Ujian',
                'section'	=> 'backend/dosen/proposal_tesis/detail',
                // DATA //
                'proposal'  => $this->proposal->detail_proposal($id_skripsi),
                'mruang'    => $this->ruang->read_aktif(),
                'mjam'      => $this->jam->read_aktif(),
                'mdosen'    => $this->dosen->read_aktif_alldep(),
                'ujian'     => $this->proposal->read_ujian($id_skripsi),
                'pembimbing'    => $this->proposal->read_pembimbing($id_skripsi),
            );
            if($data['proposal'])
            {
                $this->load->view('backend/index_sidebar',$data);	
            }
            else
            {
                $data['section'] = 'backend/notification/danger';
                $data['msg']	 = 'Tidak ditemukan';
                $data['linkback']= 'dashboardd/proposal_tesis/penjadwalan';
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