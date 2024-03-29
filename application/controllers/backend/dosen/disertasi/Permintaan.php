<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Permintaan extends CI_Controller
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
			//END MODEL
			// START LIBRARY
			$this->load->helper('array');
			// END LIBRARY
		}

		// DOSEN PENGUJI

		public function penguji_kualifikasi()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Kualifikasi - Permintaan Dosen Penguji',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/permintaan/penguji_kualifikasi',
				// DATA //
				'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_KUALIFIKASI)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function penguji_proposal()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Proposal - Permintaan Dosen Penguji',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/permintaan/penguji_proposal',
				// DATA //
				'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_PROPOSAL)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function penguji_kelayakan()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Kelayakan - Permintaan Dosen Penguji',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/permintaan/penguji_kelayakan',
				// DATA //
				'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_KELAYAKAN)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function penguji_tertutup()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Ujian Tertutup - Permintaan Dosen Penguji',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/permintaan/penguji_tertutup',
				// DATA //
				'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_TERTUTUP)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function penguji_terbuka()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Ujian Terbuka - Permintaan Dosen Penguji',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/permintaan/penguji_terbuka',
				// DATA //
				'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_TERBUKA)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function penguji_setujui()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_penguji = $this->input->post('id_penguji', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$id_disertasi = $this->input->post('id_disertasi', true);

				$data = array(
					'status' => 2,
				);

				$this->disertasi->update_penguji($data, $id_penguji);

				$semua_penguji_setuju = $this->disertasi->semua_penguji_setuju($id_ujian);
				if ($semua_penguji_setuju) {
					$ujian = $this->disertasi->detail_ujian($id_ujian);
					switch ($ujian->jenis_ujian) {
						case UJIAN_DISERTASI_KUALIFIKASI:
							$data = array(
								'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PENGUJI,
							);
							break;
						case UJIAN_DISERTASI_PROPOSAL:
							$data = array(
								'status_proposal' => STATUS_DISERTASI_PROPOSAL_SETUJUI_PENGUJI,
							);
							break;
						case UJIAN_DISERTASI_KELAYAKAN:
							$data = array(
								'status_kelayakan' => STATUS_DISERTASI_KELAYAKAN_SETUJUI_PENGUJI,
							);
							break;
						case UJIAN_DISERTASI_TERTUTUP:
							$data = array(
								'status_tertutup' => STATUS_DISERTASI_TERTUTUP_SETUJUI_PENGUJI,
							);
							break;
						case UJIAN_DISERTASI_TERBUKA:
							$data = array(
								'status_terbuka' => STATUS_DISERTASI_TERBUKA_UJIAN,
							);
							break;
					}

					$this->disertasi->update($data, $id_disertasi);
				}

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil disetujui');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		// DOSEN PENASEHAT AKADEMIK

		public function penasehat()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Permintaan Penasehat Akademik',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/permintaan/penasehat',
				// DATA //
				'disertasi' => $this->disertasi->read_permintaan_penasehat($this->session_data['username'])
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		// DOSEN PROMOTOR/KOPROMOTOR

		public function promotor()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Permintaan Dosen Promotor/Ko-Promotor',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/permintaan/promotor',
				// DATA //
				'disertasi' => $this->disertasi->read_permintaan_promotor($this->session_data['username'])
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function promotor_mkpkk()
		{
			$id_disertasi = $this->uri->segment('7');
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Promotor/Ko-Promotor - MKPKK',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/permintaan/promotor_mkpkk',
				'use_back' => true,
				'back_link' => 'dosen/disertasi/permintaan/promotor',
				// DATA //
				'disertasi' => $this->disertasi->detail($id_disertasi),
				'mkpkks' => $this->disertasi->read_mkpkk(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function promotor_mkpkk_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_mkpkks = $this->input->post('id_mkpkk', true);
				if (count($id_mkpkks) > 0) {
					$this->disertasi->delete_disertasi_mkpkk($id_disertasi);
				}
				foreach ($id_mkpkks as $id_mkpkk) {
					$mkpkk = $this->disertasi->detail_mkpkk($id_mkpkk);
					$data = array(
						'id_disertasi' => $id_disertasi,
						'id_mkpkk' => $id_mkpkk,
						'mkpkk' => $mkpkk->nama,
					);

					$this->disertasi->save_disertasi_mkpkk($data);
				}
				$this->disertasi->generate_disertasi_mkpkk_pengampu($id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'MKPKK berhasil di save');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function promotor_mkpd_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_mkpkks = $this->input->post('id_mkpkk', true);
				if (count($id_mkpkks) > 0) {
					$this->disertasi->delete_disertasi_mkpkk($id_disertasi);
				}
				foreach ($id_mkpkks as $id_mkpkk) {
					$mkpkk = $this->disertasi->detail_mkpkk($id_mkpkk);
					$data = array(
						'id_disertasi' => $id_disertasi,
						'id_mkpkk' => $id_mkpkk,
						'mkpkk' => $mkpkk->nama,
					);

					$this->disertasi->save_disertasi_mkpkk($data);
				}
				$this->disertasi->generate_disertasi_mkpkk_pengampu($id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'MKPKK berhasil di save');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function promotor_setujui()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_promotor = $this->input->post('id_promotor', true);

				$data = array(
					'status' => 2,
				);
				$this->disertasi->update_promotor($data, $id_promotor);
				$semua_promotor_setujui = $this->disertasi->semua_promotor_setujui($id_disertasi);
				if ($semua_promotor_setujui) {
					$data = array(
						'status_promotor' => STATUS_DISERTASI_PROMOTOR_SETUJUI,
					);
					$this->disertasi->update($data, $id_disertasi);
				}

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil disetujui');
				redirect('dosen/disertasi/permintaan/promotor');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

		public function mpkk_setujui()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = array(
					'status_mpkk' => STATUS_DISERTASI_MPKK_SETUJUI_PROMOTOR,
				);

				$this->disertasi->update($data, $id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil approve');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function proposal_setujui()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = array(
					'status_proposal' => STATUS_DISERTASI_PROPOSAL_SETUJUI_PROMOTOR,
				);
				$this->disertasi->update($data, $id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil approve');
				redirect('dosen/disertasi/permintaan/promotor');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

		public function mkpd_detail()
		{
			$id_disertasi = $this->uri->segment('7');
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Promotor/Ko-Promotor - MKPD',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/permintaan/promotor_mkpd',
				'use_back' => true,
				'back_link' => 'dosen/disertasi/permintaan/promotor',
				// DATA //
				'disertasi' => $this->disertasi->detail($id_disertasi),
				'mdosen' => $this->dosen->read_aktif_alldep_s3(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function mkpd_setujui()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = array(
					'status_mkpd' => STATUS_DISERTASI_MKPD_SETUJUI_PROMOTOR,
				);
				$this->disertasi->update($data, $id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil approve');
				redirect('dosen/disertasi/permintaan/promotor');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

		public function mkpd_update(){
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
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

					$this->disertasi->delete_disertasi_mkpd_by_disertasi($id_disertasi);
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
							foreach($dosens as $dosen){
								$data_pengampu = [
									'id_disertasi' => $id_disertasi,
									'id_disertasi_mkpd' => $disertasi_mkpd->id_disertasi_mkpd,
									'nip' => $dosen,
								];
								$this->disertasi->save_disertasi_mkpd_pengampu($data_pengampu);
							}
						}

					}

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil memperbarui MKPD');
					redirect_back();
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

		public function mkpd_set_pjmk()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi_mkpd_pengampu = $this->input->post('id_disertasi_mkpd_pengampu', true);
				$data = array(
					'pjmk' => '1',
				);
				$this->disertasi->update_disertasi_mkpd_pengampu($data, $id_disertasi_mkpd_pengampu);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil memilih PJMA MKPD');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function kelayakan_setujui()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = array(
					'status_kelayakan' => STATUS_DISERTASI_KELAYAKAN_SETUJUI_PROMOTOR,
				);
				$this->disertasi->update($data, $id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil approve');
				redirect('dosen/disertasi/permintaan/promotor');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

		public function tertutup_setujui()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = array(
					'status_tertutup' => STATUS_DISERTASI_TERTUTUP_SETUJUI_PROMOTOR,
				);
				$this->disertasi->update($data, $id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil approve');
				redirect('dosen/disertasi/permintaan/promotor');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

		public function terbuka_setujui()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = array(
					'status_terbuka' => STATUS_DISERTASI_TERBUKA_SETUJUI_PROMOTOR,
				);
				$this->disertasi->update($data, $id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil approve');
				redirect('dosen/disertasi/permintaan/promotor');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

	}

?>
