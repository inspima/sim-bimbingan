<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Skripsi_ujian extends CI_Controller
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
			$this->load->model('backend/baa/master/gelombang_model', 'gelombang');
			$this->load->model('backend/baa/skripsi/skripsi_ujian_model', 'skripsi');
			$this->load->model('backend/transaksi/skripsi', 'transaksi_skripsi');
			$this->load->model('backend/master/setting', 'setting');
			//END MODEL
		}

		public function index()
		{
			$data = array(
				// PAGE //
				'title' => 'Skripsi Ujian',
				'subtitle' => 'Data Skripsi (Ujian)',
				'section' => 'backend/baa/skripsi/skripsi_ujian',
				// DATA //
				'skripsi' => $this->skripsi->read()
			);

			$this->load->view('backend/index_sidebar', $data);
		}

		public function cetak_surat_tugas()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);

				$data = array(
					'skripsi' => $this->skripsi->detail($id_ujian),
					'gelombang' => $this->skripsi->read_gelombangaktif(),
					'penguji_ketua' => $this->skripsi->read_pengujiketua($id_ujian),
					'penguji_pembimbing' => $this->skripsi->read_pengujipembimbing($id_ujian),
					'penguji_anggota' => $this->skripsi->read_pengujianggota($id_ujian),
					'wadek' => $this->skripsi->read_wadek(),
					'judul' => $this->skripsi->read_judul($id_skripsi)
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$page = 'backend/baa/cetak/skripsi_surat_tugas';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "skripsi_surat_tugas.pdf";
				$this->pdf->load_view($page, $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/skripsi/skripsi_ujian');
			}
		}

		public function cetak_berita()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$data = array(
					'skripsi' => $this->skripsi->detail($id_ujian),
					'gelombang' => $this->skripsi->read_gelombangaktif(),
					'penguji_ketua' => $this->skripsi->read_pengujiketua($id_ujian),
					'penguji_pembimbing' => $this->skripsi->read_pengujipembimbing($id_ujian),
					'penguji_anggota' => $this->skripsi->read_pengujianggota($id_ujian),
					'judul' => $this->skripsi->read_judul($id_skripsi)
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$page = 'backend/baa/cetak/skripsi_berita';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "skripsi_berita.pdf";
				$this->pdf->load_view($page, $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/skripsi/skripsi_ujian');
			}
		}

		public function cetak_pemberitahuan()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);

				$data = array(
					'skripsi' => $this->skripsi->detail($id_ujian),
					'gelombang' => $this->skripsi->read_gelombangaktif(),
					'penguji_ketua' => $this->skripsi->read_pengujiketua($id_ujian),
					'penguji_pembimbing' => $this->skripsi->read_pengujipembimbing($id_ujian),
					'penguji_anggota' => $this->skripsi->read_pengujianggota($id_ujian),
					'wadek' => $this->skripsi->read_wadek(),
					'judul' => $this->skripsi->read_judul($id_skripsi)
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$page = 'backend/baa/cetak/skripsi_pemberitahuan';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "skripsi_pemberitahuan.pdf";
				$this->pdf->load_view($page, $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/skripsi/skripsi_ujian');
			}
		}

		public function cetak_penilaian()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);

				$data = array(
					'skripsi' => $this->skripsi->detail($id_ujian),
					'gelombang' => $this->skripsi->read_gelombangaktif(),
					'penguji_ketua' => $this->skripsi->read_pengujiketua($id_ujian),
					'penguji_pembimbing' => $this->skripsi->read_pengujipembimbing($id_ujian),
					'penguji_anggota' => $this->skripsi->read_pengujianggota($id_ujian),
					'wadek' => $this->skripsi->read_wadek(),
					'judul' => $this->skripsi->read_judul($id_skripsi)
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$page = 'backend/baa/cetak/skripsi_penilaian';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "skripsi_penilaian.pdf";
				$this->pdf->load_view($page, $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/skripsi/skripsi_ujian');
			}
		}

		public function cetak_rekapitulasi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);
				$ujian = $this->transaksi_skripsi->read_jadwal_by_id($id_ujian);

				$data = array(
					'skripsi' => $this->skripsi->detail($id_ujian),
					'nilai_angka' => $ujian->hasil_nilai,
					'nilai_huruf' => $this->transaksi_skripsi->get_nilai_huruf($ujian->hasil_nilai),
					'gelombang' => $this->skripsi->read_gelombangaktif(),
					'penguji_ketua' => $this->skripsi->read_pengujiketua($id_ujian),
					'penguji_pembimbing' => $this->skripsi->read_pengujipembimbing($id_ujian),
					'penguji_anggota' => $this->skripsi->read_pengujianggota($id_ujian),
					'wadek' => $this->skripsi->read_wadek(),
					'judul' => $this->skripsi->read_judul($id_skripsi)
				);
				//print_r($data['penguji_ketua']);die();
				$page = 'backend/baa/cetak/skripsi_rekapitulasi';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "skripsi_rekapitulasi.pdf";
				$this->pdf->load_view($page, $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/skripsi/skripsi_ujian');
			}


		}

		public function cetak_perbaikan()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);

				$data = array(
					'skripsi' => $this->skripsi->detail($id_ujian),
					'gelombang' => $this->skripsi->read_gelombangaktif(),
					'penguji_ketua' => $this->skripsi->read_pengujiketua($id_ujian),
					'penguji_pembimbing' => $this->skripsi->read_pengujipembimbing($id_ujian),
					'penguji_anggota' => $this->skripsi->read_pengujianggota($id_ujian),
					'wadek' => $this->skripsi->read_wadek(),
					'judul' => $this->skripsi->read_judul($id_skripsi)
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$page = 'backend/baa/cetak/skripsi_perbaikan';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "skripsi_perbaikan.pdf";
				$this->pdf->load_view($page, $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/skripsi/skripsi_ujian');
			}


		}

		public function cetak_absensi()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id_skripsi = $this->input->post('id_skripsi', true);
				$id_ujian = $this->input->post('id_ujian', true);

				$data = array(
					'skripsi' => $this->skripsi->detail($id_ujian),
					'gelombang' => $this->skripsi->read_gelombangaktif(),
					'penguji_ketua' => $this->skripsi->read_pengujiketua($id_ujian),
					'penguji_pembimbing' => $this->skripsi->read_pengujipembimbing($id_ujian),
					'penguji_anggota' => $this->skripsi->read_pengujianggota($id_ujian),
					'judul' => $this->skripsi->read_judul($id_skripsi)
				);
				//print_r($data['penguji_ketua']);die();
				ob_end_clean();
				$page = 'backend/baa/cetak/skripsi_absensi';
				$size = 'legal';
				$this->pdf->setPaper($size, 'potrait');
				$this->pdf->filename = "skripsi_absensi.pdf";
				$this->pdf->load_view($page, $data);

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect('dashboardb/skripsi/skripsi_ujian');
			}
		}


	}

?>
