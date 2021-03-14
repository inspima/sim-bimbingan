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
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $status_proposal = 0;
        if($id_prodi == S2_ILMU_HUKUM){
            $status_proposal = MIH_STATUS_TESIS_PROPOSAL_PENGAJUAN;
        }
        else if($id_prodi == S2_KENOTARIATAN){
            $status_proposal = MKN_STATUS_TESIS_PROPOSAL_PENGAJUAN_JUDUL;
        }
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/index',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            //'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'id_prodi' => $id_prodi,
            'tesis' => $this->tesis->read_proposal_prodi($id_prodi, $status_proposal),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function disetujui() {
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $status_proposal = 0;
        if($id_prodi == S2_ILMU_HUKUM){
            $status_proposal = MIH_STATUS_TESIS_PROPOSAL_SETUJUI_SPS;
        }
        else if($id_prodi == S2_KENOTARIATAN){
            $status_proposal = MKN_STATUS_TESIS_PROPOSAL_SETUJUI_SPS;
        }
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/disetujui',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            //'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'id_prodi' => $id_prodi,
            'tesis' => $this->tesis->read_proposal_prodi($id_prodi, $status_proposal),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function ditolak() {
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $status_proposal = 0;
        if($id_prodi == S2_ILMU_HUKUM){
            $status_proposal = MIH_STATUS_TESIS_PROPOSAL_TOLAK_SPS;
        }
        else if($id_prodi == S2_KENOTARIATAN){
            $status_proposal = MKN_STATUS_TESIS_PROPOSAL_TOLAK_SPS;
        }
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/ditolak',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            //'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'id_prodi' => $id_prodi,
            'tesis' => $this->tesis->read_proposal_prodi($id_prodi, $status_proposal),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function index_kabag() {
        $id_departemen = $this->dosen->detail($this->session_data['username'])->id_departemen;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/index_kabag',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'tesis' => $this->tesis->read_proposal_departemen($id_departemen),
            'prodi' => $this->tesis->read_prodi_s2(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting_pembimbing() {
        $id = $this->uri->segment(5);
        $username = $this->session_data['username'];

        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting Pembimbing',
            'section' => 'backend/dosen/tesis/proposal/setting_pembimbing',
            // DATA //
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'departemen' => $this->departemen->read(),
            'minat' => $this->minat_tesis->read(),
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

    public function setting_pembimbing_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);

            $read_judul = $this->tesis->read_judul($id_tesis);
            $judul = $this->input->post('judul', TRUE);
            $tgl_sekarang = date('Y-m-d');

            if ($judul == $read_judul->judul) {
                $data = array(
                    'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                    'jenis' => TAHAPAN_TESIS_PROPOSAL,
                    'tgl_pengajuan' => $tgl_sekarang,
                    'status_proposal' => STATUS_TESIS_PROPOSAL_PENGAJUAN,
                );
                $this->tesis->update($data, $id_tesis);
                

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('dosen/tesis/proposal/index_kabag');
            } else {
                $data = array(
                    'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
                    'jenis' => TAHAPAN_TESIS_PROPOSAL,
                    'tgl_pengajuan' => $tgl_sekarang,
                    'status_proposal' => STATUS_TESIS_PROPOSAL_PENGAJUAN,
                );
                $this->tesis->update($data, $id_tesis);

                $dataj = array(
                    'id_tesis' => $id_tesis,
                    'judul' => $this->input->post('judul', TRUE),
                    'jenis' => TAHAPAN_TESIS_PROPOSAL,
                );

                $this->tesis->update_judul($dataj, $id_tesis);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('dosen/tesis/proposal/index_kabag');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/index_kabag');
        }
    }

    public function setting_pembimbing_kedua() {
        $id = $this->uri->segment(5);
        $username = $this->session_data['username'];

        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting Pembimbing',
            'section' => 'backend/dosen/tesis/proposal/setting_pembimbing_kedua',
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

    public function setting_pembimbing_kedua_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $id_prodi = $this->tesis->cek_prodi($id_tesis);

            $read_judul = $this->tesis->read_judul($id_tesis);
            $judul = $this->input->post('judul', TRUE);

            if ($judul == $read_judul->judul) {
                $data = array(
                    'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                    'jenis' => TAHAPAN_TESIS_PROPOSAL,
                    'status_proposal' => STATUS_TESIS_PROPOSAL_PENGAJUAN,
                );
                $this->tesis->update($data, $id_tesis);
                

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('dosen/tesis/proposal/pembimbing/'.$id_prodi);
            } else {
                $data = array(
                    'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
                    'jenis' => TAHAPAN_TESIS_PROPOSAL,
                    'status_proposal' => STATUS_TESIS_PROPOSAL_PENGAJUAN,
                );
                $this->tesis->update($data, $id_tesis);

                $dataj = array(
                    'id_tesis' => $id_tesis,
                    'judul' => $this->input->post('judul', TRUE),
                    'jenis' => TAHAPAN_TESIS_PROPOSAL,
                );

                $this->tesis->update_judul($dataj, $id_tesis);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update');
                redirect('dosen/tesis/proposal/pembimbing/'.$id_prodi);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/pembimbing/'.$id_prodi);
        }
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
        $this->tesis->approval_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Proposal disetujui');
        redirect('dosen/tesis/proposal/index/'.$id_prodi);
    }

    

    public function reject() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->reject_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Proposal ditolak');
        redirect('dosen/tesis/proposal/index/'.$id_prodi);
    }

    public function batal() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Proposal dibatalkan');
        redirect('dosen/tesis/proposal/index/'.$id_prodi);
    }

    public function pembimbing() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Pembimbing Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/proposal/pembimbing',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'tesis' => $this->tesis->read_permintaan_pembimbing($this->session_data['username']),
            'tesis' => $this->tesis->read_permintaan_pembimbing_prodi($this->session_data['username'], $id),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function approve_pembimbing() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->approval_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Pembimbing Proposal disetujui');
        redirect('dosen/tesis/proposal/pembimbing/'.$id_prodi);
    }

    public function reject_pembimbing() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->reject_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Pembimbing Proposal ditolak');
        redirect('dosen/tesis/proposal/pembimbing/'.$id_prodi);
    }

    public function batal_pembimbing() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Pembimbing Proposal dibatalkan');
        redirect('dosen/tesis/proposal/pembimbing/'.$id_prodi);
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

    public function reject_penguji() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $id_tesis_ujian = $this->uri->segment(6);
        $keterangan = $this->input->post('keterangan', TRUE);
        $this->tesis->reject_penguji_proposal($id, $id_tesis_ujian, $this->session_data['username'], $keterangan);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Penguji Proposal ditolak');
        redirect('dosen/tesis/proposal/penguji');
    }

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
            'tesis' => $this->tesis->read_penjadwalan_prodi($this->session_data['username'], $id, TAHAPAN_TESIS_PROPOSAL)
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            // PAGE //
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting',
            'section' => 'backend/dosen/tesis/proposal/setting',
            'use_back' => true,
            'back_link' => 'dosen/tesis/proposal/penjadwalan/'.$id_prodi,
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

    public function status_ujian() {
        $id_tesis = $this->uri->segment('5');
        $tesis = $this->tesis->detail($id_tesis);
        $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data_dokumen = [
            'tipe' => DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS,
            'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
            'identitas' => $tesis->nim,
        ];
        $dokumen = $this->dokumen->detail_by_data($data_dokumen);
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
            'dokumen' => $dokumen,
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

    public function jadwal_pembimbing() {
        $id_tesis = $this->uri->segment('5');
        $id_prodi = $this->tesis->cek_prodi($id_tesis);
        $data = array(
            'title' => 'Tesis - Proposal',
            'subtitle' => 'Setting',
            'section' => 'backend/dosen/tesis/proposal/jadwal_pembimbing',
            'use_back' => true,
            'back_link' => 'dosen/tesis/permintaan/pembimbing/'.$id_prodi,
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

                if (!$cek_jadwal) {
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

                        if (!$bentrok) {

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

                if (!$cek_jadwal) {
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
                    'status_ujian' => 1,
                    'status_apv_kaprodi' => 1,
                );

                $cek_jadwal = $this->tesis->cek_ruang_terpakai($data);

                if (!$cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/tesis/proposal/setting/' . $id_tesis);
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
                            redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                        } else {
                            $this->tesis->update_ujian($data, $id_ujian);

                            $update_proposal = array(
                                'status_proposal' => STATUS_TESIS_UJIAN_DIJADWALKAN,
                            );
                            $this->tesis->update($update_proposal, $id_tesis);

                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                            redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                        }
                    } else { //langsung update
                        $this->tesis->update_ujian($data, $id_ujian);

                        $update_proposal = array(
                            'status_proposal' => STATUS_TESIS_UJIAN_DIJADWALKAN,
                        );
                        $this->tesis->update($update_proposal, $id_tesis);

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
                    'status_ujian' => 1,
                    'status_apv_kaprodi' => 1,
                );

                $cek_jadwal = $this->tesis->cek_ruang_terpakai($data);

                if (!$cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                } else {
                    $update_proposal = array(
                        'status_proposal' => STATUS_TESIS_UJIAN_DIJADWALKAN,
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

                    if (!$pengujibentrok) {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                        redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                    } else {
                        $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                        if ($jumlah_penguji < '4') {

                            $this->tesis->save_penguji($data);
                            $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                            $data_temp = array(
                                'status' => 2
                            );
                            $this->tesis->update_penguji_temp($data_temp, $id_penguji);
                            $this->session->set_flashdata('msg-title', 'alert-success');
                            //$this->session->set_flashdata('msg', $mesg);
                            $this->session->set_flashdata('msg', "Berhasil simpan, Jumlah penguji kurang ".(4-$jumlah_penguji));
                            redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                        } else if ($jumlah_penguji >= '4') {
                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji sudah 4');
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

            /*if($nip == $tesis->nip_pembimbing_satu){
                $data = array(
                    'id_ujian' => $id_ujian,
                    'nip' => $this->input->post('nip', TRUE),
                    'status_tim' => 2,
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

                if (!$pengujibentrok) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                    redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                } else {
                    $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                    if ($jumlah_penguji < '4') {

                        $this->tesis->save_penguji($data);
                        $jumlah_penguji = $this->tesis->count_penguji($id_ujian);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        //$this->session->set_flashdata('msg', $mesg);
                        $this->session->set_flashdata('msg', "Berhasil simpan, Jumlah penguji kurang ".(4-$jumlah_penguji));
                        redirect('dosen/tesis/proposal/setting/' . $id_tesis);
                    } else if ($jumlah_penguji >= '4') {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji sudah 4');
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

    public function kirim_berita_acara(){
        $id_tesis = $this->input->post('id_tesis', TRUE);
        $ujian = $this->tesis->detail_ujian_by_tesis($id_tesis, UJIAN_TESIS_PROPOSAL);
        $jadwal = $this->tesis->read_jadwal($id_tesis, UJIAN_TESIS_PROPOSAL);
        $tesis = $this->tesis->detail($id_tesis);
        $pengujis = $this->tesis->read_penguji($ujian->id_ujian);
        $tgl_sk = $this->input->post('tanggal_ujian_ulang', TRUE);
        $tgl_sk_ymd = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sk)));

        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $link_dokumen = base_url() . 'document/lihat_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            $link_dokumen_cetak = base_url() . 'document/cetak_tesis?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tesis . '$' . DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS . '$' . TAHAPAN_TESIS_PROPOSAL_STR . '$' . TAHAPAN_TESIS_PROPOSAL;
            // QR
            $qr_image_dokumen_name = $this->qrcode->generateQrImageName('Dokumen Berita Acara', 'Proposal', $tesis->nim, $jadwal->tanggal);
            $qr_content = 'Buka dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
            $this->qrcode->generateQr($qr_image_dokumen_name, $qr_content);
            // DOKUMEN
            $data_dokumen = [
                'kode' => $this->dokumen->generate_kode(DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS, 'tesis_proposal', $tesis->nim, $jadwal->tanggal),
                'tipe' => DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS,
                'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
                'id_tugas_akhir' => $id_tesis,
                'identitas' => $tesis->nim,
                'nama' => 'Berita Acara Ujian Proposal - ' . $tesis->nama,
                'link' => $link_dokumen,
                'link_cetak' => $link_dokumen_cetak,
                'date' => $jadwal->tanggal,
                'date_doc' => $tgl_sk_ymd,
                'qr_image' => PATH_FILE_QR . $qr_image_dokumen_name,
            ];
            $dokumen = $this->dokumen->detail_by_data($data_dokumen);
            if (empty($dokumen)) {
                $this->dokumen->save($data_dokumen);
            }
            else {
            	$this->dokumen->update($data_dokumen, $dokumen->id_dokumen);	
            }
            $dokumen = $this->dokumen->detail_by_data($data_dokumen);

            // DOKUMEN PERSETUJUAN
            $this->dokumen->generate_persetujuan($pengujis, $dokumen->id_dokumen, JENJANG_S2, $id_tesis, 0);
            //$dokumen_persetujuan = $this->dokumen->read_persetujuan($dokumen->id_dokumen);
            foreach ($pengujis as $penguji){
                $identitas = '';
                //foreach ($pengujis as $data) {
                $identitas = $penguji['nip'];
                //}

                $data_dokumen_persetujuan = [
                    'id_dokumen' => $dokumen->id_dokumen,
                    'identitas' => $identitas,
                    'jenis' => 0,
                ];

                $dokumen_persetujuan = $this->dokumen->detail_persetujuan_by_data($data_dokumen_persetujuan);

                $id_dokumen_persetujuan = $dokumen_persetujuan->id_dokumen_persetujuan;

                $data_persetujuan = [
                    'waktu' => date('Y-m-d H:i:s')
                ];
                $this->dokumen->update_persetujuan($data_persetujuan, $id_dokumen_persetujuan);
                //$this->session->set_flashdata('msg-title', 'alert-success');
                //$this->session->set_flashdata('msg', 'Persetujuan dokumen berhasil');
            }

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Persetujuan dokumen berhasil');
            redirect('dosen/tesis/proposal/status_ujian/' . $id_tesis);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/proposal/status_ujian/' . $id_tesis);
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
