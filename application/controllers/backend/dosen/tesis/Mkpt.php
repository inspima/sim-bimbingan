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
            if ($this->session_data['sebagai'] != 1 AND $this->session_data['role'] != 0) {
                redirect('logout', 'refresh');
            }
        }
        //END SESS
        //START MODEL
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/administrator/master/departemen_model', 'departemen');
        $this->load->model('backend/administrator/master/minat_tesis_model', 'minat_tesis');
        $this->load->model('backend/administrator/master/ruang_model', 'ruang');
        $this->load->model('backend/administrator/master/jam_model', 'jam');
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/transaksi/tesis', 'tesis');
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    // KPS / PENASEHAT AKADEMIK

    public function pengampu() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - MKPT',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/mkpt/pengampu',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),

            'tesis_mkpt' => $this->tesis->read_tesis_mkpt_pengampu_prodi($this->session_data['username'], $id),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting_pengampu()
    {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            // PAGE //
            'title' => 'Tesis - MKPT',
            'subtitle' => 'Pengajuan MKPT',
            'section' => 'backend/dosen/tesis/mkpt/setting_pengampu',
            'use_back' => true,
            'id_prodi' => $id_prodi,
            'back_link' => 'dosen/tesis/permintaan/pembimbing/'.$id_prodi,
            'mdosen' => $this->dosen->read_aktif_alldep(),
            // DATA //
            'gelombang' => $this->gelombang->read_berjalan(),
            'departemen' => $this->departemen->read(),
            'minat' => $this->minat_tesis->read(),
            'tesis' => $this->tesis->detail($id_tesis),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_MKPT),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function save()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $id_prodi = $this->tesis->cek_prodi($id_tesis);
            $tgl_sekarang = date('Y-m-d');
            $tesis_mkpts = $this->tesis->read_tesis_mkpt($id_tesis);
            if (!empty($tesis_mkpts)) {
                foreach ($tesis_mkpts as $index => $mkpt) {
                    //$kode = $this->input->post('kode' . $mkpt['id_tesis_mkpt'], true);
                    $nama = $this->input->post('nama' . $mkpt['id_tesis_mkpt'], true);
                    $sks = $this->input->post('sks' . $mkpt['id_tesis_mkpt'], true);
                    $dosen = $this->input->post('pengampu' . $mkpt['id_tesis_mkpt'], true);
                    $data_tesis_mkpt = [
                        'id_tesis' => $id_tesis,
                        //'kode' => $kode,
                        'mkpt' => $nama,
                        'sks' => $sks,
                    ];
                    if (!empty($nama)) {
                        $this->tesis->update_tesis_mkpt($data_tesis_mkpt, $mkpt['id_tesis_mkpt']);
                        $tesis_mkpt = $this->tesis->detail_tesis_mkpt_by_data($data_tesis_mkpt);
                        $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                        //foreach($dosens as $dosen){
                        if(!empty($mkpt_pengampus)){
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
                        }
                        else {
                            $data_pengampu = [
                                'id_tesis' => $id_tesis,
                                'id_tesis_mkpt' => $tesis_mkpt->id_tesis_mkpt,
                                'nip' => $dosen,
                            ];

                            $this->tesis->save_tesis_mkpt_pengampu($data_pengampu);
                        }
                        //}
                    }
                }
            }
            else {
                for ($i = 1; $i <= 3; $i++) {
                    //$kode = $this->input->post('kode' . $i, true);
                    $nama = $this->input->post('nama' . $i, true);
                    $sks = $this->input->post('sks' . $i, true);
                    $dosens = $this->input->post('pengampu' . $i, true);
                    $data_tesis_mkpt = [
                        'id_tesis' => $id_tesis,
                        //'kode' => $kode,
                        'mkpt' => $nama,
                        'sks' => $sks,
                    ];
                    if (!empty($nama)) {
                        $this->tesis->save_tesis_mkpt($data_tesis_mkpt);
                        $tesis_mkpt = $this->tesis->detail_tesis_mkpt_by_data($data_tesis_mkpt);
                        foreach($dosens as $dosen){
                            $data_pengampu = [
                                'id_tesis' => $id_tesis,
                                'id_tesis_mkpt' => $tesis_mkpt->id_tesis_mkpt,
                                'nip' => $dosen,
                            ];
                            $this->tesis->save_tesis_mkpt_pengampu($data_pengampu);
                        }
                    }
                }
            }

            $tgl_sekarang = date('Y-m-d');
            $data = array(
                'jenis' => TAHAPAN_TESIS_MKPT,
                'status_mkpt' => STATUS_TESIS_MKPT_PENGAJUAN,
            );

            $this->tesis->update($data, $id_tesis);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan MKPT..');
            redirect('dosen/tesis/mkpt/setting_pengampu/'.$id_tesis);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

    public function nilai() {
        $id_tesis = $this->uri->segment('6');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_tesis_mkpt_pengampu = $this->uri->segment('5');
        $data = array(
            // PAGE //
            'title' => 'Tesis - Ujian',
            'subtitle' => 'Nilai Penguji',
            'section' => 'backend/dosen/tesis/mkpt/nilai',
            'use_back' => true,
            'back_link' => 'dosen/tesis/mkpt/pengampu/'.$id_prodi,
            'gelombang' => $this->gelombang->read_berjalan(),
            // DATA //
            'id_prodi' => $id_prodi,
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_MKPT),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_MKPT),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function nilai_save()
    {
        $hand = $this->input->post('hand', true);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', true);
            $id_prodi = $this->tesis->cek_prodi($id_tesis);
            $tgl_sekarang = date('Y-m-d');
            $tesis_mkpts = $this->tesis->read_tesis_mkpt($id_tesis);
            $id_tesis_mkpt_pengampu = '';
            if (!empty($tesis_mkpts)) {
                foreach ($tesis_mkpts as $index => $mkpt) {
                    $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                    foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                        if($pengampu['status'] == '1' && $pengampu['nip'] == $this->session_data['username']){
                            $id_tesis_mkpt_pengampu = $pengampu['id_tesis_mkpt_pengampu'];
                            $nilai_angka = str_replace(',', '.', $this->input->post('nilai_angka' . $mkpt['id_tesis_mkpt'], true));
                            $data_tesis_mkpt = [
                                'nilai_angka' => $nilai_angka,
                                'nilai_publish' => $nilai_angka,
                            ];

                            $this->tesis->update_tesis_mkpt($data_tesis_mkpt, $mkpt['id_tesis_mkpt']);
                                                
                            $data_pengampu = [
                                'nilai_angka' => $nilai_angka,
                            ];
                            
                            $this->tesis->update_tesis_mkpt_pengampu($data_pengampu, $pengampu['id_tesis_mkpt_pengampu']);
                        }
                        
                    }
                    
                }
            }

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Anda telah melakukan pengajuan MKPT..');
            redirect('dosen/tesis/mkpt/nilai/'.$id_tesis_mkpt_pengampu.'/'.$id_tesis);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

    public function approve_pengampu() {
        $id_tesis_mkpt_pengampu = $this->uri->segment(5);
        $id = $this->uri->segment(6);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->approval_pengampu_mkpt($id_tesis_mkpt_pengampu);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Status Pengampu MKPT disetujui');
        redirect('dosen/tesis/mkpt/pengampu/'.$id_prodi);
    }

    public function reject_pengampu() {
    	$id_tesis_mkpt_pengampu = $this->uri->segment(5);
        $id = $this->uri->segment(6);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->reject_pengampu_mkpt($id_tesis_mkpt_pengampu);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Pengampu MKPT ditolak');
        redirect('dosen/tesis/mkpt/pengampu/'.$id_prodi);
    }

    public function batal_pengampu() {
    	$id_tesis_mkpt_pengampu = $this->uri->segment(5);
        $id = $this->uri->segment(6);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_pengampu_mkpt($id_tesis_mkpt_pengampu);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Pengampu MKPT dibatalkan');
        redirect('dosen/tesis/mkpt/pengampu/'.$id_prodi);
    }

    public function publish_nilai() {
        $id_tesis_mkpt_pengampu = $this->uri->segment(5);
        $id = $this->uri->segment(6);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->publish_nilai_mkpt($id_tesis_mkpt_pengampu);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Status Nilai MKPT dipublish');
        redirect('dosen/tesis/mkpt/nilai/'.$id_tesis_mkpt_pengampu.'/'.$id);
    }

    public function batal_publish_nilai() {
        $id_tesis_mkpt_pengampu = $this->uri->segment(5);
        $id = $this->uri->segment(6);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_publish_nilai_mkpt($id_tesis_mkpt_pengampu);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Nilai MKPT batal dipublish');
        redirect('dosen/tesis/mkpt/nilai/'.$id_tesis_mkpt_pengampu.'/'.$id);
    }

    public function penguji() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Penguji Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/penguji',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'tesis' => $this->tesis->read_permintaan_penguji($this->session_data['username'], UJIAN_TESIS_PROPOSAL)
            'tesis' => $this->tesis->read_permintaan_penguji_prodi($this->session_data['username'], UJIAN_TESIS_PROPOSAL, $id)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function approve_penguji() {
        $id_tesis = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_tesis_ujian = $this->uri->segment(6);
        $this->tesis->approval_penguji_proposal($id_tesis, $id_tesis_ujian, $this->session_data['username']);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Penguji Proposal disetujui');
        redirect('dosen/tesis/proposal/penguji/'.$id_prodi);
    }    

    /*public function reject_penguji() {
        $id = $this->uri->segment(5);
        $this->tesis->reject_penguji_proposal($id, $this->session_data['username']);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Penguji Proposal ditolak');
        redirect('dosen/tesis/proposal/penguji');
    }*/

    public function batal_penguji() {
        $id_tesis = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_tesis_ujian = $this->uri->segment(6);
        $this->tesis->batal_penguji_proposal($id_tesis, $id_tesis_ujian, $this->session_data['username']);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Penguji Proposal dibatalkan');
        redirect('dosen/tesis/proposal/penguji/'.$id_prodi);
    }

    public function penjadwalan() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Penjadwalan Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/penjadwalan',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'tesis' => $this->tesis->read_penjadwalan($this->session_data['username'])
            'tesis' => $this->tesis->read_penjadwalan_prodi($this->session_data['username'], $id)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            // PAGE //
            'title' => 'Tesis - MKPT',
            'subtitle' => 'Setting',
            'section' => 'backend/dosen/tesis/mkpt/setting',
            'use_back' => true,
            'back_link' => 'dosen/tesis/permintaan/pembimbing/'.$id_prodi,
            // DATA //
            //'tesis' => $this->tesis->detail($id_tesis),
            'gelombang' => $this->gelombang->read_berjalan(),
            'id_prodi' => $id_prodi,
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_MKPT),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_MKPT),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function status_ujian() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting',
            'section' => 'backend/dosen/tesis/proposal/status_ujian',
            'use_back' => true,
            'back_link' => 'dosen/tesis/proposal/penguji/'.$id_prodi,
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_PROPOSAL),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting_penguji() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting Penguji',
            'section' => 'backend/dosen/tesis/proposal/setting_penguji',
            'use_back' => true,
            'back_link' => 'dosen/tesis/proposal/pembimbing/'.$id_prodi,
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_PROPOSAL),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penguji_setting_penguji() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting Penguji',
            'section' => 'backend/dosen/tesis/proposal/penguji_setting_penguji',
            'use_back' => true,
            'back_link' => 'dosen/tesis/proposal/penguji/'.$id_prodi,
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_PROPOSAL),
        );
        $this->load->view('backend/index_sidebar', $data);
    }
    
    public function jadwal_pembimbing() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting',
            'section' => 'backend/dosen/tesis/proposal/jadwal_pembimbing',
            'use_back' => true,
            'back_link' => 'dosen/tesis/judul/pembimbing/'.$id_prodi,
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_PROPOSAL),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function jadwal_pembimbing_save() {
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
                    redirect('dosen/tesis/proposal/jadwal_pembimbing/' . $id_tesis);
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
                            redirect('dosen/tesis/proposal/jadwal_pembimbing/' . $id_tesis);
                        } else {
                            $this->tesis->update_ujian($data, $id_ujian);

                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Usulan Jadwal.');
                            redirect('dosen/tesis/proposal/jadwal_pembimbing/' . $id_tesis);
                        }
                    } else { //langsung update
                        $this->tesis->update_ujian($data, $id_ujian);

                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Ubah Usulan Jadwal.');
                        redirect('dosen/tesis/proposal/jadwal_pembimbing/' . $id_tesis);
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
                    redirect('dosen/tesis/proposal/jadwal_pembimbing/' . $id_tesis);
                } else {
                    /*$update_proposal = array(
                        'status_proposal' => STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS,
                    );*/
                    $this->tesis->save_ujian($data);
                    //$this->tesis->update($update_proposal, $id_tesis);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil Mengajukan Jadwal.');
                    redirect('dosen/tesis/proposal/jadwal_pembimbing/' . $id_tesis);
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/pembimbing');
        }
    }

    public function batal_verifikasi_jadwal() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_verifikasi_jadwal_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Verifikasi Jadwal Ujian Proposal dibatalkan');
        redirect('dosen/tesis/proposal/setting/'.$id);
    }

    public function jadwal_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_MKPT);

            if (!empty($ujian)) { // JIKA SUDAH ADA
                //echo 'jadwal sudah ada. tambah script update';  die();
                $id_ujian = $this->input->post('id_ujian');

                $data = array(
                    'id_tesis' => $id_tesis,
                    'id_ruang' => $this->input->post('id_ruang', TRUE),
                    'id_jam' => $this->input->post('id_jam', TRUE),
                    'tanggal' => todb($this->input->post('tanggal', TRUE)),
                    'status' => 1,
                    'status_ujian' => STATUS_TESIS_MKPT_DIJADWALKAN,
                    'status_apv_kaprodi' => 1,
                );

                $cek_jadwal = $this->tesis->cek_ruang_terpakai($data);

                if ($cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/tesis/mkpt/setting/' . $id_tesis);
                } else {
                    $penguji = $this->tesis->read_penguji($id_ujian);

                    if ($penguji) {
                        foreach ($penguji as $list) {
                            $bentrok = $this->tesis->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
                            break;
                        }

                        if ($bentrok) {

                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
                            redirect('dosen/tesis/mkpt/setting/' . $id_tesis);
                        } else {
                            $this->tesis->update_ujian($data, $id_ujian);

                            $update_mkpt = array(
                                'status_mkpt' => STATUS_TESIS_MKPT_DIJADWALKAN,
                            );
                            $this->tesis->update($update_mkpt, $id_tesis);

                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                            redirect('dosen/tesis/mkpt/setting/' . $id_tesis);
                        }
                    } else { //langsung update
                        $this->tesis->update_ujian($data, $id_ujian);

                        $update_mkpt = array(
                            'status_mkpt' => STATUS_TESIS_MKPT_DIJADWALKAN,
                        );
                        $this->tesis->update($update_mkpt, $id_tesis);

                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                        redirect('dosen/tesis/mkpt/setting/' . $id_tesis);
                    }
                }
            } else { 
                //JIKA BELUM ADA SAVE BARU
                $data = array(
                    'id_tesis' => $id_tesis,
                    'id_ruang' => $this->input->post('id_ruang', TRUE),
                    'id_jam' => $this->input->post('id_jam', TRUE),
                    'tanggal' => todb($this->input->post('tanggal', TRUE)),
                    'jenis_ujian' => UJIAN_TESIS_MKPT,
                    'status' => 1,
                    'status_ujian' => STATUS_TESIS_MKPT_DIJADWALKAN,
                    'status_apv_kaprodi' => 1,
                );

                $cek_jadwal = $this->tesis->cek_ruang_terpakai($data);

                if ($cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/tesis/mkpt/setting/' . $id_tesis);
                } else {
                    $update_mkpt = array(
                        'status_mkpt' => STATUS_TESIS_MKPT_DIJADWALKAN,
                    );
                    $this->tesis->save_ujian($data);
                    $this->tesis->update($update_mkpt, $id_tesis);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
                    redirect('dosen/tesis/mkpt/setting/' . $id_tesis);
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/mkpt/setting/' . $id_tesis);
        }
    }

    public function penguji_usulan_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $nip = $this->input->post('nip', TRUE);

            $jumlah_penguji = $this->tesis->count_penguji_temp($id_tesis, 1);

            if($jumlah_penguji < 1){
                $data = array(
                    'id_tesis' => $id_tesis,
                    'nip' => $this->input->post('nip', TRUE),
                    'status' => 1,
                    'asal_pengusul' => 1 // 1 = Usul dari Pembimbing
                );

                $this->tesis->save_penguji_temp($data);
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', $mesg);
                redirect('dosen/tesis/proposal/jadwal_pembimbing/' . $id_tesis);
            }
            else {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Pembimbing hanya bisa menginputkan satu penguji');
                redirect('dosen/tesis/proposal/jadwal_pembimbing/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal');
        }
    }

    public function penguji_usulan_penguji_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $nip = $this->input->post('nip', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);

            $jumlah_penguji = $this->tesis->count_penguji_temp($id_tesis, 2);

            if($jumlah_penguji < 1){
                $data = array(
                    'id_tesis' => $id_tesis,
                    'nip' => $this->input->post('nip', TRUE),
                    'status' => 1,
                    'asal_pengusul' => 2 // 2 = Usul dari Penguji
                );

                $this->tesis->save_penguji_temp($data);
                $this->tesis->reject_penguji_proposal($id_tesis, $id_ujian, $this->session_data['username']);
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', $mesg);
                redirect('dosen/tesis/proposal/penguji_setting_penguji/' . $id_tesis);
            }
            else {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Penguji hanya bisa mengusulkan satu penguji');
                redirect('dosen/tesis/proposal/penguji_setting_penguji/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal');
        }
    }

    public function penguji_usulan_save_kps() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            if(isset($_POST['terima'])) {
                $id_tesis = $this->input->post('id_tesis', TRUE);
                $id_ujian = $this->input->post('id_ujian', TRUE);
                $id_penguji = $this->input->post('id_penguji', TRUE);
                $nip = $this->input->post('nip', TRUE);

                $jumlah_penguji = $this->tesis->count_penguji($id_ujian);

                /*if($jumlah_penguji < 1){
                    $data = array(
                        'id_ujian' => $id_ujian,
                        'nip' => $this->input->post('nip', TRUE),
                        'status_tim' => 1,
                        'status' => 1
                    );
                }
                else {
                    $data = array(
                        'id_ujian' => $id_ujian,
                        'nip' => $this->input->post('nip', TRUE),
                        'status_tim' => 2,
                        'status' => 1
                    );
                }*/
                $data = array(
                    'id_ujian' => $id_ujian,
                    'nip' => $this->input->post('nip', TRUE),
                    'status_tim' => 2,
                    'status' => 1
                );

                $cekpenguji = $this->tesis->cek_penguji($data);
                if ($cekpenguji) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar.');
                    redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                } else {
                    $ujian = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);
                    $tanggal = $ujian->tanggal;
                    $id_jam = $ujian->id_jam;
                    $pengujibentrok = $this->tesis->read_pengujibentrok($tanggal, $id_jam, $nip);

                    if ($pengujibentrok) {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                        redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                    } else {
                        $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                        if ($jumlah_penguji < '7') {

                            $this->tesis->save_penguji($data);
                            $data_temp = array(
                                'status' => 2
                            );
                            $this->tesis->update_penguji_temp($data_temp, $id_penguji);
                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', $mesg);
                            redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                        } else
                        if ($jumlah_penguji >= '7') {
                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji sudah 7');
                            redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                        }
                    }
                }
            }
            else {
                $id_tesis = $this->input->post('id_tesis', TRUE);
                $this->tesis->reject_penguji_temp_proposal($id_tesis, $this->input->post('nip', TRUE), '4');
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Usulan Penguji Proposal ditolak');
                redirect('dosen/tesis/proposal/setting/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal');
        }
    }

    public function penguji_save() {
        $hand = $this->input->post('hand', TRUE);
        
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);
            $nip = $this->input->post('nip', TRUE);

            $tesis = $this->tesis->detail($id_tesis);
            
            $jumlah_penguji = $this->tesis->count_penguji($id_ujian);

            if($nip == $tesis->nip_pembimbing_satu){
                $data = array(
                    'id_ujian' => $id_ujian,
                    'nip' => $this->input->post('nip', TRUE),
                    'status_tim' => 1,
                    'status' => 1
                );
            }
            else {
                $data = array(
                    'id_ujian' => $id_ujian,
                    'nip' => $this->input->post('nip', TRUE),
                    'status_tim' => 2,
                    'status' => 1
                );
            }

            $cekpenguji = $this->tesis->cek_penguji($data);
            if ($cekpenguji) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar.');
                redirect('dosen/tesis/proposal/setting/' . $id_tesis);
            } else {
                $ujian = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);
                $tanggal = $ujian->tanggal;
                $id_jam = $ujian->id_jam;
                $pengujibentrok = $this->tesis->read_pengujibentrok($tanggal, $id_jam, $nip);

                if ($pengujibentrok) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                    redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                } else {
                    $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                    if ($jumlah_penguji < '7') {

                        $this->tesis->save_penguji($data);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', $mesg);
                        redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                    } else
                    if ($jumlah_penguji >= '7') {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji sudah 7');
                        redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                    }
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal');
        }
    }

    public function penguji_delete() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $id_penguji = $this->input->post('id_penguji', TRUE);

            $data = array(
                'status' => 0,
            );

            $this->tesis->update_penguji($data, $id_penguji);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
            redirect('dosen/tesis/proposal/setting/' . $id_tesis);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/pembimbing');
        }
    }

    public function penguji_usulan_delete() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $id_penguji = $this->input->post('id_penguji', TRUE);

            $data = array(
                'status' => 0,
            );

            $this->tesis->update_penguji_temp($data, $id_penguji);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
            redirect('dosen/tesis/proposal/setting_penguji/' . $id_tesis);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/pembimbing');
        }
    }

    public function penguji_update_statustim() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $id_penguji = $this->input->post('id_penguji', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);

            $data = array(
                'status_tim' => $this->input->post('status_tim'),
            );
            if ($data['status_tim'] == '1') {
                //cek ketua
                $promotor = $this->tesis->read_penguji_ketua($id_ujian);
                if (!empty($promotor)) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal update tim penguji. Ketua sudah ada.');
                    redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                } else {
                    $this->tesis->update_penguji($data, $id_penguji);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil update penguji.');
                    redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                }
            } else {
                $this->tesis->update_penguji($data, $id_penguji);
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update tim penguji.');
                redirect('dosen/tesis/proposal/setting/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/setting');
        }
    }

    public function update_status_ujian() {
        $id_tesis = $this->input->post('id_tesis', TRUE);

        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {

            //CK INI
            $status_ujian = $this->input->post('status_ujian', TRUE);

            $data = array(
                'status_ujian_mkpt' => $status_ujian,
            );
            $this->tesis->update($data, $id_tesis);

            //trigger
            if ($status_ujian == '0') { //belum ujian
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update proses');
                redirect('dosen/tesis/mkpt/setting_pengampu/' . $id_tesis);
            } 
            //else if (in_array($status_ujian, [1, 2])) { //layak
            else if ($status_ujian == '1' OR $status_ujian == '2') { //layak
                //update proposal selesai
                $data = array(
                    'status_mkpt' => STATUS_TESIS_MKPT_UJIAN_SELESAI,
                );
                $this->tesis->update($data, $id_tesis);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update proses. Data akan diteruskan ke Proses Selanjutnya.');
                redirect('dosen/tesis/mkpt/setting_pengampu/' . $id_tesis);
            } else if ($status_ujian == '3') {
                $this->session->set_flashdata('msg-title', 'alert-warning');
                $this->session->set_flashdata('msg', 'Ujian ditolak');
                redirect('dosen/tesis/mkpt/setting_pengampu/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/mkpt/setting_pengampu/' . $id_tesis);
        }
    }

    public function update_status_ujian_ketua() {
        $id_tesis = $this->input->post('id_tesis', TRUE);

        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {

            //CK INI
            $status_ujian = $this->input->post('status_ujian', TRUE);

            $data = array(
                'status_ujian_proposal' => $status_ujian,
            );
            $this->tesis->update($data, $id_tesis);

            //trigger
            if ($status_ujian == '0') { //belum ujian
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update proses');
                redirect('dosen/tesis/proposal/setting/' . $id_tesis);
            } else if (in_array($status_ujian, [1, 2])) { //layak
                //update proposal selesai
                $data = array(
                    'status_proposal' => STATUS_TESIS_PROPOSAL_UJIAN_SELESAI,
                    'status_ujian_proposal' => $status_ujian,
                );
                $this->tesis->update($data, $id_tesis);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update proses. Data akan diteruskan ke Proses Selanjutnya.');
                redirect('dosen/tesis/proposal/status_ujian/' . $id_tesis);
            } else if ($status_ujian == '3') {
                $this->session->set_flashdata('msg-title', 'alert-warning');
                $this->session->set_flashdata('msg', 'Ujian ditolak');
                redirect('dosen/tesis/proposal/status_ujian/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/status_ujian/' . $id_tesis);
        }
    }

}

?>
