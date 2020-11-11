<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
		if($this->session_data['sebagai'] != 2 AND $this->session_data['role'] != 1)
		{
			redirect('logout','refresh');
		}
	}
	//END SESS
		
	//START MODEL
	$this->load->model('backend/administrator/master/user_model','user');
	//END MODEL
	}

	public function index()
	{
		$data=array(
		// PAGE //
		'title'		=> 'Master User',
		'subtitle'	=> 'Administrator',
		'section'	=> 'backend/administrator/master/user',
        // DATA //
		'user'      => $this->user->read(),
		);
		$this->load->view('backend/index_sidebar',$data);	
	}

	public function detail()
	{
		$id = $this->uri->segment(5);

		$data=array(
			// PAGE //
			'title'		=> 'Master User',
			'subtitle'	=> 'Administrator',
			'section'	=> 'backend/administrator/master/user_detail',
			// DATA //
			'user'      => $this->user->detail($id)
			);
			
		if($data['user'])
        {
            $this->load->view('backend/index_sidebar',$data);	
        }
        else
        {
            $data['section'] = 'backend/notification/danger';
            $data['msg']	 = 'Tidak ditemukan';
            $data['linkback']= 'dashboarda/master/user';
			$this->load->view('backend/index_sidebar',$data);	
		}	
	
	}

	public function update_password()
	{
		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19')
		{
			$options = [
				'cost' => 10,
			];
			$passhash = password_hash($this->input->post('password'), PASSWORD_DEFAULT, $options);

			$id_user = $this->input->post('id_user', TRUE);
			$data = array(
			'password'	=> $passhash
			);
			
			$this->user->update($data, $id_user);

			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil update Password');
			redirect('dashboarda/master/user/detail/'.$id_user);
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/user/detail/'.$id_user);
		}
	}

	function direct_login()
	{
		$session_data = $this->session->userdata('logged_in');  

		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19')
		{
			$username = $this->input->post('username',TRUE);

			//cek tabel user
			$cekuser = $this->user->direct_login($username);

			//cek sebagai
			if($cekuser->sebagai == '1')//dosen
			{
				$result = $this->user->read_tendikdosen($username);
			}
			else
			if($cekuser->sebagai == '2')//tendik
			{
				$result = $this->user->read_tendikdosen($username);
			}
			else
			if($cekuser->sebagai == '3')//mahasiswa
			{
				$result = $this->user->read_mhs($username);
			}


			$data = array(
				'id_user' => $result->id_user,
				'username' => $result->username,
				'nama' => $result->nama,
				'role' => $result->role,
				'sebagai' => $result->sebagai
			);
			$this->session->set_userdata('logged_in', $data);	
			redirect('login', 'refresh');

		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('dashboarda/master/user');
		}
	}

}
?>