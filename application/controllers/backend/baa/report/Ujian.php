<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends CI_Controller {

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
        $id_departemen = $this->input->post('id_departemen');
         $id_semester = $this->input->post('id_semester');
        $data = array(
            // PAGE //
            'title' => 'Skripsi Pengajuan',
            'subtitle' => 'Data Skripsi (Pengajuan)',
            'section' => 'backend/baa/report/skripsi',
            // DATA //
            'departemen' => $this->departemen->read(),
            'semester' => $this->semester->read(),
            'id_departemen' => $id_departemen,
            'id_semester' => $id_semester,
            'data_ujian' => $this->report->ujian_s1($id_semester, $id_departemen)
        );
        

        $this->load->view('backend/index_sidebar', $data);
    }
    
    public function master() {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $data = array(
            // PAGE //
            'title' => 'Tesis Pengajuan',
            'subtitle' => 'Data Tesis',
            'section' => 'backend/baa/report/tesis',
            // DATA //
            'start' => $start,
            'end'=> $end,
            'departemen' => $this->departemen->read(),
            'semester' => $this->semester->read(),
            'data_ujian' => $this->report->ujian_s2($start, $end)
        );
        

        $this->load->view('backend/index_sidebar', $data);
    }


    
    

    
}

?>