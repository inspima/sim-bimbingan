<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Terbuka extends CI_Controller {

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
        $this->load->model('backend/transaksi/disertasi', 'disertasi');
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Disertasi - Ujian Terbuka',
            'section' => 'backend/mahasiswa/disertasi/terbuka/index',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'disertasi' => $this->disertasi->read_terbuka_mahasiswa($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function info() {
        $id_disertasi = $this->uri->segment('5');
        $data = array(
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Disertasi - Ujian Terbuka',
            'section' => 'backend/mahasiswa/disertasi/terbuka/info',
            'use_back' => true,
            'back_link' => 'mahasiswa/disertasi/terbuka',
            // DATA //
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'disertasi' => $this->disertasi->detail($id_disertasi),
            'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_TERBUKA),
            'status_ujians' => $this->disertasi->read_status_ujian(UJIAN_DISERTASI_TERBUKA),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $id_disertasi = $this->uri->segment('5');
        $read_aktif = $this->disertasi->read_aktif($this->session_data['username']);

        if ($read_aktif) {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Masih ada judul aktif');
            redirect('mahasiswa/disertasi/terbuka');
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul (Mahasiswa)',
                'subtitle' => 'Pengajuan Ujian Terbuka',
                'section' => 'backend/mahasiswa/disertasi/terbuka/add',
                'use_back' => true,
                'back_link' => 'mahasiswa/disertasi/terbuka',
                'mdosen' => $this->dosen->read_aktif_alldep(),
                // DATA //
                'departemen' => $this->departemen->read(),
                'gelombang' => $this->gelombang->read_berjalan(),
                'disertasi' => $this->disertasi->detail($id_disertasi),
            );
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $file_name = $this->session_data['username'] . '_berkas_terbuka.pdf';
            $config['upload_path'] = './assets/upload/mahasiswa/disertasi/terbuka';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = MAX_SIZE_FILE_UPLOAD;
            $config['remove_spaces'] = TRUE;
            $config['file_ext_tolower'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $config['file_name'] = $file_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('berkas_terbuka')) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', $this->upload->display_errors());
                redirect('mahasiswa/disertasi/kualifikasi');
            } else {
                $id_disertasi = $this->input->post('id_disertasi', TRUE);
                $tgl_sekarang = date('Y-m-d');
                $data = array(
                    'jenis' => 2,
                    'waktu_pengajuan_terbuka' => $tgl_sekarang,
                    'berkas_terbuka' => $file_name,
                    'status_terbuka' => STATUS_DISERTASI_TERBUKA_PENGAJUAN,
                );

                $this->disertasi->update($data, $id_disertasi);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan terbuka..');
                redirect('mahasiswa/disertasi/terbuka');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('mahasiswa/disertasi/kualifikasi');
        }
    }

    public function edit() {
        $id = $this->uri->segment(5);
        $username = $this->session_data['username'];

        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Pengajuan Ujian Terbuka',
            'section' => 'backend/mahasiswa/modul/terbuka_edit',
            // DATA //
            'departemen' => $this->departemen->read(),
            'gelombang' => $this->gelombang->read_berjalan(),
            'terbuka' => $this->disertasi->detail($id, $username)
        );

        if ($data['terbuka']) {
            $this->load->view('backend/index_sidebar', $data);
        } else {
            $data['section'] = 'backend/notification/danger';
            $data['msg'] = 'Tidak ditemukan';
            $data['linkback'] = 'dashboardm/modul/terbuka';
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function update() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_skripsi = $this->input->post('id_skripsi', TRUE);

            $read_judul = $this->disertasi->read_judul($id_skripsi);
            $judul = $this->input->post('judul', TRUE);

            if ($judul == $read_judul->judul) {
                $data = array(
                    'id_departemen' => $this->input->post('id_departemen', TRUE),
                );
                $this->disertasi->update($data, $id_skripsi);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('dashboardm/modul/terbuka');
            } else {
                $data = array(
                    'id_departemen' => $this->input->post('id_departemen', TRUE),
                );
                $this->disertasi->update($data, $id_skripsi);

                $dataj = array(
                    'id_skripsi' => $id_skripsi,
                    'judul' => $this->input->post('judul', TRUE)
                );

                $this->disertasi->save_judul($dataj);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('dashboardm/modul/terbuka');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardm/modul/terbuka');
        }
    }

}

?>