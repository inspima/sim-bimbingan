<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Disertasi_kualifikasi extends CI_Controller {

    public $config_qr;

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

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Doktoral',
            'subtitle' => 'Disertasi - Ujian Kualifikasi',
            'section' => 'backend/baa/doktoral/kualifikasi/index',
            // DATA //
            'disertasi' => $this->disertasi->read_kualifikasi(),
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function cetak_undangan() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
            $id_ujian = $ujian->id_ujian;

            $data = array(
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
                'pengujis' => $this->disertasi->read_penguji($id_ujian),
                'disertasi' => $this->disertasi->detail($id_disertasi),
                'wadek1' => $this->struktural->read_wadek1()
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/doktoral/kualifikasi/cetak_undangan';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "disertasi_undangan.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/doktoral/disertasi/kualifikasi/');
        }
    }

    public function cetak_berita() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $ujian = $this->disertasi->detail_ujian_by_disertasi($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);
            $id_ujian = $ujian->id_ujian;
            $disertasi = $this->disertasi->detail($id_disertasi);

            $data = array(
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
                'pengujis' => $this->disertasi->read_penguji($id_ujian),
                'disertasi' => $this->disertasi->detail($id_disertasi)
            );

            $this->ciqrcode->initialize($this->config_qr);
            $image_name = 'berita_acara_kualifikasi_' . $disertasi->nim . '.png'; //buat name dari qr code sesuai dengan nip
            $params['data'] = base_url() . 'document/berita_acara?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_disertasi . '$' . TAHAPAN_DISERTASI_KUALIFIKASI; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH . $this->config_qr['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params);
            ob_end_clean();
            $page = 'backend/baa/doktoral/kualifikasi/cetak_berita';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = 'berita_acara_kualifikasi_' . $disertasi->nim;
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/doktoral/disertasi/kualifikasi/');
        }
    }

    public function cetak_penilaian() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
                'disertasi' => $this->disertasi->detail($id_disertasi)
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/doktoral/kualifikasi/cetak_penilaian';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "disertasi_penilaian.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/doktoral/disertasi/kualifikasi/');
        }
    }

    public function cetak_absensi() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);

            $data = array(
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
                'disertasi' => $this->disertasi->detail($id_disertasi)
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/baa/doktoral/kualifikasi/cetak_absensi';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "disertasi_absensi.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/doktoral/disertasi/kualifikasi/');
        }
    }

}

?>