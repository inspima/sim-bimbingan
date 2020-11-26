<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //START SESS
        $this->session_data = $this->session->userdata('logged_in');

        if (!$this->session_data) {
            redirect('logout', 'refresh');
        } else {
            if ($this->session_data['sebagai'] != 3) {
                redirect('logout', 'refresh');
            }
        }
        //END SESS
        //START MODEL
        $this->load->model('backend/mahasiswa/master/Biodata_model', 'biodata');
        $this->load->model('backend/mahasiswa/modul/Berita_model', 'berita');
        $this->load->model('backend/transaksi/Disertasi', 'disertasi');
        //END MODEL
    }

    public function index() {
        $username = $this->session_data['username'];
        $id_jenjang = 1;
        $tugas_akhir = [];
        if ($this->session_data['role'] == '5') {
            $id_jenjang = 2;
        } else if ($this->session_data['role'] == '6') {
            $id_jenjang = 3;
            $tugas_akhir = $this->disertasi->read_mahasiswa($this->session_data['username']);
        }
        $data = array(
            // PAGE //
            'title' => 'Selamat Datang, ' . $this->session_data['nama'],
            'subtitle' => 'Mahasiswa',
            'section' => 'backend/mahasiswa/home',
            // DATA //
            'tugas_akhir' => $tugas_akhir,
            'biodata' => $this->biodata->detail($username),
            'berita' => $this->berita->read(),
            'id_jenjang' => $id_jenjang,
        );

        $this->load->view('backend/index_sidebar', $data);
    }

}

?>