<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('backend/user','user',TRUE);
	}
	
	public function index()
	{
		$session_data = $this->session->userdata('logged_in');

		$data=array(
		// PAGE //
		'title'		=> 'Login',
        'subtitle'	=> '',
        'section'   => 'backend/page/login'
		);
		
		if($session_data)
		{	
			$this->load->view('backend/incl/ifrole');
		}
		else
		{	
			$this->load->view('backend/index_top',$data);
		}
	}
	
	public function auth()
    {
	    $this->form_validation->set_rules('username', 'username ', 'trim|required');
        $this->form_validation->set_rules('password', 'password ', 'trim|required|callback_check_database');
        
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
 
    	if($this->form_validation->run() == TRUE)
		{
		    $this->load->view('backend/incl/ifrole');
		}
		else
		{
			$this->index();
		}
    }
	
	public function check_database($password)
	{
		$username 	= $this->input->post('username');
		$pass 		= $this->input->post('password');
		
		$cekuser = $this->user->login($username);
		//echo $cekuser->username;die();
		
		if($cekuser)
		{
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

			if($result)
			{
				$hsh    = $result->password;
				if (password_verify($pass,$hsh)) 
				{
					$sess_array = array(
					'id_user' => $result->id_user,
					'username' => $result->username,
					'nama' => $result->nama,
					'role' => $result->role,
					'sebagai' => $result->sebagai
					);
					
					$this->session->set_userdata('logged_in', $sess_array);	
					return true;
				}
				else
				{
					$this->form_validation->set_message('check_database', 'Password Salah');
					return false;
				}
			}
			else
			{ 
				$this->form_validation->set_message('check_database', 'Username Tidak Terdaftar');
				return false;
			}
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Username Tidak Terdaftar');
			return false;
		}
	}
	
	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login', 'refresh');
	}
	
	
	function gen()
	{
		$options = [
			'cost' => 10,
		];
		echo password_hash("aplikasi", PASSWORD_DEFAULT, $options)."\n";
	}

	public function utility()
	{
		
	}
	
}