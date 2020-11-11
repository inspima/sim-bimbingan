<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

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
	$this->load->model('backend/baa/modul/berita_model','berita');
	//END MODEL
	}

	public function index()
	{
		$data=array(
		// PAGE //
		'title'		=> 'Modul Berita',
		'subtitle'	=> 'Data Berita',
		'section'	=> 'backend/baa/modul/berita',
        // DATA //
		'berita'      => $this->berita->read(),
		);
		$this->load->view('backend/index_sidebar',$data);	
    }
    
    public function add()
    {
        $data=array(
            // PAGE //
            'title'		=> 'Modul Berita',
            'subtitle'	=> 'Tambah Berita',
            'section'	=> 'backend/baa/modul/berita_add',
            // DATA //
            'kategori'	=> $this->berita->read_kategori()
            );
            $this->load->view('backend/index_sidebar',$data);	
    }

	public function save()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
            date_default_timezone_set("Asia/Jakarta");
			$date = new DateTime("now");	
			$curr_date = $date->format('Y-m-d H:i:s');

			$data = array(
            'isi_berita'	=> $this->input->post('isi_berita',TRUE),
			'tanggal_berita'	=> $curr_date,
			'status'	=> 1
			);
            $this->berita->save($data);

            $id_berita = $this->db->insert_id() ;
            $id_kategori = $this->input->post('id_kategori');

            foreach ($id_kategori as $list){
                $datas = array(
                'id_berita'		=> $id_berita,
                'id_kategori'	=> $list,
                );
                $ada = $this->berita->cekpostkategori($datas);
                if($ada)
                {
                    if($ada->status == '0')
                    {
                        $datasub = array(
                        'id_berita_detail'	=> $ada->id_berita_detail,
                        'status'		=> 1
                        );
                        $this->berita->updatepostkategori($datasub);
                    }
                    else
                    if($ada->status == '1')
                    {
    
                    }
                }
                else
                {
                    $datasuba = array(
                        'id_berita'		=> $id_berita,
                        'id_kategori'	=> $list,
                        'status'		=> 1
                        );
                        $this->berita->savepostkategori($datasuba);
                }
            }

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil disimpan');
			redirect('dashboardb/modul/berita');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/modul/berita');
		}
	}

	public function edit()
	{
		$id = $this->uri->segment(5);

		$data=array(
			// PAGE //
			'title'		=> 'Modul Berita',
			'subtitle'	=> 'Edit Berita',
			'section'	=> 'backend/baa/modul/berita_edit',
			// DATA //
			'berita_kategori' => $this->berita->berita_kategori($id),
            'berita'	=> $this->berita->detail($id),
            'kategori'	=> $this->berita->read_kategori()
			);
			
		if($data['berita'])
        {
            $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $data['section'] = 'backend/notification/danger';
            $data['msg']	 = 'Tidak ditemukan';
            $data['linkback']= 'dashboarda/modul/berita';
			$this->load->view('backend/index_sidebar',$data);	
		}	
	}

	public function update()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
            
            $id_berita = $this->input->post('id_berita',TRUE);
			$id = $this->input->post('id_berita',TRUE);
			$data = array(
			'id_berita'		=> $this->input->post('id_berita',TRUE),
        	'isi_berita' => $this->input->post('isi_berita',TRUE),
        	);
        	$this->berita->update($data);

        	$id_kategori = $this->input->post('id_kategori');

        	$this->berita->delete_post_kategori($id_berita, $id_kategori);
			
			foreach ($id_kategori as $list)
			{
			    $datas = array(
				'id_berita'		=> $id_berita,
			    'id_kategori'	=> $list,
			    );
			    $ada = $this->berita->cekpostkategori($datas);
         
                if($ada)
                {
                    if($ada->status == '0')
                    {
                        $datasub = array(
                        'id_berita_detail'	=> $ada->id_berita_detail,
                        'status'		=> 1
                        );
                        $this->berita->updatepostkategori($datasub);
                    }
                    else
                    if($ada->status == '1')
                    {

                    }
                }
                else
                {
                    $datasuba = array(
                        'id_berita'		=> $id_berita,
                        'id_kategori'	=> $list,
                        'status'		=> 1
                        );
                        $this->berita->savepostkategori($datasuba);
                }
	        }

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update');
			redirect('dashboardb/modul/berita');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/modul/berita');
		}
    }
    
    public function update_status()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
                        
            $data = array(
                'id_berita' => $this->input->post('id_berita',TRUE),
                'status'	=> $this->input->post('status',TRUE),
            );
            $this->berita->update($data);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update');
			redirect('dashboardb/modul/berita');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/modul/berita');
		}
	}

	

}
?>