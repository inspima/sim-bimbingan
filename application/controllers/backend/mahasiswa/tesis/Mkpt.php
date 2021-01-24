<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mkpt extends CI_Controller {

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
        $this->load->model('backend/administrator/master/ruang_model', 'ruang');
        $this->load->model('backend/administrator/master/jam_model', 'jam');
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/transaksi/tesis', 'tesis');
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Tesis - Ujian',
            'section' => 'backend/mahasiswa/tesis/mkpt/index',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'tesis' => $this->tesis->read_ujian_mahasiswa($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function info() {
        $id_tesis = $this->uri->segment('5');
        $data = array(
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Tesis - Ujian',
            'section' => 'backend/mahasiswa/tesis/mkpt/info',
            'use_back' => true,
            'back_link' => 'mahasiswa/tesis/ujian',
            // DATA //
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'jadwal' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'tesis' => $this->tesis->detail($id_tesis),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $id_tesis = $this->uri->segment('5');
        $read_aktif = $this->tesis->read_aktif($this->session_data['username']);

        if ($read_aktif) {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Masih ada judul aktif');
            redirect('mahasiswa/tesis/ujian');
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul (Mahasiswa)',
                'subtitle' => 'Pengajuan Tesis',
                'section' => 'backend/mahasiswa/tesis/mkpt/add',
                'use_back' => true,
                'back_link' => 'mahasiswa/tesis/ujian',
                // DATA //
                'departemen' => $this->departemen->read(),
                'tesis' => $this->tesis->detail($id_tesis),
            );
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {

            if($_FILES['berkas_tesis']['size'] != 0){
                $file_name = $this->session_data['username'] . '_berkas_tesis.pdf';
                $config['upload_path'] = './assets/upload/mahasiswa/tesis/ujian';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = MAX_SIZE_FILE_UPLOAD;
                $config['remove_spaces'] = TRUE;
                $config['file_ext_tolower'] = TRUE;
                $config['detect_mime'] = TRUE;
                $config['mod_mime_fix'] = TRUE;
                $config['file_name'] = $file_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
            }

            if($_FILES['berkas_syarat_tesis']['size'] != 0){
                $file_name_syarat = $this->session_data['username'] . '_berkas_syarat_tesis.pdf';
                $config['upload_path'] = './assets/upload/mahasiswa/tesis/ujian';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = MAX_SIZE_FILE_UPLOAD;
                $config['remove_spaces'] = TRUE;
                $config['file_ext_tolower'] = TRUE;
                $config['detect_mime'] = TRUE;
                $config['mod_mime_fix'] = TRUE;
                $config['file_name'] = $file_name_syarat;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
            }

            if (!$this->upload->do_upload('berkas_tesis')) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', $this->upload->display_errors());
                redirect_back();
            }
            else if (!$this->upload->do_upload('berkas_syarat_tesis')) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', $this->upload->display_errors());
                redirect_back();
            } 
            else {
                $id_tesis = $this->input->post('id_tesis', TRUE);
                $tgl_sekarang = date('Y-m-d');
                $data = array(
                    'jenis' => TAHAPAN_TESIS_UJIAN,
                    'berkas_tesis' => $file_name,
                    'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    'berkas_syarat_tesis' => $file_name_syarat,
                );

                $this->tesis->update($data, $id_tesis);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan Tesis..');
                redirect('mahasiswa/tesis/ujian');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

    public function edit() {
        $id = $this->uri->segment(5);
        $username = $this->session_data['username'];

        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Pengajuan Ujian Tesis',
            'section' => 'backend/mahasiswa/tesis/mkpt/edit',
            // DATA //
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'departemen' => $this->departemen->read(),
            'gelombang' => $this->gelombang->read_berjalan(),
            'tesis' => $this->tesis->detail($id),
        );

        if ($data['tesis']) {
            $this->load->view('backend/index_sidebar', $data);
        } else {
            $data['section'] = 'backend/notification/danger';
            $data['msg'] = 'Tidak ditemukan';
            $data['linkback'] = 'mahasiswa/tesis/ujian';
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function update() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);

            $read_judul = $this->tesis->read_judul($id_tesis);
            $judul = $this->input->post('judul', TRUE);
            $tgl_sekarang = date('Y-m-d');

            if($_FILES['berkas_tesis']['size'] != 0){
                $file_name = $this->session_data['username'] . '_berkas_tesis.pdf';
                $config['upload_path'] = './assets/upload/mahasiswa/tesis/ujian';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = MAX_SIZE_FILE_UPLOAD;
                $config['remove_spaces'] = TRUE;
                $config['file_ext_tolower'] = TRUE;
                $config['detect_mime'] = TRUE;
                $config['mod_mime_fix'] = TRUE;
                $config['file_name'] = $file_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
            }

            if($_FILES['berkas_syarat_tesis']['size'] != 0) {
                $file_name_syarat = $this->session_data['username'] . '_berkas_syarat_tesis.pdf';
                $config['upload_path'] = './assets/upload/mahasiswa/tesis/ujian';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = MAX_SIZE_FILE_UPLOAD;
                $config['remove_spaces'] = TRUE;
                $config['file_ext_tolower'] = TRUE;
                $config['detect_mime'] = TRUE;
                $config['mod_mime_fix'] = TRUE;
                $config['file_name'] = $file_name_syarat;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
            }

            $tgl_sekarang = date('Y-m-d');

            if ($judul == $read_judul->judul) {
                if($_FILES['berkas_tesis']['size'] != 0 && $_FILES['berkas_syarat_tesis']['size'] != 0){
                    $data = array(
                        'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                        'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                        'jenis' => TAHAPAN_TESIS_UJIAN,
                        'berkas_tesis' => $file_name,
                        'berkas_syarat_tesis' => $file_name_syarat,
                        'nim' => $this->session_data['username'],
                        'tgl_pengajuan' => $tgl_sekarang,
                        'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }
                else if($_FILES['berkas_tesis']['size'] != 0 && $_FILES['berkas_syarat_tesis']['size'] == 0){

                    $data = array(
                        'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                        'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                        'jenis' => TAHAPAN_TESIS_UJIAN,
                        'berkas_tesis' => $file_name,
                        'nim' => $this->session_data['username'],
                        'tgl_pengajuan' => $tgl_sekarang,
                        'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }
                else if($_FILES['berkas_tesis']['size'] == 0 && $_FILES['berkas_syarat_tesis']['size'] != 0){
                    $data = array(
                        'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                        'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                        'jenis' => TAHAPAN_TESIS_UJIAN,
                        'berkas_syarat_tesis' => $file_name_syarat,
                        'nim' => $this->session_data['username'],
                        'tgl_pengajuan' => $tgl_sekarang,
                        'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }
                else {
                    $data = array(
                        'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                        'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                        'jenis' => TAHAPAN_TESIS_UJIAN,
                        'nim' => $this->session_data['username'],
                        'tgl_pengajuan' => $tgl_sekarang,
                        'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('mahasiswa/tesis/ujian');
            } else {
                if($_FILES['berkas_tesis']['size'] != 0 && $_FILES['berkas_syarat_tesis']['size'] != 0){
                    $data = array(
                        'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                        'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                        'jenis' => TAHAPAN_TESIS_UJIAN,
                        'berkas_tesis' => $file_name,
                        'berkas_syarat_tesis' => $file_name_syarat,
                        'nim' => $this->session_data['username'],
                        'tgl_pengajuan' => $tgl_sekarang,
                        'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }
                else if($_FILES['berkas_tesis']['size'] != 0 && $_FILES['berkas_syarat_tesis']['size'] == 0){
                    $data = array(
                        'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                        'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                        'jenis' => TAHAPAN_TESIS_UJIAN,
                        'berkas_tesis' => $file_name,
                        'nim' => $this->session_data['username'],
                        'tgl_pengajuan' => $tgl_sekarang,
                        'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }
                else if($_FILES['berkas_tesis']['size'] == 0 && $_FILES['berkas_syarat_tesis']['size'] != 0){
                    $data = array(
                        'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                        'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                        'jenis' => TAHAPAN_TESIS_UJIAN,
                        'berkas_syarat_tesis' => $file_name_syarat,
                        'nim' => $this->session_data['username'],
                        'tgl_pengajuan' => $tgl_sekarang,
                        'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }
                else {
                    $data = array(
                        'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                        'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                        'jenis' => TAHAPAN_TESIS_UJIAN,
                        'nim' => $this->session_data['username'],
                        'tgl_pengajuan' => $tgl_sekarang,
                        'status_tesis' => STATUS_TESIS_UJIAN_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }

                $dataj = array(
                    'id_tesis' => $id_tesis,
                    'judul' => $this->input->post('judul', TRUE)
                );

                $this->tesis->update_judul($dataj, $id_tesis);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('mahasiswa/tesis/ujian');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('mahasiswa/tesis/ujian');
        }
    }

    public function jadwal() {
        $id_tesis = $this->uri->segment('5');
        $data = array(
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Tesis - Ujian',
            'section' => 'backend/mahasiswa/tesis/mkpt/jadwal',
            'use_back' => true,
            'back_link' => 'mahasiswa/tesis/ujian',
            // DATA //            
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_UJIAN),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function jadwal_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN);

            if (!empty($ujian)) { // JIKA SUDAH ADA
                //echo 'jadwal sudah ada. tambah script update';  die();
                $id_ujian = $this->input->post('id_ujian');

                $data = array(
                    'id_tesis' => $id_tesis,
                    'id_ruang' => $this->input->post('id_ruang', TRUE),
                    'id_jam' => $this->input->post('id_jam', TRUE),
                    'tanggal' => todb($this->input->post('tanggal', TRUE)),
                    'status' => 1,
                    'status_ujian' => 1
                );

                $cek_jadwal = $this->tesis->cek_ruang_terpakai($data);

                if ($cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('mahasiswa/tesis/mkpt/jadwal/' . $id_tesis);
                } else {
                    $penguji = $this->tesis->read_penguji($id_ujian);

                    if ($penguji) {
                        foreach ($penguji as $list) {
                            $bentrok = $this->tesis->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
                            break;
                        }

                        if ($bentrok) {

                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal Ubah Usulan Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
                            redirect('mahasiswa/tesis/mkpt/jadwal/' . $id_tesis);
                        } else {
                            $this->tesis->update_ujian($data, $id_ujian);

                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Usulan Jadwal.');
                            redirect('mahasiswa/tesis/mkpt/jadwal/' . $id_tesis);
                        }
                    } else { //langsung update
                        $this->tesis->update_ujian($data, $id_ujian);

                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Ubah Usulan Jadwal.');
                        redirect('mahasiswa/tesis/mkpt/jadwal/' . $id_tesis);
                    }
                }
            } else { //JIKA BELUM ADA SAVE BARU
                $data = array(
                    'id_tesis' => $id_tesis,
                    'id_ruang' => $this->input->post('id_ruang', TRUE),
                    'id_jam' => $this->input->post('id_jam', TRUE),
                    'tanggal' => todb($this->input->post('tanggal', TRUE)),
                    'jenis_ujian' => UJIAN_TESIS_UJIAN,
                    'status' => 1,
                    'status_ujian' => 1
                );

                $cek_jadwal = $this->tesis->cek_ruang_terpakai($data);

                if ($cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('mahasiswa/tesis/mkpt/jadwal/' . $id_tesis);
                } else {
                    /*$update_proposal = array(
                        'status_proposal' => STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS,
                    );*/
                    $this->tesis->save_ujian($data);
                    //$this->tesis->update($update_proposal, $id_tesis);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil Mengajukan Jadwal.');
                    redirect('mahasiswa/tesis/mkpt/jadwal/' . $id_tesis);
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('mahasiswa/tesis/mkpt/');
        }
    }

}

?>