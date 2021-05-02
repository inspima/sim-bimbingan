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
        $this->load->model('backend/master/semester', 'semester');
        $this->load->model('backend/transaksi/tesis', 'tesis');
        $this->load->model('backend/dosen/master/dosen_model', 'dosen');
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
            'section' => 'backend/prodi/magister/tesis/ujian/index',
            // DATA //
            'tesis' => $this->tesis->read_ujian($this->session_data['username']),
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    /*public function cetak_sk_tesis() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $no_sk = $this->input->post('no_sk', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_UJIAN);
            $id_ujian = $ujian->id_ujian;

            $data = array(
                'jadwal' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
                'pengujis' => $this->tesis->read_penguji($id_ujian),
                'tesis' => $this->tesis->detail($id_tesis),
                'no_sk' => $no_sk,
                'semester' => $this->semester->detail_berjalan(),
                'dekan' => $this->struktural->read_dekan()
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/prodi/magister/tesis/ujian/cetak_sk_tesis';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "tesis_sk_proposal.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/tesis/ujian/');
        }
    }*/

    public function cetak_sk_tesis() {
        $hand = $this->input->post('hand', TRUE);
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_UJIAN);
            //$no_surat = $this->input->post('no_surat', TRUE);
            $no_sk = $this->input->post('no_sk', TRUE);

            $tgl_surat = $this->input->post('tgl_surat', TRUE);
            $tgl_surat_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_surat)));

            $tgl_sk = $this->input->post('tgl_sk', TRUE);
            $tgl_sk_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sk)));

            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_SK_UJIAN_TESIS . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_SK_UJIAN_TESIS . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen SK Tesis', 'Ujian Tesis', $tesis->nim, $tgl_surat_ymd);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_SK_UJIAN_TESIS, 'tesis_ujian', $tesis->nim, ''),
                'tipe' => DOKUMEN_SK_UJIAN_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_UJIAN_STR,
                'no_doc' => '',
                'no_ref_doc' => $no_sk,
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'SK Ujian Tesis - ' . $tesis->nama,
                'deskripsi' => $tesis->judul,
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => date('Y-m-d'),
                'date_doc' => $tgl_sk_ymd,
                'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
            ];

            $dokumen = $this->dokumen->detail_by_data($data_dokumen);
            if (empty($dokumen)) {
                $this->dokumen->save($data_dokumen);
            }
            else {
                $this->dokumen->update($data_dokumen, $dokumen->id_dokumen);    
            }

            $dokumen = $this->dokumen->detail_by_data($data_dokumen);

            // DOKUMEN PERSETUJUAN
            //$this->dokumen->generate_persetujuan_berita_acara($pengujis, $dokumen->id_dokumen, JENJANG_S2, $id_disertasi);
            //$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
            $data = array(
                'jadwal' => $jadwal,
                'pengujis' => $pengujis,
                'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
                'tesis' => $tesis,
                'no_surat' => $no_surat,
                //'semester' => $this->semester->detail($smt),
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan) : $this->semester->detail_berjalan(),
                'no_sk' => $no_sk,
                'tgl_sk' => $tgl_sk_ymd,
                'tgl_surat' => $tgl_surat_ymd,
                'dekan' => $this->struktural->read_dekan()
            );

            /*$judul_notifikasi = 'Surat Tugas Pembimbing';
            $isi_notifikasi = 'Surat Tugas Pembimbing untuk Mahasiswa berikut ini'
                . WA_LINE_BREAK . WA_LINE_BREAK . 'Nama :' . $tesis->nama
                . WA_LINE_BREAK . 'Nim :' . $tesis->nim
                . WA_LINE_BREAK . 'Judul :' . $tesis->judul
                . WA_LINE_BREAK . WA_LINE_BREAK . 'berhasil dicetak';
            $this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 1, $this->struktural->read_dekan()->nip ? $this->struktural->read_dekan()->nip : '197602042005011003');*/

            ob_end_clean();
            $page = 'backend/prodi/magister/tesis/ujian/cetak_sk_tesis';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "SK Ujian Tesis - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/ujian/');
        }
    }

    /*public function cetak_berita() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_UJIAN);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN);
            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);

            $link_dokumen = base_url() . 'document/lihat?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . UJIAN_TESIS_UJIAN;
            $link_dokumen_cetak = base_url() . 'document/cetak?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . UJIAN_TESIS_UJIAN;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Tesis', $tesis->nim, $jadwal->tanggal);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_STR, 'tesis', $tesis->nim, $jadwal->tanggal),
                'tipe' => DOKUMEN_BERITA_ACARA_STR,
                'jenis' => 'ujian_tesis',
                'id_tugas_akhir' => $id_tesis,
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
            $page = 'backend/prodi/magister/tesis/ujian/cetak_berita';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = 'berita_acara_tesis_' . $tesis->nim;
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/tesis/ujian/');
        }
    }*/

    public function cetak_berita() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_UJIAN);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN);
            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);
            $ketua_penguji = $this->tesis->read_penguji_ketua($ujian->id_ujian);

            $no_sk = $this->input->post('no_sk', TRUE);

            $tgl_sk = $this->input->post('tgl_sk', TRUE);
            $tgl_sk_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sk)));

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_UJIAN_TESIS . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_UJIAN_TESIS . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Tesis', $tesis->nim, $jadwal->tanggal);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_UJIAN_TESIS, 'tesis_ujian', $tesis->nim, $jadwal->tanggal),
                'tipe' => DOKUMEN_BERITA_ACARA_UJIAN_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_UJIAN_STR,
                'no_doc' => '',
                'no_ref_doc' => $no_sk,
                'id_tugas_akhir' => $id_tesis,
                'identitas' => $tesis->nim,
                'nama' => 'Berita Acara Ujian Tesis - ' . $tesis->nama,
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => $jadwal->tanggal,
                'date_doc' => $tgl_sk_ymd,
                'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
            ];
            $dokumen = $this->dokumen->detail_by_data($data_dokumen);
            if (empty($dokumen)) {
                $this->dokumen->save($data_dokumen);
            }
            else {
                $this->dokumen->update($data_dokumen, $dokumen->id_dokumen);    
            }
            $dokumen = $this->dokumen->detail_by_data($data_dokumen);
            // DOKUMEN PERSETUJUAN
            $this->dokumen->generate_persetujuan($pengujis, $dokumen->id_dokumen, JENJANG_S2, $id_tesis, 0);
            $dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
            $data = array(
                'jadwal' => $jadwal,
                'pengujis' => $pengujis,
                'ketua_penguji' => $ketua_penguji,
                'tesis' => $tesis,
                'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
                'dokumen_persetujuan' => $dokumen_persetujuan,
                'date_doc' => $dokumen->date_doc ? $dokumen->date_doc : '',
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan) : $this->semester->detail_berjalan(),
                'no_sk' => $no_sk,
                'tgl_sk' => $tgl_sk_ymd,
            );
            ob_end_clean();
            $page = 'backend/prodi/magister/tesis/ujian/cetak_berita';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = 'berita_acara_ujian_' . $tesis->nim;
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/ujian/');
        }
    }

    public function cetak_daftar_hadir()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $link_zoom = $this->input->post('link_zoom', true);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_UJIAN);

            $data = array(
                'link_zoom' => $link_zoom,
            );

            $this->tesis->update_ujian($data, $ujian->id_ujian);
            /*$no_surat = $this->input->post('no_surat', TRUE);
            $no_sk = $this->input->post('no_sk', TRUE);

            $tgl_surat = $this->input->post('tgl_surat', TRUE);
            $tgl_surat_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_surat)));

            $tgl_sk = $this->input->post('tgl_sk', TRUE);
            $tgl_sk_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sk)));*/

            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_DAFTAR_HADIR_UJIAN_TESIS . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_DAFTAR_HADIR_UJIAN_TESIS . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen SP Pembimbing', 'Judul Tesis', $tesis->nim, '');
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_DAFTAR_HADIR_UJIAN_TESIS, 'tesis_ujian', $tesis->nim, ''),
                'tipe' => DOKUMEN_DAFTAR_HADIR_UJIAN_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_UJIAN_STR,
                'no_doc' => '',
                'no_ref_doc' => '',
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'Daftar Hadir Ujian Tesis - ' . $tesis->nama,
                'deskripsi' => $tesis->judul,
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => date('Y-m-d'),
                'date_doc' => $tgl_sk_ymd,
                'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
            ];

            $dokumen = $this->dokumen->detail_by_data($data_dokumen);
            if (empty($dokumen)) {
                $this->dokumen->save($data_dokumen);
            }
            else {
                $this->dokumen->update($data_dokumen, $dokumen->id_dokumen);    
            }

            $dokumen = $this->dokumen->detail_by_data($data_dokumen);

            // DOKUMEN PERSETUJUAN
            //$this->dokumen->generate_persetujuan_berita_acara($pengujis, $dokumen->id_dokumen, JENJANG_S2, $id_disertasi);
            //$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
            $data = array(
                'jadwal' => $jadwal,
                'pengujis' => $pengujis,
                'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
                'tesis' => $tesis,
                'no_surat' => '',
                //'semester' => $this->semester->detail($smt),
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan) : $this->semester->detail_berjalan(),
                'no_sk' => '',
                'tgl_sk' => '',
                'tgl_surat' => '',
                'dekan' => $this->struktural->read_dekan(),
                'link_zoom' => $link_zoom,
            );

            /*$judul_notifikasi = 'Surat Tugas Pembimbing';
            $isi_notifikasi = 'Surat Tugas Pembimbing untuk Mahasiswa berikut ini'
                . WA_LINE_BREAK . WA_LINE_BREAK . 'Nama :' . $tesis->nama
                . WA_LINE_BREAK . 'Nim :' . $tesis->nim
                . WA_LINE_BREAK . 'Judul :' . $tesis->judul
                . WA_LINE_BREAK . WA_LINE_BREAK . 'berhasil dicetak';
            $this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 1, $this->struktural->read_dekan()->nip ? $this->struktural->read_dekan()->nip : '197602042005011003');*/

            ob_end_clean();
            $page = 'backend/prodi/magister/tesis/ujian/cetak_daftar_hadir';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "Daftar Hadir Ujian - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/ujian/');
        }
    }

    public function cetak_undangan()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $link_zoom = $this->input->post('link_zoom', true);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_UJIAN);

            $data = array(
                'link_zoom' => $link_zoom,
            );

            $this->tesis->update_ujian($data, $ujian->id_ujian);

            $no_surat = $this->input->post('no_surat', TRUE);
            //$no_sk = $this->input->post('no_sk', TRUE);

            $tgl_surat = $this->input->post('tgl_surat', TRUE);
            $tgl_surat_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_surat)));

            //$tgl_sk = $this->input->post('tgl_sk', TRUE);
            //$tgl_sk_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sk)));

            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_UNDANGAN_UJIAN_TESIS . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_UNDANGAN_UJIAN_TESIS . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . TAHAPAN_TESIS_UJIAN;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen SP Pembimbing', 'Judul Tesis', $tesis->nim, $tgl_surat_ymd);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_UNDANGAN_UJIAN_TESIS, 'tesis_ujian', $tesis->nim, ''),
                'tipe' => DOKUMEN_UNDANGAN_UJIAN_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_UJIAN_STR,
                'no_doc' => $no_surat,
                'no_ref_doc' => '',
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'Undangan Ujian Tesis - ' . $tesis->nama,
                'deskripsi' => $tesis->judul,
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => $tgl_surat_ymd,
                'date_doc' => '',
                'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
            ];

            $dokumen = $this->dokumen->detail_by_data($data_dokumen);
            if (empty($dokumen)) {
                $this->dokumen->save($data_dokumen);
            }
            else {
                $this->dokumen->update($data_dokumen, $dokumen->id_dokumen);    
            }

            $dokumen = $this->dokumen->detail_by_data($data_dokumen);

            // DOKUMEN PERSETUJUAN
            //$this->dokumen->generate_persetujuan_berita_acara($pengujis, $dokumen->id_dokumen, JENJANG_S2, $id_disertasi);
            //$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
            $data = array(
                'jadwal' => $jadwal,
                'pengujis' => $pengujis,
                'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
                'tesis' => $tesis,
                'no_surat' => $no_surat,
                //'semester' => $this->semester->detail($smt),
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan) : $this->semester->detail_berjalan(),
                'no_sk' => '',
                'tgl_sk' => '',
                'tgl_surat' => $tgl_surat_ymd,
                'dekan' => $this->struktural->read_dekan(),
                'wadek_satu' => $this->struktural->read_wadek1(),
            );

            /*$judul_notifikasi = 'Surat Tugas Pembimbing';
            $isi_notifikasi = 'Surat Tugas Pembimbing untuk Mahasiswa berikut ini'
                . WA_LINE_BREAK . WA_LINE_BREAK . 'Nama :' . $tesis->nama
                . WA_LINE_BREAK . 'Nim :' . $tesis->nim
                . WA_LINE_BREAK . 'Judul :' . $tesis->judul
                . WA_LINE_BREAK . WA_LINE_BREAK . 'berhasil dicetak';
            $this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 1, $this->struktural->read_dekan()->nip ? $this->struktural->read_dekan()->nip : '197602042005011003');*/

            ob_end_clean();
            $page = 'backend/prodi/magister/tesis/ujian/cetak_undangan';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "SK Ujian Tesis - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/ujian/');
        }
    }
}

?>