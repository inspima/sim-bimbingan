<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Skripsi_baa extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != 2) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/master/setting', 'setting');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/administrator/master/Departemen_model', 'departemen');
			$this->load->model('backend/baa/skripsi/Skripsi_belum_daftar_model', 'skripsi_daftar');
			$this->load->model('backend/baa/skripsi/skripsi_pengajuan_model', 'skripsi_pengajuan');
			$this->load->model('backend/baa/skripsi/skripsi_diterima_model', 'skripsi_diterima');
			$this->load->model('backend/baa/skripsi/skripsi_ujian_model', 'skripsi_ujian');
			$this->load->model('backend/transaksi/skripsi', 'skripsi');
			$this->load->model('backend/baa/skripsi/Skripsi_penguji_pengajuan_model', 'penguji');
			$this->load->model('backend/transaksi/dokumen', 'dokumen');
			$this->load->model('backend/utility/qr', 'qrcode');
			//END MODEL
		}

		public function index()
		{
			$id_departemen = $this->input->get('dept') ?: '';
			$skripsi = array();
			if ($id_departemen) {
				$skripsi = $this->skripsi_daftar->read_departemen($id_departemen) ?: array();
			} else {
				$skripsi = $this->skripsi_daftar->read();
			}
			$data = array(
				// PAGE //
				'title' => 'Skripsi Belum Daftar',
				'subtitle' => 'Data Skripsi (Mahasiswa Belum Daftar)',
				'section' => 'backend/baa/sarjanah/skripsi/index',
				// DATA //
				// 'skripsi'  => $this->skripsi->read(),
				'skripsi' => $skripsi,
				'list_departemen' => $this->departemen->read(),
				'id_departemen' => $id_departemen,
			);

			//$data['skripsi'] = $this->skripsi->read($data['departemen_berjalan']->id_departemen);
			$this->load->view('backend/index_sidebar', $data);
		}

		public function pengajuan()
		{
			$data = array(
				// PAGE //
				'title' => 'Skripsi Pengajuan',
				'subtitle' => 'Data Skripsi (Pengajuan)',
				'section' => 'backend/baa/sarjanah/skripsi/pengajuan',
				// DATA //
				'skripsi' => $this->skripsi_pengajuan->read()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function diterima()
		{
			$data = array(
				// PAGE //
				'title' => 'Skripsi Diterima',
				'subtitle' => 'Data Skripsi (Diterima)',
				'section' => 'backend/baa/sarjanah/skripsi/diterima',
				// DATA //
				'skripsi' => $this->skripsi_diterima->read()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function ujian()
		{
			$data = array(
				// PAGE //
				'title' => 'Skripsi Ujian',
				'subtitle' => 'Data Skripsi (Ujian)',
				'section' => 'backend/baa/sarjanah/skripsi/ujian',
				// DATA //
				'skripsi' => $this->skripsi_ujian->read()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function belum_approve()
		{
			$data = array(
				// PAGE //
				'title' => 'Penguji Pengajuan',
				'subtitle' => 'Data Penguji (Belum Approve)',
				'section' => 'backend/baa/sarjanah/skripsi/belum_approve',
				// DATA //
				'penguji' => $this->penguji->read()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function cetak_surat_tugas()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$no_sk = $this->input->post('no_sk', true);
				$tgl_sk = $this->input->post('tgl_sk', true);
				$skripsi = $this->skripsi->detail_proposal($id_skripsi);
				$gelombang = $this->skripsi->read_gelombangaktif();
				$pengujis = $this->skripsi->read_penguji_ujian($id_ujian, UJIAN_SKRIPSI_UJIAN);
				$wadek = $this->skripsi->read_wadek();
				// DOKUMEN
				$link_dokumen = base_url() . 'document/lihat_skripsi_surat_tugas?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . DOKUMEN_SURAT_TUGAS_SKRIPSI_PENGUJI_STR . '$' . TAHAPAN_SKRIPSI_UJIAN_STR . '$' . UJIAN_SKRIPSI_UJIAN;
				$link_dokumen_cetak = base_url() . 'document/cetak_skripsi_surat_tugas?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . DOKUMEN_SURAT_TUGAS_SKRIPSI_PENGUJI_STR . '$' . TAHAPAN_SKRIPSI_UJIAN_STR . '$' . UJIAN_SKRIPSI_UJIAN;
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Skripsi', $skripsi->nim, $tgl_sk);
				$qr_content = $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $this->dokumen->generate_kode(DOKUMEN_SURAT_TUGAS_PROPOSAL_PENGUJI_STR, TAHAPAN_SKRIPSI_PROPOSAL_STR, $skripsi->nim, $tgl_sk),
					'tipe' => DOKUMEN_SURAT_TUGAS_SKRIPSI_PENGUJI_STR,
					'jenis' => DOKUMEN_JENIS_SKRIPSI_UJIAN_SKRIPSI_STR,
					'id_jenjang' => JENJANG_S1,
					'id_tugas_akhir' => $id_skripsi,
					'identitas' => $skripsi->nim,
					'no_doc' => $no_sk,
					'date_doc' => date('Y-m-d', strtotime($tgl_sk)),
					'nama' => 'Surat Tugas Penguji - Skripsi - ' . $skripsi->nama,
					'deskripsi' => $skripsi->judul,
					'link' => $link_dokumen,
					'link_cetak' => $link_dokumen_cetak,
					'date' => date('Y-m-d', strtotime($tgl_sk)),
					'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
				];
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				if (!empty($dokumen)) {
					$this->dokumen->delete($dokumen->id_dokumen);
				}
				$this->dokumen->save($data_dokumen);
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				// DOKUMEN PERSETUJUAN
				$this->dokumen->generate_tujuan_dokumen($pengujis, $dokumen->id_dokumen, DOKUMEN_TUJUAN_JENIS_DITUJUKAN, DOKUMEN_TUJUAN_DOSEN);
				$data = array(
					'dokumen' => $dokumen,
					'proposal' => $skripsi,
					'gelombang' => $gelombang,
					'penguji_ketua' => $this->skripsi->read_pengujiketua($id_ujian),
					'penguji_anggota' => $this->skripsi->read_pengujianggota($id_ujian),
					'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
					'wadek' => $wadek,
					'judul' => $this->skripsi->read_judul($id_skripsi)
				);
				//print_r($data['penguji_ketua']);die();
				$page = 'backend/baa/cetak/proposal_surat_tugas';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "proposal_surat_tugas.pdf";
				$this->pdf->load_view($page, $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/proposal/skripsi');
			}
		}

		public function cetak_berita()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$skripsi = $this->skripsi->detail_by_id($id_skripsi);
				$jadwal = $this->skripsi->read_ujian_skripsi($id_skripsi);
				$pengujis = $this->skripsi->read_penguji_ujian($jadwal->id_ujian, UJIAN_SKRIPSI_UJIAN);
				$link_dokumen = base_url() . 'document/lihat_skripsi_ujian?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . $jadwal->id_ujian . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_SKRIPSI_UJIAN_STR . '$' . UJIAN_SKRIPSI_UJIAN;
				$link_dokumen_cetak = base_url() . 'document/cetak_skripsi_ujian?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . $jadwal->id_ujian . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_SKRIPSI_UJIAN_STR . '$' . UJIAN_SKRIPSI_UJIAN;
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Skripsi', $skripsi->nim, $jadwal->tanggal);
				$qr_content = $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_STR, TAHAPAN_SKRIPSI_UJIAN_STR, $skripsi->nim, $jadwal->tanggal),
					'tipe' => DOKUMEN_BERITA_ACARA_STR,
					'jenis' => DOKUMEN_JENIS_SKRIPSI_UJIAN_SKRIPSI_STR,
					'id_jenjang' => JENJANG_S1,
					'id_tugas_akhir' => $id_skripsi,
					'id_jadwal' => $jadwal->id_ujian,
					'identitas' => $skripsi->nim,
					'nama' => 'Berita Acara Ujian Skripsi - ' . $skripsi->nama,
					'deskripsi' => $skripsi->judul,
					'link' => $link_dokumen,
					'link_cetak' => $link_dokumen_cetak,
					'date' => $jadwal->tanggal,
					'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
				];
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				if (empty($dokumen)) {
					$this->dokumen->save($data_dokumen);
				}
				if ($skripsi->status_skripsi < STATUS_SKRIPSI_UJIAN_UJIAN) {
					// Update Disertasi
					$update_skripsi = [
						'status_skripsi' => STATUS_SKRIPSI_UJIAN_UJIAN
					];
					$this->skripsi->update($update_skripsi, $id_skripsi);
				}
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				// DOKUMEN PERSETUJUAN
				$this->dokumen->generate_persetujuan_berita_acara($pengujis, $dokumen->id_dokumen, JENJANG_S1, $id_skripsi);
				$dokumen_persetujuan_ketua = $this->dokumen->read_persetujuan_ketua($dokumen->id_dokumen);
				$dokumen_persetujuan_anggota = $this->dokumen->read_persetujuan_anggota($dokumen->id_dokumen);
				$data = array(
					'skripsi' => $skripsi,
					'jadwal' => $jadwal,
					'penguji_ketua' => $this->skripsi->read_pengujiketua($jadwal->id_ujian),
					'penguji_pembimbing' => $this->skripsi->read_pengujipembimbing($jadwal->id_ujian),
					'penguji_anggota' => $this->skripsi->read_pengujianggota($jadwal->id_ujian),
					'pengujis' => $pengujis,
					'gelombang' => $this->skripsi->read_gelombangaktif(),
					'pembimbing' => $this->skripsi->read_pembimbing_row($id_skripsi),
					'wadek1' => $this->struktural->read_wadek1(),
					'kps' => $this->struktural->read_kps(),
					'judul' => $this->skripsi->read_judul($id_skripsi),
					'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
					'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen),
					'dokumen_persetujuan_ketua' => $dokumen_persetujuan_ketua,
					'dokumen_persetujuan_anggota' => $dokumen_persetujuan_anggota,
				);
				$data['kadep'] = $this->struktural->read_kadep($data['skripsi']->id_departemen);
				$page = 'backend/baa/cetak/skripsi_berita';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "skripsi_berita.pdf";
				$this->pdf->load_view($page, $data);
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/proposal/skripsi');
			}
		}

		public function cetak_berita_ulang()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$skripsi = $this->skripsi->detail_by_id($id_skripsi);
				$jadwal = $this->skripsi->read_ujian_by_id($id_ujian);
				$pengujis = $this->skripsi->read_penguji_ujian($jadwal->id_ujian, UJIAN_SKRIPSI_PROPOSAL);
				$link_dokumen = base_url() . 'document/lihat_skripsi?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . $jadwal->id_ujian . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_SKRIPSI_PROPOSAL_STR . '$' . UJIAN_SKRIPSI_PROPOSAL;
				$link_dokumen_cetak = base_url() . 'document/cetak_skripsi?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . $jadwal->id_ujian . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_SKRIPSI_PROPOSAL_STR . '$' . UJIAN_SKRIPSI_PROPOSAL;
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Kualifikasi', $skripsi->nim, $jadwal->tanggal);
				$qr_content = $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_STR, TAHAPAN_SKRIPSI_PROPOSAL_STR, $skripsi->nim, $jadwal->tanggal),
					'tipe' => DOKUMEN_BERITA_ACARA_STR,
					'jenis' => DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR,
					'id_jenjang' => JENJANG_S1,
					'id_tugas_akhir' => $id_skripsi,
					'id_jadwal' => $jadwal->id_ujian,
					'identitas' => $skripsi->nim,
					'nama' => 'Berita Acara Ujian Proposal Skripsi - ' . $skripsi->nama,
					'deskripsi' => $skripsi->judul,
					'link' => $link_dokumen,
					'link_cetak' => $link_dokumen_cetak,
					'date' => $jadwal->tanggal,
					'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
				];
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				if (empty($dokumen)) {
					$this->dokumen->save($data_dokumen);
				}
				if ($skripsi->status_proposal < STATUS_SKRIPSI_PROPOSAL_UJIAN) {
					// Update Disertasi
					$update_skripsi = [
						'status_proposal' => STATUS_SKRIPSI_PROPOSAL_UJIAN
					];
					$this->skripsi->update($update_skripsi, $id_skripsi);
				}
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				// DOKUMEN PERSETUJUAN
				$this->dokumen->generate_persetujuan_berita_acara($pengujis, $dokumen->id_dokumen, JENJANG_S1, $id_skripsi);
				$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
				$data = array(
					'proposal' => $skripsi,
					'jadwal' => $jadwal,
					'pengujis' => $pengujis,
					'pembimbing' => $this->skripsi->read_pembimbing_row($id_skripsi),
					'wadek1' => $this->struktural->read_wadek1(),
					'kps' => $this->struktural->read_kps(),
					'judul' => $this->skripsi->read_judul($id_skripsi),
					'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
					'setujui_semua' => $this->dokumen->cek_dokumen_setujui_semua($dokumen->id_dokumen),
					'dokumen_persetujuan' => $dokumen_persetujuan,
				);
				$data['kadep'] = $this->struktural->read_kadep($data['proposal']->id_departemen);
				$page = 'backend/baa/cetak/proposal_skripsi_berita';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "proposal_skripsi_berita.pdf";
				$this->pdf->load_view($page, $data);


			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/proposal/skripsi');
			}
		}
	}

?>
