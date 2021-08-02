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
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != 2) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/master/setting', 'setting');
			$this->load->model('backend/administrator/master/struktural_model', 'struktural');
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/baa/proposal/proposal_pengajuan_model', 'proposal');
			$this->load->model('backend/baa/proposal/proposal_diterima_model', 'proposal_diterima');
			$this->load->model('backend/baa/proposal/proposal_selesai_model', 'proposal_selesai');
			$this->load->model('backend/baa/proposal/penguji_pengajuan_model', 'penguji');
			$this->load->model('backend/transaksi/skripsi', 'transaksi_proposal');
			$this->load->model('backend/transaksi/dokumen', 'dokumen');
			$this->load->model('backend/utility/qr', 'qrcode');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Proposal',
				'subtitle' => 'Data Proposal',
				'section' => 'backend/baa/sarjanah/proposal/index',
				// DATA //
				'proposal' => $this->proposal->read()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function diterima()
		{
			$data = array(
				// PAGE //
				'title' => 'Proposal',
				'subtitle' => 'Data Proposal',
				'section' => 'backend/baa/sarjanah/proposal/diterima',
				// DATA //
				'proposal' => $this->proposal_diterima->read()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function selesai()
		{
			$data = array(
				// PAGE //
				'title' => 'Proposal',
				'subtitle' => 'Data Proposal',
				'section' => 'backend/baa/sarjanah/proposal/selesai',
				// DATA //
				'proposal' => $this->proposal_selesai->read()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function ditolak()
		{
			$data = array(
				// PAGE //
				'title' => 'Proposal',
				'subtitle' => 'Data Proposal',
				'section' => 'backend/baa/sarjanah/proposal/ditolak',
				// DATA //
				'proposal' => $this->transaksi_proposal->read_baa_proposal_ditolak()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function belum_approve()
		{
			$data = array(
				// PAGE //
				'title' => 'Proposal',
				'subtitle' => 'Data Proposal ',
				'section' => 'backend/baa/sarjanah/proposal/belum_approve',
				// DATA //
				'penguji' => $this->transaksi_proposal->read_baa_proposal_penguji_blm_approve()
			);

			$this->load->view('backend/index_sidebar', $data);
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
					'subtitle' => 'Data Pengajuan Proposal',
					'section' => 'backend/dosen/proposal/kadep_pengajuan_detail',
					// DATA //
					'proposal' => $this->proposal->detail($id_departemen, $id_skripsi),
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
				redirect('dashboardd/proposal/kadep_pengajuan');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/proposal/kadep_pengajuan');
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
				redirect('dashboardd/proposal/kadep_pengajuan');
			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardd/proposal/kadep_pengajuan');
			}
		}

		public function cetak_surat_tugas()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$no_sk = $this->input->post('no_sk', true);
				$tgl_sk = $this->input->post('tgl_sk', true);
				$skripsi = $this->transaksi_proposal->detail_proposal($id_skripsi);
				$gelombang = $this->proposal_diterima->read_gelombangaktif();
				$pengujis = $this->transaksi_proposal->read_penguji_ujian($id_ujian, UJIAN_SKRIPSI_PROPOSAL);
				$wadek = $this->proposal_diterima->read_wadek();
				// DOKUMEN
				$link_dokumen = base_url() . 'document/lihat_proposal_skripsi_surat_tugas?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . DOKUMEN_SURAT_TUGAS_PROPOSAL_PENGUJI_STR . '$' . TAHAPAN_SKRIPSI_PROPOSAL_STR . '$' . UJIAN_SKRIPSI_PROPOSAL;
				$link_dokumen_cetak = base_url() . 'document/cetak_proposal_skripsi_surat_tugas?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . DOKUMEN_SURAT_TUGAS_PROPOSAL_PENGUJI_STR . '$' . TAHAPAN_SKRIPSI_PROPOSAL_STR . '$' . UJIAN_SKRIPSI_PROPOSAL;
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Kualifikasi', $skripsi->nim, $tgl_sk);
				$qr_content = $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $this->dokumen->generate_kode(DOKUMEN_SURAT_TUGAS_PROPOSAL_PENGUJI_STR, TAHAPAN_SKRIPSI_PROPOSAL_STR, $skripsi->nim, $tgl_sk),
					'tipe' => DOKUMEN_SURAT_TUGAS_PROPOSAL_PENGUJI_STR,
					'jenis' => DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR,
					'id_jenjang' => JENJANG_S1,
					'id_tugas_akhir' => $id_skripsi,
					'identitas' => $skripsi->nim,
					'no_doc' => $no_sk,
					'date_doc' => date('Y-m-d', strtotime($tgl_sk)),
					'nama' => 'Surat Tugas Penguji - Proposal Skripsi - ' . $skripsi->nama,
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
					'penguji_ketua' => $this->proposal_diterima->read_ketua_penguji($id_ujian),
					'penguji_anggota' => $this->proposal_diterima->read_anggota_penguji($id_ujian),
					'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
					'wadek' => $wadek,
					'judul' => $this->proposal_diterima->read_judul($id_skripsi)
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
				redirect('dashboardb/proposal/proposal_diterima');
			}
		}


		public function cetak_undangan()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$no_sk = $this->input->post('no_sk', true);
				$tgl_sk = $this->input->post('tgl_sk', true);

				$skripsi = $this->transaksi_proposal->detail_proposal($id_skripsi);
				$jadwal = $this->transaksi_proposal->read_ujian_by_id($id_ujian);
				$pengujis = $this->transaksi_proposal->read_penguji_ujian($id_ujian, UJIAN_SKRIPSI_PROPOSAL);
				$wadek = $this->proposal_diterima->read_wadek();
				// DOKUMEN
				$link_dokumen = base_url() . 'document/lihat_proposal_skripsi_undangan?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . $id_ujian . '$' . DOKUMEN_SURAT_UNDANGAN_PROPOSAL_STR . '$' . TAHAPAN_SKRIPSI_PROPOSAL_STR . '$' . UJIAN_SKRIPSI_PROPOSAL;
				$link_dokumen_cetak = base_url() . 'document/cetak_proposal_skripsi_undangan?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_skripsi . '$' . $id_ujian . '$' . DOKUMEN_SURAT_UNDANGAN_PROPOSAL_STR . '$' . TAHAPAN_SKRIPSI_PROPOSAL_STR . '$' . UJIAN_SKRIPSI_PROPOSAL;
				// QR
				$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Kualifikasi', $skripsi->nim, $tgl_sk);
				$qr_content = $link_dokumen; //data yang akan di jadikan QR CODE
				$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
				// DOKUMEN
				$data_dokumen = [
					'kode' => $this->dokumen->generate_kode(DOKUMEN_SURAT_UNDANGAN_PROPOSAL_STR, TAHAPAN_SKRIPSI_PROPOSAL_STR, $skripsi->nim, $tgl_sk),
					'tipe' => DOKUMEN_SURAT_UNDANGAN_PROPOSAL_STR,
					'jenis' => DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR,
					'id_jenjang' => JENJANG_S1,
					'id_tugas_akhir' => $id_skripsi,
					'id_jadwal' => $id_ujian,
					'identitas' => $skripsi->nim,
					'no_doc' => $no_sk,
					'date_doc' => date('Y-m-d', strtotime($tgl_sk)),
					'nama' => 'Surat Undangan - Proposal Skripsi - ' . $skripsi->nama,
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
				$data_tujuans = [
					[
						'identitas' => $skripsi->nim,
						'nama' => $skripsi->nama,
					]
				];
				$this->dokumen->generate_tujuan_dokumen($data_tujuans, $dokumen->id_dokumen, DOKUMEN_TUJUAN_JENIS_DITUJUKAN, DOKUMEN_TUJUAN_MAHASISWA);
				$data = array(
					'dokumen' => $dokumen,
					'proposal' => $skripsi,
					'jadwal' => $jadwal,
					'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
					'wadek' => $wadek,
					'penguji' => $pengujis,
					'judul' => $this->proposal_diterima->read_judul($id_skripsi)
				);
				$page = 'backend/baa/cetak/proposal_skripsi_undangan';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "undangan_proposal_skripsi.pdf";
				$this->pdf->load_view($page, $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/proposal/proposal_diterima');
			}
		}

		public function cetak_berita()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$skripsi = $this->transaksi_proposal->detail_by_id($id_skripsi);
				$jadwal = $this->transaksi_proposal->read_ujian_proposal($id_skripsi);
				$pengujis = $this->transaksi_proposal->read_penguji_ujian($jadwal->id_ujian, UJIAN_SKRIPSI_PROPOSAL);
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
					$this->transaksi_proposal->update($update_skripsi, $id_skripsi);
				}
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				// DOKUMEN PERSETUJUAN
				$this->dokumen->generate_persetujuan_berita_acara($pengujis, $dokumen->id_dokumen, JENJANG_S1, $id_skripsi);
				$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
				$data = array(
					'proposal' => $skripsi,
					'jadwal' => $jadwal,
					'pengujis' => $pengujis,
					'pembimbing' => $this->transaksi_proposal->read_pembimbing_row($id_skripsi),
					'wadek1' => $this->struktural->read_wadek1(),
					'kps' => $this->struktural->read_kps(),
					'judul' => $this->transaksi_proposal->read_judul($id_skripsi),
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
				redirect('dashboardb/proposal/proposal_diterima');
			}
		}

		public function cetak_berita_ulang()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$skripsi = $this->transaksi_proposal->detail_by_id($id_skripsi);
				$jadwal = $this->transaksi_proposal->read_ujian_by_id($id_ujian);
				$pengujis = $this->transaksi_proposal->read_penguji_ujian($jadwal->id_ujian, UJIAN_SKRIPSI_PROPOSAL);
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
					$this->transaksi_proposal->update($update_skripsi, $id_skripsi);
				}
				$dokumen = $this->dokumen->check_by_data($data_dokumen);
				// DOKUMEN PERSETUJUAN
				$this->dokumen->generate_persetujuan_berita_acara($pengujis, $dokumen->id_dokumen, JENJANG_S1, $id_skripsi);
				$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
				$data = array(
					'proposal' => $skripsi,
					'jadwal' => $jadwal,
					'pengujis' => $pengujis,
					'pembimbing' => $this->transaksi_proposal->read_pembimbing_row($id_skripsi),
					'wadek1' => $this->struktural->read_wadek1(),
					'kps' => $this->struktural->read_kps(),
					'judul' => $this->transaksi_proposal->read_judul($id_skripsi),
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
				redirect('dashboardb/proposal/proposal_diterima');
			}
		}


		public function cetak_absensi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);

				$data = array(
					'proposal' => $this->proposal->detail($id_skripsi),
					'jadwal' => $this->proposal->read_ujian($id_skripsi),
					'penguji' => $this->proposal->read_penguji($id_skripsi),
					'wadek1' => $this->struktural->read_wadek1()
				);

				$page = 'backend/baa/cetak/proposal_skripsi_absensi';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "absensi_proposal_skripsi.pdf";
				$this->pdf->load_view($page, $data);


			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/proposal/proposal_diterima');
			}
		}

	}

?>
