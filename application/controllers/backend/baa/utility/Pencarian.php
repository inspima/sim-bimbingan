<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pencarian extends CI_Controller {

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
        $this->load->model('backend/user', 'user', TRUE);
        $this->load->model('backend/utility/email', 'email_model', TRUE);
        $this->load->model('backend/master/tugas_akhir', 'tugas_akhir', TRUE);
        $this->load->model('backend/transaksi/disertasi', 'disertasi', TRUE);
        $this->load->model('backend/transaksi/tesis', 'tesis', TRUE);
        $this->load->model('backend/transaksi/skripsi', 'skripsi', TRUE);
		$this->load->model('backend/dosen/master/Dosen_model', 'dosen');
		//END MODEL
    }

    public function index() {
        $search = $this->input->get('search', TRUE);
        if (!empty($search)) {
            $data = array(
                // PAGE //
                'title' => 'Modul Pencarian',
                'subtitle' => 'Mahasiswa',
                'section' => 'backend/baa/utility/pencarian',
                // DATA //
                'mahasiswas' => $this->user->read_mhs_cari($search),
				'search'=>$search,
            );
        } else {
            $data = array(
                // PAGE //
                'title' => 'Modul Pencarian',
                'subtitle' => 'Mahasiswa',
                'section' => 'backend/baa/utility/pencarian',
                // DATA //
                'mahasiswas' => [],
				'search'=>$search,
            );
        }

        $this->load->view('backend/index_sidebar', $data);
    }

    public function pembimbing_sarjana($id_skripsi){

		$search = $this->input->get('search', TRUE);
		$data = array(
			// PAGE //
			'title' => 'Sarjana',
			'subtitle' => 'Update Pembimbing',
			'section' => 'backend/baa/utility/pembimbing_sarjana',
			'use_back' => true,
			'back_link' => 'baa/utility/pencarian?search='.$search,
			// DATA //
			'id_skripsi'=>$id_skripsi,
			'mdosen' => $this->dosen->read_aktif_alldep(),
			'pembimbing' => $this->skripsi->read_pembimbing($id_skripsi),
		);
		$this->load->view('backend/index_sidebar', $data);
	}

	public function pembimbing_save()
	{
		$hand = $this->input->post('hand', true);
		if ($hand == 'center19') {
			$id_skripsi = $this->input->post('id_skripsi', true);
			$nip = $this->input->post('nip', true);

			$datap = array(
				'id_skripsi' => $id_skripsi,
				'nip' => $nip,
				'status' => 2,
				'status_bimbingan' => 2
			);

			$hitungbimbingan = $this->skripsi->hitung_bimbingan_aktif($nip);

			if ($hitungbimbingan < '10') {
				$cekpembimbing = $this->skripsi->cek_pembimbing($id_skripsi);

				if ($cekpembimbing) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', 'Gagal simpan. Pembimbing sudah ada.');
					redirect_back();
				} else {
					$this->skripsi->save_pembimbing($datap);
					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Berhasil simpan pembimbing');
					redirect_back();
				}
			} else if ($hitungbimbingan >= '10') {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Gagal simpan. Pembimbing sudah aktif 10 bimbingan.');
				redirect_back();
			}
		} else {
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect_back();
		}
	}

	public function pembimbing_delete()
	{
		$hand = $this->input->post('hand', true);
		if ($hand == 'center19') {
			$id_pembimbing = $this->input->post('id_pembimbing', true);

			$this->skripsi->delete_pembimbing($id_pembimbing);
			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Berhasil hapus pembimbing');
			redirect_back();
		} else {
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect_back();
		}
	}

}

?>
