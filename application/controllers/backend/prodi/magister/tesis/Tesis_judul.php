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
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/master/semester', 'semester');
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
            'subtitle' => 'Tesis - Judul',
            'section' => 'backend/prodi/magister/tesis/judul/index',
            // DATA //
            'tesis' => $this->tesis->read_judul_tesis($this->session_data['username']),
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function cetak_surat_tugas_pembimbing() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $no_surat = $this->input->post('no_surat', TRUE);
            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, 1);
            $id_ujian = $ujian->id_ujian;

            $data = array(
                'tesis' => $this->tesis->detail($id_tesis),
                'no_surat' => $no_surat,
                'semester' => $this->semester->detail_berjalan(),
                'dekan' => $this->struktural->read_dekan()
            );
            //print_r($data['penguji_ketua']);die();
            ob_end_clean();
            $page = 'backend/prodi/magister/tesis/judul/cetak_surat_tugas_pembimbing';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = "tesis_sp_pembimbing.pdf";
            $this->pdf->load_view($page, $data);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('prodi/magister/tesis/tesis/judul/');
        }
    }
}

?>