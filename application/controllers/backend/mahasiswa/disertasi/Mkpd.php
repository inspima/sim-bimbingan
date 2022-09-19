<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Mkpd extends CI_Controller
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
			$this->load->model('backend/baa/master/mahasiswa_model', 'mahasiswa');
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
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
				'subtitle' => 'Disertasi - MKPD',
				'section' => 'backend/mahasiswa/disertasi/mkpd/index',
				// DATA //
				//'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
				'disertasi' => $this->disertasi->read_mkpd_mahasiswa($this->session_data['username'])
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function info()
		{
			$id_disertasi = $this->uri->segment('5');
			$data = array(
				'title' => 'Modul (Mahasiswa)',
				'subtitle' => 'Disertasi - MKPKK',
				'section' => 'backend/mahasiswa/disertasi/mkpd/info',
				'use_back' => true,
				'back_link' => 'mahasiswa/disertasi/mkpd',
				// DATA //
				'mdosen' => $this->dosen->read_aktif_alldep(),
				'disertasi' => $this->disertasi->detail($id_disertasi),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function add()
		{
			$id_disertasi = $this->uri->segment('5');
			$promotor_kopromotor=$this->disertasi->read_promotor_kopromotor($id_disertasi);
			$read_aktif = $this->disertasi->read_aktif($this->session_data['username']);

			if ($read_aktif) {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Masih ada judul aktif');
				redirect('mahasiswa/disertasi/mkpd');
			} else {
				$data = array(
					// PAGE //
					'title' => 'Modul (Mahasiswa)',
					'subtitle' => 'Pengajuan MKPD',
					'section' => 'backend/mahasiswa/disertasi/mkpd/add',
					'use_back' => true,
					'back_link' => 'mahasiswa/disertasi/mkpd',
					'mdosen' => $this->dosen->read_aktif_alldep_s3(),
					// DATA //
					'departemen' => $this->departemen->read(),
					'disertasi' => $this->disertasi->detail($id_disertasi),
					'promotor_kopromotors'=>$promotor_kopromotor,
				);
				$this->load->view('backend/index_sidebar', $data);
			}
		}

		public function save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$tgl_sekarang = date('Y-m-d');
				$total_sks = 0;
				$kode = $this->input->post('kode1' , true);
				$sks = $this->input->post('sks1' , true);
				$check_nama_ada =[];
				$check_dosen_ada =[];
				// CEK TOPIK/MK DIMASUKKAN
				for ($i = 1; $i <= 3; $i++) {
					$nama = $this->input->post('nama' . $i, true);
					$dosens = $this->input->post('pengampu' . $i, true);
					if (!empty($nama)) {
						$check_nama_ada[]= $nama;
					}
					if (!empty($dosens)) {
						if($dosens[0]){
							$check_dosen_ada[]= $dosens[0];
						}

					}
				}
				if (count($check_nama_ada) >= 2&&count($check_dosen_ada) >= 2) {
					for ($i = 1; $i <= 3; $i++) {
						$nama = $this->input->post('nama' . $i, true);
						$dosens = $this->input->post('pengampu' . $i, true);
						$data_disertasi_mkpd = [
							'id_disertasi' => $id_disertasi,
							'kode' => $kode,
							'mkpd' => $nama,
							'sks' => $sks,
						];
						if (!empty($kode) && !empty($nama)) {
							$this->disertasi->save_disertasi_mkpd($data_disertasi_mkpd);
							$disertasi_mkpd = $this->disertasi->detail_disertasi_mkpd_by_data($data_disertasi_mkpd);
							foreach ($dosens as $dosen) {
								if(!empty($dosen)){
									$data_pengampu = [
										'id_disertasi' => $id_disertasi,
										'id_disertasi_mkpd' => $disertasi_mkpd->id_disertasi_mkpd,
										'nip' => $dosen,
									];
									$this->disertasi->save_disertasi_mkpd_pengampu($data_pengampu);
								}

							}
						}

					}
					$tgl_sekarang = date('Y-m-d');
					$data = array(
						'jenis' => TAHAPAN_DISERTASI_MKPD,
						'status_mkpd' => STATUS_DISERTASI_MKPD_PENGAJUAN,
					);

					$this->disertasi->update($data, $id_disertasi);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan MKPD..');
					redirect('mahasiswa/disertasi/mkpd');
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Minimal masukkan 2 Topik Mata Kuliah / dosen pengampu belum sesuai dengan topik yang dipilih');
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
