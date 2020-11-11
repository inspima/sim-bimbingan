<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembimbing_pengajuan extends CI_Controller {

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
    $this->load->model('backend/dosen/skripsi/Pembimbing_model','pembimbing');
    
	//END MODEL
	}

	public function index()
	{
        $username = $this->session_data['username'];
        $data=array(
            // PAGE //
            'title'	=> 'Skripsi (Pengajuan Pembimbing)',
            'subtitle'	=> 'Skripsi(Pengajuan Pembimbing)',
            'section'	=> 'backend/dosen/skripsi/pembimbing_pengajuan',
            // DATA //
            'pembimbing'  => $this->pembimbing->read_pengajuan($username)
        );
        $this->load->view('backend/index_sidebar',$data);	
	}
	
	public function update_pembimbing()
	{
        $username = $this->session_data['username'];
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_pembimbing = $this->input->post('id_pembimbing',TRUE);
            
            $cektotal = $this->pembimbing->hitung_bimbingan_aktif($username);
            if($cektotal < 10)
            {
                $data = array(
                'status'	=> $this->input->post('status',TRUE),
                'status_bimbingan'	=> 2,
                );
                $this->pembimbing->update_pembimbing($data, $id_pembimbing);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update.');
                redirect('dashboardd/skripsi/pembimbing_pengajuan');
            }
            else
            if($cektotal >= 10)
            {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Bimbingan aktif skripsi sudah mencapai maksimum');
                redirect('dashboardd/skripsi/pembimbing_pengajuan');
            }
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