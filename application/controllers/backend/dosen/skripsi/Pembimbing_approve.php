<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Pembimbing_approve extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 1) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS

			//START MODEL
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/dosen/skripsi/Pembimbing_model', 'pembimbing');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			$this->load->model('backend/utility/ActionLog', 'action_log');
			//END MODEL
		}

		public function index()
		{
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Skripsi (Pembimbing)',
				'subtitle' => 'Skripsi(Pembimbing)',
				'section' => 'backend/dosen/skripsi/pembimbing_approve',
				// DATA //
				'pembimbing' => $this->pembimbing->read_approve($username)
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function update_pembimbing()
		{
			$username = $this->session_data['username'];
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_pembimbing = $this->input->post('id_pembimbing', true);
				$pembimbing=$this->pembimbing->pembimbingDetail($id_pembimbing);

				$cektotal = $this->pembimbing->hitung_bimbingan_aktif($username);
				if ($cektotal < 10) {
					$data = array(
						'status' => $this->input->post('status', true),
						'status_bimbingan' => 2,
					);
					$this->pembimbing->update_pembimbing($data, $id_pembimbing);
					// Save Log
					$this->action_log->saveActionLogByIdSkripsi($pembimbing->id_skripsi, $this->session_data['username'], ACTION_VERB_PEMBIMBING, ACTION_OBJECT_SKRIPSI, true);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update.');
					redirect('dashboardd/skripsi/pembimbing_pengajuan');
				} else if ($cektotal >= 10) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Bimbingan aktif skripsi sudah mencapai maksimum');
					redirect('dashboardd/skripsi/pembimbing_pengajuan');
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/proposal/penguji_pengajuan');
			}
		}

		public function bimbingan()
		{
			$id_skripsi = $this->uri->segment('5');
			$username = $this->session_data['username'];
			$data = array(
				// PAGE //
				'title' => 'Bimbingan Skripsi',
				'subtitle' => 'Bimbingan Skripsi',
				'section' => 'backend/dosen/skripsi/pembimbing_approve_bimbingan',
				'use_back' => true,
				'back_link' => 'dashboardd/skripsi/pembimbing_approve',
				// DATA //
				'skripsi' => $this->pembimbing->detail_approve($username, $id_skripsi),
				'bimbingan' => $this->pembimbing->bimbingan($id_skripsi),
				'mdosen' => $this->dosen->read_penguji_aktif(JENJANG_S1),
				'penguji_temp' => $this->pembimbing->read_pengujitemp($id_skripsi)
			);

			if ($data['skripsi']) {
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$data['section'] = 'backend/notification/danger';
				$data['msg'] = 'Tidak ditemukan';
				$data['linkback'] = 'dashboardd/skripsi/pembimbing_approve';
				$this->load->view('backend/index_sidebar', $data);
			}
		}

		public function bimbingan_update()
		{
			$username = $this->session_data['username'];
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_bimbingan = $this->input->post('id_bimbingan', true);
				$id_skripsi = $this->input->post('id_skripsi', true);

				$data = array(
					'status' => $this->input->post('status', true),
				);

				$this->pembimbing->update_bimbingan($data, $id_bimbingan);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update.');
				redirect('dashboardd/skripsi/pembimbing_approve/bimbingan/' . $id_skripsi);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/skripsi/pembimbing_approve');
			}
		}

		public function save_penguji()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);

				$dataj = array(
					'id_skripsi' => $id_skripsi,
					'nip' => $this->input->post('nip', true),
					'status' => 1
				);

				$this->pembimbing->save_penguji($dataj);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil save penguji');
				redirect('dashboardd/skripsi/pembimbing_approve/bimbingan/' . $id_skripsi);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/skripsi/pembimbing_approve/bimbingan/' . $id_skripsi);
			}

		}

		public function approve_skripsi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);

				$cekpenguji = $this->pembimbing->cek_penguji($id_skripsi);
				if ($cekpenguji) {
					$data = array(
						'status_skripsi' => STATUS_SKRIPSI_UJIAN_SETUJUI_PEMBIMMBING,
					);

					$this->pembimbing->update_skripsi($data, $id_skripsi);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil Approve.');
					redirect('dashboardd/skripsi/pembimbing_approve/bimbingan/' . $id_skripsi);
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Gagal. Simpan penguji terlebih dahulu');
					redirect('dashboardd/skripsi/pembimbing_approve/bimbingan/' . $id_skripsi);
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/skripsi/pembimbing_approve');
			}
		}


	}

?>
