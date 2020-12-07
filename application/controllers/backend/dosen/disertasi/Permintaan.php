<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //START SESS
        $this->session_data = $this->session->userdata('logged_in');

        if (!$this->session_data) {
            redirect('logout', 'refresh');
        } else {
            if ($this->session_data['sebagai'] != 1 AND $this->session_data['role'] != 0) {
                redirect('logout', 'refresh');
            }
        }
        //END SESS
        //START MODEL
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/administrator/master/departemen_model', 'departemen');
        $this->load->model('backend/administrator/master/ruang_model', 'ruang');
        $this->load->model('backend/administrator/master/jam_model', 'jam');
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/transaksi/disertasi', 'disertasi');
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    // DOSEN PENGUJI

    public function penguji_kualifikasi() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Kualifikasi - Permintaan Dosen Penguji',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/permintaan/penguji_kualifikasi',
            // DATA //
            'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_KUALIFIKASI)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penguji_proposal() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Proposal - Permintaan Dosen Penguji',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/permintaan/penguji_proposal',
            // DATA //
            'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_PROPOSAL)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penguji_kelayakan() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Kelayakan - Permintaan Dosen Penguji',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/permintaan/penguji_kelayakan',
            // DATA //
            'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_KELAYAKAN)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penguji_tertutup() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Ujian Tertutup - Permintaan Dosen Penguji',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/permintaan/penguji_tertutup',
            // DATA //
            'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_TERTUTUP)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penguji_terbuka() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Ujian Terbuka - Permintaan Dosen Penguji',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/permintaan/penguji_terbuka',
            // DATA //
            'disertasi' => $this->disertasi->read_permintaan_penguji($this->session_data['username'], UJIAN_DISERTASI_TERBUKA)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penguji_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_penguji = $this->input->post('id_penguji', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);
            $id_disertasi = $this->input->post('id_disertasi', TRUE);

            $data = array(
                'status' => 2,
            );

            $this->disertasi->update_penguji($data, $id_penguji);

            $semua_penguji_setuju = $this->disertasi->semua_penguji_setuju($id_ujian);
            if ($semua_penguji_setuju) {
                $ujian = $this->disertasi->detail_ujian($id_ujian);
                switch ($ujian->jenis_ujian) {
                    case UJIAN_DISERTASI_KUALIFIKASI:
                        $data = array(
                            'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PENGUJI,
                        );
                        break;
                    case UJIAN_DISERTASI_PROPOSAL:
                        $data = array(
                            'status_proposal' => STATUS_DISERTASI_PROPOSAL_SETUJUI_PENGUJI,
                        );
                        break;
                    case UJIAN_DISERTASI_KELAYAKAN:
                        $data = array(
                            'status_kelayakan' => STATUS_DISERTASI_KELAYAKAN_SETUJUI_PENGUJI,
                        );
                        break;
                    case UJIAN_DISERTASI_TERTUTUP:
                        $data = array(
                            'status_tertutup' => STATUS_DISERTASI_TERTUTUP_SETUJUI_PENGUJI,
                        );
                        break;
                    case UJIAN_DISERTASI_TERBUKA:
                        $data = array(
                            'status_terbuka' => STATUS_DISERTASI_TERBUKA_SETUJUI_PENGUJI,
                        );
                        break;
                }

                $this->disertasi->update($data, $id_disertasi);
            }

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil disetujui');
            redirect_back();
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

    // DOSEN PENASEHAT AKADEMIK

    public function penasehat() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Permintaan Penasehat Akademik',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/permintaan/penasehat',
            // DATA //
            'disertasi' => $this->disertasi->read_permintaan_penasehat($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penasehat_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);

            $data = array(
                'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PA,
            );

            $this->disertasi->update($data, $id_disertasi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil disetujui');
            redirect('dosen/disertasi/permintaan/penasehat');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/permintaan/penasehat');
        }
    }

    // DOSEN PROMOTOR/KOPROMOTOR

    public function promotor() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Permintaan Dosen Promotor/Ko-Promotor',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/permintaan/promotor',
            // DATA //
            'disertasi' => $this->disertasi->read_permintaan_promotor($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function promotor_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $id_promotor = $this->input->post('id_promotor', TRUE);

            $data = array(
                'status' => 2,
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
            $this->session->set_flashdata('msg', 'Berhasil disetujui');
            redirect('dosen/disertasi/permintaan/promotor');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/permintaan/promotor');
        }
    }

    public function mpkk_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'status_mpkk' => STATUS_DISERTASI_MPKK_SETUJUI_PROMOTOR,
            );
            $data = array(
                'status_mpkk' => STATUS_DISERTASI_MPKK_SELESAI,
            );
            $this->disertasi->update($data, $id_disertasi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect('dosen/disertasi/permintaan/promotor');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/permintaan/promotor');
        }
    }

    public function proposal_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'status_proposal' => STATUS_DISERTASI_PROPOSAL_SETUJUI_PROMOTOR,
            );
            $this->disertasi->update($data, $id_disertasi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect('dosen/disertasi/permintaan/promotor');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/permintaan/promotor');
        }
    }

    public function mkpd_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'status_mkpd' => STATUS_DISERTASI_MKPD_SETUJUI_PROMOTOR,
            );
            $this->disertasi->update($data, $id_disertasi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect('dosen/disertasi/permintaan/promotor');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/permintaan/promotor');
        }
    }

    public function kelayakan_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'status_kelayakan' => STATUS_DISERTASI_KELAYAKAN_SETUJUI_PROMOTOR,
            );
            $this->disertasi->update($data, $id_disertasi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect('dosen/disertasi/permintaan/promotor');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/permintaan/promotor');
        }
    }

    public function tertutup_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'status_tertutup' => STATUS_DISERTASI_TERTUTUP_SETUJUI_PROMOTOR,
            );
            $this->disertasi->update($data, $id_disertasi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect('dosen/disertasi/permintaan/promotor');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/permintaan/promotor');
        }
    }

    public function terbuka_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'status_terbuka' => STATUS_DISERTASI_TERBUKA_SETUJUI_PROMOTOR,
            );
            $this->disertasi->update($data, $id_disertasi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect('dosen/disertasi/permintaan/promotor');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/permintaan/promotor');
        }
    }

}

?>