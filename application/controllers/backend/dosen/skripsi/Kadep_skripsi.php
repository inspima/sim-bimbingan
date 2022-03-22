<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Kadep_skripsi extends CI_Controller
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
			$this->load->model('backend/dosen/skripsi/Kadep_skripsi_model', 'skripsi');
			$this->load->model('backend/administrator/master/ruang_model', 'ruang');
			$this->load->model('backend/administrator/master/jam_model', 'jam');
			$this->load->model('backend/transaksi/penjadwalan', 'penjadwalan');
			$this->load->model('backend/transaksi/skripsi', 'transaksi_skripsi');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			//END MODEL
		}

		public function index()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {

				$data = array(
					// PAGE //
					'title' => 'Skripsi',
					'subtitle' => 'Data Skripsi',
					'section' => 'backend/dosen/skripsi/kadep_skripsi',
					// DATA //
					'skripsi' => $this->skripsi->read($id_departemen)
				);
				//print_r($data['skripsi']);die();
				//var_dump($data[skripsi]);
				$this->load->view('backend/index_sidebar', $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function ujian()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {
				$id_skripsi = $this->uri->segment('5');

				$data = array(
					// PAGE //
					'title' => 'Skripsi (Modul Kepala Bagian)',
					'subtitle' => 'Data Skripsi',
					'section' => 'backend/dosen/skripsi/kadep_skripsi_ujian',
					// DATA //
					'skripsi' => $this->skripsi->detail($id_departemen, $id_skripsi),
					'ujian' => $this->skripsi->read_ujian($id_skripsi),
					'id_departemen' => $id_departemen
				);

				if ($data['skripsi']) {
					$this->load->view('backend/index_sidebar', $data);
				} else {
					$data['section'] = 'backend/notification/danger';
					$data['msg'] = 'Tidak ditemukan';
					$data['linkback'] = 'dashboardd/skripsi/kadep_skripsi';
					$this->load->view('backend/index_sidebar', $data);
				}

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}


		public function ujian_simpan()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {
				$id_skripsi = $this->input->post('id_skripsi');

				$data = array(
					'skripsi' => $this->skripsi->detail($id_departemen, $id_skripsi),
				);

				if ($data['skripsi']) {
					$cekujian = $this->skripsi->cek_ujian($id_skripsi);

					if ($cekujian) {
						// simpan sebagai ulang
						$datau = array(
							'id_skripsi' => $id_skripsi,
							'status_ujian' => 2,
							'status' => 1,
							'jenis_ujian' => 2
						);
						$this->skripsi->save_ujian($datau);

						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil Simpan Ujian');
						redirect('dashboardd/skripsi/kadep_skripsi/ujian/' . $id_skripsi);
					} else {
						$datau = array(
							'id_skripsi' => $id_skripsi,
							'status_ujian' => 1,
							'status' => 1,
							'jenis_ujian' => 2
						);
						$this->skripsi->save_ujian($datau);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil Simpan Ujian');
						redirect('dashboardd/skripsi/kadep_skripsi/ujian/' . $id_skripsi);
					}

				} else {
					$data['section'] = 'backend/notification/danger';
					$data['msg'] = 'Tidak ditemukan';
					$data['linkback'] = 'dashboardd/skripsi/kadep_skripsi';
					$this->load->view('backend/index_sidebar', $data);
				}

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function ujian_plot()
		{
			$struktural = $this->struktural->read_struktural($this->session_data['username']);
			$id_departemen = $struktural->id_departemen;
			if ($struktural->id_struktur == '5') {
				$id_skripsi = $this->uri->segment('5');
				$id_ujian = $this->uri->segment('6');

				$data = array(
					// PAGE //
					'title' => 'Skripsi (Modul Kepala Bagian)',
					'subtitle' => 'Data Skripsi',
					'section' => 'backend/dosen/skripsi/kadep_skripsi_ujian_plot',
					// DATA //
					'skripsi' => $this->skripsi->detail($id_departemen, $id_skripsi),
					'nid_ujian' => $this->skripsi->cek_id_ujian($id_ujian, $id_skripsi),
					'ujian' => $this->skripsi->detail_ujian($id_ujian),
					'mruang' => $this->ruang->read_aktif(),
					'mjam' => $this->jam->read_aktif_by_jenjang(JENJANG_S1),
					'mdosen' => $this->dosen->read_aktif_alldep(),
				);

				if ($data['skripsi'] && $data['nid_ujian']) {
					//ambil data pembimbing dan penguji jika baru
					$pengujipembimbing = $this->skripsi->read_pengujipembimbing($id_ujian);
					if ($pengujipembimbing) {

					} else {
						$pembimbing = $this->skripsi->read_pembimbing($id_skripsi);
						$datap = array(
							'id_ujian' => $id_ujian,
							'nip' => $pembimbing->nip,
							'status_tim' => 2,
							'usulan_dosbing' => 2,
							'status' => 1
						);
						$this->skripsi->save_pengujip($datap);
					}

					//cek penguji pengajuan pembimbing
					$pengujipengajuanpembimbing = $this->skripsi->read_pengujipengajuanpembimbing($id_ujian);
					if ($pengujipengajuanpembimbing) {

					} else {
						$pengujitemp = $this->skripsi->read_pengujitemp($id_skripsi);
						$datap = array(
							'id_ujian' => $id_ujian,
							'nip' => $pengujitemp->nip,
							'status_tim' => 2,
							'usulan_dosbing' => 1,
							'status' => 1
						);
						$this->skripsi->save_pengujip($datap);
					}

					$this->load->view('backend/index_sidebar', $data);
				} else {
					$data['section'] = 'backend/notification/danger';
					$data['msg'] = 'Tidak ditemukan';
					$data['linkback'] = 'dashboardd/skripsi/kadep_skripsi';
					$this->load->view('backend/index_sidebar', $data);
				}

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function ujian_plot_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$struktural = $this->struktural->read_struktural($this->session_data['username']);
				$id_departemen = $struktural->id_departemen;
				if ($struktural->id_struktur == '5') {
					$id_skripsi = $this->input->post('id_skripsi', true);
					$id_ujian = $this->input->post('id_ujian', true);


					$data = array(
						'id_ruang' => $this->input->post('id_ruang', true),
						'id_jam' => $this->input->post('id_jam', true),
						'tanggal' => todb($this->input->post('tanggal', true)),
					);

					$cek_jadwal_bentrok = $this->penjadwalan->cekBentrokJadwal($data['id_ruang'], $data['tanggal'], $data['id_jam']);

					if ($cek_jadwal_bentrok['status']) {
						$pengujis = $this->skripsi->read_penguji_tanpatolak($id_ujian);

						if ($pengujis) {
							$cek_penguji_bentrok = $this->penjadwalan->cekBentrokPengujis($pengujis, $data['tanggal'], $data['id_jam']);
							if ($cek_penguji_bentrok['status']) {

								$this->skripsi->update_ujian($data, $id_ujian);

								$this->session->set_flashdata('msg-title', 'alert-success');
								$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
								redirect('dashboardd/skripsi/kadep_skripsi/ujian_plot/' . $id_skripsi . '/' . $id_ujian);
							} else {
								$this->session->set_flashdata('msg-title', 'alert-danger');
								$this->session->set_flashdata('msg', $cek_penguji_bentrok['message']);
								redirect('dashboardd/skripsi/kadep_skripsi/ujian_plot/' . $id_skripsi . '/' . $id_ujian);
							}
						} else {
							$this->skripsi->update_ujian($data, $id_ujian);

							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
							redirect('dashboardd/skripsi/kadep_skripsi/ujian_plot/' . $id_skripsi . '/' . $id_ujian);
						}
					} else {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', $cek_jadwal_bentrok['message']);
						redirect_back();
					}

				} else {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
					redirect('dashboardd');
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd');
			}
		}

		public function plot_ulang()
		{
			$id_skripsi = $this->uri->segment('6');

			$data = array(
				// PAGE //
				'title' => 'Skripsi - Proposal ',
				'subtitle' => 'Penjadwalan Ulang Ujian',
				'section' => 'backend/dosen/skripsi/ujian/plot_ulang',
				'use_back' => true,
				'back_link' => 'dosen/dokumen/berita_acara',
				// DATA //
				'skripsi' => $this->transaksi_skripsi->detail_by_id($id_skripsi),
				'mruang' => $this->ruang->read_aktif(),
				'mjam' => $this->jam->read_aktif_by_jenjang(JENJANG_S1),
				'mdosen' => $this->dosen->read_aktif_alldep(),
				'riwayat_ujians' => $this->transaksi_skripsi->read_jadwal_riwayat($id_skripsi, UJIAN_SKRIPSI_UJIAN),
				'ujian' => $this->transaksi_skripsi->read_jadwal($id_skripsi, UJIAN_SKRIPSI_UJIAN),
				'pembimbing' => $this->transaksi_skripsi->read_pembimbing($id_skripsi),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function penguji_plot_save()
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
					redirect('dashboardd/skripsi/kadep_skripsi/ujian_plot/' . $id_skripsi . '/' . $id_ujian);
				} else {
					$ujian = $this->skripsi->read_ujian_row($id_skripsi);

					$tanggal = $ujian->tanggal;
					$id_jam = $ujian->id_jam;
					$cek_penguji_bentrok = $this->penjadwalan->cekBentrokPenguji($nip, $ujian->tanggal, $ujian->id_jam);
					if ($cek_penguji_bentrok['status']) {

						$jumlah_penguji = $this->skripsi->count_penguji($id_ujian);
						if ($jumlah_penguji < '5') {

							// START EMAIL
							/*$this->load->library('email');

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

							$this->skripsi->save_penguji($data);
							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil disimpan');
							redirect('dashboardd/skripsi/kadep_skripsi/ujian_plot/' . $id_skripsi . '/' . $id_ujian);
						} else if ($jumlah_penguji >= '5') {
							$this->session->set_flashdata('msg-title', 'alert-danger');
							$this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji 5');
							redirect('dashboardd/skripsi/kadep_skripsi/ujian_plot/' . $id_skripsi . '/' . $id_ujian);
						}
					} else {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', $cek_penguji_bentrok['message']);
						redirect('dashboardd/skripsi/kadep_skripsi/ujian_plot/' . $id_skripsi . '/' . $id_ujian);
					}
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/skripsi/kadep_skripsi');
			}
		}

		public function penguji_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$nip = $this->input->post('nip', true);
				$is_ulang = $this->input->post('is_ulang', true);

				$data = array(
					'id_ujian' => $id_ujian,
					'nip' => $this->input->post('nip', true),
					'status_tim' => 2,
					'status' => $is_ulang == '1' ? 2 : 1,
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
				$id_ujian = $this->input->post('id_ujian', true);
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

		public function ujian_ulang_save()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
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

					$pengujis = $this->transaksi_skripsi->read_penguji_aktif($id_ujian);

					if ($pengujis) {
						$cek_penguji_bentrok = $this->penjadwalan->cekBentrokPengujis($pengujis, $data['tanggal'], $data['id_jam']);
						if ($cek_penguji_bentrok['status']) {
							$this->transaksi_skripsi->update_ujian($data, $id_ujian);

							$this->session->set_flashdata('msg-title', 'alert-success');
							$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
							redirect_back();
						} else {

							$this->session->set_flashdata('msg-title', 'alert-danger');
							$this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
							redirect_back();
						}
					} else {
						//langsung update
						$this->transaksi_skripsi->update_ujian($data, $id_ujian);

						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
						redirect_back();
					}
				} else {

					$ujian_sebelum = $this->transaksi_skripsi->read_ujian_selesai($id_skripsi, UJIAN_SKRIPSI_UJIAN);
					$penguji_sebelums = $this->transaksi_skripsi->read_penguji_aktif($ujian_sebelum->id_ujian);
					$data = array(
						'id_skripsi' => $id_skripsi,
						'id_ruang' => $this->input->post('id_ruang', true),
						'id_jam' => $this->input->post('id_jam', true),
						'tanggal' => todb($this->input->post('tanggal', true)),
						'jenis_ujian' => UJIAN_SKRIPSI_UJIAN,
						'id_ujian_referensi' => $ujian_sebelum->id_ujian,
						'status' => 1,
						'status_ujian' => 2
					);
					$cek_penguji_bentrok = $this->penjadwalan->cekBentrokPengujis($penguji_sebelums, $data['tanggal'], $data['id_jam']);
					if ($cek_penguji_bentrok['status']) {
						$this->transaksi_skripsi->save_ujian($data);
						$ujian_aktif = $this->transaksi_skripsi->read_ujian_aktif($id_skripsi, UJIAN_SKRIPSI_UJIAN);
						$this->transaksi_skripsi->copy_penguji($penguji_sebelums, $ujian_aktif->id_ujian);
						$this->session->set_flashdata('msg-title', 'alert-success');
						$this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
						redirect_back();
					} else {
						$this->session->set_flashdata('msg-title', 'alert-danger');
						$this->session->set_flashdata('msg', $cek_penguji_bentrok['save']);
						redirect_back();
					}
				}
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function update_pembimbing()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$nip = $this->input->post('nip', true);

				$pembimbinglama = $this->skripsi->read_pembimbinglama($id_skripsi);

				foreach ($pembimbinglama as $list) {
					$id_pembimbing = $list['id_pembimbing'];
					$datal = array(
						'status' => 4,
						'status_bimbingan' => 4
					);
					$this->skripsi->nonaktif_pembimbing($id_pembimbing, $datal);
				}

				$datap = array(
					'id_skripsi' => $this->input->post('id_skripsi', true),
					'nip' => $this->input->post('nip', true),
					'status' => 2,
					'status_bimbingan' => 2
				);

				$this->skripsi->save_pembimbing($datap);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Berhasil update penguji.');
				redirect('dashboardd/skripsi/kadep_skripsi/ujian/' . $id_skripsi);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/skripsi/kadep_skripsi');
			}
		}

	}

?>
