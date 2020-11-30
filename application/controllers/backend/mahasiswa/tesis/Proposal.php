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
            'subtitle' => 'Tesis - Proposal',
            'section' => 'backend/mahasiswa/tesis/proposal/index',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'tesis' => $this->tesis->read_proposal_mahasiswa($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function info() {
        $id_tesis = $this->uri->segment('5');
        $data = array(
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Tesis - Proposal',
            'section' => 'backend/mahasiswa/tesis/proposal/info',
            'use_back' => true,
            'back_link' => 'mahasiswa/tesis/proposal',
            // DATA //            
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'tesis' => $this->tesis->detail($id_tesis),
            'jadwal' => $this->tesis->read_jadwal($id_tesis, 1),
            'status_ujians' => $this->tesis->read_status_ujian(1),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $read_aktif = $this->tesis->read_aktif($this->session_data['username']);

        if ($read_aktif) {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Masih ada judul aktif');
            redirect('mahasiswa/tesis/proposal');
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul (Mahasiswa)',
                'subtitle' => 'Pengajuan Ujian Proposal',
                'section' => 'backend/mahasiswa/tesis/proposal/add',
                // DATA //
                'mdosen' => $this->dosen->read_aktif_alldep(),
                'departemen' => $this->departemen->read(),
                'gelombang' => $this->gelombang->read_berjalan()
            );
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $file_name = $this->session_data['username'] . '_berkas_proposal.pdf';
            $config['upload_path'] = './assets/upload/mahasiswa/tesis/proposal';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = MAX_SIZE_FILE_UPLOAD;
            $config['remove_spaces'] = TRUE;
            $config['file_ext_tolower'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $config['file_name'] = $file_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $tgl_sekarang = date('Y-m-d');
            if (!$this->upload->do_upload('berkas_proposal')) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', $this->upload->display_errors());
                redirect('mahasiswa/tesis/proposal');
            } else {
                $data = array(
                    'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                    'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                    'jenis' => 1,
                    'berkas_proposal' => $file_name,
                    'nim' => $this->session_data['username'],
                    'tgl_pengajuan' => $tgl_sekarang,
                    'status_proposal' => 1,
                );

                $this->tesis->save($data);
                $last_id = $this->db->insert_id();

                $dataj = array(
                    'id_tesis' => $last_id,
                    'judul' => $this->input->post('judul', TRUE)
                );

                $this->tesis->save_judul($dataj);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan ujian proposal..');
                redirect('mahasiswa/tesis/proposal');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('mahasiswa/tesis/proposal');
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

    public function promotor_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $status_tim = $this->input->post('status_tim', TRUE);
            $nip = $this->input->post('nip', TRUE);

            $data = array(
                'id_disertasi' => $id_disertasi,
                'nip' => $nip,
                'status_tim' => $status_tim,
                'status' => 1
            );

            $cek_promotor = $this->disertasi->cek_promotor_kopromotor($data);
            if ($cek_promotor) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Gagal simpan. Promotor/Co-Promotor sudah terdaftar.');
                redirect('mahasiswa/disertasi/kualifikasi/info/' . $id_disertasi);
            } else {
                $jumlah_promotor = $this->disertasi->count_penguji($id_disertasi);
                if ($jumlah_promotor < 3) {
                    if ($status_tim == '1') {
                        $cek_promotor_ada = $this->disertasi->cek_promotor_ada($id_disertasi);
                        if (empty($cek_promotor_ada)) {
                            $this->disertasi->save_promotor($data);
                            // UPDATE STATUS DISERTASI
                            $update_disertasi = [
                                'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_PENGAJUAN_PROMOTOR,
                            ];
                            $this->disertasi->update($update_disertasi, $id_disertasi);
                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', "Data berhasil disimpan");
                            redirect('mahasiswa/disertasi/kualifikasi/info/' . $id_disertasi);
                        } else {
                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal simpan. Promotor sudah ada');
                            redirect('mahasiswa/disertasi/kualifikasi/info/' . $id_disertasi);
                        }
                    } else {
                        $this->disertasi->save_promotor($data);
                        // UPDATE STATUS DISERTASI
                        $update_disertasi = [
                            'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_PENGAJUAN_PROMOTOR,
                        ];
                        $this->disertasi->update($update_disertasi, $id_disertasi);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', "Data berhasil disimpan");
                        redirect('mahasiswa/disertasi/kualifikasi/info/' . $id_disertasi);
                    }
                } else if ($jumlah_promotor >= 3) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah Promotor/Ko-Promotor sudah 3');
                    redirect('mahasiswa/disertasi/kualifikasi/info/' . $id_disertasi);
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('mahasiswa/disertasi/kualifikasi');
        }
    }

    public function promotor_delete() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $id_promotor = $this->input->post('id_promotor', TRUE);

            $data = array(
                'status' => 0,
            );

            $this->disertasi->update_promotor($data, $id_promotor);

            $semua_promotor_setujui = $this->disertasi->semua_promotor_setujui($id_disertasi);
            if ($semua_promotor_setujui) {
                $data = array(
                    'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PROMOTOR,
                );
                $data = array(
                    'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SELESAI,
                );
                $this->disertasi->update($data, $id_disertasi);
            }

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
            redirect('mahasiswa/disertasi/kualifikasi/info/' . $id_disertasi);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('mahasiswa/disertasi/kualifikasi');
        }
    }

}

?>