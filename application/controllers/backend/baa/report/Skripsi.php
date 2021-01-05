<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Skripsi extends CI_Controller {

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
        $this->load->model('backend/administrator/master/Departemen_model', 'departemen');
        $this->load->model('backend/baa/skripsi/Skripsi_belum_daftar_model', 'skripsi');
        $this->load->model('backend/baa/skripsi/skripsi_pengajuan_model', 'skripsi_pengajuan');
        $this->load->model('backend/baa/skripsi/skripsi_diterima_model', 'skripsi_diterima');
        $this->load->model('backend/baa/skripsi/skripsi_ujian_model', 'skripsi_ujian');
        $this->load->model('backend/baa/skripsi/Skripsi_penguji_pengajuan_model', 'penguji');
        //END MODEL
    }

   

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Skripsi Pengajuan',
            'subtitle' => 'Data Skripsi (Pengajuan)',
            'section' => 'backend/baa/report/skripsi',
            // DATA //
            'skripsi' => $this->skripsi_pengajuan->read()
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    
    

    
}

?>