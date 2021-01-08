<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //START SESS
        $this->session_data = $this->session->userdata('logged_in');

        if (!$this->session_data) {
            redirect('logout', 'refresh');
        } else {
            if ($this->session_data['sebagai'] != 2 AND $this->session_data['role'] != 1) {
                redirect('logout', 'refresh');
            }
        }
        //END SESS
        //START MODEL
        $this->load->model('backend/user');
        $this->load->model('backend/administrator/master/departemen_model', 'departemen');
        $this->load->model('backend/master/prodi');
        //END MODEL
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Master User',
            'subtitle' => 'Administrator',
            'section' => 'backend/administrator/master/user',
            // DATA //
            'user' => $this->user->read(),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add_pegawai() {

        $data = array(
            // PAGE //
            'title' => 'Master User - Tambah Pegawai',
            'subtitle' => 'Administrator',
            'section' => 'backend/administrator/master/user_add_pegawai',
            'use_back' => true,
            'back_link' => 'dashboarda/master/user'
                // DATA //
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add_dosen() {

        $data = array(
            // PAGE //
            'title' => 'Master User - Tambah Dosen',
            'subtitle' => 'Administrator',
            'section' => 'backend/administrator/master/user_add_dosen',
            'use_back' => true,
            'back_link' => 'dashboarda/master/user',
            // DATA //
            'departemen' => $this->departemen->read(),
            'jenjang' => $this->prodi->read_jenjang(),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function save_pegawai() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $password = 'iurisfh';
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $data_user = [
                'sebagai' => '2',
                'password' => $password_hash,
                'username' => $this->input->post('nip', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE),
                'role' => $this->input->post('role', TRUE),
                'status' => '1',
                'verifikasi' => '1',
            ];
            $this->user->create($data_user);

            $data_pegawai = [
                'id_departemen' => '0',
                'jenis_pegawai' => '2',
                'id_jenjang' => '0',
                'status' => '1',
                'status_berjalan' => '1',
                'nip' => $this->input->post('nip', TRUE),
                'nama' => $this->input->post('nama', TRUE),
                'email' => $this->input->post('email', TRUE),
            ];

            $this->user->create_pegawai($data_pegawai);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil disimpan');
            redirect_back();
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

    public function save_dosen() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $password = 'iurisfh';
            $external = $this->input->post('external', TRUE);
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $data_user = [
                'sebagai' => '1',
                'password' => $password_hash,
                'username' => $this->input->post('nip', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE),
                'role' => '0',
                'status' => '1',
                'verifikasi' => '1',
            ];
            $this->user->create($data_user);

            $data_pegawai = [
                'id_departemen' => $this->input->post('id_departemen', TRUE),
                'jenis_pegawai' => '1',
                'id_jenjang' => $this->input->post('id_jenjang', TRUE),
                'status' => '1',
                'status_berjalan' => '1',
                'external' => !empty($external) ? $external : "0",
                'nip' => $this->input->post('nip', TRUE),
                'nama' => $this->input->post('nama', TRUE),
                'email' => $this->input->post('email', TRUE),
            ];

            $this->user->create_pegawai($data_pegawai);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil disimpan');
            redirect_back();
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

    public function detail() {
        $id = $this->uri->segment(5);

        $data = array(
            // PAGE //
            'title' => 'Master User',
            'subtitle' => 'Administrator',
            'section' => 'backend/administrator/master/user_detail',
            // DATA //
            'user' => $this->user->detail($id)
        );

        if ($data['user']) {
            $this->load->view('backend/index_sidebar', $data);
        } else {
            $data['section'] = 'backend/notification/danger';
            $data['msg'] = 'Tidak ditemukan';
            $data['linkback'] = 'dashboarda/master/user';
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function update_password() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $options = [
                'cost' => 10,
            ];
            $passhash = password_hash($this->input->post('password'), PASSWORD_DEFAULT, $options);

            $id_user = $this->input->post('id_user', TRUE);
            $data = array(
                'password' => $passhash
            );

            $this->user->update($data, $id_user);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil update Password');
            redirect('dashboarda/master/user/detail/' . $id_user);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboarda/master/user/detail/' . $id_user);
        }
    }

    function direct_login() {
        $session_data = $this->session->userdata('logged_in');

        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $username = $this->input->post('username', TRUE);

            //cek tabel user
            $cekuser = $this->user->login($username);

            //cek sebagai
            if ($cekuser->sebagai == '1') {//dosen
                $result = $this->user->read_tendikdosen($username);
            } else
            if ($cekuser->sebagai == '2') {//tendik
                $result = $this->user->read_tendikdosen($username);
            } else
            if ($cekuser->sebagai == '3') {//mahasiswa
                $result = $this->user->read_mhs($username);
            }


            $data = array(
                'id_user' => $result->id_user,
                'username' => $result->username,
                'nama' => $result->nama,
                'role' => $result->role,
                'sebagai' => $result->sebagai
            );
            $this->session->set_userdata('logged_in', $data);
            redirect('login', 'refresh');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboarda/master/user');
        }
    }

}

?>