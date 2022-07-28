<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Disertasi_tertutup extends CI_Controller
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
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/master/setting', 'setting');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			$this->load->model('backend/transaksi/dokumen', 'dokumen');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/utility/qr', 'qrcode');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Admin Prodi',
				'subtitle' => 'Disertasi - Ujian Tertutup',
				'section' => 'backend/prodi/doktoral/tertutup/index',
				// DATA //
				'disertasi' => $this->disertasi->read_tertutup()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function cetak_undangan()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_TERTUTUP);
				$id_ujian = $ujian->id_ujian;

				$data = array(
					'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_TERTUTUP),
					'pengujis' => $this->disertasi->read_penguji($id_ujian),
					'promotors' => $this->disertasi->read_promotor_kopromotor($id_disertasi),
					'disertasi' => $this->disertasi->detail($id_disertasi),
					'wadek1' => $this->struktural->read_wadek1()
				);
				$page = 'backend/prodi/doktoral/tertutup/cetak_undangan';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "disertasi_undangan.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('prodi/doktoral/disertasi/tertutup/');
			}
		}

		public function cetak_sk_ujian()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_TERTUTUP);
				$jadwal = $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_TERTUTUP);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$pengujis = $this->disertasi->read_penguji_anggota($ujian->id_ujian);
				$ketua_penguji = $this->disertasi->read_penguji_ketua($ujian->id_ujian);
				$no_sk = $this->input->post('no_sk', true);
				$tgl_sk = $this->input->post('tgl_sk', true);
				$kode_dokumen = $this->dokumen->generate_kode(DOKUMEN_SK_UJIAN_DISERTASI, DOKUMEN_JENIS_DISERTASI_UJIAN_TERTUTUP_STR, $disertasi->nim, $jadwal->tanggal);
				$link_dokumen = base_url() . 'document/lihat_dokumen?doc=' . base64_encode(md5($kode_dokumen));
				$link_dokumen_cetak = base_url() . 'document/cetak_dokumen?doc=' . base64_encode(md5($kode_dokumen));
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen SK Ujian', 'Tertutup', $disertasi->nim, $jadwal->tanggal);
				$qr_content = $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $kode_dokumen,
					'tipe' => DOKUMEN_SK_UJIAN_DISERTASI,
					'jenis' => DOKUMEN_JENIS_DISERTASI_UJIAN_TERTUTUP_STR,
					'id_tugas_akhir' => $id_disertasi,
					'identitas' => $disertasi->nim,
					'nama' => 'SK Ujian Tertutup - ' . $disertasi->nama,
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
				$page = 'backend/prodi/doktoral/tertutup/cetak_sk_ujian';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "SURAT KEPUTUSAN - UJIAN TERTUTUP - " . $disertasi->nim . '.pdf';
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function cetak_berita()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$link_meeting = $this->input->post('link_meeting', true);
				$ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_TERTUTUP);
				$jadwal = $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_TERTUTUP);
				$disertasi = $this->disertasi->detail($id_disertasi);
				$pengujis = $this->disertasi->read_penguji($ujian->id_ujian);
				$promotors = $this->disertasi->read_promotor_kopromotor($id_disertasi);
				$ketua_penguji = $this->disertasi->read_penguji_ketua($ujian->id_ujian);
				// Update Link Meeting
				if (!empty($link_meeting)) {
					$data_ujian = [
						'link_meeting' => $link_meeting
					];
					$this->disertasi->update_ujian($data_ujian, $ujian->id_ujian);
				}
				$link_dokumen = base_url() . 'document/lihat?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_DISERTASI_TERTUTUP_STR . '$' . UJIAN_DISERTASI_TERTUTUP;
				$link_dokumen_cetak = base_url() . 'document/cetak?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_DISERTASI_TERTUTUP_STR . '$' . UJIAN_DISERTASI_TERTUTUP;
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Ujian Tertutup', $disertasi->nim, $jadwal->tanggal);
				$qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_STR, 'proposal', $disertasi->nim, $jadwal->tanggal),
					'tipe' => DOKUMEN_BERITA_ACARA_STR,
					'jenis' => DOKUMEN_JENIS_DISERTASI_UJIAN_TERTUTUP_STR,
					'id_tugas_akhir' => $id_disertasi,
					'identitas' => $disertasi->nim,
					'nama' => 'Berita Acara Ujian Tertutup - ' . $disertasi->nama,
					'deskripsi' => $disertasi->judul,
					'link' => $link_dokumen,
					'link_cetak' => $link_dokumen_cetak,
					'date' => $jadwal->tanggal,
					'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
				];
				$dokumen = $this->dokumen->detail_by_data($data_dokumen);
				if (empty($dokumen)) {
					$this->dokumen->save($data_dokumen);
					// Update Disertasi
					$update_disertasi = [
						'status_tertutup' => STATUS_DISERTASI_TERTUTUP_CETAK_DOKUMEN
					];
					$update_disertasi = [
						'status_tertutup' => STATUS_DISERTASI_TERTUTUP_UJIAN
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
					'promotors' => $promotors,
					'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen)
				);
				$page = 'backend/prodi/doktoral/tertutup/cetak_berita';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "disertasi_berita.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('prodi/doktoral/disertasi/tertutup/');
			}
		}

		public function cetak_penilaian()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);
				$data = array(
					'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_TERTUTUP),
					'disertasi' => $this->disertasi->detail($id_disertasi)
				);
				$page = 'backend/prodi/doktoral/tertutup/cetak_penilaian';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "disertasi_penilaian.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('prodi/doktoral/disertasi/tertutup/');
			}
		}

		public function cetak_absensi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_disertasi = $this->input->post('id_disertasi', true);

				$data = array(
					'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_TERTUTUP),
					'disertasi' => $this->disertasi->detail($id_disertasi)
				);
				$page = 'backend/prodi/doktoral/tertutup/cetak_absensi';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "disertasi_absensi.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('prodi/doktoral/disertasi/tertutup/');
			}
		}

	}

?>
