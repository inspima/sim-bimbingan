<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Kadep_diterima extends CI_Controller
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
			$this->load->model('backend/master/ruang_model', 'ruang');
			$this->load->model('backend/administrator/master/jam_model', 'jam');
			$this->load->model('backend/dosen/proposal/Kadep_diterima_model', 'proposal');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			$this->load->model('backend/transaksi/Skripsi', 'skripsi');
			$this->load->model('backend/transaksi/penjadwalan', 'penjadwalan');
			$this->load->model('backend/utility/notification', 'notifikasi');

			//END MODEL
		}

		public function index()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {

				$data = array(
					// PAGE //
					'title' => 'Pengajuan Proposal (Modul Kepala Bagian)',
					'subtitle' => 'Data Pengajuan Proposal (Diterima)',
					'section' => 'backend/dosen/proposal/kadep_diterima',
					// DATA //
					'proposal' => $this->proposal->read($id_departemen)
				);
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
				$id_skripsi = $this->uri->segment('5');

				$data = array(
					// PAGE //
					'title' => 'Pengajuan Proposal (Modul Kepala Bagian)',
					'subtitle' => 'Data Pengajuan Proposal (Diterima)',
					'section' => 'backend/dosen/proposal/kadep_diterima_detail',
					// DATA //
					'proposal' => $this->proposal->detail($id_departemen, $id_skripsi),
					'departemen' => $this->departemen->read()
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
				redirect('dashboardd');
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
				redirect('dashboardd/proposal/kadep_diterima');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/proposal/kadep_diterima');
			}
		}

		public function plot()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {
				$id_skripsi = $this->uri->segment('5');

				$data = array(
					// PAGE //
					'title' => 'Pengajuan Proposal (Modul Kepala Bagian)',
					'subtitle' => 'Setting Ujian',
					'section' => 'backend/dosen/proposal/kadep_diterima_plot',
					// DATA //
					'proposal' => $this->skripsi->detail_proposal($id_skripsi),
					'mruang' => $this->ruang->read_aktif_by_prodi(S1_ILMU_HUKUM),
					'mjam' => $this->jam->read_aktif_by_jenjang(JENJANG_S1),
					'mdosen' => $this->dosen->read_aktif_alldep(),
					'ujian' => $this->proposal->read_ujian($id_skripsi),
					'pembimbing' => $this->proposal->read_pembimbing($id_skripsi),
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
				redirect('dashboardd');
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
					$ujian = $this->proposal->read_ujian($id_skripsi);
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
						$cek_jadwal_bentrok = $this->penjadwalan->cekBentrokJadwal($data['id_ruang'], $data['tanggal'], $data['id_jam']);

						if ($cek_jadwal_bentrok['status']) {
							$pengujis = $this->skripsi->read_penguji_aktif($id_ujian);

							if ($pengujis) {
								$cek_penguji_bentrok = $this->penjadwalan->cekBentrokPengujis($pengujis, $data['tanggal'], $data['id_jam']);
								if ($cek_penguji_bentrok['status']) {
									$this->proposal->update_ujian($data, $id_ujian);

									$this->session->set_flashdata('msg-title', 'alert-success');
									$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
									redirect_back();
								} else {

									$this->session->set_flashdata('msg-title', 'alert-danger');
									$this->session->set_flashdata('msg', $cek_penguji_bentrok['message']);
									redirect_back();
								}
							} else {
								$this->proposal->update_ujian($data, $id_ujian);

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

						$cek_jadwal = $this->proposal->cek_ruang_terpakai($data);

						if ($cek_jadwal) {
							$this->session->set_flashdata('msg-title', 'alert-danger');
							$this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
							redirect_back();
						} else {
							$this->proposal->save_ujian($data);

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

				$cekpenguji = $this->proposal->cek_penguji($data);
				if ($cekpenguji) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar.');
					redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
				} else {
					$ujian = $this->proposal->read_ujian($id_skripsi);
					$tanggal = $ujian->tanggal;
					$id_jam = $ujian->id_jam;
					$cek_penguji_bentrok = $this->penjadwalan->cekBentrokPenguji($nip, $tanggal, $id_jam);
					if ($cek_penguji_bentrok['status']) {

						$jumlah_penguji = $this->proposal->count_penguji($id_ujian);
						if ($jumlah_penguji < '3') {

							// START EMAIL
							/* $this->load->library('email');

							  $config['protocol'] = 'smtp';
							  $config['smtp_host'] = 'ssl://smtp.gmail.com';
							  $config['smtp_port'] = '465';
							  $config['smtp_user'] = 'usifhua@gmail.com';  //change it
							  $config['smtp_pass'] = 'hukum2012'; //change it
							  $config['charset'] = 'utf-8';
							  $config['newline'] = "\r\n";
							  $config['mailtype'] = 'html';
							  $config['wordwrap'] = TRUE;
							  $this->email->initialize($config);

							  $this->email->set_newline("\r\n");
							  $this->email->from('usifhua@gmail.com', 'IURIS');
							  //CHANGE
							  //$this->email->to('icocspa@fisip.unair.ac.id');
							  $this->email->to('rachmadkuncoro@gmail.com');
							  $this->email->subject('Ada Permintaan IURIS');

							  $msg = "Yth. Dosen<br>Mohon untuk membuka aplikasi iuris anda. Terdapat Penunjukan Penguji Skripsi.<br><br>Tertanda<br>Wakil Dekan I";

							  $this->email->message($msg);

							  if($this->email->send()) // IF EMAIL SUCCESS SEND
							  {
							  $mesg = 'Berhasil set penguji. Email berhasil dikirim.';
							  }
							  else // IF EMAIL GAGAL
							  {
							  $mesg = 'Berhasil set penguji. Email gagal dikirim.';
							  }
							 */

							$this->proposal->save_penguji($data);
							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', "Berhasil disimpan");
							redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
						} else if ($jumlah_penguji >= '3') {
							$this->session->set_flashdata('msg-title', 'alert-danger');
							$this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji 3');
							redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
						}
					} else {

						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', $cek_penguji_bentrok['message']);
						redirect_back();
					}

				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/proposal/kadep_diterima');
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

				$this->proposal->update_penguji($data, $id_penguji);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
				redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/proposal/kadep_diterima');
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
					$ketua = $this->proposal->read_pengujiketua($id_ujian);
					if ($ketua) {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Gagal update tim penguji. Ketua sudah ada.');
						redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
					} else {
						$this->proposal->update_penguji($data, $id_penguji);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil set ketua penguji.');
						redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
					}
				} else if ($data['status_tim'] == '2') {
					$this->proposal->update_penguji($data, $id_penguji);
					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil update tim penguji.');
					redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/proposal/kadep_diterima');
			}
		}

		public function penguji_kirim_whatsapp()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$skripsi = $this->proposal->detail($id_departemen, $id_skripsi);
				$ujian = $this->proposal->read_ujian($id_skripsi);
				$pengujis = $this->proposal->read_penguji($ujian->id_ujian);
				foreach ($pengujis as $penguji) {
					$judul_notifikasi = 'Permintaan Penguji Proposal';
					$isi_notifikasi = 'Mohon kesediaanya untuk menjadi penguji proposal skripsi mahasiswa dengan Nim ' . $skripsi->nim . ' pada sistem IURIS';
					$this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 1, $penguji['nip']);
				}

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Notifikasi whatsapp berhasil dikirim');
				redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/proposal/kadep_diterima');
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
					'status' => 2,
					'status_bimbingan' => 2
				);

				$hitungbimbingan = $this->proposal->hitung_bimbingan_aktif($nip);

				if ($hitungbimbingan < '10') {
					$cekpembimbing = $this->proposal->cek_pembimbing($id_skripsi);

					if ($cekpembimbing) {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', 'Gagal simpan. Pembimbing sudah ada.');
						redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
					} else {
						$this->proposal->save_pembimbing($datap);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil simpan pembimbing');
						redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
					}
				} else if ($hitungbimbingan >= '10') {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Gagal simpan. Pembimbing sudah aktif 10 bimbingan.');
					redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/proposal/kadep_diterima');
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

				$cekpembimbing = $this->proposal->cek_pembimbing($id_skripsi);

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

							//							// trigger ke skripsi
							//							$datas = array(
							//								'id_departemen' => $proposal->id_departemen,
							//								'jenis' => 2,
							//								'nim' => $proposal->nim,
							//							);
							//							$this->proposal->save_skripsi($datas);
							//							$last_id = $this->db->insert_id();
							//
							//							//trigger judul
							//							$judul = $this->proposal->read_judul($id_skripsi);
							//							$dataj = array(
							//								'id_skripsi' => $last_id,
							//								'judul' => $judul->judul,
							//							);
							//
							//							$this->proposal->save_judul($dataj);

							// trigger pembimbing
							$cekpembimbing = $this->proposal->cek_pembimbing($id_skripsi);

							$datap = array(
								'id_skripsi' => $id_skripsi,
								'nip' => $cekpembimbing->nip,
								'status' => 2,
								'status_bimbingan' => 2
							);
							$this->proposal->save_pembimbing($datap);

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

							//							// trigger ke skripsi
							//							$datas = array(
							//								'id_departemen' => $proposal->id_departemen,
							//								'jenis' => 2,
							//								'nim' => $proposal->nim,
							//							);
							//							$this->proposal->save_skripsi($datas);
							//							$last_id = $this->db->insert_id();
							//
							//							//trigger judul
							//							$judul = $this->proposal->read_judul($id_skripsi);
							//							$dataj = array(
							//								'id_skripsi' => $last_id,
							//								'judul' => $judul->judul,
							//							);
							//
							//							$this->proposal->save_judul($dataj);

							// trigger pembimbing
							$cekpembimbing = $this->proposal->cek_pembimbing($id_skripsi);

							$datap = array(
								'id_skripsi' => $id_skripsi,
								'nip' => $cekpembimbing->nip,
								'status' => 2,
								'status_bimbingan' => 2
							);
							$this->proposal->save_pembimbing($datap);

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
