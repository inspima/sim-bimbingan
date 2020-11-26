<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends CI_Controller {

    public $config_qr;

    public function __construct() {
        parent::__construct();

        //START MODEL
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/transaksi/disertasi', 'disertasi');
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        //END MODEL
        // LIBRARY
        $this->load->library('encryption');
        // QR
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $this->config_qr['cacheable'] = true; //boolean, the default is true
        $this->config_qr['cachedir'] = 'application/cache/'; //string, the default is application/cache/
        $this->config_qr['errorlog'] = 'application/logs/'; //string, the default is application/logs/
        $this->config_qr['imagedir'] = './assets/img/qr/'; //direktori penyimpanan qr code
        $this->config_qr['quality'] = true; //boolean, the default is true
        $this->config_qr['size'] = '1024'; //interger, the default is 1024
        $this->config_qr['black'] = array(224, 255, 255); // array, default is array(255,255,255)
        $this->config_qr['white'] = array(70, 130, 180); // array, default is array(0,0,0)
    }

    public function berita_acara() {
        $doc = $this->input->get('doc', TRUE);
        $params = explode('$', $doc);
        if (!empty($params) && count($params) == 3) {
            $id_disertasi = $params[1];
            $jenis = $params[2];
            $disertasi = $this->disertasi->detail($id_disertasi);
            $page = '';
            $section_title = '';
            switch ($jenis) {
                case TAHAPAN_DISERTASI_KUALIFIKASI:
                    $page = 'frontend/document/berita_acara/kualifikasi';
                    $section_title = 'Ujian Kualifikasi';
                    break;
                case TAHAPAN_DISERTASI_PROPOSAL:
                    $page = 'frontend/document/berita_acara/proposal';
                    $section_title = 'Ujian Proposal';
                    break;
                case TAHAPAN_DISERTASI_KELAYAKAN:
                    $page = 'frontend/document/berita_acara/kelayakan';
                    $section_title = 'Ujian Kelayakan';
                    break;
                case TAHAPAN_DISERTASI_TERTUTUP:
                    $page = 'frontend/document/berita_acara/tertutup';
                    $section_title = 'Ujian Tahap 1';
                    break;
                case TAHAPAN_DISERTASI_TERBUKA:
                    $page = 'frontend/document/berita_acara/berita_acara';
                    $section_title = 'Ujian Terbuka';
                    break;
            }
            $data = array(
                // PAGE //
                'title' => 'Informasi Dokumen ',
                'subtitle' => 'Berita Acara',
                'section' => $page,
                // DATA //
                'nama_dokumen' => 'Berita Acara - ' . $section_title,
                'disertasi' => $disertasi,
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, $jenis),
            );

            $this->load->view('frontend/index', $data);
        } else {
            $data["heading"] = "404 Page Not Found";
            $data["message"] = "The page you requested was not found ";
            $this->load->view('error', $data);
        }
    }

    public function berita_acara_cetak() {
        $doc = $this->input->get('doc', TRUE);
        $params = explode('$', $doc);
        if (!empty($params) && count($params) == 3) {
            $id_disertasi = $params[1];
            $jenis = $params[2];
            $disertasi = $this->disertasi->detail($id_disertasi);

            $data = array(
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, $jenis),
                'pengujis' => $this->disertasi->read_penguji($id_disertasi),
                'disertasi' => $disertasi,
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, $jenis),
            );
            // QR CODE

            $this->ciqrcode->initialize($this->config_qr);
            $image_name = 'berita_acara_kualifikasi_' . $disertasi->nim . '.png'; //buat name dari qr code sesuai dengan nip
            $params['data'] = base_url() . 'document/berita_acara?disertasi=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . TAHAPAN_DISERTASI_KUALIFIKASI; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH . $this->config_qr['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
            ob_end_clean();
            switch ($jenis) {
                case TAHAPAN_DISERTASI_KUALIFIKASI:
                    $page = 'frontend/document/berita_acara/kualifikasi_document';
                    break;
                case TAHAPAN_DISERTASI_PROPOSAL:
                    $page = 'frontend/document/berita_acara/proposal_document';
                    break;
                case TAHAPAN_DISERTASI_KELAYAKAN:
                    $page = 'frontend/document/berita_acara/kelayakan_document';
                    break;
                case TAHAPAN_DISERTASI_TERTUTUP:
                    $page = 'frontend/document/berita_acara/tertutup_document';
                    break;
                case TAHAPAN_DISERTASI_TERBUKA:
                    $page = 'frontend/document/berita_acara/berita_acara_document';
                    break;
            }

            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = 'berita_acara_kualifikasi_' . $disertasi->nim;
            $this->pdf->load_view($page, $data);
        } else {
            $data["heading"] = "404 Page Not Found";
            $data["message"] = "The page you requested was not found ";
            $this->load->view('error', $data);
        }
    }

}

?>