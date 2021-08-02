<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kadep_ditolak extends CI_Controller {

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
	$this->load->model('backend/dosen/proposal/Kadep_ditolak_model','proposal');
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
                'subtitle'	=> 'Data Pengajuan Proposal (Ditolak)',
                'section'	=> 'backend/dosen/proposal/kadep_ditolak',
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
                'subtitle'	=> 'Data Pengajuan Proposal (Ditolak)',
                'section'	=> 'backend/dosen/proposal/kadep_ditolak_detail',
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

    public function update_proses()
    {
        $hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_skripsi = $this->input->post('id_skripsi',TRUE);
			
			$data = array(
            'status_proposal'	=> $this->input->post('status_proposal',TRUE),
            'keterangan_proposal' => $this->input->post('keterangan_proposal',TRUE),
			);
			$this->proposal->update($data, $id_skripsi);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update proses');
			redirect('dashboardd/proposal/kadep_ditolak');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardd/proposal/kadep_ditolak');
		}
    }

    
}
?>
