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
            if ($this->session_data['sebagai'] != 2 AND $this->session_data['role'] != 2) {
                redirect('logout', 'refresh');
            }
        }
        //END SESS
        //START MODEL
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/baa/proposal/proposal_pengajuan_model', 'proposal');
        $this->load->model('backend/baa/proposal/proposal_diterima_model', 'proposal_diterima');
        $this->load->model('backend/baa/proposal/proposal_selesai_model', 'proposal_selesai');
        $this->load->model('backend/baa/proposal/penguji_pengajuan_model', 'penguji');
        //END MODEL
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Proposal',
            'subtitle' => 'Data Proposal (Pengajuan)',
            'section' => 'backend/baa/sarjanah/proposal/index',
            // DATA //
            'proposal' => $this->proposal->read()
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function diterima() {
        $data = array(
            // PAGE //
            'title' => 'Proposal',
            'subtitle' => 'Data Proposal (Pengajuan)',
            'section' => 'backend/baa/sarjanah/proposal/diterima',
            // DATA //
            'proposal' => $this->proposal_diterima->read()
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function selesai() {
        $data = array(
            // PAGE //
            'title' => 'Proposal',
            'subtitle' => 'Data Proposal (Pengajuan)',
            'section' => 'backend/baa/sarjanah/proposal/selesai',
            // DATA //
            'proposal' => $this->proposal_selesai->read()
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function ditolak() {
        $data = array(
            // PAGE //
            'title' => 'Proposal',
            'subtitle' => 'Data Proposal (Pengajuan)',
            'section' => 'backend/baa/sarjanah/proposal/ditolak',
            // DATA //
            'proposal' => $this->proposal->read()
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function belum_approve() {
        $data = array(
            // PAGE //
            'title' => 'Proposal',
            'subtitle' => 'Data Proposal (Pengajuan)',
            'section' => 'backend/baa/sarjanah/proposal/belum_approve',
            // DATA //
            'penguji' => $this->penguji->read()
        );

        $this->load->view('backend/index_sidebar', $data);
    }

    public function edit() {
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
        if ($struktural->id_struktur == '5') {
            $id_skripsi = $this->uri->segment('5');

            $data = array(
                // PAGE //
                'title' => 'Pengajuan Proposal (Modul Ketua Departemen)',
                'subtitle' => 'Data Pengajuan Proposal',
                'section' => 'backend/dosen/proposal/kadep_pengajuan_detail',
                // DATA //
                'proposal' => $this->proposal->detail($id_departemen, $id_skripsi),
                'departemen' => $this->departemen->read()
            );

            if ($data['proposal']) {
                $this->load->view('backend/index_sidebar', $data);
            } else {
                $data['section'] = 'backend/notification/danger';
                $data['msg'] = 'Tidak ditemukan';
                $data['linkback'] = 'dashboardd/proposal/kadep_pengajuan';
                $this->load->view('backend/index_sidebar', $data);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardd');
        }
    }

    public function update_proses() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_skripsi = $this->input->post('id_skripsi', TRUE);

            $data = array(
                'status_proposal' => $this->input->post('status_proposal', TRUE),
                'keterangan_proposal' => $this->input->post('keterangan_proposal', TRUE),
            );
            $this->proposal->update($data, $id_skripsi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil update proses');
            redirect('dashboardd/proposal/kadep_pengajuan');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardd/proposal/kadep_pengajuan');
        }
    }

    public function update_departemen() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_skripsi = $this->input->post('id_skripsi', TRUE);

            $data = array(
                'id_departemen' => $this->input->post('id_departemen', TRUE),
            );
            $this->proposal->update($data, $id_skripsi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil update departemen. Data pengajuan proposal akan berpindah ke departemen yang dituju.');
            redirect('dashboardd/proposal/kadep_pengajuan');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardd/proposal/kadep_pengajuan');
        }
    }

}

?>