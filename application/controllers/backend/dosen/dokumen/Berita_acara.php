<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Berita_acara extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 1 and $this->session_data['role'] != 0) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/transaksi/dokumen', 'dokumen');
			$this->load->model('backend/utility/notification', 'notifikasi');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/user', 'user');
			//END MODEL
		}

		// KPS / PENASEHAT AKADEMIK

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Berita Acara',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/dokumen/berita_acara/index',
				// DATA //
				'dokumens' => $this->dokumen->read_persetujuan_dosen($this->session_data['username'], 'berita-acara'),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function persetujuan()
		{
			$id_dokumen = $this->uri->segment('5');
			$data_persetujuan = [
				'identitas' => $this->session_data['username'],
				'id_dokumen' => $id_dokumen,
			];
			$data = array(
				// PAGE //
				'title' => 'Berita Acara',
				'subtitle' => 'Persetujuan',
				'section' => 'backend/dosen/dokumen/berita_acara/persetujuan',
				'use_back' => true,
				'back_link' => 'backend/dosen/dokumen/berita_acara',
				// DATA //
				'dosens' => $this->dokumen->read_persetujuan($id_dokumen),
				'dokumen_persetujuan' => $this->dokumen->detail_persetujuan_by_data($data_persetujuan),
				'status_ujians' => $this->disertasi->read_status_ujian(UJIAN_DISERTASI_KUALIFIKASI),
			);
			$this->load->view('backend/index_sidebar', $data);
		}


		public function persetujuan_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_persetujuan = $this->input->post('id_persetujuan', true);
				$nilai = $this->input->post('nilai', true);
				$hasil = $this->input->post('hasil', true);
				$keterangan = $this->input->post('keterangan', true);
				$data = array(
					'nilai' => $nilai,
					'hasil' => $hasil,
					'hasil_keterangan' => $keterangan,
					'waktu' => date('Y-m-d H:i:s')
				);
				$this->dokumen->update_persetujuan($data, $id_persetujuan);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil melakukan persetujuan.');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


	}

?>
