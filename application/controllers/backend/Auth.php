<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $captcha_config;

    function __construct() {
        parent::__construct();
        $this->captcha_config = array(
            'img_url' => base_url() . 'assets/captcha/',
            'img_path' => 'assets/captcha/',
            'word_length' => 6,
            'font_size' => 11
        );
        $this->load->model('backend/user', 'user', TRUE);
        $this->load->model('backend/master/prodi', 'prodi', TRUE);
        $this->load->model('backend/utility/email', 'email_model', TRUE);
        $this->load->model('backend/mahasiswa/master/Biodata_model', 'biodata');
        $this->load->library('session', 'session');
        $this->load->helper('string');
        $this->load->helper('captcha');
    }

    public function register() {
        if ($this->input->post('_token')) {
            $email = $this->input->post('email');
            $nama = $this->input->post('nama');
            $nim = $this->input->post('nim');
            $id_prodi = $this->input->post('prodi');
            $sks = $this->input->post('sks');
            $captcha_insert = $this->input->post('captcha');
            $password = random_string('alnum', 6);
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $contain_sess_captcha = $this->session->userdata('captcha_code');
            if ($captcha_insert === $contain_sess_captcha) {
                $prodi = $this->prodi->detail($id_prodi);
                $role = 0;
                // SET ROLE
                // S2
                if ($prodi->id_jenjang == 2) {
                    $role = 5;
                }
                // S3
                else if ($prodi->id_jenjang == 3) {
                    $role = 6;
                }
                $data_user = [
                    'username' => $nim,
                    'password' => $password_hash,
                    'sebagai' => 3,
                    'role' => $role,
                    'status' => 1,
                    'verifikasi' => 0
                ];
                // Insert User
                $this->user->create($data_user);
                $data_mahasiswa = [
                    'nim' => $nim,
                    'nama' => $nama,
                    'telp' => '',
                    'email' => $email,
                    'status' => 1,
                    'sks' => $sks,
                    'id_prodi' => $id_prodi,
                ];
                // Cek Mahasiswa sudah ada 
                $cek_mhs = $this->user->read_mhs($nim);
                if (!empty($cek_mhs)) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Data mahasiswa sudah ada');
                } else {
                    // Insert Mahasiswa Mahasiswa
                    $this->user->create_mahasiswa($data_mahasiswa);
                    // Kirim Email
                    $this->email_model->send_registration($email, $nim, $password);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Registrasi berhasil, silahkan cek email.');
                }
            } else {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Kode verifikasi tidak sesuai');
            }
        }
        $captcha = create_captcha($this->captcha_config);
        $data = array(
            // PAGE //
            'title' => 'Registrasi',
            'subtitle' => '',
            'section' => 'backend/page/register',
            'prodis' => $this->prodi->read_all_prodi(),
            'captcha_image' => $captcha['image'],
        );
        $this->session->unset_userdata('captcha_code');
        $this->session->set_userdata('captcha_code', $captcha['word']);
        $this->load->view('backend/index_top', $data);
    }

    public function verifikasi() {
        $this->session_data = $this->session->userdata('logged_in');
        if ($this->input->post('_token')) {
            $file_name = $this->session_data['username'] . '_berkas_verifikasi.pdf';
            $config['upload_path'] = './assets/upload/mahasiswa/verifikasi';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 1000;
            $config['remove_spaces'] = TRUE;
            $config['file_ext_tolower'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $config['file_name'] = $file_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $id_mhs = $this->input->post('id_mhs', TRUE);
            $nama = $this->input->post('nama', TRUE);
            $alamat = $this->input->post('alamat', TRUE);
            $telp = $this->input->post('telp', TRUE);


            if (!$this->upload->do_upload('berkas_verifikasi')) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', $this->upload->display_errors());
                redirect('auth/verifikasi');
            } else {

                $data_mahasiswa = [
                    'nama' => $nama,
                    'telp' => $telp,
                    'alamat' => $alamat,
                    'berkas_verifikasi' => $file_name,
                ];
                // Inser Mahasiswa Mahasiswa
                $this->user->update_mahasiswa($data_mahasiswa, $id_mhs);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Data berhasil disimpan. Kami akan mengirimkan email setelah proses verifikasi selesai');
                redirect('auth/verifikasi');
            }
        }
        $username = $this->session_data['username'];
        $data = array(
            // PAGE //
            'title' => 'Mahasiswa',
            'subtitle' => 'Verifikasi',
            'section' => 'backend/mahasiswa/verifikasi',
            'biodata' => $this->biodata->detail($username),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function captcha_refresh() {
        $captcha = create_captcha($this->captcha_config);
        $this->session->unset_userdata('captcha_code');
        $this->session->set_userdata('captcha_code', $captcha['word']);
        echo $captcha['image'];
    }

}
