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
		$this->load->model('backend/utility/notification', 'notifikasi');
        //END MODEL
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Modul Registrasi',
            'subtitle' => 'Verifikasi Mahasiswa',
            'section' => 'backend/baa/utility/verifikasi',
            // DATA //
            'mahasiswas' => $this->user->read_mhs_verifikasi(),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

	public function sarjana() {
		$data = array(
			// PAGE //
			'title' => 'Modul Registrasi',
			'subtitle' => 'Verifikasi Mahasiswa - S1',
			'section' => 'backend/baa/utility/verifikasi',
			// DATA //
			'mahasiswas' => $this->user->read_mhs_verifikasi_by_jenjang(JENJANG_S1),
		);
		$this->load->view('backend/index_sidebar', $data);
	}

	public function master() {
		$data = array(
			// PAGE //
			'title' => 'Modul Registrasi',
			'subtitle' => 'Verifikasi Mahasiswa - S2',
			'section' => 'backend/baa/utility/verifikasi',
			// DATA //
			'mahasiswas' => $this->user->read_mhs_verifikasi_by_jenjang(JENJANG_S2),
		);
		$this->load->view('backend/index_sidebar', $data);
	}

	public function master_mih() {
		$data = array(
			// PAGE //
			'title' => 'Modul Registrasi',
			'subtitle' => 'Verifikasi Mahasiswa - S2 Ilmu Hukum',
			'section' => 'backend/baa/utility/verifikasi',
			// DATA //
			'mahasiswas' => $this->user->read_mhs_verifikasi_by_prodi(S2_ILMU_HUKUM),
		);
		$this->load->view('backend/index_sidebar', $data);
	}

	public function master_mkn() {
		$data = array(
			// PAGE //
			'title' => 'Modul Registrasi',
			'subtitle' => 'Verifikasi Mahasiswa - S2 Kenotariatan',
			'section' => 'backend/baa/utility/verifikasi',
			// DATA //
			'mahasiswas' => $this->user->read_mhs_verifikasi_by_prodi(S2_KENOTARIATAN),
		);
		$this->load->view('backend/index_sidebar', $data);
	}

	public function doktor() {
		$data = array(
			// PAGE //
			'title' => 'Modul Registrasi',
			'subtitle' => 'Verifikasi Mahasiswa - S3',
			'section' => 'backend/baa/utility/verifikasi',
			// DATA //
			'mahasiswas' => $this->user->read_mhs_verifikasi_by_jenjang(JENJANG_S3),
		);
		$this->load->view('backend/index_sidebar', $data);
	}

    public function verifikasi() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_user = $this->input->post('id_user', TRUE);
            $email = $this->input->post('email', TRUE);
            $nama = $this->input->post('nama', TRUE);
			$nim = $this->input->post('nim', TRUE);

            $data = array(
                'verifikasi' => 1,
            );
            $this->user->update_p($data, $id_user);
            // KIRIM EMAIL VERIFIKASI
            $this->email_model->send_verified($email, $nama);
			// Kirim Whatsapp
			$judul_notifikasi = 'Verifikasi Berhasil';
			$isi_notifikasi = 'Akun telah diverifikasi silahkan logout kemudian login kembali';
			$this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 2, $nim);
            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil diverifikasi');
            redirect('baa/utility/registrasi');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/utility/registrasi');
        }
    }

}

?>
