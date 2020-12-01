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

        $data = array(

            // PAGE //

            'title' => 'Tesis - Ujian',

            'subtitle' => 'Data',

            'section' => 'backend/dosen/tesis/ujian/index',

            // DATA //

            'tesis' => $this->tesis->read_ujian(),

            'struktural' => $this->struktural->read_struktural($this->session_data['username']),

        );

        $this->load->view('backend/index_sidebar', $data);

    }



    public function terima() {

        $hand = $this->input->post('hand', TRUE);

        if ($hand == 'center19') {

            $struktural = $this->struktural->read_struktural($this->session_data['username']);

            $id_tesis = $this->input->post('id_tesis', TRUE);

            if ($struktural->id_struktur == STRUKTUR_SPS) {

                $data = array(

                    'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_SPS,

                );

            } else if ($struktural->id_struktur == STRUKTUR_KPS_S3) {



                $data = array(

                    'status_tesis' => STATUS_TESIS_UJIAN_SETUJUI_KPS,

                );



                $data = array(

                    'status_tesis' => STATUS_TESIS_UJIAN_SELESAI,

                );

            }

            $this->tesis->update($data, $id_tesis);



            $this->session->set_flashdata('msg-title', 'alert-success');

            $this->session->set_flashdata('msg', 'Berhasil approve');

            redirect('dosen/tesis/ujian');

        } else {

            $this->session->set_flashdata('msg-title', 'alert-danger');

            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');

            redirect('dosen/tesis/ujian');

        }

    }



}



?>