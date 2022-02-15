<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Penilaian extends CI_Controller
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
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/administrator/master/ruang_model', 'ruang');
			$this->load->model('backend/administrator/master/jam_model', 'jam');
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			$this->load->model('backend/master/setting', 'setting');
			//END MODEL
		}

		// DOSEN PENILAIAN MKPKK

		public function mkpkk()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Penilaian - MKPKK',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/penilaian/mkpkk',
				// DATA //
				'disertasi' => $this->disertasi->read_penilaian_mkpkk($this->session_data['username'])
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function mkpkk_input()
		{
			$id_disertasi = $this->uri->segment('6');
			$this->disertasi->regenerate_disertasi_mkpkk_pengampu($id_disertasi);
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Penilaian - MKPKK',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/penilaian/mkpkk_input',
				'use_back' => true,
				'back_link' => 'dosen/disertasi/penilaian',
				// DATA //
				'disertasi' => $this->disertasi->detail($id_disertasi),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function mkpkk_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi_mkpkk_pengampu = $this->input->post('id_disertasi_mkpkk_pengampu', true);
				$nilai_angka = $this->input->post('nilai_angka', true);
				$disertasi_mkpkk_pengampu = $this->disertasi->detail_disertasi_mkpkk_pengampu($id_disertasi_mkpkk_pengampu);
				// UPDATE NILAI PERDOSEN
				$data = array(
					'nilai_angka' => $nilai_angka,
				);
				$this->disertasi->update_disertasi_mkpkk_pengampu($data, $id_disertasi_mkpkk_pengampu);
				// UPDATE NILAI PER MK
				/// AMBIL NILAI RATA RATA
				$rata_nilai = $this->disertasi->rata_nilai_disertasi_mkpkk($disertasi_mkpkk_pengampu->id_disertasi, $disertasi_mkpkk_pengampu->id_mkpkk);
				$data_mk = [
					'nilai_angka' => $rata_nilai,
				];
				$this->disertasi->update_disertasi_mkpkk($data_mk, $disertasi_mkpkk_pengampu->id_disertasi, $disertasi_mkpkk_pengampu->id_mkpkk);
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil memasukkan nilai');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function mkpkk_publish_nilai()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_mkpkk = $this->input->post('id_mkpkk', true);
				$data_mk = [
					'nilai_publish' => 1,
				];
				$this->disertasi->update_disertasi_mkpkk($data_mk, $id_disertasi, $id_mkpkk);
				if($this->disertasi->cek_mkpkk_sudah_publish($id_disertasi)){
					$data = array(
						'status_mpkk' => STATUS_DISERTASI_MPKK_SELESAI,
					);
					$this->disertasi->update($data, $id_disertasi);
				}

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil dipublish');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


		public function mkpkk_cetak()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_mkpkk = $this->input->post('id_mkpkk', true);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$mkpkk = $this->disertasi->detail_mkpkk($id_mkpkk);
				$disertasi_mkpkk = $this->disertasi->detail_disertasi_mkpkk($id_disertasi,$id_mkpkk);
				$pjmk_mkpkk = $this->disertasi->detail_mkpkk_pengampu_pjmk($id_mkpkk);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$data = [
					'disertasi' => $disertasi,
					'mkpkk' => $mkpkk,
					'disertasi_mkpkk' => $disertasi_mkpkk,
					'pjma_mkpkk' => $pjmk_mkpkk,
				];
				$page = 'backend/dosen/disertasi/penilaian/mkpkk_cetak';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "nilai_mkpkk.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function mkpd()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Penilaian - MKPD',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/penilaian/mkpd',
				// DATA //
				'disertasi' => $this->disertasi->read_penilaian_mkpd($this->session_data['username'])
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function mkpd_input()
		{
			$id_disertasi = $this->uri->segment('6');
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Penilaian - MKPD',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/penilaian/mkpd_input',
				'use_back' => true,
				'back_link' => 'dosen/disertasi/penilaian',
				// DATA //
				'disertasi' => $this->disertasi->detail($id_disertasi),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function mkpd_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi_mkpd_pengampu = $this->input->post('id_disertasi_mkpd_pengampu', true);
				$nilai_angka = $this->input->post('nilai_angka', true);
				$disertasi_mkpd_pengampu = $this->disertasi->detail_disertasi_mkpd_pengampu($id_disertasi_mkpd_pengampu);
				// UPDATE NILAI PERDOSEN
				$data = array(
					'nilai_angka' => $nilai_angka,
				);
				$this->disertasi->update_disertasi_mkpd_pengampu($data, $id_disertasi_mkpd_pengampu);
				// UPDATE NILAI PER MK
				/// AMBIL NILAI RATA RATA
				$rata_nilai = $this->disertasi->rata_nilai_disertasi_mkpd($disertasi_mkpd_pengampu->id_disertasi_mkpd);
				$data_mk = [
					'nilai_angka' => $rata_nilai,
				];
				$this->disertasi->update_disertasi_mkpd($data_mk, $disertasi_mkpd_pengampu->id_disertasi_mkpd);
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil memasukkan nilai');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function mkpd_publish_nilai()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_disertasi_mkpd = $this->input->post('id_disertasi_mkpd', true);
				$data_mk = [
					'nilai_publish' => 1,
				];
				$this->disertasi->update_disertasi_mkpd($data_mk, $id_disertasi_mkpd);
				if($this->disertasi->cek_mkpd_sudah_publish($id_disertasi)){
					$data = array(
						'status_mkpd' => STATUS_DISERTASI_MKPD_SELESAI,
					);
					$this->disertasi->update($data, $id_disertasi);
				}

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil dipublish');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


		public function mkpd_cetak()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_disertasi_mkpd = $this->input->post('id_disertasi_mkpd', true);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$disertasi_mkpd = $this->disertasi->detail_disertasi_mkpd($id_disertasi_mkpd);
				$pjmk_mkpd = $this->disertasi->detail_mkpd_pengampu_pjmk($id_disertasi_mkpd);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$data = [
					'disertasi' => $disertasi,
					'disertasi_mkpd' => $disertasi_mkpd,
					'pjma_mkpd' => $pjmk_mkpd,
				];
				$page = 'backend/dosen/disertasi/penilaian/mkpd_cetak';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "nilai_mkpd.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


	}

?>
