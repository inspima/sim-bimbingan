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
				if ($this->session_data['sebagai'] != 1 and $this->session_data['role'] != 0) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/master/ruang_model', 'ruang');
			$this->load->model('backend/master/jam_model', 'jam');
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/transaksi/penjadwalan', 'penjadwalan');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			$this->load->model('backend/utility/notification', 'notifikasi');
			$this->load->model('backend/user', 'user');
			//END MODEL
		}

		// KPS / PENASEHAT AKADEMIK

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Ujian Proposal',
				'subtitle' => 'Data',
				'section' => 'backend/dosen/disertasi/proposal/index',
				// DATA //
				'disertasi' => $this->disertasi->read_proposal(),
				'struktural' => $this->struktural->read_struktural($this->session_data['username']),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function terima()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$struktural = $this->struktural->read_struktural($this->session_data['username']);
				$id_disertasi = $this->input->post('id_disertasi', true);
				if ($struktural->id_struktur == STRUKTUR_SPS) {
					$data = array(
						'status_proposal' => STATUS_DISERTASI_PROPOSAL_SETUJUI_SPS,
					);
				} else if ($struktural->id_struktur == STRUKTUR_KPS_S3) {

					$data = array(
						'status_proposal' => STATUS_DISERTASI_PROPOSAL_SETUJUI_KPS,
					);

				}
				$this->disertasi->update($data, $id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil approve');
				redirect('dosen/disertasi/proposal');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/proposal');
			}
		}

		public function setting()
		{
			$id_disertasi = $this->uri->segment('5');

			$data = array(
				// PAGE //
				'title' => 'Disertasi - Ujian Proposal',
				'subtitle' => 'Setting',
				'section' => 'backend/dosen/disertasi/proposal/setting',
				'use_back' => true,
				'back_link' => 'backend/dosen/disertasi/permintaan/promotor',
				// DATA //
				'disertasi' => $this->disertasi->detail($id_disertasi),
				'mruang' => $this->ruang->read_aktif_by_prodi(S3_ILMU_HUKUM),
				'mjam' => $this->jam->read_aktif_by_prodi(S3_ILMU_HUKUM),
				'mdosen' => $this->dosen->read_aktif_alldep_s3(),
				'promotors' => $this->disertasi->read_promotor_kopromotor($id_disertasi),
				'ujian' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_PROPOSAL),
				'status_ujians' => $this->disertasi->read_status_ujian(UJIAN_DISERTASI_PROPOSAL),
			);
			if ($data['disertasi']) {
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$data['section'] = 'backend/notification/danger';
				$data['msg'] = 'Tidak ditemukan';
				$data['linkback'] = 'dosen/disertasi/proposal';
				$this->load->view('backend/index_sidebar', $data);
			}
		}

		public function jadwal_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$ujian = $this->disertasi->read_jadwal($id_disertasi, 2);

				if (!empty($ujian)) { // JIKA SUDAH ADA
					$id_ujian = $this->input->post('id_ujian');

					$data_update = array(
						'status' => 0,
						'status_ujian' => 1
					);

					$data = array(
						'id_disertasi' => $id_disertasi,
						'id_ruang' => $this->input->post('id_ruang', true),
						'id_jam' => $this->input->post('id_jam', true),
						'tanggal' => todb($this->input->post('tanggal', true)),
						'link_meeting' => $this->input->post('link_meeting', true),
						'status' => 1,
						'jenis_ujian' => UJIAN_DISERTASI_PROPOSAL,
						'status_ujian' => 1
					);

					$cek_jadwal_bentrok = $this->penjadwalan->cekBentrokJadwal($data['id_ruang'], $data['tanggal'], $data['id_jam']);

					if ($cek_jadwal_bentrok['status']) {
						$pengujis = $this->disertasi->read_penguji($ujian->id_ujian);
						if (!empty($pengujis)) {
							$cek_penguji_bentrok = $this->penjadwalan->cekBentrokPengujis($pengujis, $data['tanggal'], $data['id_jam']);
							if ($cek_penguji_bentrok['status']) {
								// set ujian non aktif
								$this->disertasi->update_ujian($data_update, $ujian->id_ujian);
								// masukkan ujian baru
								$this->disertasi->save_ujian($data);
								$ujian_baru = $this->disertasi->detail_ujian_by_data($id_disertasi, $data);
								// set penguji ke jadwal baru
								$data_update_penguji = array(
									'id_ujian' => $ujian_baru->id_ujian,
								);
								$this->disertasi->update_penguji_by_jadwal_lama($data_update_penguji, $ujian->id_ujian);
								$this->session->set_flashdata('msg-title', 'alert-success');
								$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
								redirect_back();
							} else {
								$this->session->set_flashdata('msg-title', 'alert-danger');
								$this->session->set_flashdata('msg', $cek_penguji_bentrok['message']);
								redirect_back();
							}
						} else { //langsung update
							// set ujian non aktif
							$this->disertasi->update_ujian($data_update, $ujian->id_ujian);
							// masukkan ujian baru
							$this->disertasi->save_ujian($data);

							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
							redirect_back();
						}
					} else {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', $cek_jadwal_bentrok['message']);
						redirect_back();

					}
				} else { //JIKA BELUM ADA SAVE BARU
					$data = array(
						'id_disertasi' => $id_disertasi,
						'id_ruang' => $this->input->post('id_ruang', true),
						'id_jam' => $this->input->post('id_jam', true),
						'tanggal' => todb($this->input->post('tanggal', true)),
						'jenis_ujian' => UJIAN_DISERTASI_PROPOSAL,
						'status' => 1,
						'status_ujian' => 1
					);

					$cek_jadwal_bentrok = $this->penjadwalan->cekBentrokJadwal($data['id_ruang'], $data['tanggal'], $data['id_jam']);

					if ($cek_jadwal_bentrok['status']) {
						$this->disertasi->save_ujian($data);
						$update_proposal = array(
							'status_proposal' => STATUS_DISERTASI_PROPOSAL_DIJADWALKAN,
						);
						$this->disertasi->update($update_proposal, $id_disertasi);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
						redirect_back();
					} else {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', $cek_jadwal_bentrok['message']);
						redirect_back();
					}
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

		public function penguji_promotor_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$promotors = $this->disertasi->read_promotor_kopromotor($id_disertasi);
				foreach ($promotors as $promotor) {
					$data = array(
						'id_ujian' => $id_ujian,
						'nip' => $promotor['nip'],
						'status_tim' => 2,
						'status' => 1
					);
					$cekpenguji = $this->disertasi->cek_penguji($data);
					if (empty($cekpenguji)) {
						$this->disertasi->save_penguji($data);
					}

				}
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Penguji Promotor Berhasil ditambahkan');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function penguji_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$nip = $this->input->post('nip', true);

				$data = array(
					'id_ujian' => $id_ujian,
					'nip' => $this->input->post('nip', true),
					'status_tim' => 2,
					'status' => 1
				);

				$cekpenguji = $this->disertasi->cek_penguji($data);
				if ($cekpenguji) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar.');
					redirect('dosen/disertasi/proposal/setting/' . $id_disertasi);
				} else {
					$ujian = $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_PROPOSAL);
					$cek_penguji_bentrok = $this->penjadwalan->cekBentrokPenguji($nip, $ujian->tanggal, $ujian->id_jam);
					if ($cek_penguji_bentrok['status']) {
						$jumlah_penguji = $this->disertasi->count_penguji($id_ujian);
						if ($jumlah_penguji < '7') {
							$this->disertasi->save_penguji($data);
							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', "Penguji berhasil ditambahkan");
							redirect('dosen/disertasi/proposal/setting/' . $id_disertasi);
						} else if ($jumlah_penguji >= '7') {
							$this->session->set_flashdata('msg-title', 'alert-danger');
							$this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji sudah 7');
							redirect('dosen/disertasi/proposal/setting/' . $id_disertasi);
						}
					} else {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
						redirect('dosen/disertasi/proposal/setting/' . $id_disertasi);
					}
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

		public function penguji_delete()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_penguji = $this->input->post('id_penguji', true);

				$data = array(
					'status' => 0,
				);

				$this->disertasi->update_penguji($data, $id_penguji);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
				redirect('dosen/disertasi/proposal/setting/' . $id_disertasi);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

		public function penguji_kirim_whatsapp()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$ujian = $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_PROPOSAL);
				$pengujis = $this->disertasi->read_penguji($ujian->id_ujian);
				$mhs = $this->user->read_mhs($disertasi->nim);
				foreach ($pengujis as $penguji) {
					$judul_notifikasi = 'Permintaan Penguji Ujian Proposal';
					$isi_notifikasi = 'Mohon kesediaanya untuk menjadi penguji pada Ujian Proposal mahasiswa'
						. WA_LINE_BREAK . WA_LINE_BREAK . 'Nama :' . $mhs->nama
						. WA_LINE_BREAK . 'Nim :' . $disertasi->nim
						. WA_LINE_BREAK . 'Judul :' . $disertasi->judul
						. WA_LINE_BREAK . WA_LINE_BREAK . 'Pada sistem IURIS';
					$this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 1, $penguji['nip']);
				}

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Notifikasi whatsapp berhasil dikirim');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function penguji_update_statustim()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$id_penguji = $this->input->post('id_penguji', true);
				$id_ujian = $this->input->post('id_ujian', true);

				$data = array(
					'status_tim' => $this->input->post('status_tim'),
				);
				if ($data['status_tim'] == '1') {
					//cek ketua
					$promotor = $this->disertasi->read_penguji_ketua($id_ujian);
					if (!empty($promotor)) {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Gagal update tim penguji. Ketua sudah ada.');
						redirect('dosen/disertasi/proposal/setting/' . $id_disertasi);
					} else {
						$this->disertasi->update_penguji($data, $id_penguji);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil update penguji.');
						redirect('dosen/disertasi/proposal/setting/' . $id_disertasi);
					}
				} else {
					$this->disertasi->update_penguji($data, $id_penguji);
					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update tim penguji.');
					redirect('dosen/disertasi/proposal/setting/' . $id_disertasi);
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

		public function update_status_ujian()
		{
			$id_disertasi = $this->input->post('id_disertasi', true);

			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {

				//CK INI
				$status_ujian = $this->input->post('status_ujian', true);

				$data = array(
					'status_ujian_proposal' => $status_ujian,
				);
				$this->disertasi->update($data, $id_disertasi);

				//trigger
				if ($status_ujian == '0') { //belum ujian
					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update proses');
					redirect('dosen/disertasi/proposal/setting/' . $id_disertasi);
				} else if (in_array($status_ujian, [1, 2])) { //layak
					//update proposal selesai
					$data = array(
						'status_proposal' => STATUS_DISERTASI_PROPOSAL_SELESAI,
						'status_ujian_proposal' => $status_ujian,
					);
					$this->disertasi->update($data, $id_disertasi);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update proses. Data akan diteruskan ke Proses Selanjutnya.');
					redirect('dosen/disertasi/permintaan/promotor');
				} else if ($status_ujian == '3') {
					$this->session->set_flashdata('msg-title', 'alert-warning');
					$this->session->set_flashdata('msg', 'Ujian ditolak');
					redirect('dosen/disertasi/permintaan/promotor');
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dosen/disertasi/permintaan/promotor');
			}
		}

	}

?>
