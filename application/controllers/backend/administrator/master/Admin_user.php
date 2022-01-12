<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Admin_user extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != 1) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/user');
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/master/prodi');
			$this->load->model('backend/utility/notification', 'notifikasi');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Master User',
				'subtitle' => 'Administrator',
				'section' => 'backend/administrator/master/user',
				// DATA //
				'user' => $this->user->read(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function add_pegawai()
		{

			$data = array(
				// PAGE //
				'title' => 'Master User - Tambah Pegawai',
				'subtitle' => 'Administrator',
				'section' => 'backend/administrator/master/user_add_pegawai',
				'use_back' => true,
				'back_link' => 'dashboarda/master/user',
				'jenjang' => $this->prodi->read_jenjang(),
				'prodis' => $this->prodi->read_all_prodi(),
				// DATA //
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function add_dosen()
		{

			$data = array(
				// PAGE //
				'title' => 'Master User - Tambah Dosen',
				'subtitle' => 'Administrator',
				'section' => 'backend/administrator/master/user_add_dosen',
				'use_back' => true,
				'back_link' => 'dashboarda/master/user',
				// DATA //
				'departemen' => $this->departemen->read(),
				'jenjang' => $this->prodi->read_jenjang(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function edit_pegawai($id_user, $id_pegawai)
		{
			$data = array(
				// PAGE //
				'title' => 'Master User - Edit Pegawai',
				'subtitle' => 'Administrator',
				'section' => 'backend/administrator/master/edit_pegawai',
				'use_back' => true,
				'back_link' => 'dashboarda/master/user',
				'id_user' => $id_user,
				'id_pegawai' => $id_pegawai,
				'pegawai' => $this->user->detail_pegawai($id_pegawai),
				'jenjang' => $this->prodi->read_jenjang(),
				'prodis' => $this->prodi->read_all_prodi(),
				// DATA //
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function edit_nip($id_user, $id_pegawai)
		{
			$data = array(
				// PAGE //
				'title' => 'Master User - Edit Pegawai',
				'subtitle' => 'Administrator',
				'section' => 'backend/administrator/master/user_edit_nip',
				'use_back' => true,
				'back_link' => 'dashboarda/master/user',
				'id_user' => $id_user,
				'id_pegawai' => $id_pegawai,
				'pegawai' => $this->user->detail_pegawai($id_pegawai),
				// DATA //
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function save_pegawai()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$password = 'iurisfh';
				$password_hash = password_hash($password, PASSWORD_BCRYPT);
				$id_prodi = $this->input->post('id_prodi', true);
				$id_jenjang = '';
				if (!empty($id_prodi)) {
					$prodi = $this->prodi->detail($id_prodi);
					$id_jenjang = $prodi->id_jenjang;
				}
				$data_user = [
					'sebagai' => '2',
					'password' => $password_hash,
					'username' => $this->input->post('nip', true),
					'no_hp' => $this->input->post('no_hp', true),
					'role' => $this->input->post('role', true),
					'status' => '1',
					'verifikasi' => '1',
				];
				$this->user->create($data_user);

				$data_pegawai = [
					'id_departemen' => '0',
					'jenis_pegawai' => '2',
					'id_jenjang' => $id_jenjang,
					'id_prodi' => $id_prodi,
					'status' => '1',
					'status_berjalan' => '1',
					'nip' => $this->input->post('nip', true),
					'nama' => $this->input->post('nama', true),
					'email' => $this->input->post('email', true),
				];

				$this->user->create_pegawai($data_pegawai);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil disimpan');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function save_dosen()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$password = 'iurisfh';
				$external = $this->input->post('external', true);
				$password_hash = password_hash($password, PASSWORD_BCRYPT);
				$data_user = [
					'sebagai' => '1',
					'password' => $password_hash,
					'username' => $this->input->post('nip', true),
					'no_hp' => $this->input->post('no_hp', true),
					'role' => '0',
					'status' => '1',
					'verifikasi' => '1',
				];
				$this->user->create($data_user);

				$data_pegawai = [
					'id_departemen' => $this->input->post('id_departemen', true),
					'jenis_pegawai' => '1',
					'id_jenjang' => $this->input->post('id_jenjang', true),
					'status' => '1',
					'status_berjalan' => '1',
					'external' => !empty($external) ? $external : "0",
					'nip' => $this->input->post('nip', true),
					'nama' => $this->input->post('nama', true),
					'email' => $this->input->post('email', true),
				];

				$this->user->create_pegawai($data_pegawai);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil disimpan');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_pegawai()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_user = $this->input->post('id_user', true);
				$id_pegawai = $this->input->post('id_pegawai', true);
				$id_prodi = $this->input->post('id_prodi', true);
				$id_jenjang = '';
				if (!empty($id_prodi)) {
					$prodi = $this->prodi->detail($id_prodi);
					$id_jenjang = $prodi->id_jenjang;
				}
				$data_user = [
					'no_hp' => $this->input->post('no_hp', true),
					'role' => $this->input->post('role', true),
				];
				$this->user->update_user($data_user, $id_user);

				$data_pegawai = [
					'id_jenjang' => $id_jenjang,
					'id_prodi' => $id_prodi,
					'nama' => $this->input->post('nama', true),
					'email' => $this->input->post('email', true),
				];

				$this->user->update_pegawai_by_id($data_pegawai, $id_pegawai);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Data berhasil diperbarui');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function detail()
		{
			$id = $this->uri->segment(5);

			$data = array(
				// PAGE //
				'title' => 'Master User',
				'subtitle' => 'Administrator',
				'section' => 'backend/administrator/master/user_detail',
				// DATA //
				'user' => $this->user->detail($id)
			);

			if ($data['user']) {
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$data['section'] = 'backend/notification/danger';
				$data['msg'] = 'Tidak ditemukan';
				$data['linkback'] = 'dashboarda/master/user';
				$this->load->view('backend/index_sidebar', $data);
			}
		}

		public function update_nip()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_pegawai = $this->input->post('id_pegawai', true);
				$pegawai = $this->user->detail_pegawai($id_pegawai);
				$nip_lama = $pegawai->nip;
				$nip_baru = $this->input->post('nip', true);
				if ($nip_lama != $nip_baru) {
					$this->db->trans_begin();
					if ($pegawai->sebagai == '1') {
						// Update Dosen
						//Query Update User
						$query_update_user = "update user set username='{$nip_baru}' where username='{$nip_lama}'";
						// echo $query_update_user.'<br/>';
						$this->db->query($query_update_user);
						// Update Pegawai
						$query_update_pegawai = "update pegawai set nip='{$nip_baru}' where nip='{$nip_lama}'";
						// echo $query_update_pegawai.'<br/>';
						$this->db->query($query_update_pegawai);
						// Update Pembimbing
						$query_update_pembimbing = "update pembimbing set nip='{$nip_baru}' where nip='{$nip_lama}'";
						// echo $query_update_pembimbing.'<br/>';
						$this->db->query($query_update_pembimbing);
						// Update Promotor
						$query_update_promotor = "update promotor set nip='{$nip_baru}' where nip='{$nip_lama}'";
						// echo $query_update_promotor.'<br/>';
						$this->db->query($query_update_promotor);
						// Update Tesis Pembimbing 1
						$query_update_pembimbing_tesis1 = "update tesis set nip_pembimbing_satu='{$nip_baru}' where nip_pembimbing_satu='{$nip_lama}'";
						// echo $query_update_pembimbing_tesis1.'<br/>';
						$this->db->query($query_update_pembimbing_tesis1);
						// Update Tesis Pembimbing 2
						$query_update_pembimbing_tesis2 = "update tesis set nip_pembimbing_dua='{$nip_baru}' where nip_pembimbing_dua='{$nip_lama}'";
						// echo $query_update_pembimbing_tesis2.'<br/>';
						$this->db->query($query_update_pembimbing_tesis2);
						// Update Penasehat
						$query_update_penasehat = "update disertasi set nip_penasehat='{$nip_baru}' where nip_penasehat='{$nip_lama}'";
						// echo $query_update_penasehat.'<br/>';
						$this->db->query($query_update_penasehat);
						// Update Penguji S1
						$query_update_penguji = "update penguji set nip='{$nip_baru}' where nip='{$nip_lama}'";
						// echo $query_update_penguji.'<br/>';
						$this->db->query($query_update_penguji);
						// Update Penguji S2
						$query_update_penguji2 = "update penguji_tesis set nip='{$nip_baru}' where nip='{$nip_lama}'";
						// echo $query_update_penguji2.'<br/>';
						$this->db->query($query_update_penguji2);
						// Update Penguji S3
						$query_update_penguji3 = "update penguji_disertasi set nip='{$nip_baru}' where nip='{$nip_lama}'";
						// echo $query_update_penguji3.'<br/>';
						$this->db->query($query_update_penguji3);
						// Update MKPT TESIS
						$query_update_tesis_mkpt = "update tesis_mkpt_pengampu set nip='{$nip_baru}' where nip='{$nip_lama}'";
						// echo $query_update_tesis_mkpt.'<br/>';
						$this->db->query($query_update_tesis_mkpt);
						// Update MKPKK
						$query_update_mkpkk = "update mkpkk_pengampu set nip='{$nip_baru}' where nip='{$nip_lama}'";
						// echo $query_update_mkpkk.'<br/>';
						$this->db->query($query_update_mkpkk);
						// Update Dokumen Persetujuan
						$query_update_dokumen_persetujuan = "update dokumen_persetujuan set identitas='{$nip_baru}' where identitas='{$nip_lama}'";
						//echo $query_update_dokumen_persetujuan.'<br/>';
						$this->db->query($query_update_dokumen_persetujuan);
					} else if ($pegawai->sebagai == '2') {
						// Update Tendik
						//Query Update User
						$query_update_user = "update user set username='{$nip_baru}' where username='{$nip_lama}'";
						//echo $query_update_user.'<br/>';
						$this->db->query($query_update_user);
						// Update Pegawai
						$query_update_pegawai = "update pegawai set nip='{$nip_baru}' where nip='{$nip_lama}'";
						//echo $query_update_pegawai.'<br/>';
						$this->db->query($query_update_pegawai);
					}

					if ($this->db->trans_status() === false) {
						$this->db->trans_rollback();
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Query gagal');
						redirect_back();
					} else {
						$this->db->trans_commit();
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil update');
						redirect_back();
					}
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Tidak ada perubahan data');
					redirect_back();
				}

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboarda/master/dosen');
			}
		}


		public function update_password()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$options = [
					'cost' => 10,
				];
				$passhash = password_hash($this->input->post('password'), PASSWORD_DEFAULT, $options);

				$id_user = $this->input->post('id_user', true);
				$data = array(
					'password' => $passhash
				);

				$this->user->update_user($data, $id_user);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update Password');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function reset_verifikasi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_user = $this->input->post('id_user', true);
				$username = $this->input->post('username', true);

				$data = array(
					'verifikasi' => '0'
				);
				$this->user->update_user($data, $id_user);

				// Kirim Whatsapp
				$judul_notifikasi = 'Verifikasi Ulang';
				$isi_notifikasi = 'Terdapat kesalahan data silahkan logout kemudian login kembali lalu isi ulang data pada menu verifikasi';
				$this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 2, $username);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil reset verifikasi');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		function direct_login()
		{
			$session_data = $this->session->userdata('logged_in');

			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$username = $this->input->post('username', true);

				//cek tabel user
				$cekuser = $this->user->login($username);

				//cek sebagai
				if ($cekuser->sebagai == '1') {//dosen
					$result = $this->user->read_tendikdosen($username);
				} else if ($cekuser->sebagai == '2') {//tendik
					$result = $this->user->read_tendikdosen($username);
				} else if ($cekuser->sebagai == '3') {//mahasiswa
					$result = $this->user->read_mhs($username);
				}

				if ($cekuser->sebagai == '3') {
					$data = array(
						'id_user' => $result->id_user,
						'username' => $result->username,
						'id_jenjang' => $result->id_jenjang,
						'id_prodi' => $result->id_prodi,
						'nama' => $result->nama,
						'role' => $result->role,
						'sebagai' => $result->sebagai,
						'email' => $result->email,
						'verifikasi' => $result->verifikasi
					);
				} else {
					$data = array(
						'id_user' => $result->id_user,
						'username' => $result->username,
						'id_jenjang' => $result->id_jenjang,
						'id_prodi' => $result->id_prodi,
						'nama' => $result->nama,
						'role' => $result->role,
						'sebagai' => $result->sebagai,
						'email' => $result->email,
					);
				}

				$this->session->set_userdata('logged_in', $data);
				redirect('login', 'refresh');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboarda/master/user');
			}
		}

	}

?>
