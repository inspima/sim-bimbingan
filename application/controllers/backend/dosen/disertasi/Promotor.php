<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Promotor extends CI_Controller {

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
        $this->load->model('backend/transaksi/disertasi', 'disertasi');
        $this->load->model('backend/administrator/master/struktural_model', 'struktural');
		$this->load->model('backend/utility/notification', 'notifikasi');
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    // KPS / PENASEHAT AKADEMIK

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Pengajuan Promotor',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/promotor/index',
            // DATA //
            'disertasi' => $this->disertasi->read_promotor(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setting() {
        $id_disertasi = $this->uri->segment('5');
        $data = array(
            // PAGE //
            'title' => 'Disertasi',
            'subtitle' => 'Setting - Promotor',
            'section' => 'backend/dosen/disertasi/promotor/setting',
            'use_back' => true,
            'back_link' => 'backend/dosen/disertasi/promotor/index',
            // DATA //
            'disertasi' => $this->disertasi->detail($id_disertasi),
            'mdosen' => $this->dosen->read_aktif_alldep(),
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $struktural = $this->struktural->read_struktural($this->session_data['username']);
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            if ($struktural->id_struktur == STRUKTUR_KPS_S3) {
                $data = array(
                    'status_promotor' => STATUS_DISERTASI_PROMOTOR_SETUJUI_KPS,
                );
            }
            $this->disertasi->update($data, $id_disertasi);
            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect_back();
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect_back();
        }
    }

	public function kirim_whatsapp()
	{
		$hand = $this->input->post('hand', true);
		if ($hand == 'center19') {
			$id_disertasi = $this->input->post('id_disertasi', true);
			$disertasi = $this->disertasi->detail($id_disertasi);
			$promotors = $this->disertasi->read_promotor_kopromotor($id_disertasi);
			$mhs = $this->user->read_mhs($disertasi->nim);
			foreach ($promotors as $promotor) {
				$judul_notifikasi = 'Permintaan Promotor/Ko-Promotor';
				$isi_notifikasi = 'Mohon kesediaanya untuk menjadi promotor/ko-promotor mahasiswa'
					. WA_LINE_BREAK . WA_LINE_BREAK . 'Nama :' . $mhs->nama
					. WA_LINE_BREAK . 'Nim :' . $disertasi->nim
					. WA_LINE_BREAK . 'Judul :' . $disertasi->judul
					. WA_LINE_BREAK . WA_LINE_BREAK . 'Pada sistem IURIS';
				$this->notifikasi->send($judul_notifikasi, $isi_notifikasi, 1, $promotor['nip']);
			}
			$this->session->set_flashdata('msg-title', 'alert-success');
			$this->session->set_flashdata('msg', 'Notifikasi whatsapp berhasil dikirim');
			redirect_back();
		} else {
			$this->session->set_flashdata('msg-title', 'alert-danger');
			$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
			redirect_back();
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
