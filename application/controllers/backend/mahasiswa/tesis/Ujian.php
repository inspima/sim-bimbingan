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
        $this->load->model('backend/administrator/master/departemen_model', 'departemen');
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
            'jadwal' => $this->tesis->read_jadwal($id_tesis, 2),
            'tesis' => $this->tesis->detail($id_tesis),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $id_tesis = $this->uri->segment('5');
        $read_aktif = $this->tesis->read_aktif($this->session_data['username']);

        if ($read_aktif) {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Masih ada judul aktif');
            redirect('mahasiswa/tesis/ujian');
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul (Mahasiswa)',
                'subtitle' => 'Pengajuan Tesis',
                'section' => 'backend/mahasiswa/tesis/ujian/add',
                'use_back' => true,
                'back_link' => 'mahasiswa/tesis/ujian',
                // DATA //
                'departemen' => $this->departemen->read(),
                'tesis' => $this->tesis->detail($id_tesis),
            );
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $file_name = $this->session_data['username'] . '_berkas_tesis.pdf';
            $config['upload_path'] = './assets/upload/mahasiswa/tesis/ujian';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = MAX_SIZE_FILE_UPLOAD;
            $config['remove_spaces'] = TRUE;
            $config['file_ext_tolower'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $config['file_name'] = $file_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $file_name_syarat = $this->session_data['username'] . '_berkas_syarat_tesis.pdf';
            $config_syarat['upload_path'] = './assets/upload/mahasiswa/tesis/ujian';
            $config_syarat['allowed_types'] = 'pdf';
            $config_syarat['max_size'] = MAX_SIZE_FILE_UPLOAD;
            $config_syarat['remove_spaces'] = TRUE;
            $config_syarat['file_ext_tolower'] = TRUE;
            $config_syarat['detect_mime'] = TRUE;
            $config_syarat['mod_mime_fix'] = TRUE;
            $config_syarat['file_name'] = $file_name;
            $this->load->library('upload', $config_syarat);
            $this->upload->initialize($config_syarat);

            if (!$this->upload->do_upload('berkas_tesis') AND !$this->upload->do_upload('berkas_syarat_tesis')) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', $this->upload->display_errors());
                redirect_back();
            } else {
                $id_tesis = $this->input->post('id_tesis', TRUE);
                $tgl_sekarang = date('Y-m-d');
                $data = array(
                    'jenis' => TAHAPAN_TESIS_UJIAN,
                    'berkas_tesis' => $file_name,
                    'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    'berkas_syarat_tesis' => $file_name_syarat,
                );

                $this->tesis->update($data, $id_tesis);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan Tesis..');
                redirect('mahasiswa/tesis/ujian');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

}

?>