<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpkk extends CI_Controller {

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
            'subtitle' => 'Disertasi - MKPKK',
            'section' => 'backend/mahasiswa/disertasi/mpkk/index',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'disertasi' => $this->disertasi->read_mpkk_mahasiswa($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function info() {
        $id_disertasi = $this->uri->segment('5');
        $data = array(
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Disertasi - MKPKK',
            'section' => 'backend/mahasiswa/disertasi/mpkk/info',
            'use_back' => true,
            'back_link' => 'mahasiswa/disertasi/mpkk',
            // DATA //
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'disertasi' => $this->disertasi->detail($id_disertasi),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $id_disertasi = $this->uri->segment('5');
        $read_aktif = $this->disertasi->read_aktif($this->session_data['username']);

        if ($read_aktif) {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Masih ada judul aktif');
            redirect('mahasiswa/disertasi/mpkk');
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul (Mahasiswa)',
                'subtitle' => 'Pengajuan MKPKK',
                'section' => 'backend/mahasiswa/disertasi/mpkk/add',
                'use_back' => true,
                'back_link' => 'mahasiswa/disertasi/mpkk',
                // DATA //
                'departemen' => $this->departemen->read(),
                'disertasi' => $this->disertasi->detail($id_disertasi),
                'mkpkks' => $this->disertasi->read_mkpkk(),
            );
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $file_name = $this->session_data['username'] . '_berkas_mpkk.pdf';
            $config['upload_path'] = './assets/upload/mahasiswa/disertasi/mpkk';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = MAX_SIZE_FILE_UPLOAD;
            $config['remove_spaces'] = TRUE;
            $config['file_ext_tolower'] = TRUE;
            $config['detect_mime'] = TRUE;
            $config['mod_mime_fix'] = TRUE;
            $config['file_name'] = $file_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('berkas_mpkk')) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', $this->upload->display_errors());
                redirect_back();
            } else {
                $id_disertasi = $this->input->post('id_disertasi', TRUE);
                $id_mkpkks = $this->input->post('id_mkpkk', TRUE);
                $tgl_sekarang = date('Y-m-d');
				if(count($id_mkpkks)==2){
					foreach ($id_mkpkks as $id_mkpkk) {
						$mkpkk = $this->disertasi->detail_mkpkk($id_mkpkk);
						$data = array(
							'id_disertasi' => $id_disertasi,
							'id_mkpkk' => $id_mkpkk,
							'mkpkk' => $mkpkk->nama,
						);

						$this->disertasi->save_disertasi_mkpkk($data);
					}

					$this->disertasi->generate_disertasi_mkpkk_pengampu($id_disertasi);

					$data = array(
						'jenis' => TAHAPAN_DISERTASI_MPKK,
						'berkas_mpkk' => $file_name,
						'status_mpkk' => STATUS_DISERTASI_MPKK_PENGAJUAN,
					);

					$this->disertasi->update($data, $id_disertasi);

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan MKPKK..');
					redirect('mahasiswa/disertasi/mpkk');
				}else{
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Jumlah Mata kuliah yang dipilih harus 2');
					redirect_back();
				}

            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

}

?>
