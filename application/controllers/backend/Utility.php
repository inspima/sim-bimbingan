<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	//START SESS
	$this->session_data = $this->session->userdata('logged_in');
	if(!$this->session_data)
	{		
		$this->load->view('backend/incl/sess_dest');
	}
	//END SESS
		
	//START MODEL
	$this->load->model('backend/user','user');
	}

	public function index()
	{
		$username = $this->session_data['username'];

		$data=array(
		// PAGE //
		'title'	=> 'Utility',
		'subtitle'	=> 'Ubah Password',
		'section'	=> 'backend/utility',
		// DATA //
		);
			
		$this->load->view('backend/index_sidebar',$data);	
	}

	public function change_password()
	{
		$session_data = $this->session->userdata('logged_in');
		$username = $session_data['username'];

		$hand = $this->input->post('hand',TRUE);
		if($hand == 'center19')
		{	
            $password = $this->user->read_user($username);
            
			$hsh    = $password->password;
			$pass = $this->input->post('password',TRUE);
			
			if (password_verify($pass,$hsh)) 
			{
				$password_new = $this->input->post('password_new',TRUE);
				$password_new_c = $this->input->post('password_new_c',TRUE);
				if($password_new == $password_new_c)
				{
					$options = [
						'cost' => 10,
					];
					$pass_new_update = password_hash($password_new, PASSWORD_DEFAULT, $options);

					$datap = array(
						
                        'password'	=> $pass_new_update,
                        'plain'     => $password_new
                        ); 
                        $id_user	= $session_data['id_user'];
					$this->user->update_p($datap, $id_user);
					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Ubah password berhasil !');
					redirect('/utility');
				}
				else
				if($password_new != $password_new_c)
				{
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Password baru tidak sama !');
					redirect('/utility');
				}
			}
			else
			{
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Password lama salah !');
				redirect('/utility');
			}
			
		}
		else
		{
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect('utility');
		}
	}

}
?>