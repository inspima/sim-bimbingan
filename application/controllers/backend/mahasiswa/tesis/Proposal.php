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
        $this->load->model('backend/mahasiswa/master/biodata_model', 'biodata');
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
            'subtitle' => 'Tesis - Proposal',
            'section' => 'backend/mahasiswa/tesis/proposal/index',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'biodata' => $this->biodata->detail($this->session_data['username']),
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
            'jadwal' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_PROPOSAL),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $id = $this->uri->segment(5);
        $username = $this->session_data['username'];

        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Pengajuan Ujian Proposal',
            'section' => 'backend/mahasiswa/tesis/proposal/add',
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
            $data['linkback'] = 'mahasiswa/tesis/proposal';
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $judul = $this->input->post('judul', TRUE);
            $read_judul = $this->tesis->read_judul($id_tesis, TAHAPAN_TESIS_JUDUL);

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
                redirect('mahasiswa/tesis/judul');
            } else {
                $data = array(
                    'jenis' => TAHAPAN_TESIS_PROPOSAL,
                    'tgl_pengajuan_proposal' => $tgl_sekarang,
                    'berkas_proposal' => $file_name,
                    'status_proposal' => STATUS_TESIS_PROPOSAL_PENGAJUAN,
                );
                $this->tesis->update($data, $id_tesis);

                $dataj = array(
                    'id_tesis' => $id_tesis,
                    //'judul' => $read_judul->judul,
                    'judul' => $judul,
                    'latar_belakang' => $read_judul->latar_belakang,
                    'rumusan_masalah_pertama' => $read_judul->rumusan_masalah_pertama,
                    'rumusan_masalah_kedua' => $read_judul->rumusan_masalah_kedua,
                    'rumusan_masalah_lain' => $read_judul->rumusan_masalah_lain,
                    'penelusuran_artikel_internet' => $read_judul->penelusuran_artikel_internet,
                    'penelusuran_artikel_unair' => $read_judul->penelusuran_artikel_unair,
                    'uraian_topik' => $read_judul->uraian_topik,
                    'jenis' => TAHAPAN_TESIS_PROPOSAL,
                );

                $this->tesis->save_judul($dataj);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan ujian proposal..');
                redirect('mahasiswa/tesis/proposal');
            }

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil update');
            redirect('mahasiswa/tesis/proposal');

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
            'subtitle' => 'Pengajuan Ujian Proposal',
            'section' => 'backend/mahasiswa/tesis/proposal/edit',
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
            $data['linkback'] = 'mahasiswa/tesis/proposal';
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

            if ($judul == $read_judul->judul) {
                if($_FILES['berkas_proposal']['size'] != 0){
                    unlink('./assets/upload/mahasiswa/tesis/proposal/'.$file_name);
                    if ($this->upload->do_upload('berkas_proposal')) {
                        $data = array(
                            'tgl_pengajuan_proposal' => $tgl_sekarang,
                            'berkas_proposal' => $file_name,
                        );
                        $this->tesis->update($data, $id_tesis);
                    }
                    else {
                        echo "Error Upload"; die;
                    }
                }

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('mahasiswa/tesis/proposal');
            } else {
                if($_FILES['berkas_proposal']['size'] != 0){
                    unlink('./assets/upload/mahasiswa/tesis/proposal/'.$file_name);
                    if ($this->upload->do_upload('berkas_proposal')) {
                        $data = array(
                            'tgl_pengajuan_proposal' => $tgl_sekarang,
                            'berkas_proposal' => $file_name,
                        );
                        $this->tesis->update($data, $id_tesis);
                    }
                    else {
                        echo "Error Upload"; die;
                    }
                }

                $dataj = array(
                    'id_tesis' => $id_tesis,
                    'judul' => $this->input->post('judul', TRUE),
                    'latar_belakang' => $this->input->post('latar_belakang', TRUE),
                    'rumusan_masalah_pertama' => $this->input->post('rumusan_masalah_pertama', TRUE),
                    'rumusan_masalah_kedua' => $this->input->post('rumusan_masalah_kedua', TRUE),
                    'rumusan_masalah_lain' => $this->input->post('rumusan_masalah_lain', TRUE),
                    'penelusuran_artikel_internet' => $this->input->post('penelusuran_artikel_internet', TRUE),
                    'penelusuran_artikel_unair' => $this->input->post('penelusuran_artikel_unair', TRUE),
                    'uraian_topik' => $this->input->post('uraian_topik', TRUE),
                    'jenis' => TAHAPAN_TESIS_PROPOSAL,
                );

                $this->tesis->update_judul($dataj, $id_tesis, TAHAPAN_TESIS_PROPOSAL);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('mahasiswa/tesis/proposal');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('mahasiswa/tesis/proposal');
        }
    }

    public function jadwal() {
        $id_tesis = $this->uri->segment('5');
        $data = array(
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Tesis - Proposal',
            'section' => 'backend/mahasiswa/tesis/proposal/jadwal',
            'use_back' => true,
            'back_link' => 'mahasiswa/tesis/proposal',
            // DATA //            
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL),
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_PROPOSAL),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function jadwal_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);

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
                    redirect('mahasiswa/tesis/proposal/jadwal/' . $id_tesis);
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
                            redirect('mahasiswa/tesis/proposal/jadwal/' . $id_tesis);
                        } else {
                            $this->tesis->update_ujian($data, $id_ujian);

                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Usulan Jadwal.');
                            redirect('mahasiswa/tesis/proposal/jadwal/' . $id_tesis);
                        }
                    } else { //langsung update
                        $this->tesis->update_ujian($data, $id_ujian);

                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Ubah Usulan Jadwal.');
                        redirect('mahasiswa/tesis/proposal/jadwal/' . $id_tesis);
                    }
                }
            } else { //JIKA BELUM ADA SAVE BARU
                $data = array(
                    'id_tesis' => $id_tesis,
                    'id_ruang' => $this->input->post('id_ruang', TRUE),
                    'id_jam' => $this->input->post('id_jam', TRUE),
                    'tanggal' => todb($this->input->post('tanggal', TRUE)),
                    'jenis_ujian' => UJIAN_TESIS_PROPOSAL,
                    'status' => 1,
                    'status_ujian' => 1
                );

                $cek_jadwal = $this->tesis->cek_ruang_terpakai($data);

                if ($cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('mahasiswa/tesis/proposal/jadwal/' . $id_tesis);
                } else {
                    /*$update_proposal = array(
                        'status_proposal' => STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS,
                    );*/
                    $this->tesis->save_ujian($data);
                    //$this->tesis->update($update_proposal, $id_tesis);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil Mengajukan Jadwal.');
                    redirect('mahasiswa/tesis/proposal/jadwal/' . $id_tesis);
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('mahasiswa/tesis/proposal/');
        }
    }

}

?>