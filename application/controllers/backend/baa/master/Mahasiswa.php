<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

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
	$this->load->model('backend/baa/master/mahasiswa_model','mahasiswa');
	//END MODEL
	$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
	}

	public function index()
	{
		$data=array(
		// PAGE //
		'title'		=> 'Master Mahasiswa',
		'subtitle'	=> 'Data Mahasiswa',
		'section'	=> 'backend/baa/master/mahasiswa',
        // DATA //
		'mahasiswa'      => $this->mahasiswa->read(),
		);
		$this->load->view('backend/index_sidebar',$data);	
    }
    
    public function add()
    {
        $data=array(
            // PAGE //
            'title'		=> 'Master Mahasiswa',
            'subtitle'	=> 'Tambah Mahasiswa',
            'section'	=> 'backend/baa/master/mahasiswa_add',
            // DATA //
            );
            $this->load->view('backend/index_sidebar',$data);	
    }

	public function save()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){

			$data = array(
            'nim'	=> $this->input->post('nim',TRUE),
			'nama'	=> $this->input->post('nama',TRUE),
			'alamat'	=> $this->input->post('alamat',TRUE),
			'telp'	=> $this->input->post('telp',TRUE),
            'email'	=> $this->input->post('email',TRUE),
			'status'	=> 1
			);
			
			$nim = $data['nim'];
			$mhs = $this->mahasiswa->cek_mahasiswa($nim)->nim;
			
			if($mhs)
			{
				$this->session->set_flashdata('msg-title', 'alert-danger');
    			$this->session->set_flashdata('msg', 'Gagal. NIM sudah ada');
    			redirect('dashboardb/master/mahasiswa');
			}
			else
			{
                $this->mahasiswa->save_mahasiswa($data);
    
                $options = [
    				'cost' => 10,
    			];
    			$passhash = password_hash($this->input->post('password'), PASSWORD_DEFAULT, $options);
                
                $datas = array(
                'username'	=> $this->input->post('nim',TRUE),
                'sebagai'   => 3,
                'role'      => 0,
                'password'	=> $passhash,
                'status'	=> 1
                );
                $this->mahasiswa->save_user($datas);
    
    			$this->session->set_flashdata('msg-title', 'alert-success');
    			$this->session->set_flashdata('msg', 'Berhasil disimpan');
    			redirect('dashboardb/master/mahasiswa');
			}
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/master/mahasiswa');
		}
	}

	public function edit()
	{
		$id = $this->uri->segment(5);

		$data=array(
			// PAGE //
			'title'		=> 'Master Mahasiswa',
			'subtitle'	=> 'Edit Mahasiswa',
			'section'	=> 'backend/baa/master/mahasiswa_edit',
			// DATA //
			'mahasiswa'      => $this->mahasiswa->detail($id)
			);
			
		if($data['mahasiswa'])
        {
            $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $data['section'] = 'backend/notification/danger';
            $data['msg']	 = 'Tidak ditemukan';
            $data['linkback']= 'dashboardb/master/mahasiswa';
			$this->load->view('backend/index_sidebar',$data);	
		}	
	}


	public function update()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			$id_mahasiswa = $this->input->post('id_mahasiswa',TRUE);
            $id_user = $this->input->post('id_user',TRUE);

			$data = array(
                'nim'	=> $this->input->post('nim',TRUE),
                'nama'	=> $this->input->post('nama',TRUE),
				'email'	=> $this->input->post('email',TRUE),
				'alamat'	=> $this->input->post('alamat',TRUE),
				'telp'	=> $this->input->post('telp',TRUE),
            );
            $this->mahasiswa->update_mahasiswa($data, $id_mahasiswa);
            
            $datas = array(
                'username'	=> $this->input->post('nim',TRUE),
            );
            $this->mahasiswa->update_user($datas, $id_user);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update');
			redirect('dashboardb/master/mahasiswa');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/master/mahasiswa');
		}
    }
    
    public function update_password()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
            $id_user = $this->input->post('id_user',TRUE);
            $options = [
				'cost' => 10,
			];
			$passhash = password_hash($this->input->post('password'), PASSWORD_DEFAULT, $options);

            $datas = array(
                'password'	=> $passhash,
            );
            $this->mahasiswa->update_user($datas, $id_user);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update');
			redirect('dashboardb/master/mahasiswa');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/master/mahasiswa');
		}
	}

	public function import()
	{
		$data=array(
            // PAGE //
            'title'		=> 'Master Mahasiswa',
            'subtitle'	=> 'Import Mahasiswa',
            'section'	=> 'backend/baa/master/mahasiswa_import',
            // DATA //
            );
            $this->load->view('backend/index_sidebar',$data);	
	}

	public function download_excel()
    {

		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19')
		{	
			$this->load->view('backend/baa/master/mahasiswa_xls');	
			
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/master/mahasiswa');
		}
	}

	public function import_save()
    {

		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19')
		{	
			$id  = $this->input->post('id_periode');
			$fileName = $_FILES['file']['name'];
		
			$config['upload_path']          = './assets/upload/mahasiswa/';
			$config['allowed_types'] = 'xls';
			$config['max_size'] = 1000;
				
			$this->load->library('upload');
			$this->upload->initialize($config);
		
			if(! $this->upload->do_upload('file') )
			{
				
				echo $this->upload->display_errors();
				die();
			}
			else
			{
				$media = $this->upload->data();
				$inputFileName = './assets/upload/mahasiswa/'.$media['file_name'];
			       
			
				try {
						$inputFileType = IOFactory::identify($inputFileName);
						$objReader = IOFactory::createReader($inputFileType);
						$objPHPExcel = $objReader->load($inputFileName);
					} 
				catch(Exception $e) 
					{
						die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
					}
		
					$sheet = $objPHPExcel->getSheet(0);
					$highestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn();
					
					for ($row = 2; $row <= $highestRow; $row++)
					{                  //  Read a row of data into an array                 
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
														NULL,
														TRUE,
														FALSE);
														
						//Sesuaikan sama nama kolom tabel di database                                
						$data = array(
							"nim"=> '0'.$rowData[0][0],
							"nama"=> $rowData[0][1],
							"alamat"=> $rowData[0][2],
							"telp"=> $rowData[0][3],
							"email"=> $rowData[0][4],
							//"password"=> $rowData[0][5],
							//awalnya '0' aq ubah '1' krn tombol aktifkan tdk bisa
							'status' => 1
						);
						$nim = $data['nim'];
						$mhs = $this->mahasiswa->cek_mahasiswa($nim)->nim;
						
						
						//password nim
					/*	$options = [
				                    'cost' => 10,
			                        ];
			            $passhash = password_hash($this->input->post('password'), PASSWORD_DEFAULT, $options);*/

						//sesuaikan nama dengan nama tabel
						if($mhs)
						{
						    
						}
						else
						{
						$this->mahasiswa->save_mahasiswa($data);
						}
						delete_files($media['file_path']);
					}

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Upload Berhasil');
				redirect('dashboardb/master/mahasiswa');	
			}
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/master/mahasiswa');
		}
	}

	public function aktifkan()
	{
		$hand = $this->input->post('hand',TRUE);
		$id_mahasiswa = $this->input->post('id_mahasiswa',TRUE);

		if($hand == 'center19'){
			$data=array(
				// PAGE //
				'title'		=> 'Master Mahasiswa',
				'subtitle'	=> 'Aktifkan Mahasiswa',
				'section'	=> 'backend/baa/master/mahasiswa_edit_aktif',
				// DATA //
				'mahasiswa'      => $this->mahasiswa->detail_mhs($id_mahasiswa)
				);
				
			if($data['mahasiswa'])
			{
				$this->load->view('backend/index_sidebar',$data);	
			}
			else
			{
				$data['section'] = 'backend/notification/danger';
				$data['msg']	 = 'Tidak ditemukan';
				$data['linkback']= 'dashboardb/master/mahasiswa';
				$this->load->view('backend/index_sidebar',$data);	
			}	
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/master/mahasiswa');
		}
	}
	
	public function aktifkan_save()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19'){
			
			$id_mahasiswa = $this->input->post('id_mahasiswa',TRUE);

			$data = array(
			'alamat'	=> $this->input->post('alamat',TRUE),
			'telp'	=> $this->input->post('telp',TRUE),
            'email'	=> $this->input->post('email',TRUE),
			'status'	=> 1
			);
            $this->mahasiswa->update_mahasiswa($data, $id_mahasiswa);

            $options = [
				'cost' => 10,
			];
			$passhash = password_hash($this->input->post('password'), PASSWORD_DEFAULT, $options);
            
            $datas = array(
            'username'	=> $this->input->post('nim',TRUE),
            'sebagai'   => 3,
            'role'      => 0,
            'password'	=> $passhash,
            'status'	=> 1
            );
            $this->mahasiswa->save_user($datas);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil disimpan');
			redirect('dashboardb/master/mahasiswa');
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboardb/master/mahasiswa');
		}
	}


	

}
?>