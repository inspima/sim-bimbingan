<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Promotor extends CI_Controller {

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
            'subtitle' => 'Disertasi - Pengajuan Promotor',
            'section' => 'backend/mahasiswa/disertasi/promotor/index',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'disertasi' => $this->disertasi->read_kualifikasi_mahasiswa($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function info() {
        $id_disertasi = $this->uri->segment('5');
        $data = array(
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Disertasi - Kualifikasi',
            'section' => 'backend/mahasiswa/disertasi/promotor/info',
            'use_back' => true,
            'back_link' => 'mahasiswa/disertasi/promotor',
            // DATA //            
            'mdosen' => $this->dosen->read_aktif_alldep_s3(),
            'disertasi' => $this->disertasi->detail($id_disertasi),
            'jadwal' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
            'status_ujians' => $this->disertasi->read_status_ujian(UJIAN_DISERTASI_KUALIFIKASI),
        );
        $this->load->view('backend/index_sidebar', $data);
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
                redirect_back();
            } else {
                $jumlah_promotor = $this->disertasi->count_penguji($id_disertasi);
                if ($jumlah_promotor < 3) {
                    if ($status_tim == '1') {
                        $cek_promotor_ada = $this->disertasi->cek_promotor_ada($id_disertasi);
                        if (empty($cek_promotor_ada)) {
                            $this->disertasi->save_promotor($data);
                            // UPDATE STATUS DISERTASI
                            $update_disertasi = [
                                'status_promotor' => STATUS_DISERTASI_PROMOTOR_PENGAJUAN,
                            ];
                            $this->disertasi->update($update_disertasi, $id_disertasi);
                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', "Data berhasil disimpan");
                            redirect_back();
                        } else {
                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal simpan. Promotor sudah ada');
                            redirect_back();
                        }
                    } else {
                        $this->disertasi->save_promotor($data);
                        // UPDATE STATUS DISERTASI
                        $update_disertasi = [
                            'status_promotor' => STATUS_DISERTASI_PROMOTOR_PENGAJUAN,
                        ];
                        $this->disertasi->update($update_disertasi, $id_disertasi);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', "Data berhasil disimpan");
                        redirect_back();
                    }
                } else if ($jumlah_promotor >= 3) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah Promotor/Ko-Promotor sudah 3');
                    redirect_back();
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
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
                    'status_promotor' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PROMOTOR,
                );
                $this->disertasi->update($data, $id_disertasi);
            }

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
            redirect_back();
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

}

?>