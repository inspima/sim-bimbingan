<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tesis_ujian extends CI_Controller {

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
        $this->load->model('backend/transaksi/tesis', 'tesis');
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
            'title' => 'Magister',
            'subtitle' => 'Tesis - Ujian',
            'section' => 'backend/baa/magister/ujian/index',
            // DATA //
            'tesis' => $this->tesis->read_ujian(),
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function cetak_undangan() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_UJIAN);
            $id_ujian = $ujian->id_ujian;

            $data = array(
                'jadwal' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
                'pengujis' => $this->tesis->read_penguji($id_ujian),
                'tesis' => $this->tesis->detail($id_tesis),
                'wadek1' => $this->struktural->read_wadek1()
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/magister/ujian/cetak_undangan';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "tesis_undangan.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/magister/tesis/ujian/');
        }
    }

    public function cetak_berita() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, TAHAPAN_TESIS_UJIAN);
            $jadwal = $this->tesis->read_jadwal($id_tesis, TAHAPAN_TESIS_UJIAN);
            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);

            $link_dokumen = base_url() . 'document/lihat?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            $link_dokumen_cetak = base_url() . 'document/cetak?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Tesis', $tesis->nim, $jadwal->tanggal);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_STR, 'tesis', $tesis->nim, $jadwal->tanggal),
                'tipe' => DOKUMEN_BERITA_ACARA_STR,
                'jenis' => 'tesis',
                'identitas' => $tesis->nim,
                'nama' => 'Berita Acara Ujian Tesis - ' . $tesis->nama,
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
            $this->dokumen->generate_persetujuan($pengujis, $dokumen->id_dokumen, JENJANG_S2, $id_tesis, 0);
            $dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
            $data = array(
                'jadwal' => $jadwal,
                'pengujis' => $pengujis,
                'tesis' => $tesis,
                'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
                'dokumen_persetujuan' => $dokumen_persetujuan
            );
            ob_end_clean();
            $page = 'backend/baa/magister/ujian/cetak_berita';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = 'berita_acara_tesis_' . $tesis->nim;
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/magister/tesis/ujian/');
        }
    }

    public function cetak_penilaian() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $data = array(
                'jadwal' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
                'tesis' => $this->tesis->detail($id_tesis)
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/magister/ujian/cetak_penilaian';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "tesis_penilaian.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/magister/tesis/ujian/');
        }
    }

    public function cetak_absensi() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, TAHAPAN_TESIS_UJIAN);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);
            $data = array(
                'jadwal' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
                'tesis' => $this->tesis->detail($id_tesis),
                'pengujis' => $this->tesis->read_penguji($ujian->id_ujian)
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/magister/ujian/cetak_absensi';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "tesis_absensi.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/magister/tesis/ujian/');
        }
    }

    public function nilai_ujian() {
        $id_tesis = $this->uri->segment('6');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_ujian = $this->uri->segment('7');
        $data = array(
            // PAGE //
            'title' => 'Tesis - Ujian',
            'subtitle' => 'Nilai Ujian',
            'section' => 'backend/baa/magister/ujian/nilai_ujian',
            'use_back' => true,
            'back_link' => 'baa/magister/tesis/ujian',
            // DATA //
            'id_ujian' => $id_ujian,
            'tesis' => $this->tesis->detail($id_tesis),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_UJIAN),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function nilai_ujian_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_ujian = $this->input->post('id_ujian', TRUE);
            $id_tesis = $this->input->post('id_tesis', TRUE);

            $data = array(
                'rata_nilai_ujian' => $this->input->post('rata_nilai_ujian', TRUE),
                'bobot_nilai_konversi' => $this->input->post('bobot_nilai_konversi', TRUE),
                'nilai_ujian' => $this->input->post('nilai_ujian', TRUE)
            );

            $this->tesis->update_ujian($data, $id_ujian);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', $mesg);
            redirect('baa/magister/tesis/ujian/nilai_ujian/' . $id_tesis .'/'.$id_ujian);

        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/magister/tesis/ujian/index');
        }
    }

}

?>