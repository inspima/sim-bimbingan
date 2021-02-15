<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Judul extends CI_Controller {

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
        //$this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    // KPS / PENASEHAT AKADEMIK

    public function index() {
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $status_judul = STATUS_TESIS_JUDUL_PENGAJUAN;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Judul',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/judul/index',
            // DATA //
            'id_prodi' => $id_prodi,
            'tesis' => $this->tesis->read_judul_prodi_status($id_prodi, $status_judul),
            'prodi' => $this->tesis->read_prodi_s2(),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function disetujui() {
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $status_judul = STATUS_TESIS_JUDUL_SETUJUI_SPS;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Judul',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/judul/disetujui',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            //'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'id_prodi' => $id_prodi,
            'tesis' => $this->tesis->read_judul_prodi_status($id_prodi, $status_judul),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function ditolak() {
        //$id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $status_judul = STATUS_TESIS_JUDUL_DITOLAK;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Judul',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/judul/ditolak',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            //'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'id_prodi' => $id_prodi,
            'tesis' => $this->tesis->read_judul_prodi_status($id_prodi, $status_judul),
            'prodi' => $this->tesis->read_prodi_s2(),
            //'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function index_kabag() {
        $id_departemen = $this->dosen->detail($this->session_data['username'])->id_departemen;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Judul',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/judul/index_kabag',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'tesis' => $this->tesis->read_judul_departemen($id_departemen),
            'prodi' => $this->tesis->read_prodi_s2(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function index_kabag_pembimbing() {
        $id_departemen = $this->dosen->detail($this->session_data['username'])->id_departemen;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Judul',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/judul/index_kabag_pembimbing',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'tesis' => $this->tesis->read_judul_departemen_pembimbing($id_departemen),
            'prodi' => $this->tesis->read_prodi_s2(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function index_kps() {
        //$id_departemen = $this->dosen->detail($this->session_data['username'])->id_departemen;
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Judul',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/judul/index_kps',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'tesis' => $this->tesis->read_judul_prodi($id_prodi),
            'prodi' => $this->tesis->read_prodi_s2(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function index_kps_pembimbing() {
        //$id_departemen = $this->dosen->detail($this->session_data['username'])->id_departemen;
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        $data = array(
            // PAGE //
            'title' => 'Tesis - Judul',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/judul/index_kps_pembimbing',
            // DATA //
            //'tesis' => $this->tesis->read_proposal(),
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'tesis' => $this->tesis->read_judul_prodi_pembimbing($id_prodi),
            'prodi' => $this->tesis->read_prodi_s2(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting_pembimbing() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $username = $this->session_data['username'];

        $data = array(
            // PAGE //
            'title' => 'Tesis - Judul',
            'subtitle' => 'Setting Pembimbing',
            'section' => 'backend/dosen/tesis/judul/setting_pembimbing',
            // DATA //
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'departemen' => $this->departemen->read(),
            'minat' => $this->minat_tesis->read(),
            'gelombang' => $this->gelombang->read_berjalan(),
            'tesis' => $this->tesis->detail($id),
            'id_prodi' => $id_prodi,
        );

        if ($data['tesis']) {
            $this->load->view('backend/index_sidebar', $data);
        } else {
            $data['section'] = 'backend/notification/danger';
            $data['msg'] = 'Tidak ditemukan';
            $data['linkback'] = 'mahasiswa/tesis/judul';
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function setting_pembimbing_save() {
        $hand = $this->input->post('hand', TRUE);
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_prodi = $struktural->id_prodi;
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);

            $data = array(
                'nip_pembimbing_satu' => $this->input->post('nip_pembimbing_satu', TRUE),
            );
            $this->tesis->update($data, $id_tesis);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil update pembimbing utama');
            if($id_prodi != ''){
                redirect('dosen/tesis/judul/index_kps');
            }
            else {
                redirect('dosen/tesis/judul/index_kabag');
            }
            
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            if($id_prodi != ''){
                redirect('dosen/tesis/judul/index_kps');
            }
            else {
                redirect('dosen/tesis/judul/index_kabag');
            }
        }
    }

    public function setting_pembimbing_kedua() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $username = $this->session_data['username'];

        $data = array(
            // PAGE //
            'title' => 'Tesis - Judul',
            'subtitle' => 'Setting Pembimbing',
            'section' => 'backend/dosen/tesis/judul/setting_pembimbing_kedua',
            // DATA //
            'mdosen' => $this->dosen->read_aktif_alldep(),
            'departemen' => $this->departemen->read(),
            'minat' => $this->minat_tesis->read(),
            'gelombang' => $this->gelombang->read_berjalan(),
            'tesis' => $this->tesis->detail($id),
            'id_prodi' => $id_prodi,
        );

        if ($data['tesis']) {
            $this->load->view('backend/index_sidebar', $data);
        } else {
            $data['section'] = 'backend/notification/danger';
            $data['msg'] = 'Tidak ditemukan';
            $data['linkback'] = 'mahasiswa/tesis/judul';
            $this->load->view('backend/index_sidebar', $data);
        }
    }

    public function setting_pembimbing_kedua_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_tesis = $this->input->post('id_tesis', TRUE);
            $id_prodi = $this->tesis->cek_prodi($id_tesis);

            $data = array(
                'nip_pembimbing_dua' => $this->input->post('nip_pembimbing_dua', TRUE),
            );
            $this->tesis->update($data, $id_tesis);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil update pembimbing kedua');
            redirect('dosen/tesis/permintaan/pembimbing/'.$id_prodi);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/tesis/permintaan/pembimbing/'.$id_prodi);
        }
    }

    public function approve() {
        $id = $this->uri->segment(5);
        //$id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->approval_judul($id);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Judul disetujui');
        //redirect('dosen/tesis/judul/index/'.$id_prodi);
        redirect('dosen/tesis/judul/index');
    }

    
    public function reject() {
        $id = $this->input->post('id_tesis', TRUE);
        //$id_prodi = $this->tesis->cek_prodi($id);
        $keterangan = $this->input->post('keterangan', TRUE);
        $this->tesis->reject_judul($id, $keterangan);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Judul ditolak');
        //redirect('dosen/tesis/judul/index/'.$id_prodi);
        redirect('dosen/tesis/judul/index');
    }

    public function batal() {
        $id = $this->uri->segment(5);
        //$id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_judul($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Judul dibatalkan');
        //redirect('dosen/tesis/judul/index/'.$id_prodi);
        redirect('dosen/tesis/judul/index');
    }

    public function batal_pembimbing_utama() {
        $id = $this->uri->segment(5);
        //$id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_pembimbing($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Pembimbing utama dibatalkan');
        //redirect('dosen/tesis/judul/index/'.$id_prodi);
        redirect('dosen/tesis/judul/index_kabag_pembimbing');
    }

    public function pembimbing() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Pembimbing Proposal',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/judul/pembimbing',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),

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
        redirect('dosen/tesis/judul/pembimbing/'.$id_prodi);
    }

    public function reject_pembimbing() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->reject_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Pembimbing Proposal ditolak');
        redirect('dosen/tesis/judul/pembimbing/'.$id_prodi);
    }

    public function batal_pembimbing() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Pembimbing Proposal dibatalkan');
        redirect('dosen/tesis/judul/pembimbing/'.$id_prodi);
    }

}

?>
