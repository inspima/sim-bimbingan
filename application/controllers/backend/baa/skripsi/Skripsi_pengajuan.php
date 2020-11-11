<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skripsi_pengajuan extends CI_Controller {

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
    $this->load->model('backend/baa/skripsi/skripsi_pengajuan_model','skripsi');
	//END MODEL
	}

	public function index()
	{
        $data=array(
        // PAGE //
        'title'		=> 'Skripsi Pengajuan',
        'subtitle'	=> 'Data Skripsi (Pengajuan)',
        'section'	=> 'backend/baa/skripsi/skripsi_pengajuan',
        // DATA //
        'skripsi'  => $this->skripsi->read()
        );

        $this->load->view('backend/index_sidebar',$data);	
    }
    
    public function approve()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
            $id_skripsi = $this->input->post('id_skripsi',TRUE);
            $gelombang_aktif = $this->gelombang->read_berjalan();

            $data = array(
            'status_skripsi' => 2,
            'id_gelombang'  => $gelombang_aktif->id_gelombang
            );

            $this->skripsi->update($data, $id_skripsi);

            $this->session->set_flashdata('msg-title', 'alert-success');
	        $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect('dashboardb/skripsi/skripsi_pengajuan');
			
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/skripsi/skripsi_pengajuan');
		}
    }

    public function bimbingan()
    {
        $id = $this->uri->segment(5); 
        $data=array(
        // PAGE //
        'title'		=> 'Modul (Mahasiswa)',
        'subtitle'	=> 'Bimbingan Skripsi',
        'section'	=> 'backend/baa/skripsi/skripsi_pengajuan_bimbingan',
        // DATA //
        'skripsi'  => $this->skripsi->detail($id),
        'bimbingan'=> $this->skripsi->read_bimbingan($id)
        );

        if($data['skripsi'])
        {
            $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $data['section'] = 'backend/notification/danger';
            $data['msg']	 = 'Tidak ditemukan';
            $data['linkback']= 'dashboardm/modul/skripsi';
            $this->load->view('backend/index_sidebar',$data);	
        }		
    }

}
?>