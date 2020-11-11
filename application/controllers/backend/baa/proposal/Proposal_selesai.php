<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal_selesai extends CI_Controller {

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
    $this->load->model('backend/administrator/master/struktural_model','struktural');
    $this->load->model('backend/baa/master/gelombang_model','gelombang');
    $this->load->model('backend/baa/proposal/proposal_selesai_model','proposal');
	//END MODEL
	}

	public function index()
	{
        $data=array(
        // PAGE //
        'title'		=> 'Proposal Selesai',
        'subtitle'	=> 'Data Proposal (Selesai)',
        'section'	=> 'backend/baa/proposal/proposal_selesai',
        // DATA //
        'proposal'  => $this->proposal->read()
        );

        $this->load->view('backend/index_sidebar',$data);	
    }
    
    public function cetak_surat_tugas()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
           $id_skripsi = $this->input->post('id_skripsi',TRUE);
            $id_ujian = $this->input->post('id_ujian',TRUE);

            $data = array(
            'skripsi' => $this->proposal->detail($id_ujian),
            'gelombang'  => $this->proposal->read_gelombangaktif(),
            'penguji_ketua' => $this->proposal->read_pengujiketua($id_ujian),
            'penguji_pembimbing' => $this->proposal->read_pengujipembimbing($id_ujian),
            'penguji_anggota'   => $this->proposal->read_pengujianggota($id_ujian),
            'wadek' => $this->proposal->read_wadek(),
            'judul' => $this->proposal->read_judul($id_skripsi)
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/cetak/proposal_surat_tugas';
		    $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "proposal_surat_tugas.pdf";
            $this->pdf->load_view($page, $data);
			
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/proposal/proposal_diterima');
		}
    }

    public function cetak_undangan()
    {
        $hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_skripsi = $this->input->post('id_skripsi',TRUE);
            
            $data=array(
                'proposal'	=> $this->proposal->detail($id_skripsi),
                'jadwal'=> $this->proposal->read_ujian($id_skripsi),
                'penguji'	=> $this->proposal->read_penguji($id_skripsi),
                'wadek1'	=> $this->struktural->read_wadek1()
            );
            
            $page = 'backend/baa/cetak/proposal_skripsi_undangan';
			$size = 'legal';
			$this->pdf->setPaper($size, 'potrait');
			$this->pdf->filename = "undangan_proposal_skripsi.pdf";
			$this->pdf->load_view($page, $data);	
			

		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/proposal/proposal_diterima');
		}
    }

    public function cetak_berita()
    {
        $hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_skripsi = $this->input->post('id_skripsi',TRUE);
            
            $data=array(
                'proposal'	=> $this->proposal->detail($id_skripsi),
                'jadwal'=> $this->proposal->read_ujian($id_skripsi),
                'penguji'	=> $this->proposal->read_penguji($id_skripsi),
                'wadek1'	=> $this->struktural->read_wadek1(),
                'kps'       => $this->struktural->read_kps(),
                'judul'     => $this->proposal->read_judul($id_skripsi),
            );
            $data['kadep'] = $this->struktural->read_kadep($data['proposal']->id_departemen);
            $page = 'backend/baa/cetak/proposal_skripsi_berita';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "proposal_skripsi_berita.pdf";
            $this->pdf->load_view($page, $data);
			

		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/proposal/proposal_diterima');
		}
    }


}
?>