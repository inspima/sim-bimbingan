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
            'disertasi' => $this->disertasi->read_kualifikasi()
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function terima() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_disertasi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'status_kualifikasi' => 2,
            );
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
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
        if ($struktural->id_struktur == '9') {
            $id_disertasi = $this->uri->segment('5');

            $data = array(
                // PAGE //
                'title' => 'Disertasi - Kualifikasi',
                'subtitle' => 'Setting',
                'section' => 'backend/dosen/disertasi/kualifikasi/setting',
                'use_back' => true,
                'back_link' => 'backend/dosen/disertasi/kualifikasi',
                // DATA //
                'disertasi' => $this->disertasi->detail($id_disertasi),
                'mruang' => $this->ruang->read_aktif(),
                'mjam' => $this->jam->read_aktif(),
                'mdosen' => $this->dosen->read_aktif_alldep(),
                'ujian' => $this->disertasi->read_jadwal($id_disertasi, 1),
            );
            if ($data['disertasi']) {
                $this->load->view('backend/index_sidebar', $data);
            } else {
                $data['section'] = 'backend/notification/danger';
                $data['msg'] = 'Tidak ditemukan';
                $data['linkback'] = 'dosen/disertasi/kualifikasi';
                $this->load->view('backend/index_sidebar', $data);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardd');
        }
    }

    public function jadwal_save() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $struktural = $this->struktural->read_struktural($this->session_data['username']);
            if ($struktural->id_struktur == '9') {
                $id_disertasi = $this->input->post('id_disertasi', TRUE);
                $ujian = $this->disertasi->read_jadwal($id_disertasi, 1);

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
                            'status_kualifikasi' => 3,
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
                $ujian = $this->disertasi->read_ujian($id_disertasi);
                $tanggal = $ujian->tanggal;
                $id_jam = $ujian->id_jam;
                $pengujibentrok = $this->disertasi->read_pengujibentrok($tanggal, $id_jam, $nip);

                if ($pengujibentrok) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                    redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                } else {
                    $jumlah_penguji = $this->disertasi->count_penguji($id_ujian);
                    if ($jumlah_penguji < '7') {

                        $this->disertasi->save_penguji($data);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', $mesg);
                        redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                    } else
                    if ($jumlah_penguji >= '7') {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji sudah 7');
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
                $ketua = $this->disertasi->read_pengujiketua($id_ujian);
                if ($ketua) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal update tim penguji. Ketua sudah ada.');
                    redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                } else {
                    $this->disertasi->update_penguji($data, $id_penguji);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil set ketua penguji.');
                    redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
                }
            } else
            if ($data['status_tim'] == '2') {
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
        $struktural = $this->struktural->read_struktural($this->session_data['username']);
        $id_departemen = $struktural->id_departemen;
        $id_disertasi = $this->input->post('id_disertasi', TRUE);
        $proposal = $this->disertasi->detail($id_departemen, $id_disertasi);

        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {

            //CK INI
            $status_ujian = $this->input->post('status_ujian_proposal', TRUE);

            $data = array(
                'status_ujian_proposal' => $status_ujian,
            );
            $this->disertasi->update($data, $id_disertasi);

            //trigger
            if ($status_ujian == '0') { //belum ujian
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update proses');
                redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_disertasi);
            } else
            if ($status_ujian == '1') { //layak
                $cekskripsi = $this->disertasi->cekskripsi($proposal->nim);

                if ($cekskripsi) {
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil update proses');
                    redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_disertasi);
                } else {
                    //update proposal selesai
                    $data = array(
                        'status_kualifikasi' => 3
                    );
                    $this->disertasi->update($data, $id_disertasi);

                    // trigger ke skripsi
                    $datas = array(
                        'id_departemen' => $proposal->id_departemen,
                        'jenis' => 2,
                        'nim' => $proposal->nim,
                    );
                    $this->disertasi->save_skripsi($datas);
                    $last_id = $this->db->insert_id();

                    //trigger judul
                    $judul = $this->disertasi->read_judul($id_disertasi);
                    $dataj = array(
                        'id_disertasi' => $last_id,
                        'judul' => $judul->judul,
                    );

                    $this->disertasi->save_judul($dataj);

                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil update proses. Data akan diteruskan ke Proposal Skripsi Selesai.');
                    redirect('dashboardd/proposal/kadep_diterima');
                    //end sini
                }
            } else
            if ($status_ujian == '2') { //layak dengan catatan
                $cekskripsi = $this->disertasi->cekskripsi($proposal->nim);

                if ($cekskripsi) {
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil update proses');
                    redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_disertasi);
                } else {
                    //update proposal selesai
                    $data = array(
                        'status_kualifikasi' => 3
                    );
                    $this->disertasi->update($data, $id_disertasi);

                    // trigger ke skripsi
                    $datas = array(
                        'id_departemen' => $disertasi->id_departemen,
                        'jenis' => 2,
                        'nim' => $disertasi->nim,
                    );
                    $this->disertasi->save($datas);
                    $last_id = $this->db->insert_id();

                    //trigger judul
                    $judul = $this->disertasi->read_judul($id_disertasi);
                    $dataj = array(
                        'id_disertasi' => $last_id,
                        'judul' => $judul->judul,
                    );

                    $this->disertasi->save_judul($dataj);

                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil update proses. Data akan diteruskan ke Proposal Skripsi Selesai.');
                    redirect('dosen/disertasi/kualifikasi');
                    //end sini
                }
            } else
            if ($status_ujian == '3') { //tidak layak
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/kualifikasi/setting/' . $id_disertasi);
        }
    }

    // DOSEN PENGUJI

    public function penguji() {
        $data = array(
            // PAGE //
            'title' => 'Disertasi - Kualifikasi - Permintaan Dosen Penguji',
            'subtitle' => 'Data',
            'section' => 'backend/dosen/disertasi/kualifikasi/penguji',
            // DATA //
            'disertasi' => $this->disertasi->read_kualifikasi()
        );
        $this->load->view('backend/index_sidebar', $data);
    }

    public function penguji_setujui() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_penguji = $this->input->post('id_penguji', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);
            $id_disertasi = $this->input->post('id_disertasi', TRUE);

            $data = array(
                'status' => 2,
            );

            $this->disertasi->update_penguji($data, $id_penguji);

            $semua_penguji_setuju = $this->disertasi->semua_penguji_setuju($id_ujian);
            if ($semua_penguji_setuju) {
                $data = array(
                    'status_kualifikasi' => 4,
                );
                $this->disertasi->update($data, $id_disertasi);
            }

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil disetujui');
            redirect('dosen/disertasi/kualifikasi/penguji');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dosen/disertasi/kualifikasi/penguji');
        }
    }

}

?>