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
            if ($this->session_data['sebagai'] != 3 AND $this->session_data['role'] != 0) {
                redirect('logout', 'refresh');
            }
        }
        //END SESS
        //START MODEL
        $this->load->model('backend/baa/master/mahasiswa_model', 'mahasiswa');
        $this->load->model('backend/mahasiswa/master/biodata_model', 'biodata');
        $this->load->model('backend/administrator/master/departemen_model', 'departemen');
        $this->load->model('backend/administrator/master/minat_tesis_model', 'minat_tesis');
        $this->load->model('backend/administrator/master/ruang_model', 'ruang');
        $this->load->model('backend/administrator/master/jam_model', 'jam');
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/transaksi/tesis', 'tesis');
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Tesis - Ujian',
            'section' => 'backend/mahasiswa/tesis/ujian/index',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'biodata' => $this->biodata->detail($this->session_data['username']),
            'tesis' => $this->tesis->read_ujian_mahasiswa($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function info() {
        $id_tesis = $this->uri->segment('5');
        $data = array(
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Tesis - Ujian',
            'section' => 'backend/mahasiswa/tesis/ujian/info',
            'use_back' => true,
            'back_link' => 'mahasiswa/tesis/ujian',
            // DATA //
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'jadwal' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'tesis' => $this->tesis->detail($id_tesis),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $id_tesis = $this->uri->segment('5');
        $read_aktif = $this->tesis->read_aktif_tesis($this->session_data['username']);

        if ($read_aktif) {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->sessio