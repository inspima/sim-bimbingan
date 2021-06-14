<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tesis_judul extends CI_Controller {

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
        $this->load->model('backend/utility/notification', 'notifikasi');
        $this->load->model('backend/utility/qr', 'qrcode');
        //END MODEL
        // LIBRARY
        $this->load->library('encryption');
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Magister',
            'subtitle' => 'Tesis - Judul',
            'section' => 'backend/prodi/magister/tesis/judul/index',
            // DATA //
            'semester' => $this->semester->read(),
            'tesis' => $this->tesis->read_judul_tesis($this->session_data['username']),
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function cetak_surat_tugas_pembimbing()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $no_surat = $this->input->post('no_surat', TRUE);
            $no_sk = $this->input->post('no_sk', TRUE);

            $tgl_surat = $this->input->post('tgl_surat', TRUE);
            $tgl_surat_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_surat)));

            $tgl_sk = $this->input->post('tgl_sk', TRUE);
            $tgl_sk_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sk)));

            $tesis = $this->tesis->detail($id_tesis);

            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_SP_PEMBIMBING_TESIS . '$' . TAHAPAN_TESIS_JUDUL_STR . '$' . TAHAPAN_TESIS_JUDUL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_SP_PEMBIMBING_TESIS . '$' . TAHAPAN_TESIS_JUDUL_STR . '$' . TAHAPAN_TESIS_JUDUL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen SP Pembimbing', 'Judul Tesis', $tesis->nim, $tgl_surat_ymd);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_SP_PEMBIMBING_TESIS, 'tesis_judul', $tesis->nim, ''),
                'tipe' => DOKUMEN_SP_PEMBIMBING_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_JUDUL_STR,
                'no_doc' => $no_surat,
                'no_ref_doc' => $no_sk,
                'id_tugas_akhir' => $id_tesis,
                'id_semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan)->id_semester,
                'id_jenjang' => '2',
                'identitas' => $tesis->nim,
                'nama' => 'Surat Tugas Pembimbing Tesis - ' . $tesis->nama,
                'deskripsi' => $tesis->judul,
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => $tgl_surat_ymd,
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
                'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
                'tesis' => $tesis,
                'no_surat' => $no_surat,
                //'semester' => $this->semester->detail($smt),
                'semester' => $this->semester->semester_pengajuan($tesis->tgl_pengajuan),
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
            $page = 'backend/prodi/magister/tesis/judul/cetak_surat_tugas_pembimbing';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "SURAT TUGAS PEMBIMBING TESIS - ".$tesis->nim.'.pdf';
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/judul/');
        }
    }

    /*public function cetak_surat_tugas_pembimbing() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $no_surat = $this->input->post('no_surat', TRUE);
            $no_sk = $this->input->post('no_sk', TRUE);
            $tgl_surat = $this->input->post('tgl_surat', TRUE);
            $tgl_surat_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_surat)));
            $tgl_sk = $this->input->post('tgl_sk', TRUE);
            $tgl_sk_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sk)));
            //$smt = $this->input->post('smt', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, 1);
            $id_ujian = $ujian->id_ujian;

            $data = array(
                'tesis' => $this->tesis->detail($id_tesis),
                'no_surat' => $no_surat,
                //'semester' => $this->semester->detail($smt),
                'semester' => $this->semester->detail_berjalan(),
                'no_sk' => $no_sk,
                'tgl_sk' => $tgl_sk_ymd,
                'tgl_surat' => $tgl_surat_ymd,
                'dekan' => $this->struktural->read_dekan()
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/prodi/magister/tesis/judul/cetak_surat_tugas_pembimbing';
            $size = 'A4';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "tesis_sp_pembimbing.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/tesis/judul/');
        }
    }*/
}

?>