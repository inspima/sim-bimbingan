<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends CI_Controller {

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
        $this->load->model('backend/transaksi/dokumen', 'dokumen');
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    // KPS / PENASEHAT AKADEMIK

    public function index() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Ujian',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/ujian/index',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'tesis' => $this->tesis->read_ujian_prodi($id),
            'prodi' => $this->tesis->read_prodi_s2(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function approve() {
        $id = $this->uri->segment(5);
        $this->tesis->approval_ujian($id);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Tesis disetujui');
        redirect('dosen/tesis/ujian');
    }

    public function reject() {
        $id = $this->uri->segment(5);
        $this->tesis->reject_ujian($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Tesis ditolak');
        redirect('dosen/tesis/ujian');
    }

    public function batal() {
        $id = $this->uri->segment(5);
        $this->tesis->batal_ujian($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Tesis dibatalkan');
        redirect('dosen/tesis/ujian');
    }

    public function pembimbing() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Pembimbing Tesis',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/ujian/pembimbing',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'tesis' => $this->tesis->read_permintaan_pembimbing($this->session_data['username'])
            'tesis' => $this->tesis->read_permintaan_pembimbing_prodi($this->session_data['username'], $id)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function approve_pembimbing() {
        $id = $this->uri->segment(5);
        $this->tesis->approval_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Pembimbing Tesis disetujui');
        redirect('dosen/tesis/ujian/pembimbing');
    }

    public function reject_pembimbing() {
        $id = $this->uri->segment(5);
        $this->tesis->reject_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Pembimbing Tesis dibatalkan');
        redirect('dosen/tesis/ujian/pembimbing');
    }

    public function batal_pembimbing() {
        $id = $this->uri->segment(5);
        $this->tesis->cancel_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Pembimbing Tesis ditolak');
        redirect('dosen/tesis/ujian/pembimbing');
    }

    public function penguji() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Penguji Tesis',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/ujian/penguji',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'tesis' => $this->tesis->read_permintaan_penguji($this->session_data['username'], UJIAN_TESIS_UJIAN)
            'tesis' => $this->tesis->read_permintaan_penguji_prodi($this->session_data['username'], UJIAN_TESIS_UJIAN, $id)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function approve_penguji() {
        $id_tesis = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_tesis_ujian = $this->uri->segment(6);
        $this->tesis->approval_penguji_tesis($id_tesis, $id_tesis_ujian, $this->session_data['username']);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Penguji Tesis disetujui');
        redirect('dosen/tesis/ujian/penguji/'.$id_prodi);
    }    

    public function reject_penguji() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_tesis_ujian = $this->uri->segment(6);
        $keterangan = $this->input->post('keterangan', TRUE);
        $this->tesis->reject_penguji_tesis($id, $id_tesis_ujian, $this->session_data['username'], $keterangan);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Penguji Tesis ditolak');
        redirect('dosen/tesis/ujian/penguji');
    }

    public function batal_penguji() {
        $id_tesis = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_tesis_ujian = $this->uri->segment(6);
        $this->tesis->batal_penguji_tesis($id_tesis, $id_tesis_ujian, $this->session_data['username']);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Penguji Tesis dibatalkan');
        redirect('dosen/tesis/ujian/penguji/'.$id_prodi);
    }

    public function pengajuan_baru() {
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Penjadwalan Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/ujian/pengajuan_baru',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'tesis' => $this->tesis->read_penjadwalan($this->session_data['username'])
            'tesis' => $this->tesis->read_penjadwalan_prodi_tesis_status($this->session_data['username'], $id_prodi, TAHAPAN_TESIS_UJIAN, 'anyar')
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penjadwalan() {
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Penjadwalan Ujian',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/ujian/penjadwalan',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'tesis' => $this->tesis->read_penjadwalan($this->session_data['username'])
            //'tesis' => $this->tesis->read_penjadwalan_prodi($this->session_data['username'], $id, TAHAPAN_TESIS_UJIAN)
            'tesis' => $this->tesis->read_penjadwalan_prodi_tesis_status($this->session_data['username'], $id_prodi, TAHAPAN_TESIS_UJIAN, STATUS_TESIS_UJIAN_SETUJUI_BAA)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penjadwalan_sudah() {
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Penjadwalan Ujian',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/ujian/penjadwalan_sudah',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'tesis' => $this->tesis->read_penjadwalan($this->session_data['username'])
            'tesis' => $this->tesis->read_penjadwalan_prodi_tesis_status($this->session_data['username'], $id_prodi, TAHAPAN_TESIS_UJIAN, STATUS_TESIS_UJIAN_DIJADWALKAN)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penjadwalan_selesai_tesis() {
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Penjadwalan Ujian',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/ujian/penjadwalan_selesai_tesis',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'tesis' => $this->tesis->read_penjadwalan($this->session_data['username'])
            'tesis' => $this->tesis->read_penjadwalan_prodi_tesis_status($this->session_data['username'], $id_prodi, TAHAPAN_TESIS_UJIAN, STATUS_TESIS_UJIAN_SELESAI)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            // PAGE //
            'title' => 'Tesis - Ujian',
            'subtitle' => 'Setting',
            'section' => 'backend/dosen/tesis/ujian/setting',
            'use_back' => true,
            'back_link' => 'dosen/tesis/ujian/penjadwalan/'.$id_prodi,
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif_id_desc(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_UJIAN),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting_penguji() {
        $id_tesis = $this->uri->segment('5');
        $data = array(
            // PAGE //
            'title' => 'Tesis - Ujian',
            'subtitle' => 'Setting Penguji',
            'section' => 'backend/dosen/tesis/ujian/setting_penguji',
            'use_back' => true,
            'back_link' => 'backend/dosen/tesis/ujian/pembimbing',
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif_id_desc(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_UJIAN),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function nilai() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_penguji = $this->uri->segment('6');
        $data = array(
            // PAGE //
            'title' => 'Tesis - Ujian',
            'subtitle' => 'Nilai Penguji',
            'section' => 'backend/dosen/tesis/ujian/nilai',
            'use_back' => true,
            'back_link' => 'dosen/tesis/ujian/penguji/'.$id_prodi,
            // DATA //
            'id_penguji' => $id_penguji,
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif_id_desc(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_UJIAN),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penguji_setting_penguji() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            // PAGE //
            'title' => 'Tesis - Ujian',
            'subtitle' => 'Setting Penguji',
            'section' => 'backend/dosen/tesis/ujian/penguji_setting_penguji',
            'use_back' => true,
            'back_link' => 'dosen/tesis/ujian/penguji/'.$id_prodi,
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif_id_desc(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_UJIAN),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function terima() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $struktural = $this->struktural->read_struktural($this->session_data['username']);
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            if ($struktural->id_struktur == STRUKTUR_SPS) {
                $data = array(
                    'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_SPS,
                );
            } else if ($struktural->id_struktur == STRUKTUR_KPS_S3) {
                // SETUJUI KPS
                $data = array(
                    'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_KPS,
                );
                // SEDANG UJIAN
                $data = array(
                    'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_UJIAN,
                );
            }
            $this->disertasi->update($data, $id_disertasi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect('dosen/disertasi/kualifikasi');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/kualifikasi');
        }
    }

    /*public function setting() {
        $id_disertasi = $this->uri->segment('5');
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Kualifikasi',
            'subtitle' => 'Setting',
            'section' => 'backend/dosen/disertasi/kualifikasi/setting',
            'use_back' => true,
            'back_link' => 'backend/dosen/disertasi/permintaan/penasehat',
            // DATA //
            'disertasi' => $this->disertasi->detail($id_disertasi),
            'mruang' => $this->ruang->read_aktif_id_desc(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI),
            'status_ujians' => $this->disertasi->read_status_ujian(UJIAN_DISERTASI_KUALIFIKASI),
        );
        $this->load->view('backend/index_sidebar', $data);
    }*/
    
    public function promotor() {
        $id_disertasi = $this->uri->segment('5');
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Kualifikasi',
            'subtitle' => 'Setting - Promotor',
            'section' => 'backend/dosen/disertasi/kualifikasi/promotor',
            'use_back' => true,
            'back_link' => 'backend/dosen/disertasi/kualifikasi/index',
            // DATA //
            'disertasi' => $this->disertasi->detail($id_disertasi),
            'mdosen' => $this->dosen->read_aktif_alldep(),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function jadwal_pembimbing() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            'title' => 'Tesis - Ujian',
            'subtitle' => 'Setting',
            'section' => 'backend/dosen/tesis/ujian/jadwal_pembimbing',
            'use_back' => true,
            'back_link' => 'dosen/tesis/ujian/pembimbing/'.$id_prodi,
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif_id_desc(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_UJIAN),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function jadwal_pembimbing_save() {
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

                if (!$cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/tesis/ujian/jadwal_pembimbing/' . $id_tesis);
                } else {
                    $penguji = $this->tesis->read_penguji($id_ujian);

                    if ($penguji) {
                        foreach ($penguji as $list) {
                            $bentrok = $this->tesis->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
                            break;
                        }

                        if (!$bentrok) {

                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal Ubah Usulan Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
                            redirect('dosen/tesis/ujian/jadwal_pembimbing/' . $id_tesis);
                        } else {
                            $this->tesis->update_ujian($data, $id_ujian);

                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Usulan Jadwal.');
                            redirect('dosen/tesis/ujian/jadwal_pembimbing/' . $id_tesis);
                        }
                    } else { //langsung update
                        $this->tesis->update_ujian($data, $id_ujian);

                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Ubah Usulan Jadwal.');
                        redirect('dosen/tesis/ujian/jadwal_pembimbing/' . $id_tesis);
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

                if (!$cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/tesis/ujian/jadwal_pembimbing/' . $id_tesis);
                } else {
                    /*$update_proposal = array(
                        'status_proposal' => STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS,
                    );*/
                    $this->tesis->save_ujian($data);
                    //$this->tesis->update($update_proposal, $id_tesis);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil Mengajukan Jadwal.');
                    redirect('dosen/tesis/ujian/jadwal_pembimbing/' . $id_tesis);
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian/pembimbing');
        }
    }

    public function batal_verifikasi_jadwal() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_verifikasi_jadwal_tesis($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Verifikasi Jadwal Ujian Tesis dibatalkan');
        redirect('dosen/tesis/ujian/setting/'.$id);
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
                    'status_ujian' => 1,
                    'status_apv_kaprodi' => 1,
                );

                $cek_jadwal = $this->tesis->cek_ruang_terpakai($data);

                if (!$cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                } else {
                    $penguji = $this->tesis->read_penguji($id_ujian);

                    if ($penguji) {
                        foreach ($penguji as $list) {
                            $bentrok = $this->tesis->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
                            break;
                        }

                        if (!$bentrok) {

                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
                            redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                        } else {
                            $this->tesis->update_ujian($data, $id_ujian);

                            $update_tesis = array(
                                'status_tesis' => STATUS_TESIS_UJIAN_DIJADWALKAN,
                            );
                            $this->tesis->update($update_tesis, $id_tesis);
                            
                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                            redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                        }
                    } else { //langsung update
                        $this->tesis->update_ujian($data, $id_ujian);

                        $update_tesis = array(
                            'status_tesis' => STATUS_TESIS_UJIAN_DIJADWALKAN,
                        );
                        $this->tesis->update($update_tesis, $id_tesis);

                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                        redirect('dosen/tesis/ujian/setting/' . $id_tesis);
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

                if (!$cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                } else {
                    $update_tesis = array(
                        'status_tesis' => STATUS_TESIS_UJIAN_DIJADWALKAN,
                    );
                    $this->tesis->save_ujian($data);
                    $this->tesis->update($update_tesis, $id_tesis);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
                    redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian/penjadwalan');
        }
    }

    public function penguji_nilai_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_penguji = $this->input->post('id_penguji', TRUE);
            $id_tesis = $this->input->post('id_tesis', TRUE);

            $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_UJIAN);
            $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN);
            $tesis = $this->tesis->detail($id_tesis);
            $pengujis = $this->tesis->read_penguji_id($id_penguji);

            $link_dokumen = base_url() . 'document/lihat?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . UJIAN_TESIS_UJIAN;
            $link_dokumen_cetak = base_url() . 'document/cetak?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_STR . '$' . TAHAPAN_TESIS_UJIAN_STR . '$' . UJIAN_TESIS_UJIAN;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Tesis', $tesis->nim, $jadwal->tanggal);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_STR, 'tesis', $tesis->nim, $jadwal->tanggal),
                'tipe' => DOKUMEN_BERITA_ACARA_STR,
                'jenis' => 'ujian_tesis',
                'id_tugas_akhir' => $id_tesis,
                'identitas' => $tesis->nim,
                'nama' => 'Berita Acara Ujian Tesis - ' . $tesis->nama,
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => $jadwal->tanggal,
                'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
            ];
            $dokumen = $this->dokumen->detail_by_data($data_dokumen);
            if (empty($dokumen)) {
                $this->dokumen->save($data_dokumen);
            }
            $dokumen = $this->dokumen->detail_by_data($data_dokumen);
            // DOKUMEN PERSETUJUAN
            $this->dokumen->generate_persetujuan($pengujis, $dokumen->id_dokumen, JENJANG_S2, $id_tesis, 0);
            //$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);

            $identitas = '';
            foreach ($pengujis as $data) {
                $identitas = $data['nip'];
            }

            $data_dokumen_persetujuan = [
                'id_dokumen' => $dokumen->id_dokumen,
                'identitas' => $identitas,
                'jenis' => 0,
            ];

            $dokumen_persetujuan = $this->dokumen->detail_persetujuan_by_data($data_dokumen_persetujuan);

            /*$data = array(
                'jadwal' => $jadwal,
                'pengujis' => $pengujis,
                'tesis' => $tesis,
                'qr_dokumen' => PATH_FILE_QR . $qr_image_dokumen_name,
                'dokumen_persetujuan' => $dokumen_persetujuan
            );
            ob_end_clean();
            $page = 'backend/baa/magister/proposal/cetak_berita';
            $size = 'legal';
            $this->pdf->setPaper($size, 'potrait');
            $this->pdf->filename = 'berita_acara_proposal_' . $tesis->nim;
            $this->pdf->load_view($page, $data);*/
            $id_dokumen_persetujuan = $dokumen_persetujuan->id_dokumen_persetujuan;

            $data_persetujuan = [
                'waktu' => date('Y-m-d H:i:s')
            ];
            $this->dokumen->update_persetujuan($data_persetujuan, $id_dokumen_persetujuan);
            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Persetujuan dokumen berhasil');

            $jumlah_nilai = $this->tesis->read_kriteria_nilai();

            $penguji = $this->tesis->read_penguji($ujian->id_ujian);
            $total_seluruh_nilai_terbobot = 0;
            foreach ($penguji as $uji) {
                $nilai_ujian = 0;
                $total_bobot = 0;
                $total_nilai = 0;
                $total_nilai_terbobot = 0;
                foreach ($jumlah_nilai as $data) {
                    $id_penguji = $uji['id_penguji'];
                    $nilai_penguji = $this->tesis->read_penilaian($uji['id_penguji'], $data['id']);

                    $nilai_ujian = $this->input->post('nilai_'.$data['id'], TRUE);
                    $total_bobot = $total_bobot + $data['bobot'];

                    $total_nilai = $total_nilai + $nilai_ujian;
                    $total_nilai_terbobot = $total_nilai_terbobot + ($nilai_ujian*$data['bobot']);


                    if(empty($nilai_penguji)){
                        $data = array(
                            'id_penguji' => $id_penguji,
                            'id_kriteria_penilaian' => $data['id'],
                            'nilai' => $this->input->post('nilai_'.$data['id'], TRUE),
                            'status_aktif' => 1,
                        );

                        $this->tesis->save_penilaian($data);
                    }
                    else {
                        $data = array(
                            'id_penguji' => $id_penguji,
                            'id_kriteria_penilaian' => $data['id'],
                            'nilai' => $this->input->post('nilai_'.$data['id'], TRUE),
                            'status_aktif' => 1,
                        );

                        $this->tesis->update_penilaian($data, $nilai_penguji->id);
                    }

                }

                
            }

            $total_seluruh_nilai_terbobot = ($total_seluruh_nilai_terbobot + $total_nilai_terbobot)*count($penguji);

            $rata_nilai = number_format(($total_seluruh_nilai_terbobot/count($penguji)),1);
            $bobot_nilai_konversi = $ujian->bobot_nilai_konversi;
            $nilai_ujian = $rata_nilai * $bobot_nilai_konversi;


            $data = array(
                'rata_nilai_ujian' => $rata_nilai,
                'bobot_nilai_konversi' => $bobot_nilai_konversi,
                'nilai_ujian' => $nilai_ujian
            );

            $this->tesis->update_ujian($data, $ujian->id_ujian);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', $mesg);
            redirect('dosen/tesis/ujian/nilai/' . $id_tesis .'/'.$id_penguji);

        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian');
        }
    }

    public function penguji_usulan_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $nip = $this->input->post('nip', TRUE);

            $jumlah_penguji = $this->tesis->count_penguji_temp($id_tesis);

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
                redirect('dosen/tesis/ujian/jadwal_pembimbing/' . $id_tesis);
            }
            else {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Pembimbing hanya bisa menginputkan satu penguji');
                redirect('dosen/tesis/ujian/jadwal_pembimbing/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian');
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
                $this->tesis->reject_penguji_tesis($id_tesis, $id_ujian, $this->session_data['username']);
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
                    redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                } else {
                    $ujian = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN);
                    $tanggal = $ujian->tanggal;
                    $id_jam = $ujian->id_jam;
                    $pengujibentrok = $this->tesis->read_pengujibentrok($tanggal, $id_jam, $nip);

                    if (!$pengujibentrok) {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                        redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                    } else {
                        $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                        if ($jumlah_penguji < '5') {

                            $this->tesis->save_penguji($data);
                            $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                            $data_temp = array(
                                'status' => 2
                            );
                            $this->tesis->update_penguji_temp($data_temp, $id_penguji);
                            $this->session->set_flashdata('msg-title', 'alert-success');
                            //$this->session->set_flashdata('msg', $mesg);
                            $this->session->set_flashdata('msg', "Berhasil simpan, Jumlah penguji kurang ".(5-$jumlah_penguji));
                            redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                        } else if ($jumlah_penguji >= '5') {
                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji sudah 5');
                            redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                        }
                    }
                }
            }
            else {
                $id_tesis = $this->input->post('id_tesis', TRUE);
                $this->tesis->reject_penguji_temp_proposal($id_tesis, $this->input->post('nip', TRUE), '4');
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Usulan Penguji Tesis ditolak');
                redirect('dosen/tesis/ujian/setting/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian');
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

            /*if($nip == $tesis->nip_pembimbing_satu){
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
                redirect('dosen/tesis/ujian/setting/' . $id_tesis);
            } else {
                $ujian = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN);
                $tanggal = $ujian->tanggal;
                $id_jam = $ujian->id_jam;
                $pengujibentrok = $this->tesis->read_pengujibentrok($tanggal, $id_jam, $nip);

                if (!$pengujibentrok) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                    redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                } else {
                    $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                    if ($jumlah_penguji < '5') {

                        $this->tesis->save_penguji($data);
                        $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        //$this->session->set_flashdata('msg', $mesg);
                        $this->session->set_flashdata('msg', "Berhasil simpan, Jumlah penguji kurang ".(5-$jumlah_penguji));
                        redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                    } else if ($jumlah_penguji >= '5') {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji sudah 5');
                        redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                    }
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian');
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
            redirect('dosen/tesis/ujian/setting/' . $id_tesis);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian/pembimbing');
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
            redirect('dosen/tesis/ujian/jadwal_pembimbing/' . $id_tesis);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian/pembimbing');
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
                    redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                } else {
                    $this->tesis->update_penguji($data, $id_penguji);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil update penguji.');
                    redirect('dosen/tesis/ujian/setting/' . $id_tesis);
                }
            } else {
                $this->tesis->update_penguji($data, $id_penguji);
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update tim penguji.');
                redirect('dosen/tesis/ujian/setting/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian/setting');
        }
    }

    public function update_status_ujian() {
        $id_tesis = $this->input->post('id_tesis', TRUE);

        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {

            //CK INI
            $status_ujian = $this->input->post('status_ujian', TRUE);

            $data = array(
                'status_ujian_tesis' => $status_ujian,
            );
            $this->tesis->update($data, $id_tesis);

            //trigger
            if ($status_ujian == '0') { //belum ujian
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update proses');
                redirect('dosen/tesis/ujian/nilai/' . $id_tesis);
            } else if (in_array($status_ujian, [1, 2])) { //layak
                //update ujian selesai
                $data = array(
                    'status_tesis' => STATUS_TESIS_UJIAN_SELESAI,
                    'status_ujian_tesis' => $status_ujian,
                );
                $this->tesis->update($data, $id_tesis);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update proses. Data akan diteruskan ke Proses Selanjutnya.');
                redirect('dosen/tesis/ujian/setting/' . $id_tesis);
            } else if ($status_ujian == '3') {
                $this->session->set_flashdata('msg-title', 'alert-warning');
                $this->session->set_flashdata('msg', 'Ujian ditolak');
                redirect('dosen/tesis/ujian/nilai/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/ujian/nilai/' . $id_tesis);
        }
    }

    public function promotor_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $status_tim = $this->input->post('status_tim', TRUE);
            $nip = $this->input->post('nip', TRUE);

            $data = array(
                'id_disertasi' => $id_disertasi,
                'nip' => $nip,
                'status_tim' => $status_tim,
                'status' => 1
            );

            $cek_promotor = $this->disertasi->cek_promotor_kopromotor($data);
            if ($cek_promotor) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Gagal simpan. Promotor/Co-Promotor sudah terdaftar.');
                redirect_back();
            } else {
                $jumlah_promotor = $this->disertasi->count_penguji($id_disertasi);
                if ($jumlah_promotor < 3) {
                    if ($status_tim == '1') {
                        $cek_promotor_ada = $this->disertasi->cek_promotor_ada($id_disertasi);
                        if (empty($cek_promotor_ada)) {
                            $this->disertasi->save_promotor($data);
                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', "Data berhasil disimpan");
                            redirect_back();
                        } else {
                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal simpan. Promotor sudah ada');
                            redirect_back();
                        }
                    } else {
                        $this->disertasi->save_promotor($data);
                        $this->disertasi->update($update_disertasi, $id_disertasi);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', "Data berhasil disimpan");
                        redirect_back();
                    }
                } else if ($jumlah_promotor >= 3) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah Promotor/Ko-Promotor sudah 3');
                    redirect_back();
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

    public function promotor_delete() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $id_promotor = $this->input->post('id_promotor', TRUE);

            $data = array(
                'status' => 0,
            );

            $this->disertasi->update_promotor($data, $id_promotor);

            $semua_promotor_setujui = $this->disertasi->semua_promotor_setujui($id_disertasi);
            if ($semua_promotor_setujui) {
                $data = array(
                    'status_promotor' => STATUS_DISERTASI_PROMOTOR_SETUJUI,
                );
                $this->disertasi->update($data, $id_disertasi);
            }

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
            redirect_back();
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

}

?>
