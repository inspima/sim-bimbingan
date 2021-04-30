<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bimbingan extends CI_Controller {

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
        $this->load->model('backend/administrator/master/Departemen_model', 'departemen');
        $this->load->model('backend/baa/master/semester_model', 'semester');
        $this->load->model('backend/baa/report/report_model', 'report');
        //END MODEL
    }

   

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Skripsi Pengajuan',
            'subtitle' => 'Data Skripsi (Pengajuan)',
            'section' => 'backend/baa/report/bimbingan',
            // DATA //
            'departemen' => $this->departemen->read(),
            'semester' => $this->semester->read(),
            'data_bimbingan' => $this->report->bimbingan()
        );
        

        $this->load->view('backend/index_sidebar', $data);
    }
    
    public function detail_bimbingan() {
        $nip = $this->uri->segment(6);
        $data = array(
            // PAGE //
            'title' => 'Daftar Bimbingan',
            'subtitle' => 'Data Bimbingan',
            'section' => 'backend/baa/report/detail_bimbingan',
            // DATA //
            'data_bimbingan' => $this->report->detail_bimbingan($nip)
        );
        

        $this->load->view('backend/index_sidebar', $data);
    }

    
    

    
}

?>