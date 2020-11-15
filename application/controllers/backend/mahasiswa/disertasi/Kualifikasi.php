<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kualifikasi extends CI_Controller {

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
        $this->load->model('backend/mahasiswa/disertasi_model', 'disertasi');
        $this->load->model('backend/administrator/master/departemen_model', 'departemen');
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        //END MODEL
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Disertasi - Kualifikasi',
            'section' => 'backend/mahasiswa/disertasi/kualifikasi/index',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'disertasi' => $this->disertasi->read_kualifikasi_mahasiswa($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $read_aktif = $this->disertasi->read_aktif($this->session_data['username']);

        if ($read_aktif) {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Masih ada judul aktif');
            redirect('mahasiswa/disertasi/kualifikasi');
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul (Mahasiswa)',
                'subtitle' => 'Pengajuan Ujian Kualifikasi',
                'section' => 'backend/mahasiswa/disertasi/kualifikasi/add',
                // DATA //
                'departemen' => $this->departemen->read(),
                'gelombang' => $this->gelombang->read_berjalan()
            );
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $tgl_sekarang = date('Y-m-d');
            $data = array(
                'id_departemen' => $this->input->post('id_departemen', TRUE),
                'jenis' => 1,
                'nim' => $this->session_data['username'],
                'tgl_pengajuan' => $tgl_sekarang,
                'status_disertasi' => 1,
                'berkas_proposal' => '',
                'status_proposal' => 0,
            );

            $this->disertasi->save($data);
            $last_id = $this->db->insert_id();

            $dataj = array(
                'id_disertasi' => $last_id,
                'judul' => $this->input->post('judul', TRUE)
            );

            $this->disertasi->save_judul($dataj);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan ujian kualifikasi..');
            redirect('mahasiswa/disertasi/kualifikasi');
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
            'subtitle' => 'Pengajuan Proposal Skripsi',
            'section' => 'backend/mahasiswa/modul/proposal_edit',
            // DATA //
            'departemen' => $this->departemen->read(),
            'gelombang' => $this->gelombang->read_berjalan(),
            'proposal' => $this->disertasi->detail($id, $username)
        );

        if ($data['proposal']) {
            $this->load->view('backend/index_sidebar', $data);
        } else {
            $data['section'] = 'backend/notification/danger';
            $data['msg'] = 'Tidak ditemukan';
            $data['linkback'] = 'dashboardm/modul/proposal';
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
                redirect('dashboardm/modul/proposal');
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
                redirect('dashboardm/modul/proposal');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardm/modul/proposal');
        }
    }

    public function update_file() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_skripsi = $this->input->post('id_skripsi', TRUE);

            $config['upload_path'] = './assets/upload/proposal/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 20000;
            $config['remove_spaces'] = TRUE;
            $config['file_ext_tolower'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('berkas_proposal')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $upload_data = $this->upload->data();
                $file = $upload_data['file_name'];

                $data = array(
                    'berkas_proposal' => $upload_data['file_name'],
                );

                $this->disertasi->update($data, $id_skripsi);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Update BAB I berhasil.');
                redirect('dashboardm/modul/proposal');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardm/modul/proposal');
        }
    }

    public function ujian() {
        $id = $this->uri->segment(5);
        $username = $this->session_data['username'];

        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Pengajuan Proposal Skripsi (Jadwal Ujian)',
            'section' => 'backend/mahasiswa/modul/proposal_ujian',
            // DATA //
            'proposal' => $this->disertasi->detail($id, $username),
            'ujian' => $this->disertasi->ujian($id, $username)
        );
        if ($data['ujian']) {
            $data['penguji'] = $this->disertasi->read_penguji($data['ujian']->id_ujian);
            $this->load->view('backend/index_sidebar', $data);
        } else {
            $data['section'] = 'backend/notification/danger';
            $data['msg'] = 'Tidak ditemukan / Ujian belum disetting Kadep.';
            $data['linkback'] = 'dashboardm/modul/proposal';
            $this->load->view('backend/index_sidebar', $data);
        }
    }

}

?>