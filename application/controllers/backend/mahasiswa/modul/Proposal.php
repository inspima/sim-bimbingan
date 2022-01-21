<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Proposal extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 3 and $this->session_data['role'] != 0) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/user', 'user');
			$this->load->model('backend/master/pekan_model', 'pekan');
			$this->load->model('backend/transaksi/skripsi', 'skripsi');
			$this->load->model('backend/transaksi/revisi_skripsi', 'revisi_skripsi');
			$this->load->model('backend/baa/master/mahasiswa_model', 'mahasiswa');
			$this->load->model('backend/mahasiswa/modul/proposal_model', 'proposal');
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/utility/notification', 'notifikasi');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Modul (Mahasiswa)',
				'subtitle' => 'Proposal Skripsi',
				'section' => 'backend/mahasiswa/modul/proposal',
				// DATA //
				//'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
				'proposal' => $this->proposal->read($this->session_data['username'])
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function add()
		{
			$read_aktif = $this->proposal->read_aktif($this->session_data['username']);
			$read_aktif_pekan = $this->pekan->read_aktif_skripsi();

			if (!empty($read_aktif)) {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Masih ada Proposal aktif');
				redirect('dashboardm/modul/proposal');
			} else if (empty($read_aktif_pekan)) {
				$data = array(
					'title' => 'Modul (Mahasiswa)',
					'subtitle' => 'Pengajuan Proposal Skripsi',
					'section' => 'backend/notification/error',
					'use_back' => true,
					'back_link' => 'dashboardm/modul/proposal',
					// DATA //
					'message_title' => 'Data Kosong',
					'message' => 'Tidak ada pekan skripsi aktif, silahkan hubungi BAA',
				);
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$data = array(
					// PAGE //
					'title' => 'Modul (Mahasiswa)',
					'subtitle' => 'Pengajuan Proposal Skripsi',
					'section' => 'backend/mahasiswa/modul/proposal_add',
					// DATA //
					'pekan' => $read_aktif_pekan[0],
					'departemen' => $this->departemen->read(),
					'gelombang' => $this->gelombang->read_berjalan()
				);
				$this->load->view('backend/index_sidebar', $data);
			}
		}

		public function save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$config['upload_path'] = './assets/upload/proposal/';
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = 20000;
				$config['remove_spaces'] = true;
				$config['file_ext_tolower'] = true;
				$config['detect_mime'] = true;
				$config['mod_mime_fix'] = true;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$id_departemen = $this->input->post('id_departemen', true);

				if (!$this->upload->do_upload('berkas_proposal')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', $error['error']);
					redirect('dashboardm/modul/proposal');
				} else {
					$upload_data = $this->upload->data();
					$file = $upload_data['file_name'];

					date_default_timezone_set('Asia/Jakarta');
					$now = date('Y-m-d H:i:s');

					$data = array(
						'id_departemen' => $id_departemen,
						'id_gelombang' => $this->input->post('id_gelombang', true),
						'jenis' => 1,
						'nim' => $this->session_data['username'],
						'tgl_pengajuan' => $now,
						'berkas_proposal' => $upload_data['file_name'],
						'status_proposal' => 1
					);
					$this->proposal->save($data);
					$last_id = $this->db->insert_id();

					$dataj = array(
						'id_skripsi' => $last_id,
						'judul' => $this->input->post('judul', true)
					);
					$this->proposal->save_judul($dataj);

					$data_pekan = [
						'id_skripsi' => $last_id,
						'id_pekan' => $this->input->post('id_pekan', true),
						'status' => 1,
					];
					$this->pekan->save_skripsi($data_pekan);

					// Kirim Notifikasi
					$id_struktural = '';
					switch ($id_departemen) {
						case 1:
							$id_struktural = 1;
							break;
						case 3:
							$id_struktural = 8;
							break;
						case 6:
							$id_struktural = 5;
							break;
						case 5:
							$id_struktural = 6;
							break;
						case 3:
							$id_struktural = 7;
							break;
						case 2:
							$id_struktural = 4;
							break;
					}
					$struktur_kadep = $this->struktural->detail($id_struktural);
					$judul_notifikasi = 'Persetujuan Proposal Skripsi (KADEP/KETUA BAGIAN)';
					$isi_notifikasi = 'Mohon untuk melakukan persetujuan proposal skripsi dengan Nim ' . $this->session_data['username'] . ' pada sistem IURIS';
					$this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 1, $struktur_kadep->nip);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan proposal skripsi. Tunggu persetujuan Kadep.');
					redirect('dashboardm/modul/proposal');
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardm/modul/proposal');
			}
		}

		public function edit()
		{
			$id = $this->uri->segment(5);
			$username = $this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Modul (Mahasiswa)',
				'subtitle' => 'Pengajuan Proposal Skripsi',
				'section' => 'backend/mahasiswa/modul/proposal_edit',
				// DATA //
				'departemen' => $this->departemen->read(),
				'gelombang' => $this->gelombang->read_berjalan(),
				'proposal' => $this->proposal->detail($id, $username)
			);

			if ($data['proposal']) {
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$data['section'] = 'backend/notification/danger';
				$data['msg'] = 'Tidak ditemukan';
				$data['linkback'] = 'dashboardm/modul/proposal';
				$this->load->view('backend/index_sidebar', $data);
			}
		}

		public function update()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_judul = $this->input->post('id_judul', true);
				$persetujuan_judul = $this->input->post('persetujuan_judul', true);

				if ($persetujuan_judul == 2) {
					$data = array(
						'id_departemen' => $this->input->post('id_departemen', true),
						'judul' => $this->input->post('judul', true),
					);
					$this->proposal->update($data, $id_skripsi);

					$dataj = array(
						'id_skripsi' => $id_skripsi,
						'judul' => $this->input->post('judul', true)
					);
					$this->proposal->save_judul($dataj);
				} else {
					$data = array(
						'id_departemen' => $this->input->post('id_departemen', true),
						'judul' => $this->input->post('judul', true),
					);
					$this->proposal->update($data, $id_skripsi);

					$dataj = array(
						'judul' => $this->input->post('judul', true)
					);
					$this->proposal->update_judul($dataj, $id_judul);
				}

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update');
				redirect('dashboardm/modul/proposal');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardm/modul/proposal');
			}
		}

		public function update_file()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);

				$config['upload_path'] = './assets/upload/proposal/';
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = 20000;
				$config['remove_spaces'] = true;
				$config['file_ext_tolower'] = true;
				$config['detect_mime'] = true;
				$config['mod_mime_fix'] = true;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('berkas_proposal')) {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				} else {
					$upload_data = $this->upload->data();
					$file = $upload_data['file_name'];

					$data = array(
						'berkas_proposal' => $upload_data['file_name'],
					);

					$this->proposal->update($data, $id_skripsi);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Update BAB I berhasil.');
					redirect('dashboardm/modul/proposal');
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardm/modul/proposal');
			}
		}

		public function ujian()
		{
			$id = $this->uri->segment(5);
			$username = $this->session_data['username'];

			$data = array(
				// PAGE //
				'title' => 'Modul (Mahasiswa)',
				'subtitle' => 'Pengajuan Proposal Skripsi (Jadwal Ujian)',
				'section' => 'backend/mahasiswa/modul/proposal_ujian',
				'use_back' => true,
				'back_link' => 'dashboardm/modul/proposal',
				// DATA //
				'proposal' => $this->proposal->detail($id, $username),
				'ujian' => $this->proposal->ujian($id, $username)
			);
			if ($data['ujian']) {
				$data['penguji'] = $this->proposal->read_penguji($data['ujian']->id_ujian);
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$data = array(
					'title' => 'Modul (Mahasiswa)',
					'subtitle' => 'Pengajuan Proposal Skripsi (Jadwal Ujian)',
					'section' => 'backend/notification/error',
					'use_back' => true,
					'back_link' => 'dashboardm/modul/proposal',
					// DATA //
					'message_title' => 'Data Tidak ditemukan',
					'message' => ' Ujian belum disetting Kadep / Penguji belum melakukan persetujuan',
				);
				$this->load->view('backend/index_sidebar', $data);
			}
		}

		public function revisi($id_skripsi)
		{
			$username = $this->session_data['username'];
			$skripsi=$this->skripsi->detail_by_id($id_skripsi);
			$ujian=$this->proposal->ujian($id_skripsi, $username);
			$pengujis=$this->skripsi->read_penguji_by_ujian($ujian->id_ujian);
			$riwayat_revisis=$this->revisi_skripsi->readRiwayatRevisi($ujian->id_ujian);
			$data = array(
				// PAGE //
				'title' => 'Modul (Mahasiswa)',
				'subtitle' => 'Revisi - Ujian Proposal Skripsi',
				'section' => 'backend/mahasiswa/modul/proposal_revisi',
				'use_back' => true,
				'back_link' => 'dashboardm/modul/proposal',
				// DATA //
				'proposal' => $skripsi,
				'pengujis'=>$pengujis,
				'ujian' => $ujian,
				'riwayat_revisis' => $riwayat_revisis,
			);
			$this->load->view('backend/index_sidebar', $data);

		}

		public function saveRevisi(){
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$config['upload_path'] = './assets/upload/mahasiswa/skripsi/revisi';
				$config['allowed_types'] = 'pdf|jpg|png';
				$config['max_size'] = MAX_SIZE_FILE_UPLOAD;
				$config['remove_spaces'] = true;
				$config['file_ext_tolower'] = true;
				$config['detect_mime'] = true;
				$config['mod_mime_fix'] = true;
				$config['encrypt_name'] = TRUE;

				if ( !is_dir( $config['upload_path'] ) ) {
					mkdir( $config['upload_path'] );
				}

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('bukti_revisi')) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', $this->upload->display_errors());
					redirect_back();
				} else {
					$upload_data = $this->upload->data();
					$data = array(
						'id_ujian' => $this->input->post('id_ujian', true),
						'id_mhs' => $this->input->post('id_mhs', true),
						'id_dosen' => $this->input->post('id_dosen', true),
						'revisi' => $this->input->post('revisi', true),
						'tgl' => date('Y-m-d'),
						'tipe_ujian' => 'proposal',
						'file'=>$upload_data['file_name'],
					);

					$this->revisi_skripsi->saveRevisi($data);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil simpan.');
					redirect_back();
				}

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function deleteRevisi(){
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_revisi = $this->input->post('id_revisi', true);
				$this->revisi_skripsi->deleteRevisi($id_revisi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil simpan.');
				redirect_back();

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

	}

?>
