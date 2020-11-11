<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skripsi_diterima extends CI_Controller {

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
    $this->load->model('backend/baa/skripsi/skripsi_diterima_model','skripsi');
	//END MODEL
	}

	public function index()
	{
        $data=array(
        // PAGE //
        'title'		=> 'Skripsi Diterima',
        'subtitle'	=> 'Data Skripsi (Diterima)',
        'section'	=> 'backend/baa/skripsi/skripsi_diterima',
        // DATA //
        'skripsi'  => $this->skripsi->read()
        );

        $this->load->view('backend/index_sidebar',$data);	
    }
    
    public function update_berkas()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
            $id_skripsi = $this->input->post('id_skripsi',TRUE);

            $data = array(
            'berkas_skripsi' => $this->input->post('berkas_skripsi',TRUE),
            );

            $this->skripsi->update($data, $id_skripsi);

            //update selesai pembimbing
            $pembimbing = $this->skripsi->read_pembimbing($id_skripsi);
            $id_pembimbing = $pembimbing->id_pembimbing;
            $datab = array(
                'status_bimbingan' => 3,
                );

            $this->skripsi->update_pembimbing($datab, $id_pembimbing);

            $this->session->set_flashdata('msg-title', 'alert-success');
	        $this->session->set_flashdata('msg', 'Berhasil update berkas');
            redirect('dashboardb/skripsi/skripsi_diterima');
			
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/skripsi/skripsi_diterima');
		}
    }

    public function bimbingan()
    {
        $id = $this->uri->segment(5); 
        $data=array(
        // PAGE //
        'title'		=> 'Modul (Mahasiswa)',
        'subtitle'	=> 'Bimbingan Skripsi',
        'section'	=> 'backend/baa/skripsi/skripsi_diterima_bimbingan',
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