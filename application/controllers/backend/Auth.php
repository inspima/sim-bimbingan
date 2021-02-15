<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Auth extends CI_Controller
	{

		private $captcha_config;

		function __construct()
		{
			parent::__construct();
			$this->captcha_config = array(
				'img_url' => base_url() . 'assets/captcha/',
				'img_path' => 'assets/captcha/',
				'word_length' => 4,
				'img_width' => '100',
				'font_size' => 12
			);
			$this->load->model('backend/user', 'user', true);
			$this->load->model('backend/master/prodi', 'prodi', true);
			$this->load->model('backend/utility/email', 'email_model', true);
			$this->load->model('backend/mahasiswa/master/Biodata_model', 'biodata');
			$this->load->library('session', 'session');
			$this->load->helper('string');
		}

		public function register()
		{
			if ($this->input->post('_token')) {
				$email = $this->input->post('email');
				$nama = $this->input->post('nama');
				$nim = $this->input->post('nim');
				$id_prodi = $this->input->post('prodi');
				$sks = $this->input->post('sks');
				$no_hp = $this->input->post('no_hp');
				$captcha_insert = $this->input->post('captcha');
				$password = random_string('alnum', 6);
				$password_hash = password_hash($password, PASSWORD_BCRYPT);
				$contain_sess_captcha = $this->session->userdata('captcha_code');
				if ($captcha_insert == $contain_sess_captcha) {
					$prodi = $this->prodi->detail($id_prodi);
					$role = 0;
					// SET ROLE
					$data_user = [
						'username' => $nim,
						'password' => $password_hash,
						'sebagai' => 3,
						'role' => $role,
						'no_hp' => formatNoHpWhatsapp($no_hp),
						'status' => 1,
						'verifikasi' => 0
					];
					$data_mahasiswa = [
						'nim' => $nim,
						'nama' => $nama,
						'telp' => '',
						'email' => $email,
						'status' => 1,
						'sks' => $sks,
						'id_jenjang' => $prodi->id_jenjang,
						'id_prodi' => $id_prodi,
					];
					// Cek Mahasiswa sudah ada
					$cek_mhs = $this->user->read_mhs($nim);
					if (!empty($cek_mhs)) {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Data mahasiswa sudah ada');
					} else {
						// Insert User
						$this->user->create($data_user);
						// Insert Mahasiswa Mahasiswa
						$this->user->create_mahasiswa($data_mahasiswa);
						// Kirim Email
						$this->email_model->send_registration($email, $nim, $password);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Registrasi berhasil, silahkan cek email untuk informasi akun.');
					}
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Kode verifikasi tidak sesuai');
				}
			}
			$captcha_num1 = rand(1, 5);
			$captcha_num2 = rand(6, 9);
			$captcha = $captcha_num1 * $captcha_num2;
			$data = array(
				// PAGE //
				'title' => 'Registrasi',
				'subtitle' => '',
				'section' => 'backend/page/register',
				'prodis' => $this->prodi->read_all_prodi(),
				'captcha_num1' => $captcha_num1,
				'captcha_num2' => $captcha_num2,
			);
			$this->session->unset_userdata('captcha_code');
			$this->session->set_userdata('captcha_code', $captcha);
			$this->load->view('backend/index_top', $data);
		}

		public function verifikasi()
		{
			$this->session_data = $this->session->userdata('logged_in');
			if ($this->input->post('_token')) {
				$file_name = $this->session_data['username'] . '_berkas_verifikasi.pdf';
				$config['upload_path'] = './assets/upload/mahasiswa/verifikasi';
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = 1000;
				$config['remove_spaces'] = true;
				$config['file_ext_tolower'] = true;
				$config['detect_mime'] = true;
				$config['mod_mime_fix'] = true;
				$config['file_name'] = $file_name;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$id_user = $this->input->post('id_user', true);
				$id_mhs = $this->input->post('id_mhs', true);
				$nama = $this->input->post('nama', true);
				$alamat = $this->input->post('alamat', true);
				$telp = $this->input->post('telp', true);
				$no_hp = $this->input->post('no_hp', true);


				if (!$this->upload->do_upload('berkas_verifikasi')) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', $this->upload->display_errors());
					redirect('auth/verifikasi');
				} else {
					$data_user = [
						'no_hp' => formatNoHpWhatsapp($no_hp),
					];
					$data_mahasiswa = [
						'nama' => $nama,
						'telp' => $telp,
						'alamat' => $alamat,
						'berkas_verifikasi' => $file_name,
					];
					$this->user->update_p($data_user, $id_user);
					// Update Mahasiswa
					$this->user->update_mahasiswa($data_mahasiswa, $id_mhs);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Data berhasil disimpan. Kami akan mengirimkan email setelah proses verifikasi selesai');
					redirect('auth/verifikasi');
				}
			}
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Mahasiswa',
				'subtitle' => 'Verifikasi',
				'section' => 'backend/mahasiswa/verifikasi',
				'biodata' => $this->biodata->detail($username),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function captcha_refresh()
		{
			$captcha = create_captcha($this->captcha_config);
			$this->session->unset_userdata('captcha_code');
			$this->session->set_userdata('captcha_code', $captcha['word']);
			echo $captcha['image'];
		}

	}
