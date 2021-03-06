<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Profile extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');
			if (!$this->session_data) {
				$this->load->view('backend/incl/sess_dest');
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/user', 'user');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/dosen/modul/Berita_model', 'berita');
		}

		public function index()
		{
			$username = $this->session_data['username'];

			if ($this->session_data['sebagai'] != '3') {
				$biodata = $this->user->read_tendikdosen($username);
			} else {
				$biodata = $this->user->read_mhs($username);
			}
			$data = array(
				// PAGE //
				'title' => 'Profile',
				'subtitle' => 'Pengguna',
				'section' => 'backend/profile/index',
				'biodata' => $biodata,
				// DATA //
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function change_password()
		{
			$username = $this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Profile',
				'subtitle' => 'Ubah Password',
				'section' => 'backend/profile/change_password',
				// DATA //
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function signature()
		{
			$username = $this->session_data['username'];
			$biodata = $this->user->read_tendikdosen($username);
			if (!empty($biodata->ttd)) {
				redirect('/profile/signature/view');
			} else {
				$data = array(
					// PAGE //
					'title' => 'Profile',
					'subtitle' => 'Tanda Tangan',
					'section' => 'backend/profile/signature',
					// DATA //
				);

				$this->load->view('backend/index_sidebar', $data);
			}
		}

		public function signature_change()
		{
			$data = array(
				// PAGE //
				'title' => 'Profile',
				'subtitle' => 'Tanda Tangan',
				'section' => 'backend/profile/signature_change',
				// DATA //
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function signature_view()
		{
			$username = $this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Profile',
				'subtitle' => 'Tanda Tangan',
				'section' => 'backend/profile/signature_view',
				// DATA //
				'biodata' => $this->user->read_tendikdosen($username),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function change_password_save()
		{
			$session_data = $this->session->userdata('logged_in');
			$username = $session_data['username'];

			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$password = $this->user->read_user($username);

				$hsh = $password->password;
				$pass = $this->input->post('password', true);

				if (password_verify($pass, $hsh)) {
					$password_new = $this->input->post('password_new', true);
					$password_new_c = $this->input->post('password_new_c', true);
					if ($password_new == $password_new_c) {
						$options = [
							'cost' => 10,
						];
						$pass_new_update = password_hash($password_new, PASSWORD_DEFAULT, $options);

						$datap = array(
							'password' => $pass_new_update,
							'plain' => $password_new
						);
						$id_user = $session_data['id_user'];
						$this->user->update_p($datap, $id_user);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Ubah password berhasil !');
						redirect('/profile');
					} else if ($password_new != $password_new_c) {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Password baru tidak sama !');
						redirect('/profile');
					}
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Password lama salah !');
					redirect('/profile');
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('profile');
			}
		}

		public function signature_save()
		{
			$session_data = $this->session->userdata('logged_in');
			$username = $session_data['username'];
			try {
				$image_url = $this->input->post('ttd', true);
				$image_path = 'assets/upload/profile/signature/';
				$path = './' . $image_path;
				$filename = $username . '.png';
				$image = str_replace('[removed]', '', $image_url);
				// Upload PNG
				file_put_contents($path . $filename, base64_decode($image));
				// Update Database
				$data_update = [
					'ttd' => base_url() . $image_path . $filename
				];
				$this->user->update_pegawai($data_update, $username);

				$response = [
					'status' => '0',
					'message' => 'Tanda tangan berhasil disimpan'
				];

				$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
					->_display();
				exit;
			} catch (Exception $e) {
				$response = [
					'status' => '1',
					'message' => $e->getMessage()
				];

				$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
					->_display();
				exit;
			}
		}

		public function signature_upload()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$username = $this->session_data['username'];
				$file_name = $username . '.png';
				$upload_path = '/assets/upload/profile/signature/';
				$config['upload_path'] = '.' . $upload_path;
				$config['allowed_types'] = 'png';
				$config['max_size'] = MAX_SIZE_FILE_UPLOAD_IMG;
				$config['remove_spaces'] = true;
				$config['file_ext_tolower'] = true;
				$config['detect_mime'] = true;
				$config['mod_mime_fix'] = true;
				$config['overwrite'] = true;
				$config['file_name'] = $file_name;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$tgl_sekarang = date('Y-m-d');
				if (!$this->upload->do_upload('ttd_image')) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', $this->upload->display_errors());
					redirect_back();
				} else {
					// Update Database
					$data_update = [
						'ttd' => substr(base_url(),0,strlen(base_url())-1) . $upload_path . $file_name
					];
					$this->user->update_pegawai($data_update, $username);
					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'TTD Berhasil di upload');
					redirect('profile/signature/view');
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function phone_save()
		{
			$session_data = $this->session->userdata('logged_in');
			try {
				$id_user = $this->input->post('id_user', true);
				$no_hp = $this->input->post('no_hp', true);
				$datap = array(
					'no_hp' => formatNoHpWhatsapp($no_hp),
				);
				$this->user->update_p($datap, $id_user);
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Ubah no hp berhasil !');
				redirect('/profile');
			} catch (Exception $e) {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('profile');
			}
		}

	}

?>
