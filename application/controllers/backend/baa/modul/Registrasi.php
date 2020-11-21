<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi extends CI_Controller {

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
        $this->load->model('backend/user', 'user', TRUE);
        $this->load->model('backend/utility/email', 'email_model', TRUE);
        //END MODEL
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Modul Registrasi',
            'subtitle' => 'Verifikasi Mahasiswa',
            'section' => 'backend/baa/modul/verifikasi',
            // DATA //
            'mahasiswas' => $this->user->read_mhs_verifikasi(),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function verifikasi() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_user = $this->input->post('id_user', TRUE);
            $email = $this->input->post('email', TRUE);
            $nama = $this->input->post('nama', TRUE);

            $data = array(
                'verifikasi' => 1,
            );
            $this->user->update_p($data, $id_user);
            // KIRIM EMAIL VERIFIKASI
            $this->email_model->send_verified($email, $nama);
            
            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil diverifikasi');
            redirect('baa/modul/registrasi');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/modul/registrasi');
        }
    }

}

?>