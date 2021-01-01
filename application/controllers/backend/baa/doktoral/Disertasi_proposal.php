<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Disertasi_proposal extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //START SESS
        $this->session_data = $this->session->userdata('logged_in');

        if (!$this->session_data) {
            redirect('logout', 'refresh');
        } else {
            if ($this->session_data['sebagai'] != 2 AND $this->session_data['role'] != 2) {
                redirect('logout', 'refresh');
            }
        }
        //END SESS
        //START MODEL
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/transaksi/disertasi', 'disertasi');
		$this->load->model('backend/transaksi/dokumen', 'dokumen');
		$this->load->model('backend/administrator/master/struktural_model', 'struktural');
		$this->load->model('backend/utility/qr', 'qrcode');
		//END MODEL
		// LIBRARY
		$this->load->library('encryption');
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Doktoral',
            'subtitle' => 'Disertasi - Ujian Proposal',
            'section' => 'backend/baa/doktoral/proposal/index',
            // DATA //
            'disertasi' => $this->disertasi->read_proposal()
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function terima() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'status_proposal' => STATUS_DISERTASI_PROPOSAL_SETUJUI_BAA,
            );
            $this->disertasi->update($data, $id_disertasi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil setujui');
            redirect('baa/doktoral/disertasi/proposal');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/doktoral/disertasi/proposal');
        }
    }

    public function cetak_undangan() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_PROPOSAL);
            $id_ujian = $ujian->id_ujian;

            $data = array(
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_PROPOSAL),
                'pengujis' => $this->disertasi->read_penguji($id_ujian),
                'promotors' => $this->disertasi->read_promotor_kopromotor($id_disertasi),
                'disertasi' => $this->disertasi->detail($id_disertasi),
                'wadek1' => $this->struktural->read_wadek1()
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/doktoral/proposal/cetak_undangan';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "disertasi_undangan.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/doktoral/disertasi/proposal/');
        }
    }

    public function cetak_berita() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
			$ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_PROPOSAL);
			$jadwal = $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_PROPOSAL);
			$disertasi = $this->disertasi->detail($id_disertasi);
			$pengujis = $this->disertasi->read_penguji($ujian->id_ujian);
			$promotors =$this->disertasi->read_promotor_kopromotor($id_disertasi);
			$ketua_penguji = $this->disertasi->read_penguji_ketua($ujian->id_ujian);
			// Update Disertasi
			$update_disertasi = [
				'status_proposal' => STATUS_DISERTASI_PROPOSAL_CETAK_DOKUMEN
			];
			$this->disertasi->update($update_disertasi, $id_disertasi);
			$link_dokumen = base_url() . 'document/lihat?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_DISERTASI_PROPOSAL_STR . '$' . UJIAN_DISERTASI_PROPOSAL;
			$link_dokumen_cetak = base_url() . 'document/cetak?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_DISERTASI_PROPOSAL_STR . '$' . UJIAN_DISERTASI_PROPOSAL;
			// QR
			$qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Kualifikasi', $disertasi->nim, $jadwal->tanggal);
			$qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
			$this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
			// DOKUMEN
			$data_dokumen = [
				'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_STR, 'proposal', $disertasi->nim, $jadwal->tanggal),
				'tipe' => DOKUMEN_BERITA_ACARA_STR,
				'jenis' => DOKUMEN_JENIS_DISERTASI_UJIAN_PROPOSAL_STR,
				'id_tugas_akhir' => $id_disertasi,
				'identitas' => $disertasi->nim,
				'nama' => 'Berita Acara Ujian Proposal - ' . $disertasi->nama,
				'deskripsi' => $disertasi->judul,
				'link' => $link_dokumen,
				'link_cetak' => $link_dokumen_cetak,
				'date' => $jadwal->tanggal,
				'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
			];
			$dokumen = $this->dokumen->detail_by_data($data_dokumen);
			if (empty($dokumen)) {
				$this->dokumen->save($data_dokumen);
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
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/doktoral/proposal/cetak_berita';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "disertasi_berita.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/doktoral/disertasi/proposal/');
        }
    }

    public function cetak_penilaian() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_PROPOSAL),
                'disertasi' => $this->disertasi->detail($id_disertasi)
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/doktoral/proposal/cetak_penilaian';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "disertasi_penilaian.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/doktoral/disertasi/proposal/');
        }
    }

    public function cetak_absensi() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);

            $data = array(
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_PROPOSAL),
                'disertasi' => $this->disertasi->detail($id_disertasi)
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/doktoral/proposal/cetak_absensi';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "disertasi_absensi.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/doktoral/disertasi/proposal/');
        }
    }

}

?>
