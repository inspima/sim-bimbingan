<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pencarian extends CI_Controller {

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
        $this->load->model('backend/user', 'user', TRUE);
        $this->load->model('backend/utility/email', 'email_model', TRUE);
        $this->load->model('backend/master/tugas_akhir', 'tugas_akhir', TRUE);
        $this->load->model('backend/transaksi/disertasi', 'disertasi', TRUE);
        //END MODEL
    }

    public function index() {
        $search = $this->input->get('search', TRUE);
        if (!empty($search)) {
            $data = array(
                // PAGE //
                'title' => 'Modul Pencarian',
                'subtitle' => 'Mahasiswa',
                'section' => 'backend/baa/utility/pencarian',
                // DATA //
                'mahasiswas' => $this->user->read_mhs_cari($search),
            );
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul Pencarian',
                'subtitle' => 'Mahasiswa',
                'section' => 'backend/baa/utility/pencarian',
                // DATA //
                'mahasiswas' => [],
            );
        }

        $this->load->view('backend/index_sidebar', $data);
    }

}

?>