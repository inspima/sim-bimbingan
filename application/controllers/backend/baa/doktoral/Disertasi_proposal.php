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
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        //END MODEL
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
            $id_ujian = $ujian->id_ujian;

            $data = array(
                'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_PROPOSAL),
                'promotors' => $this->disertasi->read_promotor_kopromotor($id_disertasi),
                'pengujis' => $this->disertasi->read_penguji($id_ujian),
                'disertasi' => $this->disertasi->detail($id_disertasi)
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