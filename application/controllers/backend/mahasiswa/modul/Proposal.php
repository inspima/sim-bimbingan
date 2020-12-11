<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal extends CI_Controller {

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
        $this->load->model('backend/user', 'user');
        $this->load->model('backend/baa/master/mahasiswa_model', 'mahasiswa');
        $this->load->model('backend/mahasiswa/modul/proposal_model', 'proposal');
        $this->load->model('backend/administrator/master/departemen_model', 'departemen');
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/utility/notification', 'notifikasi');
        //END MODEL
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Proposal Skripsi',
            'section' => 'backend/mahasiswa/modul/proposal',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'proposal' => $this->proposal->read($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $read_aktif = $this->proposal->read_aktif($this->session_data['username']);

        if ($read_aktif) {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Proposal masih aktif');
            redirect('dashboardm/modul/proposal');
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul (Mahasiswa)',
                'subtitle' => 'Pengajuan Proposal Skripsi',
                'section' => 'backend/mahasiswa/modul/proposal_add',
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
            $config['upload_path'] = './assets/upload/proposal/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 20000;
            $config['remove_spaces'] = TRUE;
            $config['file_ext_tolower'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $id_departemen = $this->input->post('id_departemen', TRUE);

            if (!$this->upload->do_upload('berkas_proposal')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $upload_data = $this->upload->data();
                $file = $upload_data['file_name'];

                date_default_timezone_set('Asia/Jakarta');
                $now = date('Y-m-d H:i:s');

                $data = array(
                    'id_departemen' => $id_departemen,
                    'id_gelombang' => $this->input->post('id_gelombang', TRUE),
                    'jenis' => 1,
                    'nim' => $this->session_data['username'],
                    'tgl_pengajuan' => $now,
                    'berkas_proposal' => $upload_data['file_name'],
                    'status_proposal' => 1
                );

                $this->proposal->save($data);
                $last_id = $this->db->insert_id();

                $dataj = array(
                    'id_skripsi' => $last_id,
                    'judul' => $this->input->post('judul', TRUE)
                );

                $this->proposal->save_judul($dataj);

                // Kirim Notifikasi
                $id_struktural = '';
                switch ($id_departemen) {
                    case 1:
                        $id_struktural = 1;
                        break;
                    case 3:
                        $id_struktural = 8;
                        break;
                    case 6:
                        $id_struktural = 5;
                        break;
                    case 5:
                        $id_struktural = 6;
                        break;
                    case 3:
                        $id_struktural = 7;
                        break;
                    case 2:
                        $id_struktural = 4;
                        break;
                }
                $struktur_kadep = $this->struktural->detail($id_struktural);
                $judul_notifikasi = 'Persetujuan Proposal Skripsi (KADEP)';
                $isi_notifikasi = 'Mohon untuk melakukan persetujuan proposal skripsi dengan Nim ' . $this->session_data['username'] . ' pada sistem IURIS';
                $this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 1, $struktur_kadep->nip);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan proposal skripsi. Tunggu persetujuan Kadep.');
                redirect('dashboardm/modul/proposal');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardm/modul/proposal');
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
            'proposal' => $this->proposal->detail($id, $username)
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

            $read_judul = $this->proposal->read_judul($id_skripsi);
            $judul = $this->input->post('judul', TRUE);

            if ($judul == $read_judul->judul) {
                $data = array(
                    'id_departemen' => $this->input->post('id_departemen', TRUE),
                );
                $this->proposal->update($data, $id_skripsi);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('dashboardm/modul/proposal');
            } else {
                $data = array(
                    'id_departemen' => $this->input->post('id_departemen', TRUE),
                );
                $this->proposal->update($data, $id_skripsi);

                $dataj = array(
                    'id_skripsi' => $id_skripsi,
                    'judul' => $this->input->post('judul', TRUE)
                );

                $this->proposal->save_judul($dataj);

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

                $this->proposal->update($data, $id_skripsi);

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
            'proposal' => $this->proposal->detail($id, $username),
            'ujian' => $this->proposal->ujian($id, $username)
        );
        if ($data['ujian']) {
            $data['penguji'] = $this->proposal->read_penguji($data['ujian']->id_ujian);
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