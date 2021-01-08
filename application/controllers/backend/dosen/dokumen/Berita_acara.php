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

		private function get_value_jenis_dokumen($jenis)
		{
			$result = 0;
			switch ($jenis) {
				case DOKUMEN_JENIS_DISERTASI_UJIAN_KUALIFIKASI_STR:
					$result = UJIAN_DISERTASI_KUALIFIKASI;
					break;
				case DOKUMEN_JENIS_DISERTASI_UJIAN_PROPOSAL_STR:
					$result = UJIAN_DISERTASI_PROPOSAL;
					break;
				case DOKUMEN_JENIS_DISERTASI_UJIAN_KELAYAKAN_STR:
					$result = UJIAN_DISERTASI_KELAYAKAN;
					break;
				case DOKUMEN_JENIS_DISERTASI_UJIAN_TERTUTUP_STR:
					$result = UJIAN_DISERTASI_TERTUTUP;
					break;
				case DOKUMEN_JENIS_DISERTASI_UJIAN_TERBUKA_STR:
					$result = UJIAN_DISERTASI_TERBUKA;
					break;
			}
			return $result;
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
			$dokumen = $this->dokumen->detail($id_dokumen);
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
				'dokumen' => $dokumen,
				'dokumen_persetujuan' => $this->dokumen->detail_persetujuan_by_data($data_persetujuan),
				'status_ujians' => $this->disertasi->read_status_ujian($this->get_value_jenis_dokumen($dokumen->jenis)),
			);
			$this->load->view('backend/index_sidebar', $data);
		}


		public function persetujuan_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_dokumen = $this->input->post('id_dokumen', true);
				$id_persetujuan = $this->input->post('id_persetujuan', true);
				$nilai = $this->input->post('nilai', true);
				$hasil = $this->input->post('hasil', true);
				$jenis = $this->input->post('jenis', true);
				$keterangan = $this->input->post('keterangan', true);
				$dokumen = $this->dokumen->detail($id_dokumen);
				$data = array(
					'nilai' => $nilai,
					'hasil' => $hasil,
					'hasil_keterangan' => $keterangan,
					'waktu' => date('Y-m-d H:i:s')
				);
				$this->dokumen->update_persetujuan($data, $id_persetujuan);
				// Jika merupakan ketua penguji
				if ($jenis == '1') {
					// Disertasi Kualifikasi
					if ($dokumen->jenis == DOKUMEN_JENIS_DISERTASI_UJIAN_KUALIFIKASI_STR) {
						$data_disertasi = [
							'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SELESAI,
							'status_ujian_kualifikasi' => $this->disertasi->get_id_status_ujian_by_text($hasil, UJIAN_DISERTASI_KUALIFIKASI),
						];
						$this->disertasi->update($data_disertasi, $dokumen->id_tugas_akhir);
					} else if ($dokumen->jenis == DOKUMEN_JENIS_DISERTASI_UJIAN_PROPOSAL_STR) {
						$data_disertasi = [
							'status_proposal' => STATUS_DISERTASI_PROPOSAL_SELESAI,
							'status_ujian_proposal' => $this->disertasi->get_id_status_ujian_by_text($hasil, UJIAN_DISERTASI_PROPOSAL),
						];
						$this->disertasi->update($data_disertasi, $dokumen->id_tugas_akhir);
					} else if ($dokumen->jenis == DOKUMEN_JENIS_DISERTASI_UJIAN_KELAYAKAN_STR) {
						$data_disertasi = [
							'status_kelayakan' => STATUS_DISERTASI_KELAYAKAN_SELESAI,
							'status_ujian_kelayakan' => $this->disertasi->get_id_status_ujian_by_text($hasil, UJIAN_DISERTASI_KELAYAKAN),
						];
						$this->disertasi->update($data_disertasi, $dokumen->id_tugas_akhir);
					} else if ($dokumen->jenis == DOKUMEN_JENIS_DISERTASI_UJIAN_TERTUTUP_STR) {
						$data_disertasi = [
							'status_tertutup' => STATUS_DISERTASI_TERTUTUP_SELESAI,
							'status_ujian_tertutup' => $this->disertasi->get_id_status_ujian_by_text($hasil, UJIAN_DISERTASI_TERTUTUP),
						];
						$this->disertasi->update($data_disertasi, $dokumen->id_tugas_akhir);
					} else if ($dokumen->jenis == DOKUMEN_JENIS_DISERTASI_UJIAN_TERBUKA_STR) {
						$data_disertasi = [
							'status_terbuka' => STATUS_DISERTASI_TERBUKA_SELESAI,
							'status_ujian_terbuka' => $this->disertasi->get_id_status_ujian_by_text($hasil, UJIAN_DISERTASI_TERBUKA),
						];
						$this->disertasi->update($data_disertasi, $dokumen->id_tugas_akhir);
					}
				}

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