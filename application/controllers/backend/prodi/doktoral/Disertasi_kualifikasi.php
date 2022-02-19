<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Disertasi_kualifikasi extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != ROLE_ADMIN_PRODI) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/master/setting', 'setting');
			$this->load->model('backend/master/semester', 'semester');
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/administrator/master/Struktural_model', 'struktural');
			$this->load->model('backend/administrator/master/ruang_model', 'ruang');
			$this->load->model('backend/administrator/master/jam_model', 'jam');
			$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/transaksi/dokumen', 'dokumen');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/utility/qr', 'qrcode');
			//END MODEL
			// LIBRARY
			$this->load->library('encryption');
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Admin Prodi',
				'subtitle' => 'Disertasi - Ujian Kualifikasi',
				'section' => 'backend/prodi/doktoral/kualifikasi/index',
				// DATA //
				'disertasi' => $this->disertasi->read_kualifikasi(),
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function setting()
		{
			$id_disertasi = $this->uri->segment('6');
			$data = array(
				// PAGE //
				'title' => 'Disertasi - Kualifikasi',
				'subtitle' => 'Setting',
				'section' => 'backend/prodi/doktoral/kualifikasi/setting',
				'use_back' => true,
				'back_link' => 'prodi/doktoral/disertasi/kualifikasi',
				// DATA //
				'disertasi' => $this->disertasi->detail($id_disertasi),
				'mdosen' => $this->dosen->read_aktif_alldep_s3(),
			);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function penasehat_update()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = array(
					'nip_penasehat' => $this->input->post('nip', true),

				);
				$this->disertasi->update($data, $id_disertasi);

				$this->session->set_flashdata('msg-title', 'alert-success');
				$this->session->set_flashdata('msg', 'Data berhasil disimpan..');
				redirect_back();
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function cetak_sk_penasehat_old()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$no_sk = $this->input->post('no_sk', true);
				$disertasi = $this->disertasi->detail($id_disertasi);
				// Jika Status belum cetak SK
				if ($disertasi->status_kualifikasi < STATUS_DISERTASI_KUALIFIKASI_CETAK_SK_PENASEHAT) {
					$data = array(
						'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_CETAK_SK_PENASEHAT,

					);
					$this->disertasi->update($data, $id_disertasi);
				}

				$data = array(
					'no_sk' => $no_sk,
					'semester' => $this->semester->detail_berjalan(),
					'disertasi' => $disertasi,
					'wadek' => $this->struktural->read_wadek1(),
					'kps_s3' => $this->struktural->read_kps_s3(),
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$header = 'backend/widgets/common/pdf_header';
				$page = 'backend/prodi/doktoral/kualifikasi/cetak_sk_penasehat';
				$size = 'a4';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "SURAT KEPUTUSAN - PENASEHAT AKADEMIK - " . $disertasi->nim . '.pdf';
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function cetak_sk_penasehat()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$no_sk = $this->input->post('no_sk', true);
				$tgl_sk = $this->input->post('tgl_sk', true);
				$link_dokumen = base_url() . 'document/lihat?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . DOKUMEN_SURAT_KEPUTUSAN . '$' . TAHAPAN_DISERTASI_KUALIFIKASI_STR . '$' . UJIAN_DISERTASI_KUALIFIKASI;
				$link_dokumen_cetak = base_url() . 'document/cetak?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . DOKUMEN_SURAT_KEPUTUSAN . '$' . TAHAPAN_DISERTASI_KUALIFIKASI_STR . '$' . UJIAN_DISERTASI_KUALIFIKASI;
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen SK Ujian', 'Kualifikasi', $disertasi->nim, date('Y-m-d', strtotime($tgl_sk)));
				$qr_content = $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $this->dokumen->generate_kode(DOKUMEN_SURAT_KEPUTUSAN, 'kualifikasi', $disertasi->nim, date('Y-m-d', strtotime($tgl_sk))),
					'tipe' => DOKUMEN_SURAT_KEPUTUSAN,
					'jenis' => DOKUMEN_JENIS_DISERTASI_SK_PENASEHAT_STR,
					'id_tugas_akhir' => $id_disertasi,
					'identitas' => $disertasi->nim,
					'nama' => 'SK Penasehat - ' . $disertasi->nama,
					'deskripsi' => $disertasi->judul,
					'no_doc' => $no_sk,
					'date_doc' => date('Y-m-d', strtotime($tgl_sk)),
					'id_jenjang' => JENJANG_S3,
					'link' => $link_dokumen,
					'link_cetak' => $link_dokumen_cetak,
					'date' => date('Y-m-d', strtotime($tgl_sk)),
					'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$this->dokumen->delete($dokumen->id_dokumen);
				}
				$this->dokumen->save($data_dokumen);
				$dokumen = $this->dokumen->check_by_data($data_dokumen);

				$data = array(
					'dokumen' => $dokumen,
					'semester' => $this->semester->detail_berjalan(),
					'disertasi' => $disertasi,
					'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
					'wadek' => $this->struktural->read_wadek1(),
					'kps_s3' => $this->struktural->read_kps_s3(),
				);
				$page = 'backend/prodi/doktoral/kualifikasi/cetak_sk_penasehat';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "SURAT KEPUTUSAN - PENASEHAT AKADEMIK - " . $disertasi->nim . '.pdf';
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function cetak_undangan()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
				$id_ujian = $ujian->id_ujian;

				$data = array(
					'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
					'pengujis' => $this->disertasi->read_penguji($id_ujian),
					'disertasi' => $this->disertasi->detail($id_disertasi),
					'wadek1' => $this->struktural->read_wadek1()
				);
				$page = 'backend/admin/doktoral/kualifikasi/cetak_undangan';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "disertasi_undangan.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/doktoral/disertasi/kualifikasi/');
			}
		}

		public function cetak_sk_ujian()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
				$jadwal = $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$pengujis = $this->disertasi->read_penguji_anggota($ujian->id_ujian);
				$ketua_penguji = $this->disertasi->read_penguji_ketua($ujian->id_ujian);
				$no_sk = $this->input->post('no_sk', true);
				$tgl_sk = $this->input->post('tgl_sk', true);
				$kode_dokumen = $this->dokumen->generate_kode(DOKUMEN_SK_UJIAN_DISERTASI, DOKUMEN_JENIS_DISERTASI_UJIAN_KUALIFIKASI_STR, $disertasi->nim, $jadwal->tanggal);
				$link_dokumen = base_url() . 'document/lihat_dokumen?doc=' . base64_encode(md5($kode_dokumen));
				$link_dokumen_cetak = base_url() . 'document/cetak_dokumen?doc=' . base64_encode(md5($kode_dokumen));
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen SK Ujian', 'Kualifikasi', $disertasi->nim, $jadwal->tanggal);
				$qr_content = $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $kode_dokumen,
					'tipe' => DOKUMEN_SK_UJIAN_DISERTASI,
					'jenis' => DOKUMEN_JENIS_DISERTASI_UJIAN_KUALIFIKASI_STR,
					'id_tugas_akhir' => $id_disertasi,
					'identitas' => $disertasi->nim,
					'nama' => 'SK Ujian Kualifikasi - ' . $disertasi->nama,
					'deskripsi' => $disertasi->judul,
					'no_doc' => $no_sk,
					'date_doc' => date('Y-m-d', strtotime($tgl_sk)),
					'id_jenjang' => JENJANG_S3,
					'id_jadwal' => $jadwal->id_ujian,
					'link' => $link_dokumen,
					'link_cetak' => $link_dokumen_cetak,
					'date' => $jadwal->tanggal,
					'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$this->dokumen->delete($dokumen->id_dokumen);
				}
				$this->dokumen->save($data_dokumen);
				$dokumen = $this->dokumen->check_by_data($data_dokumen);

				$data = array(
					'dokumen' => $dokumen,
					'jadwal' => $jadwal,
					'pengujis' => $pengujis,
					'ketua_penguji' => $ketua_penguji,
					'disertasi' => $disertasi,
					'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
					'dekan' => $this->struktural->read_dekan(),
					'kps_s3' => $this->struktural->read_kps_s3(),
				);
				$page = 'backend/prodi/doktoral/kualifikasi/cetak_sk_ujian';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "SURAT KEPUTUSAN - UJIAN KUALIFIKASI - " . $disertasi->nim . '.pdf';
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/doktoral/disertasi/kualifikasi/');
			}
		}

		public function cetak_berita()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$link_meeting = $this->input->post('link_meeting', true);
				$ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
				$jadwal = $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$pengujis = $this->disertasi->read_penguji($ujian->id_ujian);
				$ketua_penguji = $this->disertasi->read_penguji_ketua($ujian->id_ujian);
				// Update Link Meeting
				if (!empty($link_meeting)) {
					$data_ujian = [
						'link_meeting' => $link_meeting
					];
					$this->disertasi->update_ujian($data_ujian, $ujian->id_ujian);
				}
				$link_dokumen = base_url() . 'document/lihat?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_DISERTASI_KUALIFIKASI_STR . '$' . UJIAN_DISERTASI_KUALIFIKASI;
				$link_dokumen_cetak = base_url() . 'document/cetak?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_DISERTASI_KUALIFIKASI_STR . '$' . UJIAN_DISERTASI_KUALIFIKASI;
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Kualifikasi', $disertasi->nim, $jadwal->tanggal);
				$qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_STR, 'kualifikasi', $disertasi->nim, $jadwal->tanggal),
					'tipe' => DOKUMEN_BERITA_ACARA_STR,
					'jenis' => DOKUMEN_JENIS_DISERTASI_UJIAN_KUALIFIKASI_STR,
					'id_tugas_akhir' => $id_disertasi,
					'identitas' => $disertasi->nim,
					'nama' => 'Berita Acara Ujian Kualifikasi - ' . $disertasi->nama,
					'deskripsi' => $disertasi->judul,
					'id_jenjang' => JENJANG_S3,
					'id_jadwal' => $jadwal->id_ujian,
					'link' => $link_dokumen,
					'link_cetak' => $link_dokumen_cetak,
					'date' => $jadwal->tanggal,
					'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (empty($dokumen)) {
					$this->dokumen->save($data_dokumen);
				}
				if ($disertasi->status_kualifikasi < STATUS_DISERTASI_KUALIFIKASI_UJIAN) {
					$update_disertasi = [
						'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_CETAK_DOKUMEN
					];
					$update_disertasi = [
						'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_UJIAN
					];
					$this->disertasi->update($update_disertasi, $id_disertasi);
				}
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				// DOKUMEN PERSETUJUAN
				$this->dokumen->generate_persetujuan_berita_acara($pengujis, $dokumen->id_dokumen, JENJANG_S3, $id_disertasi);
				$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
				$data = array(
					'jadwal' => $jadwal,
					'pengujis' => $pengujis,
					'ketua_penguji' => $ketua_penguji,
					'disertasi' => $disertasi,
					'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
					'dokumen_persetujuan' => $dokumen_persetujuan,
					'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
				);
				$page = 'backend/prodi/doktoral/kualifikasi/cetak_berita';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "BERITA ACARA DISERTASI - UJIAN KUALIFIKASI - " . $disertasi->nim . '.pdf';
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/doktoral/disertasi/kualifikasi/');
			}
		}

		public function cetak_penilaian()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = array(
					'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
					'disertasi' => $this->disertasi->detail($id_disertasi)
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$page = 'backend/prodi/doktoral/kualifikasi/cetak_penilaian';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "disertasi_penilaian.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/doktoral/disertasi/kualifikasi/');
			}
		}

		public function cetak_nilai_akhir()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$ujian = $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
				$pengujis = $this->disertasi->read_penguji($ujian->id_ujian);
				$ketua_penguji = $this->disertasi->read_penguji_ketua($ujian->id_ujian);
				$data_dokumen = [
					'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_STR, 'kualifikasi', $disertasi->nim, $ujian->tanggal),
					'tipe' => DOKUMEN_BERITA_ACARA_STR,
					'jenis' => DOKUMEN_JENIS_DISERTASI_UJIAN_KUALIFIKASI_STR,
					'id_tugas_akhir' => $id_disertasi,
					'identitas' => $disertasi->nim,
					'deskripsi' => $disertasi->judul,
					'id_jenjang' => JENJANG_S3,
					'id_jadwal' => $ujian->id_ujian,
					'date' => $ujian->tanggal,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				$data = array(
					'jadwal' => $ujian,
					'dokumen' => $dokumen,
					'disertasi' => $this->disertasi->detail($id_disertasi),
					'pengujis' => $pengujis,
					'ketua_penguji' => $ketua_penguji,
				);
				//print_r($data['penguji_ketua']);die();
				$page = 'backend/prodi/doktoral/kualifikasi/cetak_nilai_akhir';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "disertasi_nilai_akhir.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/doktoral/disertasi/kualifikasi/');
			}
		}

		public function cetak_absensi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$jadwal = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
				$id_ujian = $jadwal->id_ujian;

				$data = array(
					'pengujis' => $this->disertasi->read_penguji($id_ujian),
					'jadwal' => $jadwal,
					'disertasi' => $this->disertasi->detail($id_disertasi)
				);
				$page = 'backend/prodi/doktoral/kualifikasi/cetak_absensi';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "disertasi_absensi.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('baa/doktoral/disertasi/kualifikasi/');
			}
		}

	}

?>
