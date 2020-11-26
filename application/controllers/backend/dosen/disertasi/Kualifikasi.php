<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kualifikasi extends CI_Controller {

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
        $this->load->model('backend/dosen/master/Dosen_model', 'dosen');
        //END MODEL
    }

    // KPS / PENASEHAT AKADEMIK

    public function index() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Kualifikasi',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/kualifikasi/index',
            // DATA //
            'disertasi' => $this->disertasi->read_kualifikasi(),
            'struktural' => $this->struktural->read_struktural($this->session_data['username']),
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

    public function setting() {
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
    }

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
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $ujian = $this->disertasi->read_jadwal($id_disertasi, UJIAN_DISERTASI_KUALIFIKASI);

            if (!empty($ujian)) { // JIKA SUDAH ADA
                //echo 'jadwal sudah ada. tambah script update';  die();
                $id_ujian = $this->input->post('id_ujian');

                $data = array(
                    'id_disertasi' => $id_disertasi,
                    'id_ruang' => $this->input->post('id_ruang', TRUE),
                    'id_jam' => $this->input->post('id_jam', TRUE),
                    'tanggal' => todb($this->input->post('tanggal', TRUE)),
                    'status' => 1,
                    'status_ujian' => 1
                );

                $cek_jadwal = $this->disertasi->cek_ruang_terpakai($data);

                if ($cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                } else {
                    $penguji = $this->disertasi->read_penguji($id_ujian);

                    if ($penguji) {
                        foreach ($penguji as $list) {
                            $bentrok = $this->disertasi->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
                            break;
                        }

                        if ($bentrok) {

                            $this->session->set_flashdata('msg-title', 'alert-danger');
                            $this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
                            redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                        } else {
                            $this->disertasi->update_ujian($data, $id_ujian);

                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                            redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                        }
                    } else { //langsung update
                        $this->disertasi->update_ujian($data, $id_ujian);

                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                        redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                    }
                }
            } else { //JIKA BELUM ADA SAVE BARU
                $data = array(
                    'id_disertasi' => $id_disertasi,
                    'id_ruang' => $this->input->post('id_ruang', TRUE),
                    'id_jam' => $this->input->post('id_jam', TRUE),
                    'tanggal' => todb($this->input->post('tanggal', TRUE)),
                    'jenis_ujian' => 1,
                    'status' => 1,
                    'status_ujian' => 1
                );

                $cek_jadwal = $this->disertasi->cek_ruang_terpakai($data);

                if ($cek_jadwal) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                    redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                } else {
                    $update_kualifikasi = array(
                        'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_DIJADWALKAN,
                    );
                    $this->disertasi->save_ujian($data);
                    $this->disertasi->update($update_kualifikasi, $id_disertasi);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
                    redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardd');
        }
    }

    public function penguji_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);
            $nip = $this->input->post('nip', TRUE);

            $data = array(
                'id_ujian' => $id_ujian,
                'nip' => $this->input->post('nip', TRUE),
                'status_tim' => 2,
                'status' => 1
            );

            $cekpenguji = $this->disertasi->cek_penguji($data);
            if ($cekpenguji) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar.');
                redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
            } else {
                $ujian = $this->disertasi->read_jadwal($id_disertasi, 1);
                $tanggal = $ujian->tanggal;
                $id_jam = $ujian->id_jam;
                $pengujibentrok = $this->disertasi->read_pengujibentrok($tanggal, $id_jam, $nip);

                if ($pengujibentrok) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                    redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                } else {
                    $jumlah_penguji = $this->disertasi->count_penguji($id_ujian);
                    if ($jumlah_penguji < MAX_PENGUJI_S3) {

                        $this->disertasi->save_penguji($data);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', "Berhasil simpan data");
                        redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                    } else
                    if ($jumlah_penguji >= MAX_PENGUJI_S3) {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji sudah melebihi jumlah maksimal');
                        redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                    }
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/kualifikasi');
        }
    }

    public function penguji_delete() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $id_penguji = $this->input->post('id_penguji', TRUE);

            $data = array(
                'status' => 0,
            );

            $this->disertasi->update_penguji($data, $id_penguji);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
            redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/kualifikasi');
        }
    }

    public function penguji_update_statustim() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $id_penguji = $this->input->post('id_penguji', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);

            $data = array(
                'status_tim' => $this->input->post('status_tim'),
            );
            if ($data['status_tim'] == '1') {
                //cek ketua
                $promotor = $this->disertasi->read_penguji_ketua($id_ujian);
                if (!empty($promotor)) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal update tim penguji. Ketua sudah ada.');
                    redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                } else {
                    $this->disertasi->update_penguji($data, $id_penguji);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil update penguji.');
                    redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                }
            } else {
                $this->disertasi->update_penguji($data, $id_penguji);
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update tim penguji.');
                redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/kualifikasi/setting');
        }
    }

    public function update_status_ujian() {
        $id_disertasi = $this->input->post('id_disertasi', TRUE);

        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {

            //CK INI
            $status_ujian = $this->input->post('status_ujian', TRUE);

            $data = array(
                'status_ujian_kualifikasi' => $status_ujian,
            );
            $this->disertasi->update($data, $id_disertasi);

            //trigger
            if ($status_ujian == '0') { //belum ujian
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update proses');
                redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
            } else if (in_array($status_ujian, [1, 2])) { //layak
                //update proposal selesai
                $data = array(
                    'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_UJIAN_SELESAI,
                    'status_ujian_kualifikasi' => $status_ujian,
                );
                $this->disertasi->update($data, $id_disertasi);

                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update proses. Data akan diteruskan ke Proses Selanjutnya.');
                redirect('dosen/disertasi/permintaan/penasehat');
            } else if ($status_ujian == '3') {
                $this->session->set_flashdata('msg-title', 'alert-warning');
                $this->session->set_flashdata('msg', 'Ujian ditolak');
                redirect('dosen/disertasi/permintaan/penasehat');
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
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
                    'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PROMOTOR,
                );
                $data = array(
                    'status_kualifikasi' => STATUS_DISERTASI_KUALIFIKASI_SELESAI,
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