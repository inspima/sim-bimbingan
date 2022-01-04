<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan extends CI_Controller {

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
        $this->load->model('backend/administrator/master/ruang_model', 'ruang');
        $this->load->model('backend/administrator/master/jam_model', 'jam');
        $this->load->model('backend/baa/master/gelombang_model', 'gelombang');
        $this->load->model('backend/transaksi/tesis', 'tesis');
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    public function pembimbing() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Pembimbing',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/permintaan/pembimbing',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),

            'tesis' => $this->tesis->read_permintaan_pembimbing_prodi($this->session_data['username'], $id, 'pengajuan'),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function riwayat() {
        $id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->tesis->read_max_prodi_s2();
        $data = array(
            // PAGE //
            'title' => 'Tesis - Pembimbing',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/tesis/permintaan/riwayat',
            // DATA //
            'max_id_prodi' => $this->tesis->read_max_prodi_s2(),
            'prodi' => $this->tesis->read_prodi_s2(),

            'tesis' => $this->tesis->read_permintaan_pembimbing_prodi($this->session_data['username'], $id, 'riwayat'),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function approve_pembimbing() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->approval_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Pembimbing Proposal disetujui');
        redirect('dosen/tesis/permintaan/pembimbing/'.$id_prodi);
    }

    public function reject_pembimbing() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->reject_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Pembimbing Proposal ditolak');
        redirect('dosen/tesis/permintaan/pembimbing/'.$id_prodi);
    }

    public function batal_pembimbing() {
        $id = $this->uri->segment(5);
        $id_prodi = $this->tesis->cek_prodi($id);
        $this->tesis->batal_pembimbing_proposal($id);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Pembimbing Proposal dibatalkan');
        redirect('dosen/tesis/permintaan/pembimbing/'.$id_prodi);
    }

    public function bimbingan_proposal() {
        $id_tesis = $this->uri->segment('5');

        $username = $this->session_data['username'];

        $data = array(
            'title' => 'Tesis - Pembimbing',
            'subtitle' => 'Bimbingan :: Tesis - Proposal',
            'section' => 'backend/dosen/tesis/permintaan/bimbingan_proposal',
            'use_back' => true,
            'back_link' => 'mahasiswa/tesis/ujian',
            // DATA //            
            'bimbingan' => $this->tesis->read_bimbingan_tesis($id_tesis, UJIAN_TESIS_PROPOSAL),
            'tesis' => $this->tesis->detail($id_tesis),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function bimbingan_mkpt() {
        $id_tesis = $this->uri->segment('5');

        $username = $this->session_data['username'];

        $data = array(
            'title' => 'Tesis - Pembimbing',
            'subtitle' => 'Bimbingan :: Tesis - MKPT',
            'section' => 'backend/dosen/tesis/permintaan/bimbingan_mkpt',
            'use_back' => true,
            'back_link' => 'mahasiswa/tesis/ujian',
            // DATA //            
            'bimbingan' => $this->tesis->read_bimbingan_tesis($id_tesis, UJIAN_TESIS_MKPT),
            'tesis' => $this->tesis->detail($id_tesis),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function bimbingan_tesis() {
        $id_tesis = $this->uri->segment('5');

        $username = $this->session_data['username'];

        $data = array(
            'title' => 'Tesis - Pembimbing',
            'subtitle' => 'Bimbingan :: Tesis - Ujian',
            'section' => 'backend/dosen/tesis/permintaan/bimbingan_tesis',
            'use_back' => true,
            'back_link' => 'mahasiswa/tesis/ujian',
            // DATA //            
            'bimbingan' => $this->tesis->read_bimbingan_tesis($id_tesis, UJIAN_TESIS_UJIAN),
            'tesis' => $this->tesis->detail($id_tesis),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function approve_bimbingan() {
        $id_tesis = $this->uri->segment(5);
        $id_bimbingan = $this->uri->segment(6);
        $pembimbing = $this->uri->segment(7);
        $jenis_ujian = $this->uri->segment(8);
        $this->tesis->approval_bimbingan($id_bimbingan, $pembimbing);
        $this->session->set_flashdata('msg-title', 'alert-success');
        $this->session->set_flashdata('msg', 'Status Bimbingan disetujui');
        if($jenis_ujian == UJIAN_TESIS_PROPOSAL){
            redirect('dosen/tesis/permintaan/bimbingan_proposal/'.$id_tesis);
        }
        else if($jenis_ujian == UJIAN_TESIS_MKPT){
            redirect('dosen/tesis/permintaan/bimbingan_mkpt/'.$id_tesis);
        }
        else if($jenis_ujian == UJIAN_TESIS_UJIAN){
            redirect('dosen/tesis/permintaan/bimbingan_tesis/'.$id_tesis);
        }
    }

    public function reject_bimbingan() {
        $id_tesis = $this->uri->segment(5);
        $id_bimbingan = $this->uri->segment(6);
        $pembimbing = $this->uri->segment(7);
        $jenis_ujian = $this->uri->segment(8);
        $this->tesis->reject_bimbingan($id_bimbingan, $pembimbing);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Bimbingan ditolak');
        if($jenis_ujian == UJIAN_TESIS_PROPOSAL){
            redirect('dosen/tesis/permintaan/bimbingan_proposal/'.$id_tesis);
        }
        else if($jenis_ujian == UJIAN_TESIS_MKPT){
            redirect('dosen/tesis/permintaan/bimbingan_mkpt/'.$id_tesis);
        }
        else if($jenis_ujian == UJIAN_TESIS_UJIAN){
            redirect('dosen/tesis/permintaan/bimbingan_tesis/'.$id_tesis);
        }
    }

    public function batal_bimbingan() {
        $id_tesis = $this->uri->segment(5);
        $id_bimbingan = $this->uri->segment(6);
        $pembimbing = $this->uri->segment(7);
        $jenis_ujian = $this->uri->segment(8);
        $this->tesis->batal_bimbingan($id_bimbingan, $pembimbing);
        $this->session->set_flashdata('msg-title', 'alert-danger');
        $this->session->set_flashdata('msg', 'Status Bimbingan dibatalkan');
        if($jenis_ujian == UJIAN_TESIS_PROPOSAL){
            redirect('dosen/tesis/permintaan/bimbingan_proposal/'.$id_tesis);
        }
        else if($jenis_ujian == UJIAN_TESIS_MKPT){
            redirect('dosen/tesis/permintaan/bimbingan_mkpt/'.$id_tesis);
        }
        else if($jenis_ujian == UJIAN_TESIS_UJIAN){
            redirect('dosen/tesis/permintaan/bimbingan_tesis/'.$id_tesis);
        }
    }

}

?>
