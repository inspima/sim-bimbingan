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
        $this->load->model('backend/administrator/master/minat_tesis_model', 'minat_tesis');
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
            'subtitle' => 'Tesis - MKPT',
            'section' => 'backend/mahasiswa/tesis/mkpt/index',
            // DATA //
            //'mahasiswa'      => $this->mahasiswa->read_aktif($this->session_data['username']),
            'tesis' => $this->tesis->read_mkpt_mahasiswa($this->session_data['username'])
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
            'back_link' => 'mahasiswa/tesis/mkpt',
            // DATA //
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'jadwal' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_MKPT),
            'tesis' => $this->tesis->detail($id_tesis),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_MKPT),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function add() {
        $id_tesis = $this->uri->segment('5');
        $read_aktif = $this->tesis->read_aktif_mkpt($this->session_data['username']);

        if (!$read_aktif) {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Masih ada judul aktif');
            redirect('mahasiswa/tesis/mkpt');
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul (Mahasiswa)',
                'subtitle' => 'Pengajuan MKPT',
                'section' => 'backend/mahasiswa/tesis/mkpt/add',
                'use_back' => true,
                'back_link' => 'mahasiswa/tesis/mkpt',
                // DATA //
                'mdosen' => $this->dosen->read_aktif_alldep(),
                'departemen' => $this->departemen->read(),
                'gelombang' => $this->gelombang->read_berjalan(),
                'tesis' => $this->tesis->detail($id_tesis),
            );
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {

            if($_FILES['berkas_mkpt']['size'] != 0){
                $file_name = $this->session_data['username'] . '_berkas_mkpt.pdf';
                $config['upload_path'] = './assets/upload/mahasiswa/tesis/mkpt';
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

            if (!$this->upload->do_upload('berkas_mkpt')) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', $this->upload->display_errors());
                redirect_back();
            }
            else {
                $id_tesis = $this->input->post('id_tesis', TRUE);
                $read_judul = $this->tesis->read_judul($id_tesis, TAHAPAN_TESIS_PROPOSAL);
                $tgl_sekarang = date('Y-m-d');

                $tesis_mkpts = $this->tesis->read_tesis_mkpt($id_tesis);

                if (!empty($tesis_mkpts)) {
                    foreach ($tesis_mkpts as $index => $mkpt) {
                        //$kode = $this->input->post('kode' . $mkpt['id_tesis_mkpt'], true);
                        $nama = $this->input->post('nama' . $mkpt['id_tesis_mkpt'], true);
                        $sks = $this->input->post('sks' . $mkpt['id_tesis_mkpt'], true);
                        //$dosens = $this->input->post('pengampu' . $mkpt['id_tesis_mkpt'], true);
                        $data_tesis_mkpt = [
                            'id_tesis' => $id_tesis,
                            //'kode' => $kode,
                            'mkpt' => $nama,
                            'sks' => $sks,
                        ];
                        if (!empty($nama)) {
                            $this->tesis->update_tesis_mkpt($data_tesis_mkpt, $mkpt['id_tesis_mkpt']);
                            $tesis_mkpt = $this->tesis->detail_tesis_mkpt_by_data($data_tesis_mkpt);
                            /*$mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                            foreach($dosens as $dosen){
                                foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                                    $data_pengampu = [
                                        'id_tesis' => $id_tesis,
                                        'id_tesis_mkpt' => $tesis_mkpt->id_tesis_mkpt,
                                        'nip' => $dosen,
                                    ];
                                    if($pengampu['nip'] == $dosen){
                                        $this->tesis->update_tesis_mkpt_pengampu($data_pengampu, $pengampu['id_tesis_mkpt_pengampu']);
                                    }
                                    else {
                                        $this->tesis->save_tesis_mkpt_pengampu($data_pengampu);
                                    }
                                }
                            }*/
                        }
                    }
                }
                else {
                    for ($i = 1; $i <= 3; $i++) {
                        //$kode = $this->input->post('kode' . $i, true);
                        $nama = $this->input->post('nama' . $i, true);
                        $sks = $this->input->post('sks' . $i, true);
                        //$dosens = $this->input->post('pengampu' . $i, true);
                        $data_tesis_mkpt = [
                            'id_tesis' => $id_tesis,
                            //'kode' => $kode,
                            'mkpt' => $nama,
                            'sks' => $sks,
                        ];
                        if (!empty($nama)) {
                            $this->tesis->save_tesis_mkpt($data_tesis_mkpt);
                            $tesis_mkpt = $this->tesis->detail_tesis_mkpt_by_data($data_tesis_mkpt);
                            /*foreach($dosens as $dosen){
                                $data_pengampu = [
                                    'id_tesis' => $id_tesis,
                                    'id_tesis_mkpt' => $tesis_mkpt->id_tesis_mkpt,
                                    'nip' => $dosen,
                                ];
                                $this->tesis->save_tesis_mkpt_pengampu($data_pengampu);
                            }*/
                        }
                    }
                }
                
                $data = array(
                    'jenis' => TAHAPAN_TESIS_MKPT,
                    'berkas_mkpt' => $file_name,
                    'status_mkpt' => STATUS_TESIS_MKPT_PENGAJUAN,
                );

                $this->tesis->update($data, $id_tesis);

                $dataj = array(
                    'id_tesis' => $id_tesis,
                    'judul' => $read_judul->judul,
                    'latar_belakang' => $read_judul->latar_belakang,
                    'rumusan_masalah_pertama' => $read_judul->rumusan_masalah_pertama,
                    'rumusan_masalah_kedua' => $read_judul->rumusan_masalah_kedua,
                    'rumusan_masalah_lain' => $read_judul->rumusan_masalah_lain,
                    'penelusuran_artikel_internet' => $read_judul->penelusuran_artikel_internet,
                    'penelusuran_artikel_unair' => $read_judul->penelusuran_artikel_unair,
                    'uraian_topik' => $read_judul->uraian_topik,
                    'jenis' => TAHAPAN_TESIS_MKPT,
                );

                $this->tesis->save_judul($dataj);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan MKPT..');
                redirect('mahasiswa/tesis/mkpt');
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
            'subtitle' => 'Pengajuan MKPT',
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
            $data['linkback'] = 'mahasiswa/tesis/mkpt';
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function update() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);

            $read_judul = $this->tesis->read_judul($id_tesis, TAHAPAN_TESIS_MKPT);
            //$judul = $this->input->post('judul', TRUE);
            $tgl_sekarang = date('Y-m-d');

            if($_FILES['berkas_mkpt']['size'] != 0){
                $file_name = $this->session_data['username'] . '_berkas_mkpt.pdf';
                $config['upload_path'] = './assets/upload/mahasiswa/tesis/mkpt';
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

            if ($judul == $read_judul->judul) {
                if($_FILES['berkas_mkpt']['size'] != 0){

                    $tesis_mkpts = $this->tesis->read_tesis_mkpt($id_tesis);

                    if (!empty($tesis_mkpts)) {
                        foreach ($tesis_mkpts as $index => $mkpt) {
                            //$kode = $this->input->post('kode' . $mkpt['id_tesis_mkpt'], true);
                            $nama = $this->input->post('nama' . $mkpt['id_tesis_mkpt'], true);
                            $sks = $this->input->post('sks' . $mkpt['id_tesis_mkpt'], true);
                            //$dosens = $this->input->post('pengampu' . $mkpt['id_tesis_mkpt'], true);
                            $data_tesis_mkpt = [
                                'id_tesis' => $id_tesis,
                                //'kode' => $kode,
                                'mkpt' => $nama,
                                'sks' => $sks,
                            ];
                            if (!empty($nama)) {
                                $this->tesis->update_tesis_mkpt($data_tesis_mkpt, $mkpt['id_tesis_mkpt']);
                                $tesis_mkpt = $this->tesis->detail_tesis_mkpt_by_data($data_tesis_mkpt);
                                /*$mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                                foreach($dosens as $dosen){
                                    foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                                        $data_pengampu = [
                                            'id_tesis' => $id_tesis,
                                            'id_tesis_mkpt' => $tesis_mkpt->id_tesis_mkpt,
                                            'nip' => $dosen,
                                        ];
                                        if($pengampu['nip'] == $dosen){
                                            $this->tesis->update_tesis_mkpt_pengampu($data_pengampu, $pengampu['id_tesis_mkpt_pengampu']);
                                        }
                                        else {
                                            $this->tesis->save_tesis_mkpt_pengampu($data_pengampu);
                                        }
                                    }
                                }*/
                            }
                        }
                    }
                    else {
                        for ($i = 1; $i <= 3; $i++) {
                            //$kode = $this->input->post('kode' . $i, true);
                            $nama = $this->input->post('nama' . $i, true);
                            $sks = $this->input->post('sks' . $i, true);
                            //$dosens = $this->input->post('pengampu' . $i, true);
                            $data_tesis_mkpt = [
                                'id_tesis' => $id_tesis,
                                //'kode' => $kode,
                                'mkpt' => $nama,
                                'sks' => $sks,
                            ];
                            if (!empty($nama)) {
                                $this->tesis->save_tesis_mkpt($data_tesis_mkpt);
                                $tesis_mkpt = $this->tesis->detail_tesis_mkpt_by_data($data_tesis_mkpt);
                                /*foreach($dosens as $dosen){
                                    $data_pengampu = [
                                        'id_tesis' => $id_tesis,
                                        'id_tesis_mkpt' => $tesis_mkpt->id_tesis_mkpt,
                                        'nip' => $dosen,
                                    ];
                                    $this->tesis->save_tesis_mkpt_pengampu($data_pengampu);
                                }*/
                            }
                        }
                    }
                
                    $data = array(
                        'jenis' => TAHAPAN_TESIS_MKPT,
                        'berkas_mkpt' => $file_name,
                        'status_mkpt' => STATUS_TESIS_MKPT_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('mahasiswa/tesis/mkpt');
            } else {
                if($_FILES['berkas_mkpt']['size'] != 0){

                    $tesis_mkpts = $this->tesis->read_tesis_mkpt($id_tesis);

                    if (!empty($tesis_mkpts)) {
                        foreach ($tesis_mkpts as $index => $mkpt) {
                            //$kode = $this->input->post('kode' . $mkpt['id_tesis_mkpt'], true);
                            $nama = $this->input->post('nama' . $mkpt['id_tesis_mkpt'], true);
                            $sks = $this->input->post('sks' . $mkpt['id_tesis_mkpt'], true);
                            //$dosens = $this->input->post('pengampu' . $mkpt['id_tesis_mkpt'], true);
                            $data_tesis_mkpt = [
                                'id_tesis' => $id_tesis,
                                //'kode' => $kode,
                                'mkpt' => $nama,
                                'sks' => $sks,
                            ];
                            if (!empty($nama)) {
                                $this->tesis->update_tesis_mkpt($data_tesis_mkpt, $mkpt['id_tesis_mkpt']);
                                $tesis_mkpt = $this->tesis->detail_tesis_mkpt_by_data($data_tesis_mkpt);
                                /*$mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                                foreach($dosens as $dosen){
                                    foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                                        $data_pengampu = [
                                            'id_tesis' => $id_tesis,
                                            'id_tesis_mkpt' => $tesis_mkpt->id_tesis_mkpt,
                                            'nip' => $dosen,
                                        ];
                                        if($pengampu['nip'] == $dosen){
                                            $this->tesis->update_tesis_mkpt_pengampu($data_pengampu, $pengampu['id_tesis_mkpt_pengampu']);
                                        }
                                        else {
                                            $this->tesis->save_tesis_mkpt_pengampu($data_pengampu);
                                        }
                                    }
                                }*/
                            }
                        }
                    }
                    else {
                        for ($i = 1; $i <= 3; $i++) {
                            //$kode = $this->input->post('kode' . $i, true);
                            $nama = $this->input->post('nama' . $i, true);
                            $sks = $this->input->post('sks' . $i, true);
                            //$dosens = $this->input->post('pengampu' . $i, true);
                            $data_tesis_mkpt = [
                                'id_tesis' => $id_tesis,
                                //'kode' => $kode,
                                'mkpt' => $nama,
                                'sks' => $sks,
                            ];
                            if (!empty($nama)) {
                                $this->tesis->save_tesis_mkpt($data_tesis_mkpt);
                                $tesis_mkpt = $this->tesis->detail_tesis_mkpt_by_data($data_tesis_mkpt);
                                /*foreach($dosens as $dosen){
                                    $data_pengampu = [
                                        'id_tesis' => $id_tesis,
                                        'id_tesis_mkpt' => $tesis_mkpt->id_tesis_mkpt,
                                        'nip' => $dosen,
                                    ];
                                    $this->tesis->save_tesis_mkpt_pengampu($data_pengampu);
                                }*/
                            }
                        }
                    }

                    $data = array(
                        'jenis' => TAHAPAN_TESIS_MKPT,
                        'berkas_mkpt' => $file_name,
                        'status_mkpt' => STATUS_TESIS_MKPT_PENGAJUAN,
                    );
                    $this->tesis->update($data, $id_tesis);
                }

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('mahasiswa/tesis/mkpt');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('mahasiswa/tesis/mkpt');
        }
    }

    public function jadwal() {
        $id_tesis = $this->uri->segment('5');
        $data = array(
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Tesis - Ujian',
            'section' => 'backend/mahasiswa/tesis/mkpt/jadwal',
            'use_back' => true,
            'back_link' => 'mahasiswa/tesis/mkpt',
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