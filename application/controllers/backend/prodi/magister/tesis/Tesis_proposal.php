<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tesis_proposal extends CI_Controller {

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
        $this->load->model('backend/master/setting', 'setting');
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
            'subtitle' => 'Tesis - Ujian Proposal',
            'section' => 'backend/prodi/magister/tesis/proposal/index',
            // DATA //
            'tesis' => $this->tesis->read_proposal($this->session_data['username']),
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function cetak_sk_proposal()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_PROPOSAL);
            $no_surat = $this->input->post('no_surat', TRUE);
            $no_sk = $this->input->post('no_sk', TRUE);

            $tgl_surat = $this->input->post('tgl_surat', TRUE);
            $tgl_surat_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_surat)));

            $tgl_sk = $this->input->post('tgl_sk', TRUE);
            $tgl_sk_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sk)));

            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_SK_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_SK_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen SK Proposal', 'Proposal Tesis', $tesis->nim, $tgl_surat_ymd);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_SK_PROPOSAL_TESIS, 'tesis_proposal', $tesis->nim, ''),
                'tipe' => DOKUMEN_SK_PROPOSAL_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
                'no_doc' => $no_surat,
                'no_ref_doc' => $no_sk,
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'SK Ujian Proposal Tesis - ' . $tesis->nama,
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
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) : $this->semester->detail_berjalan(),
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

            //ob_end_clean();
            $page = 'backend/prodi/magister/tesis/proposal/cetak_sk_proposal';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "SK Ujian Proposal - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/proposal/');
        }
    }

    public function cetak_sk_proposal_ulang()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $jadwal = $this->tesis->read_jadwal_ujian_ulang($id_tesis, UJIAN_TESIS_PROPOSAL);
            $ujian = $this->tesis->detail_ujian_by_tesis_ulang($id_tesis, UJIAN_TESIS_PROPOSAL);
            $no_surat = $this->input->post('no_surat', TRUE);
            $no_sk = $this->input->post('no_sk', TRUE);

            $tgl_surat = $this->input->post('tgl_surat', TRUE);
            $tgl_surat_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_surat)));

            $tgl_sk = $this->input->post('tgl_sk', TRUE);
            $tgl_sk_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sk)));

            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_SK_PROPOSAL_TESIS_ULANG . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_SK_PROPOSAL_TESIS_ULANG . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen SK Proposal', 'Proposal Tesis', $tesis->nim, $tgl_surat_ymd);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_SK_PROPOSAL_TESIS_ULANG, 'tesis_proposal', $tesis->nim, ''),
                'tipe' => DOKUMEN_SK_PROPOSAL_TESIS_ULANG,
                'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
                'no_doc' => $no_surat,
                'no_ref_doc' => $no_sk,
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'SK Ujian Proposal Tesis - ' . $tesis->nama,
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
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) : $this->semester->detail_berjalan(),
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

            //ob_end_clean();
            $page = 'backend/prodi/magister/tesis/proposal/cetak_sk_proposal_ulang';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "SK Ujian Proposal Ulang - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/proposal/');
        }
    }

    /*public function cetak_sk_proposal() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $no_sk = $this->input->post('no_sk', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_PROPOSAL);
            $id_ujian = $ujian->id_ujian;

            $data = array(
                'jadwal' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL),
                'pengujis' => $this->tesis->read_penguji($id_ujian),
                'tesis' => $this->tesis->detail($id_tesis),
                'no_sk' => $no_sk,
                'semester' => $this->semester->detail_berjalan(),
                'dekan' => $this->struktural->read_dekan()
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/prodi/magister/tesis/proposal/cetak_sk_proposal';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "tesis_sk_proposal.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/tesis/proposal/');
        }
    }*/

    public function cetak_berita() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_PROPOSAL);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);
            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);
            $ketua_penguji = $this->tesis->read_penguji_ketua($ujian->id_ujian);

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Proposal', $tesis->nim, $jadwal->tanggal);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS, 'tesis_proposal', $tesis->nim, $jadwal->tanggal),
                'tipe' => DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
                'id_tugas_akhir' => $id_tesis,
                'identitas' => $tesis->nim,
                'nama' => 'Berita Acara Ujian Proposal - ' . $tesis->nama,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => $jadwal->tanggal,
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
            );
            //ob_end_clean();
            $page = 'backend/prodi/magister/tesis/proposal/cetak_berita';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = 'berita_acara_proposal_' . $tesis->nim;
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/tesis/proposal/');
        }
    }

    public function cetak_berita_ulang() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis_ulang($id_tesis, UJIAN_TESIS_PROPOSAL);
            $jadwal = $this->tesis->read_jadwal_ujian_ulang($id_tesis, UJIAN_TESIS_PROPOSAL);
            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji($ujian->id_ujian);
            $ketua_penguji = $this->tesis->read_penguji_ketua($ujian->id_ujian);

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS_ULANG . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS_ULANG . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Proposal', $tesis->nim, $jadwal->tanggal);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS_ULANG, 'tesis_proposal', $tesis->nim, $jadwal->tanggal),
                'tipe' => DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS_ULANG,
                'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
                'id_tugas_akhir' => $id_tesis,
                'identitas' => $tesis->nim,
                'nama' => 'Berita Acara Ujian Proposal Ulang - ' . $tesis->nama,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => $jadwal->tanggal,
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
            );
            //ob_end_clean();
            $page = 'backend/prodi/magister/tesis/proposal/cetak_berita_ulang';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = 'berita_acara_proposal_ulang_' . $tesis->nim;
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/tesis/proposal/');
        }
    }

    public function cetak_daftar_hadir()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $link_zoom = $this->input->post('link_zoom', true);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_PROPOSAL);

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

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_DAFTAR_HADIR_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_DAFTAR_HADIR_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Daftar Hadir Pembimbing', 'Judul Tesis', $tesis->nim, '');
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_DAFTAR_HADIR_PROPOSAL_TESIS, 'tesis_proposal', $tesis->nim, ''),
                'tipe' => DOKUMEN_DAFTAR_HADIR_PROPOSAL_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
                'no_doc' => '',
                'no_ref_doc' => '',
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'Daftar Hadir Ujian Proposal Tesis - ' . $tesis->nama,
                'deskripsi' => $tesis->judul,
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => date('Y-m-d'),
                'date_doc' => date('Y-m-d'),
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
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) : $this->semester->detail_berjalan(),
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

            //ob_end_clean();
            $page = 'backend/prodi/magister/tesis/proposal/cetak_daftar_hadir';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "Daftar Hadir Ujian Proposal - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/proposal/');
        }
    }

    public function cetak_daftar_hadir_ulang()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $link_zoom = $this->input->post('link_zoom', true);
            $jadwal = $this->tesis->read_jadwal_ujian_ulang($id_tesis, UJIAN_TESIS_PROPOSAL);
            $ujian = $this->tesis->detail_ujian_by_tesis_ulang($id_tesis, UJIAN_TESIS_PROPOSAL);

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

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_DAFTAR_HADIR_PROPOSAL_TESIS_ULANG . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_DAFTAR_HADIR_PROPOSAL_TESIS_ULANG . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Daftar Hadir Pembimbing', 'Judul Tesis', $tesis->nim, '');
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_DAFTAR_HADIR_PROPOSAL_TESIS_ULANG, 'tesis_proposal', $tesis->nim, ''),
                'tipe' => DOKUMEN_DAFTAR_HADIR_PROPOSAL_TESIS_ULANG,
                'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
                'no_doc' => '',
                'no_ref_doc' => '',
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'Daftar Hadir Ujian Proposal Tesis Ulang - ' . $tesis->nama,
                'deskripsi' => $tesis->judul,
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => date('Y-m-d'),
                'date_doc' => date('Y-m-d'),
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
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) : $this->semester->detail_berjalan(),
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

            //ob_end_clean();
            $page = 'backend/prodi/magister/tesis/proposal/cetak_daftar_hadir_ulang';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "Daftar Hadir Ujian Proposal Ulang - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/proposal/');
        }
    }

    public function cetak_undangan()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $link_zoom = $this->input->post('link_zoom', true);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_PROPOSAL);

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

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_UNDANGAN_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_UNDANGAN_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Undangan Pembimbing', 'Judul Tesis', $tesis->nim, $tgl_surat_ymd);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_UNDANGAN_PROPOSAL_TESIS, 'tesis_proposal', $tesis->nim, ''),
                'tipe' => DOKUMEN_UNDANGAN_PROPOSAL_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
                'no_doc' => $no_surat,
                'no_ref_doc' => '',
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'Undangan Ujian Proposal Tesis - ' . $tesis->nama,
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
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) : $this->semester->detail_berjalan(),
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

            //ob_end_clean();
            $page = 'backend/prodi/magister/tesis/proposal/cetak_undangan';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "SK Ujian Proposal - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/proposal/');
        }
    }

    public function cetak_undangan_ulang()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $link_zoom = $this->input->post('link_zoom', true);
            $jadwal = $this->tesis->read_jadwal_ujian_ulang($id_tesis, UJIAN_TESIS_PROPOSAL);
            $ujian = $this->tesis->detail_ujian_by_tesis_ulang($id_tesis, UJIAN_TESIS_PROPOSAL);

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

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_UNDANGAN_PROPOSAL_TESIS_ULANG . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_UNDANGAN_PROPOSAL_TESIS_ULANG . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Undangan Pembimbing', 'Judul Tesis', $tesis->nim, $tgl_surat_ymd);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_UNDANGAN_PROPOSAL_TESIS_ULANG, 'tesis_proposal', $tesis->nim, ''),
                'tipe' => DOKUMEN_UNDANGAN_PROPOSAL_TESIS_ULANG,
                'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
                'no_doc' => $no_surat,
                'no_ref_doc' => '',
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal)->id_semester : $this->semester->detail_berjalan()->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'Undangan Ujian Proposal Tesis Ulang - ' . $tesis->nama,
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
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) ? $this->semester->semester_pengajuan($tesis->tgl_pengajuan_proposal) : $this->semester->detail_berjalan(),
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

            //ob_end_clean();
            $page = 'backend/prodi/magister/tesis/proposal/cetak_undangan_ulang';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "SK Ujian Proposal - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/proposal/');
        }
    }

}

?>