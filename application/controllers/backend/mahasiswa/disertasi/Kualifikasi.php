<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Kualifikasi extends CI_Controller
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
			$this->load->model('backend/master/setting', 'setting');
			$this->load->model('backend/baa/master/mahasiswa_model', 'mahasiswa');
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Modul (Mahasiswa)',
				'subtitle' => 'Disertasi - Kualifikasi',
				'section' => 'backend/mahasiswa/disertasi/kualifikasi/index',
				// DATA //
				//'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
				'disertasi' => $this->disertasi->read_kualifikasi_mahasiswa($this->session_data['username'])
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function info()
		{
			$id_disertasi = $this->uri->segment('5');
			$data = array(
				'title' => 'Modul (Mahasiswa)',
				'subtitle' => 'Disertasi - Kualifikasi',
				'section' => 'backend/mahasiswa/disertasi/kualifikasi/info',
				'use_back' => true,
				'back_link' => 'mahasiswa/disertasi/kualifikasi',
				// DATA //
				'mdosen' => $this->dosen->read_aktif_alldep(),
				'disertasi' => $this->disertasi->detail($id_disertasi),
				'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
				'status_ujians' => $this->disertasi->read_status_ujian(UJIAN_DISERTASI_KUALIFIKASI),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function add()
		{
			$read_aktif = $this->disertasi->read_aktif($this->session_data['username']);

			if ($read_aktif) {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Masih ada judul aktif');
				redirect('mahasiswa/disertasi/kualifikasi');
			} else {
				$data = array(
					// PAGE //
					'title' => 'Modul (Mahasiswa)',
					'subtitle' => 'Pengajuan Ujian Kualifikasi',
					'section' => 'backend/mahasiswa/disertasi/kualifikasi/add',
					// DATA //
					'mdosen' => $this->dosen->read_aktif_alldep_s3(),
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
				$file_name = $this->session_data['username'] . '_berkas_kualifikasi.pdf';
				$config['upload_path'] = './assets/upload/mahasiswa/disertasi/kualifikasi';
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = MAX_SIZE_FILE_UPLOAD;
				$config['remove_spaces'] = true;
				$config['file_ext_tolower'] = true;
				$config['detect_mime'] = true;
				$config['mod_mime_fix'] = true;
				$config['file_name'] = $file_name;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$tgl_sekarang = date('Y-m-d');
				if (!$this->upload->do_upload('berkas_kualifikasi')) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', $this->upload->display_errors());
					redirect('mahasiswa/disertasi/kualifikasi');
				} else {
					$data = array(
						'jenis' => TAHAPAN_DISERTASI_KUALIFIKASI,
						'berkas_kualifikasi' => $file_name,
						'nim' => $this->session_data['username'],
						'tgl_pengajuan' => $tgl_sekarang,
						'waktu_pengajuan_kualifikasi' => $tgl_sekarang,
						'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_PENGAJUAN,
					);

					$this->disertasi->save($data);
					$last_id = $this->db->insert_id();

					$dataj = array(
						'id_disertasi' => $last_id,
						'judul' => $this->input->post('judul', true)
					);

					$this->disertasi->save_judul($dataj);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan ujian kualifikasi..');
					redirect('mahasiswa/disertasi/kualifikasi');
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('mahasiswa/disertasi/kualifikasi');
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
				'proposal' => $this->disertasi->detail($id, $username)
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

				$read_judul = $this->disertasi->read_judul($id_skripsi);
				$judul = $this->input->post('judul', true);

				if ($judul == $read_judul->judul) {
					$data = array(
						'id_departemen' => $this->input->post('id_departemen', true),
					);
					$this->disertasi->update($data, $id_skripsi);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update');
					redirect('dashboardm/modul/proposal');
				} else {
					$data = array(
						'id_departemen' => $this->input->post('id_departemen', true),
					);
					$this->disertasi->update($data, $id_skripsi);

					$dataj = array(
						'id_skripsi' => $id_skripsi,
						'judul' => $this->input->post('judul', true)
					);

					$this->disertasi->save_judul($dataj);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update');
					redirect('dashboardm/modul/proposal');
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardm/modul/proposal');
			}
		}

		public function cetak_pengajuan()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
				if (!empty($ujian)) {
					$id_ujian = $ujian->id_ujian;

					$data = array(
						'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
						'pengujis' => $this->disertasi->read_penguji($id_ujian),
						'disertasi' => $this->disertasi->detail($id_disertasi),
						'kps_s3' => $this->struktural->read_kps_s3()
					);
					//print_r($data['penguji_ketua']);die();
					ob_end_clean();
					$page = 'backend/mahasiswa/disertasi/kualifikasi/cetak-pengajuan';
					$size = 'legal';
					$this->pdf->setPaper($size, 'potrait');
					$this->pdf->filename = "FORM PENGAJUAN - UJIAN KUALIFIKASI.pdf";
					$this->pdf->load_view($page, $data);
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Jadwal Ujian belum ada tunggu sampai status sudah dijadwalkan');
					redirect_back();
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

	}

?>
