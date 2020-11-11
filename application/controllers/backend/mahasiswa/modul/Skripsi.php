<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skripsi extends CI_Controller {

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
		if($this->session_data['sebagai'] != 3 AND $this->session_data['role'] != 0)
		{
			redirect('logout','refresh');
		}
	}
	//END SESS
		
	//START MODEL
    $this->load->model('backend/baa/master/mahasiswa_model','mahasiswa');
    $this->load->model('backend/mahasiswa/modul/skripsi_model','skripsi');
    $this->load->model('backend/administrator/master/departemen_model','departemen');
    $this->load->model('backend/baa/master/gelombang_model','gelombang');
	//END MODEL
	}

	public function index()
	{
		$data=array(
		// PAGE //
		'title'		=> 'Modul (Mahasiswa)',
		'subtitle'	=> 'Skripsi',
		'section'	=> 'backend/mahasiswa/modul/skripsi',
        // DATA //
		//'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
        'skripsi'  => $this->skripsi->read($this->session_data['username']),
        
        );
		$this->load->view('backend/index_sidebar',$data);	
    }
    
    public function syarat()
    {
        $id = $this->uri->segment(5); 
        $data=array(
        // PAGE //
        'title'		=> 'Modul (Mahasiswa)',
        'subtitle'	=> 'Syarat Skripsi',
        'section'	=> 'backend/mahasiswa/modul/skripsi_syarat',
        // DATA //
        'skripsi'  => $this->skripsi->detail($id, $this->session_data['username'])
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
    
    public function syarat_upload()
    {
        $hand = $this->input->post('hand',TRUE);
        
		if($hand == 'center19'){
            $id_skripsi = $this->input->post('id_skripsi',TRUE);

            $config['upload_path']          = './assets/upload/turnitin/';
            $config['allowed_types']        = 'pdf';
            $config['max_size']             = 20000;
            $config['remove_spaces']        = TRUE;
            $config['file_ext_tolower']     = TRUE;
            $config['detect_mime']          = TRUE;
            $config['mod_mime_fix']         = TRUE;
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload('file'))
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            }
            else
            {
                $upload_data= $this->upload->data();
                $file 		= $upload_data['file_name'];

                $data = array(
                'turnitin' 		=> $upload_data['file_name'],
                );                

                $this->skripsi->update($data, $id_skripsi);

                $this->session->set_flashdata('msg-title', 'alert-success');
			    $this->session->set_flashdata('msg', 'Berhasil upload');
                redirect('dashboardm/modul/skripsi');
            }

		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardm/modul/skripsi');
		}
    }

    public function update_toefl()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
            $id_skripsi = $this->input->post('id_skripsi',TRUE);

            $data = array(
                'toefl'	=> $this->input->post('toefl',TRUE),
            );
            $this->skripsi->update($data, $id_skripsi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil update');
            redirect('dashboardm/modul/skripsi');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardm/modul/skripsi');
		}
    }

    public function save_judul()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
            $id_skripsi = $this->input->post('id_skripsi',TRUE);

            $dataj = array(
            'id_skripsi' => $id_skripsi,
            'judul'      => $this->input->post('judul',TRUE)
            );
    
            $this->skripsi->save_judul($dataj);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil update judul');
            redirect('dashboardm/modul/skripsi/bimbingan/'.$id_skripsi);
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardm/modul/skripsi/bimbingan/'.$id_skripsi);
		}
        
    }

    public function bimbingan()
    {
        $id = $this->uri->segment(5); 
        $data=array(
        // PAGE //
        'title'		=> 'Modul (Mahasiswa)',
        'subtitle'	=> 'Bimbingan Skripsi',
        'section'	=> 'backend/mahasiswa/modul/skripsi_bimbingan',
        // DATA //
        'skripsi'  => $this->skripsi->detail($id, $this->session_data['username']),
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

    public function bimbingan_save()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
            $id_skripsi = $this->input->post('id_skripsi',TRUE);
            $data = array(
            'id_skripsi' => $id_skripsi,
            'tanggal'      => todb($this->input->post('tanggal',TRUE)),
            'hal'   => $this->input->post('hal',TRUE)
            );

            $this->skripsi->save_bimbingan($data);

            $this->session->set_flashdata('msg-title', 'alert-success');
	        $this->session->set_flashdata('msg', 'Berhasil simpan.');
            redirect('dashboardm/modul/skripsi/bimbingan/'.$id_skripsi);
			
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardm/modul/skripsi');
		}
    }

    public function bimbingan_delete()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
            $id_skripsi = $this->input->post('id_skripsi',TRUE);
            $id_bimbingan = $this->input->post('id_bimbingan',TRUE);
            $data = array(
            'status' => 3,
            );

            $this->skripsi->update_bimbingan($data, $id_bimbingan);

            $this->session->set_flashdata('msg-title', 'alert-success');
	        $this->session->set_flashdata('msg', 'Berhasil hapus.');
            redirect('dashboardm/modul/skripsi/bimbingan/'.$id_skripsi);
			
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardm/modul/skripsi');
		}
    }

	public function update()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
            $id_skripsi = $this->input->post('id_skripsi',TRUE);
            
            $read_judul = $this->proposal->read_judul($id_skripsi);
            $judul = $this->input->post('judul',TRUE);

            if($judul == $read_judul->judul)
            {
                $data = array(
                    'id_departemen'	=> $this->input->post('id_departemen',TRUE),
                );
                $this->proposal->update($data, $id_skripsi);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('dashboardm/modul/proposal');
            }
            else
            {
                $data = array(
                    'id_departemen'	=> $this->input->post('id_departemen',TRUE),
                );
                $this->proposal->update($data, $id_skripsi);

                $dataj = array(
                    'id_skripsi' => $id_skripsi,
                    'judul'      => $this->input->post('judul',TRUE)
                    );
    
                    $this->proposal->save_judul($dataj);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('dashboardm/modul/proposal');
            }
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardm/modul/proposal');
		}
    }

    public function update_file()
	{
		$hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
            $id_skripsi = $this->input->post('id_skripsi',TRUE);

            $config['upload_path']          = './assets/upload/turnitin/';
            $config['allowed_types']        = 'pdf';
            $config['max_size']             = 20000;
            $config['remove_spaces']        = TRUE;
            $config['file_ext_tolower']     = TRUE;
            $config['detect_mime']          = TRUE;
            $config['mod_mime_fix']         = TRUE;
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload('file'))
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            }
            else
            {
                $upload_data= $this->upload->data();
                $file 		= $upload_data['file_name'];

                $data = array(
                'turnitin' 		=> $upload_data['file_name'],
                );

                $this->skripsi->update($data, $id_skripsi);

                $this->session->set_flashdata('msg-title', 'alert-success');
			    $this->session->set_flashdata('msg', 'Berhasil Upload.');
                redirect('dashboardm/modul/skripsi');
            }
			
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardm/modul/skripsi');
			echo $hand;
		}
    }
    
    

    public function daftar()
    {
        $hand = $this->input->post('hand',TRUE);
        if($hand == 'center19')
        {
            $id_skripsi = $this->input->post('id_skripsi',TRUE);
            date_default_timezone_set('Asia/Jakarta');
            $now = date('Y-m-d H:i:s');
            $data = array(
            'status_skripsi' => 1,
            'tgl_pengajuan' => $now
            );

            $this->skripsi->update($data, $id_skripsi);

            $this->session->set_flashdata('msg-title', 'alert-success');
	        $this->session->set_flashdata('msg', 'Berhasil mengajukan pendaftaran. Tunggu Approve BAA');
            redirect('dashboardm/modul/skripsi');
			
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardm/modul/skripsi');
		}
    }

    public function ujian()
    {
        $id_skripsi = $this->uri->segment(5);
        $username = $this->session_data['username'];

		$data=array(
			// PAGE //
			'title'		=> 'Modul (Mahasiswa)',
            'subtitle'	=> 'Skripsi (Jadwal Ujian)',
			'section'	=> 'backend/mahasiswa/modul/skripsi_ujian',
            // DATA //
			'skripsi'  => $this->skripsi->ujiana($id_skripsi, $username)
            );	
		if($data['skripsi'])
        {
            $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $data['section'] = 'backend/notification/danger';
            $data['msg']	 = 'Tidak ditemukan / belum setting kadep / kps belum approve ';
            $data['linkback']= 'dashboardm/modul/skripsi';
			$this->load->view('backend/index_sidebar',$data);	
		}	
    }
    
    
}
?>