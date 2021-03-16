<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Kadep_proposal extends CI_Controller
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
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/administrator/master/ruang_model', 'ruang');
			$this->load->model('backend/administrator/master/jam_model', 'jam');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			$this->load->model('backend/dosen/proposal/Kadep_pengajuan_model', 'proposal');
			$this->load->model('backend/transaksi/skripsi', 'skripsi');
			$this->load->model('backend/utility/notification', 'notifikasi');
			//END MODEL
		}

		public function pengajuan()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {

				$data = array(
					// PAGE //
					'title' => 'Ketua Bagian (Departemen) - Skripsi - Proposal',
					'subtitle' => 'Pengajuan',
					'section' => 'backend/dosen/skripsi/proposal/kadep_pengajuan',
					// DATA //
					'proposal' => $this->skripsi->read_kadep_pengajuan($id_departemen)
				);
				//print_r($data['proposal']);die();
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function diterima()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {

				$data = array(
					// PAGE //
					'title' => 'Ketua Bagian (Departemen) - Skripsi - Proposal',
					'subtitle' => 'Diterima',
					'section' => 'backend/dosen/skripsi/proposal/kadep_diterima',
					// DATA //
					'proposal' => $this->skripsi->read_kadep_diterima($id_departemen)
				);
				//print_r($data['proposal']);die();
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function selesai()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {

				$data = array(
					// PAGE //
					'title' => 'Ketua Bagian (Departemen) - Skripsi - Proposal',
					'subtitle' => 'Selesai',
					'section' => 'backend/dosen/skripsi/proposal/kadep_selesai',
					// DATA //
					'proposal' => $this->skripsi->read_kadep_selesai($id_departemen)
				);
				//print_r($data['proposal']);die();
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function ditolak()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {

				$data = array(
					// PAGE //
					'title' => 'Ketua Bagian (Departemen) - Skripsi - Proposal',
					'subtitle' => 'Ditolak',
					'section' => 'backend/dosen/skripsi/proposal/kadep_ditolak',
					// DATA //
					'proposal' => $this->skripsi->read_kadep_ditolak($id_departemen)
				);
				//print_r($data['proposal']);die();
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function edit()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {
				$id_skripsi = $this->uri->segment('6');

				$data = array(
					// PAGE //
					'title' => 'Ketua Bagian (Departemen) - Skripsi - Proposal',
					'subtitle' => 'Edit Proposal',
					'section' => 'backend/dosen/skripsi/proposal/pengajuan_detail',
					'use_back' => true,
					'back_link' => 'dosen/sarjana/kadep/proposal/diterima',
					// DATA //
					'proposal' => $this->skripsi->detail_proposal($id_skripsi),
					'departemen' => $this->departemen->read()
				);

				if ($data['proposal']) {
					$this->load->view('backend/index_sidebar', $data);
				} else {
					$data['section'] = 'backend/notification/danger';
					$data['msg'] = 'Tidak ditemukan';
					$data['linkback'] = 'dashboardd/proposal/kadep_pengajuan';
					$this->load->view('backend/index_sidebar', $data);
				}

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function plot()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {
				$id_skripsi = $this->uri->segment('6');

				$data = array(
					// PAGE //
					'title' => 'Ketua Bagian (Departemen) - Skripsi - Proposal',
					'subtitle' => 'Setting Ujian',
					'section' => 'backend/dosen/skripsi/proposal/plot',
					'use_back' => true,
					'back_link' => 'dosen/sarjana/kadep/proposal/diterima',
					// DATA //
					'proposal' => $this->skripsi->detail_proposal($id_skripsi),
					'mruang' => $this->ruang->read_aktif(),
					'mjam' => $this->jam->read_aktif(),
					'mdosen' => $this->dosen->read_aktif_alldep(),
					'ujian' => $this->skripsi->read_jadwal($id_skripsi, UJIAN_SKRIPSI_PROPOSAL),
					'pembimbing' => $this->skripsi->read_pembimbing($id_skripsi),
				);
				if ($data['proposal']) {
					$this->load->view('backend/index_sidebar', $data);
				} else {
					$data['section'] = 'backend/notification/danger';
					$data['msg'] = 'Tidak ditemukan';
					$data['linkback'] = 'dashboardd/proposal/kadep_diterima';
					$this->load->view('backend/index_sidebar', $data);
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function plot_pembimbing()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {
				$id_skripsi = $this->uri->segment('6');

				$data = array(
					// PAGE //
					'title' => 'Ketua Bagian (Departemen) - Skripsi - Proposal',
					'subtitle' => 'Setting Pembimbing',
					'section' => 'backend/dosen/skripsi/proposal/plot_pembimbing',
					'use_back' => true,
					'back_link' => 'dosen/sarjana/kadep/proposal/selesai',
					// DATA //
					'proposal' => $this->skripsi->detail_proposal($id_skripsi),
					'mdosen' => $this->dosen->read_aktif_alldep(),
					'ujian' => $this->skripsi->read_jadwal($id_skripsi, UJIAN_SKRIPSI_PROPOSAL),
					'pembimbing' => $this->skripsi->read_pembimbing($id_skripsi),
				);
				if ($data['proposal']) {
					$this->load->view('backend/index_sidebar', $data);
				} else {
					$data['section'] = 'backend/notification/danger';
					$data['msg'] = 'Tidak ditemukan';
					$data['linkback'] = 'dashboardd/proposal/selesai';
					$this->load->view('backend/index_sidebar', $data);
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function plot_ulang()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {
				$id_skripsi = $this->uri->segment('6');

				$data = array(
					// PAGE //
					'title' => 'Ketua Bagian (Departemen) - Skripsi - Proposal',
					'subtitle' => 'Setting Ujian',
					'section' => 'backend/dosen/skripsi/proposal/plot_ulang',
					'use_back' => true,
					'back_link' => 'dosen/sarjana/kadep/proposal/ditolak',
					// DATA //
					'proposal' => $this->skripsi->detail_proposal($id_skripsi),
					'mruang' => $this->ruang->read_aktif(),
					'mjam' => $this->jam->read_aktif(),
					'mdosen' => $this->dosen->read_aktif_alldep(),
					'riwayat_ujians' => $this->skripsi->read_jadwal_riwayat($id_skripsi, UJIAN_SKRIPSI_PROPOSAL),
					'ujian' => $this->skripsi->read_jadwal($id_skripsi, UJIAN_SKRIPSI_PROPOSAL),
					'pembimbing' => $this->skripsi->read_pembimbing($id_skripsi),
				);
				if ($data['proposal']) {
					$this->load->view('backend/index_sidebar', $data);
				} else {
					$data['section'] = 'backend/notification/danger';
					$data['msg'] = 'Tidak ditemukan';
					$data['linkback'] = 'dashboardd/proposal/kadep_diterima';
					$this->load->view('backend/index_sidebar', $data);
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_proses()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);

				$data = array(
					'status_proposal' => $this->input->post('status_proposal', true),
					'keterangan_proposal' => $this->input->post('keterangan_proposal', true),
				);
				$this->proposal->update($data, $id_skripsi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update proses');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}


		public function update_departemen()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$data = array(
					'id_departemen' => $this->input->post('id_departemen', true),
				);
				$this->proposal->update($data, $id_skripsi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update departemen. Data pengajuan proposal akan berpindah ke departemen yang dituju.');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function ujian_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$struktural = $this->struktural->read_struktural($this->session_data['username']);
				$id_departemen = $struktural->id_departemen;
				if ($struktural->id_struktur == '5') {
					$id_skripsi = $this->input->post('id_skripsi', true);
					$ujian = $this->skripsi->read_ujian_proposal($id_skripsi);
					$data_skripsi = [
						'status_proposal' => STATUS_SKRIPSI_PROPOSAL_DIJADWALKAN
					];
					if ($ujian) { // JIKA SUDAH ADA
						//echo 'jadwal sudah ada. tambah script update';  die();
						$id_ujian = $this->input->post('id_ujian');

						$data = array(
							'id_skripsi' => $id_skripsi,
							'id_ruang' => $this->input->post('id_ruang', true),
							'id_jam' => $this->input->post('id_jam', true),
							'tanggal' => todb($this->input->post('tanggal', true)),
							'status' => 1,
							'status_ujian' => 1
						);

						$cek_jadwal = $this->skripsi->cek_ruang_terpakai($data);

						if ($cek_jadwal) {
							$this->session->set_flashdata('msg-title', 'alert-danger');
							$this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
							redirect_back();
						} else {
							$penguji = $this->skripsi->read_penguji($id_ujian);

							if ($penguji) {
								foreach ($penguji as $list) {
									$bentrok = $this->skripsi->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
									break;
								}

								if ($bentrok) {

									$this->session->set_flashdata('msg-title', 'alert-danger');
									$this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
									redirect_back();
								} else {
									$this->skripsi->update_ujian($data, $id_ujian);

									$this->session->set_flashdata('msg-title', 'alert-success');
									$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
									redirect_back();
								}
							} else { //langsung update
								$this->skripsi->update_ujian($data, $id_ujian);

								$this->session->set_flashdata('msg-title', 'alert-success');
								$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
								redirect_back();
							}
						}
					} else { //JIKA BELUM ADA SAVE BARU

						$this->skripsi->update($data_skripsi, $id_skripsi);
						$data = array(
							'id_skripsi' => $id_skripsi,
							'id_ruang' => $this->input->post('id_ruang', true),
							'id_jam' => $this->input->post('id_jam', true),
							'tanggal' => todb($this->input->post('tanggal', true)),
							'jenis_ujian' => 1,
							'status' => 1,
							'status_ujian' => 1
						);

						$cek_jadwal = $this->skripsi->cek_ruang_terpakai($data);

						if ($cek_jadwal) {
							$this->session->set_flashdata('msg-title', 'alert-danger');
							$this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
							redirect_back();
						} else {
							$this->skripsi->save_ujian($data);

							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
							redirect_back();
						}
					}
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
					redirect_back();
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function ujian_ulang_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$struktural = $this->struktural->read_struktural($this->session_data['username']);
				$id_departemen = $struktural->id_departemen;
				if ($struktural->id_struktur == '5') {
					$is_update = $this->input->post('is_update', true);
					$id_ujian = $this->input->post('id_ujian', true);
					$id_skripsi = $this->input->post('id_skripsi', true);
					if ($is_update) {
						$data = array(
							'id_skripsi' => $id_skripsi,
							'id_ruang' => $this->input->post('id_ruang', true),
							'id_jam' => $this->input->post('id_jam', true),
							'tanggal' => todb($this->input->post('tanggal', true)),
							'status' => 1,
							'status_ujian' => 2
						);

						$penguji = $this->skripsi->read_penguji_aktif($id_ujian);

						if ($penguji) {
							foreach ($penguji as $list) {
								$bentrok = $this->skripsi->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
								break;
							}

							if ($bentrok) {
								$this->session->set_flashdata('msg-title', 'alert-danger');
								$this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
								redirect_back();
							} else {
								$this->skripsi->update_ujian($data, $id_ujian);

								$this->session->set_flashdata('msg-title', 'alert-success');
								$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
								redirect_back();
							}
						} else {
							//langsung update
							$this->skripsi->update_ujian($data, $id_ujian);

							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
							redirect_back();
						}
					} else {

						$data = array(
							'id_skripsi' => $id_skripsi,
							'id_ruang' => $this->input->post('id_ruang', true),
							'id_jam' => $this->input->post('id_jam', true),
							'tanggal' => todb($this->input->post('tanggal', true)),
							'jenis_ujian' => UJIAN_SKRIPSI_PROPOSAL,
							'status' => 1,
							'status_ujian' => 2
						);
						$ujian_sebelum = $this->skripsi->read_ujian_selesai($id_skripsi, UJIAN_SKRIPSI_PROPOSAL);
						$penguji_sebelums = $this->skripsi->read_penguji_aktif($ujian_sebelum->id_ujian);
						foreach ($penguji_sebelums as $list) {
							$bentrok = $this->skripsi->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
							break;
						}
						if ($bentrok) {
							$this->session->set_flashdata('msg-title', 'alert-danger');
							$this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
							redirect_back();
						} else {
							$this->skripsi->save_ujian($data);
							$ujian_aktif = $this->skripsi->read_ujian_aktif($id_skripsi, UJIAN_SKRIPSI_PROPOSAL);
							$this->skripsi->copy_penguji($penguji_sebelums, $ujian_aktif->id_ujian);
							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
							redirect_back();
						}
					}
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Akses ditolak');
					redirect_back();
				}
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
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$nip = $this->input->post('nip', true);

				$data = array(
					'id_ujian' => $id_ujian,
					'nip' => $this->input->post('nip', true),
					'status_tim' => 2,
					'status' => 1
				);

				$cekpenguji = $this->skripsi->cek_penguji($data);
				if ($cekpenguji) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar.');
					redirect_back();
				} else {
					$ujian = $this->skripsi->read_ujian_proposal($id_skripsi);
					$tanggal = $ujian->tanggal;
					$id_jam = $ujian->id_jam;
					$pengujibentrok = $this->skripsi->read_pengujibentrok($tanggal, $id_jam, $nip);

					if ($pengujibentrok) {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
						redirect_back();
					} else {
						$jumlah_penguji = $this->skripsi->count_penguji($id_ujian);
						if ($jumlah_penguji < '3') {

							$this->skripsi->save_penguji($data);
							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', "Penguji belum sesuai");
							redirect_back();
						} else if ($jumlah_penguji >= '3') {
							$this->session->set_flashdata('msg-title', 'alert-danger');
							$this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji 3');
							redirect_back();
						}
					}
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function penguji_delete()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_penguji = $this->input->post('id_penguji', true);

				$data = array(
					'status' => 0,
				);

				$this->skripsi->update_penguji($data, $id_penguji);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
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
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_penguji = $this->input->post('id_penguji', true);
				$id_ujian = $this->input->post('id_ujian', true);

				$data = array(
					'status_tim' => $this->input->post('status_tim'),
				);
				if ($data['status_tim'] == '1') {
					//cek ketua
					$ketua = $this->skripsi->read_pengujiketua($id_ujian);
					if ($ketua) {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Gagal update tim penguji. Ketua sudah ada.');
						redirect_back();
					} else {
						$this->skripsi->update_penguji($data, $id_penguji);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil set ketua penguji.');
						redirect_back();
					}
				} else if ($data['status_tim'] == '2') {
					$this->skripsi->update_penguji($data, $id_penguji);
					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update tim penguji.');
					redirect_back();
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function penguji_kirim_whatsapp()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$skripsi = $this->skripsi->detail_proposal($id_skripsi);
				$ujian = $this->skripsi->read_ujian_proposal($id_skripsi);
				$pengujis = $this->skripsi->read_penguji($ujian->id_ujian);
				foreach ($pengujis as $penguji) {
					$judul_notifikasi = 'Permintaan Penguji Proposal';
					$isi_notifikasi = 'Mohon kesediaanya untuk menjadi penguji proposal skripsi mahasiswa dengan Nim ' . $skripsi->nim . ' pada sistem IURIS';
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

		public function pembimbing_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$nip = $this->input->post('nip', true);

				$datap = array(
					'id_skripsi' => $id_skripsi,
					'nip' => $nip,
					'status' => 1,
					'status_bimbingan' => 2
				);

				$hitungbimbingan = $this->skripsi->hitung_bimbingan_aktif($nip);

				if ($hitungbimbingan < '10') {
					$cekpembimbing = $this->skripsi->cek_pembimbing($id_skripsi);

					if ($cekpembimbing) {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Gagal simpan. Pembimbing sudah ada.');
						redirect_back();
					} else {
						$this->skripsi->save_pembimbing($datap);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil simpan pembimbing');
						redirect_back();
					}
				} else if ($hitungbimbingan >= '10') {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Gagal simpan. Pembimbing sudah aktif 10 bimbingan.');
					redirect_back();
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function pembimbing_delete()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_pembimbing = $this->input->post('id_pembimbing', true);

				$this->skripsi->delete_pembimbing( $id_pembimbing);
				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil hapus pembimbing');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function pembimbing_konfirm()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_pembimbing = $this->input->post('id_pembimbing', true);

				$data_skripsi = [
					'status_proposal' => STATUS_SKRIPSI_PROPOSAL_PEMBIMBING
				];
				$this->skripsi->update($data_skripsi, $id_skripsi);

				$datap = array(
					'status' => 2,
					'status_bimbingan' => 2
				);
				$this->skripsi->update_pembimbing($datap, $id_pembimbing);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil simpan pembimbing');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_status_ujian()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			$id_skripsi = $this->input->post('id_skripsi', true);
			$proposal = $this->proposal->detail($id_departemen, $id_skripsi);

			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {

				$cekpembimbing = $this->skripsi->cek_pembimbing($id_skripsi);

				if ($cekpembimbing) {
					//CK INI
					$status_ujian_proposal = $this->input->post('status_ujian_proposal', true);

					$data = array(
						'status_ujian_proposal' => $status_ujian_proposal,
					);
					$this->proposal->update($data, $id_skripsi);

					//trigger
					if ($status_ujian_proposal == '0') { //belum ujian
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil update proses');
						redirect_back();
					} else if ($status_ujian_proposal == '1') { //layak
						$cekskripsi = $this->skripsi->cekskripsi($proposal->nim);

						if ($cekskripsi) {
							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil update proses');
							redirect_back();
						} else {
							//update proposal selesai
							$data = array(
								'status_proposal' => STATUS_SKRIPSI_PROPOSAL_SELESAI,
								'jenis' => TAHAPAN_SKRIPSI_UJIAN,
							);
							$this->proposal->update($data, $id_skripsi);

							// trigger pembimbing
							$cekpembimbing = $this->skripsi->cek_pembimbing($id_skripsi);

							$datap = array(
								'id_skripsi' => $id_skripsi,
								'nip' => $cekpembimbing->nip,
								'status' => 2,
								'status_bimbingan' => 2
							);
							$this->skripsi->update_pembimbing($datap, $cekpembimbing->id_pembimbing);

							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil update proses. Data akan diteruskan ke Proposal Skripsi Selesai.');
							redirect_back();
							//end sini
						}
					} else if ($status_ujian_proposal == '2') { //layak dengan catatan
						$cekskripsi = $this->proposal->cekskripsi($proposal->nim);

						if ($cekskripsi) {
							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil update proses');
							redirect_back();
						} else {
							//update proposal selesai
							$data = array(
								'status_proposal' => STATUS_SKRIPSI_PROPOSAL_SELESAI,
								'jenis' => TAHAPAN_SKRIPSI_UJIAN,
							);
							$this->proposal->update($data, $id_skripsi);

							// trigger pembimbing
							$cekpembimbing = $this->proposal->cek_pembimbing($id_skripsi);

							$datap = array(
								'id_skripsi' => $id_skripsi,
								'nip' => $cekpembimbing->nip,
								'status' => 2,
								'status_bimbingan' => 2
							);
							$this->skripsi->update_pembimbing($datap, $cekpembimbing->id_pembimbing);

							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil update proses. Data akan diteruskan ke Proposal Skripsi Selesai.');
							redirect_back();
							//end sini
						}
					} else if ($status_ujian_proposal == '3') { //tidak layak
					}
				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Gagal simpan. Input Pembimbing terlebih dahulu.');
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
