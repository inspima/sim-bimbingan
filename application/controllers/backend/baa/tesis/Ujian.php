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
            if ($this->session_data['sebagai'] != 2 AND $this->session_data['role'] != 2) {
                redirect('logout', 'refresh');
            }
        }
        //END SESS
        //START MODEL
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/administrator/master/departemen_model', 'departemen');
        $this->load->model('backend/administrator/master/ruang_model', 'ruang');
        $this->load->model('backend/administrator/master/jam_model', 'jam');
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/transaksi/tesis', 'tesis');
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
            'section' => 'backend/baa/tesis/ujian/index',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'tesis' => $this->tesis->read_ujian_prodi($id, TAHAPAN_TESIS_UJIAN),
            'prodi' => $this->tesis->read_prodi_s2(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    /*public function index_prodi() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/index_prodi',
            // DATA //
            'tesis' => $this->tesis->read_proposal_prodi($id),
            'prodi' => $this->tesis->read_prodi_s2(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }*/

    public function approve() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->approval_tesis($id);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Tesis disetujui');
        redirect('baa/tesis/ujian/index/'.$id_prodi);
    }

    public function reject() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->reject_tesis($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Tesis ditolak');
        redirect('baa/tesis/ujian/index/'.$id_prodi);
    }

    public function batal() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_tesis($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Tesis dibatalkan');
        redirect('baa/tesis/ujian/index/'.$id_prodi);
    }

    public function pembimbing() {
        $data = array(
            // PAGE //
            'title' => 'Tesis - Pembimbing Tesis',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/pembimbing',
            // DATA //
            'tesis' => $this->tesis->read_permintaan_pembimbing($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function approve_pembimbing() {
        $id = $this->uri->segment(5);
        $this->tesis->approval_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Pembimbing Proposal disetujui');
        redirect('dosen/tesis/proposal/pembimbing');
    }

    public function reject_pembimbing() {
        $id = $this->uri->segment(5);
        $this->tesis->reject_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Pembimbing Proposal dibatalkan');
        redirect('dosen/tesis/proposal/pembimbing');
    }

    public function batal_pembimbing() {
        $id = $this->uri->segment(5);
        $this->tesis->cancel_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Pembimbing Proposal ditolak');
        redirect('dosen/tesis/proposal/pembimbing');
    }

    public function penguji() {
        $data = array(
            // PAGE //
            'title' => 'Tesis - Penguji Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/penguji',
            // DATA //
            'tesis' => $this->tesis->read_permintaan_penguji($this->session_data['username'], 1)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function approve_penguji() {
        $id = $this->uri->segment(5);
        $this->tesis->approval_penguji_proposal($id, $this->session_data['username']);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Penguji Proposal disetujui');
        redirect('dosen/tesis/proposal/penguji');
    }    

    public function reject_penguji() {
        $id = $this->uri->segment(5);
        $this->tesis->reject_penguji_proposal($id, $this->session_data['username']);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Penguji Proposal ditolak');
        redirect('dosen/tesis/proposal/penguji');
    }

    public function batal_penguji() {
        $id = $this->uri->segment(5);
        $this->tesis->batal_penguji_proposal($id, $this->session_data['username']);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Penguji Proposal dibatalkan');
        redirect('dosen/tesis/proposal/penguji');
    }

    public function penjadwalan() {
        $data = array(
            // PAGE //
            'title' => 'Tesis - Penjadwalan Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/penjadwalan',
            // DATA //
            'tesis' => $this->tesis->read_penjadwalan($this->session_data['username'])
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting() {
        $id_tesis = $this->uri->segment('5');
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting',
            'section' => 'backend/dosen/tesis/proposal/setting',
            'use_back' => true,
            'back_link' => 'backend/dosen/tesis/proposal/penjadwalan',
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, 1),
            'status_ujians' => $this->tesis->read_status_ujian(1),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting_penguji() {
        $id_tesis = $this->uri->segment('5');
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting Penguji',
            'section' => 'backend/dosen/tesis/proposal/setting_penguji',
            'use_back' => true,
            'back_link' => 'backend/dosen/tesis/proposal/pembimbing',
            // DATA //
            'tesis' => $this->tesis->detail($id_tesis),
            'mruang' => $this->ruang->read_aktif(),
            'mjam' => $this->jam->read_aktif(),
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'ujian' => $this->tesis->read_jadwal($id_tesis, 1),
            'status_ujians' => $this->tesis->read_status_ujian(1),
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
            'mruang' => $this->ruang->read_aktif(),
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

    public function jadwal_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $ujian = $this->tesis->read_jadwal($id_tesis, 1);

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
                    redirect('dosen/tesis/proposal/setting/' . $id_disertasi);
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
                            redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                        } else {
                            $this->tesis->update_ujian($data, $id_ujian);

                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                            redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                        }
                    } else { //langsung update
                        $this->tesis->update_ujian($data, $id_ujian);

                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                        redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                    }
                }
            } else { //JIKA BELUM ADA SAVE BARU
                $data = array(
                    'id_tesis' => $id_tesis,
                    'id_ruang' => $this->input->post('id_ruang', TRUE),
                    'id_jam' => $this->input->post('id_jam', TRUE),
                    'tanggal' => todb($this->input->post('tanggal', TRUE)),
                    'jenis_ujian' => 1,
                    'status' => 1,
                    'status_ujian' => 1
                );

                $cek_jadwal = $this->tesis->cek_ruang_terpakai($data);

                if ($cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                } else {
                    $update_proposal = array(
                        'status_proposal' => STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS,
                    );
                    $this->tesis->save_ujian($data);
                    $this->tesis->update($update_proposal, $id_tesis);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
                    redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/penjadwalan');
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
                    'status' => 1
                );

                $this->tesis->save_penguji_temp($data);
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', $mesg);
                redirect('dosen/tesis/proposal/setting_penguji/' . $id_tesis);
            }
            else {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Pembimbing hanya bisa menginputkan satu penguji');
                redirect('dosen/tesis/proposal/setting_penguji/' . $id_tesis);
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
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);
            $id_penguji = $this->input->post('id_penguji', TRUE);
            $nip = $this->input->post('nip', TRUE);

            $jumlah_penguji = $this->tesis->count_penguji($id_ujian);

            if($jumlah_penguji < 1){
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
                $ujian = $this->tesis->read_jadwal($id_tesis, 1);
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
                $ujian = $this->tesis->read_jadwal($id_tesis, 1);
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
                redirect('dosen/tesis/proposal/setting/' . $id_tesis);
            } else if ($status_ujian == '3') {
                $this->session->set_flashdata('msg-title', 'alert-warning');
                $this->session->set_flashdata('msg', 'Ujian ditolak');
                redirect('dosen/tesis/proposal/setting/' . $id_tesis);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/setting/' . $id_tesis);
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

    public function nilai_ujian() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_ujian = $this->uri->segment('6');
        $data = array(
            // PAGE //
            'title' => 'Tesis - Ujian',
            'subtitle' => 'Nilai Ujian',
            'section' => 'backend/baa/tesis/ujian/nilai_ujian',
            'use_back' => true,
            'back_link' => 'baa/tesis/ujian/index/'.$id_prodi,
            // DATA //
            'id_ujian' => $id_ujian,
            'tesis' => $this->tesis->detail($id_tesis),
            'ujian' => $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_UJIAN),
            'status_ujians' => $this->tesis->read_status_ujian(UJIAN_TESIS_UJIAN),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function nilai_ujian_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_ujian = $this->input->post('id_ujian', TRUE);
            $id_tesis = $this->input->post('id_tesis', TRUE);

            $data = array(
                //'rata_nilai_ujian' => $this->input->post('rata_nilai_ujian', TRUE),
                'bobot_nilai_konversi' => str_replace(',', '.', $this->input->post('bobot_nilai_konversi', TRUE)),
                //'nilai_ujian' => $this->input->post('nilai_ujian', TRUE)
            );

            $this->tesis->update_ujian($data, $id_ujian);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Bobot Nilai Konversi berhasil disimpan');
            redirect('baa/tesis/ujian/nilai_ujian/' . $id_tesis .'/'.$id_ujian);

        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('baa/tesis/ujian/index');
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
