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
            $id_skripsi = $this->input->post('id_disertasi', TRUE);
            $data = array(
                'status_kualifikasi' => 2,
            );
            $this->disertasi->update($data, $id_skripsi);

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
                // DATA //
                'disertasi' => $this->disertasi->detail($id_disertasi),
                'mruang' => $this->ruang->read_aktif(),
                'mjam' => $this->jam->read_aktif(),
                'mdosen' => $this->dosen->read_aktif_alldep(),
                'ujian' => $this->disertasi->read_jadwal($id_disertasi, 1),
                'pembimbing' => $this->disertasi->read_pembimbing($id_disertasi),
            );
            if ($data['disertasi']) {
                $this->load->view('backend/index_sidebar', $data);
            } else {
                $data['section'] = 'backend/notification/danger';
                $data['msg'] = 'Tidak ditemukan';
                $data['linkback'] = 'dashboardd/proposal/kadep_diterima';
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
            $id_departemen = $struktural->id_departemen;
            if ($struktural->id_struktur == '5') {
                $id_skripsi = $this->input->post('id_skripsi', TRUE);
                $ujian = $this->proposal->read_ujian($id_skripsi);

                if ($ujian) { // JIKA SUDAH ADA
                    //echo 'jadwal sudah ada. tambah script update';  die();
                    $id_ujian = $this->input->post('id_ujian');

                    $data = array(
                        'id_skripsi' => $id_skripsi,
                        'id_ruang' => $this->input->post('id_ruang', TRUE),
                        'id_jam' => $this->input->post('id_jam', TRUE),
                        'tanggal' => todb($this->input->post('tanggal', TRUE)),
                        'status' => 1,
                        'status_ujian' => 1
                    );

                    $cek_jadwal = $this->proposal->cek_ruang_terpakai($data);

                    if ($cek_jadwal) {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                        redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                    } else {
                        $penguji = $this->proposal->read_penguji($id_ujian);

                        if ($penguji) {
                            foreach ($penguji as $list) {
                                $bentrok = $this->proposal->read_pengujibentrok($data['tanggal'], $data['id_jam'], $list['nip']);
                                break;
                            }

                            if ($bentrok) {

                                $this->session->set_flashdata('msg-title', 'alert-danger');
                                $this->session->set_flashdata('msg', 'Gagal Ubah Jadwal. Penguji Sudah ada jadwal di tanggal dan jam sama');
                                redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                            } else {
                                $this->proposal->update_ujian($data, $id_ujian);

                                $this->session->set_flashdata('msg-title', 'alert-success');
                                $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                                redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                            }
                        } else { //langsung update
                            $this->proposal->update_ujian($data, $id_ujian);

                            $this->session->set_flashdata('msg-title', 'alert-success');
                            $this->session->set_flashdata('msg', 'Berhasil Ubah Jadwal.');
                            redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                        }
                    }
                } else { //JIKA BELUM ADA SAVE BARU
                    $data = array(
                        'id_skripsi' => $id_skripsi,
                        'id_ruang' => $this->input->post('id_ruang', TRUE),
                        'id_jam' => $this->input->post('id_jam', TRUE),
                        'tanggal' => todb($this->input->post('tanggal', TRUE)),
                        'jenis_ujian' => 1,
                        'status' => 1,
                        'status_ujian' => 1
                    );

                    $cek_jadwal = $this->proposal->cek_ruang_terpakai($data);

                    if ($cek_jadwal) {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Tanggal, Ruang dan Jam yang dipilih terpakai.');
                        redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                    } else {
                        $this->proposal->save_ujian($data);

                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', 'Berhasil Setting Jadwal.');
                        redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
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
            $id_skripsi = $this->input->post('id_skripsi', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);
            $nip = $this->input->post('nip', TRUE);

            $data = array(
                'id_ujian' => $id_ujian,
                'nip' => $this->input->post('nip', TRUE),
                'status_tim' => 2,
                'status' => 1
            );

            $cekpenguji = $this->proposal->cek_penguji($data);
            if ($cekpenguji) {
                $this->session->set_flashdata('msg-title', 'alert-danger');
                $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar.');
                redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
            } else {
                $ujian = $this->proposal->read_ujian($id_skripsi);
                $tanggal = $ujian->tanggal;
                $id_jam = $ujian->id_jam;
                $pengujibentrok = $this->proposal->read_pengujibentrok($tanggal, $id_jam, $nip);

                if ($pengujibentrok) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal simpan. Penguji sudah terdaftar di hari dan jam yang sama.');
                    redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                } else {
                    $jumlah_penguji = $this->proposal->count_penguji($id_ujian);
                    if ($jumlah_penguji < '3') {

                        // START EMAIL
                        /* $this->load->library('email');

                          $config['protocol'] = 'smtp';
                          $config['smtp_host'] = 'ssl://smtp.gmail.com';
                          $config['smtp_port'] = '465';
                          $config['smtp_user'] = 'usifhua@gmail.com';  //change it
                          $config['smtp_pass'] = 'hukum2012'; //change it
                          $config['charset'] = 'utf-8';
                          $config['newline'] = "\r\n";
                          $config['mailtype'] = 'html';
                          $config['wordwrap'] = TRUE;
                          $this->email->initialize($config);

                          $this->email->set_newline("\r\n");
                          $this->email->from('usifhua@gmail.com', 'IURIS');
                          //CHANGE
                          //$this->email->to('icocspa@fisip.unair.ac.id');
                          $this->email->to('rachmadkuncoro@gmail.com');
                          $this->email->subject('Ada Permintaan IURIS');

                          $msg = "Yth. Dosen<br>Mohon untuk membuka aplikasi iuris anda. Terdapat Penunjukan Penguji Skripsi.<br><br>Tertanda<br>Wakil Dekan I";

                          $this->email->message($msg);

                          if($this->email->send()) // IF EMAIL SUCCESS SEND
                          {
                          $mesg = 'Berhasil set penguji. Email berhasil dikirim.';
                          }
                          else // IF EMAIL GAGAL
                          {
                          $mesg = 'Berhasil set penguji. Email gagal dikirim.';
                          }
                         */

                        $this->proposal->save_penguji($data);
                        $this->session->set_flashdata('msg-title', 'alert-success');
                        $this->session->set_flashdata('msg', $mesg);
                        redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                    } else
                    if ($jumlah_penguji >= '3') {
                        $this->session->set_flashdata('msg-title', 'alert-danger');
                        $this->session->set_flashdata('msg', 'Gagal simpan. Jumlah penguji 3');
                        redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                    }
                }
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardd/proposal/kadep_diterima');
        }
    }

    public function penguji_delete() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_skripsi = $this->input->post('id_skripsi', TRUE);
            $id_penguji = $this->input->post('id_penguji', TRUE);

            $data = array(
                'status' => 0,
            );

            $this->proposal->update_penguji($data, $id_penguji);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil hapus penguji.');
            redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardd/proposal/kadep_diterima');
        }
    }

    public function penguji_update_statustim() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_skripsi = $this->input->post('id_skripsi', TRUE);
            $id_penguji = $this->input->post('id_penguji', TRUE);
            $id_ujian = $this->input->post('id_ujian', TRUE);

            $data = array(
                'status_tim' => $this->input->post('status_tim'),
            );
            if ($data['status_tim'] == '1') {
                //cek ketua
                $ketua = $this->proposal->read_pengujiketua($id_ujian);
                if ($ketua) {
                    $this->session->set_flashdata('msg-title', 'alert-danger');
                    $this->session->set_flashdata('msg', 'Gagal update tim penguji. Ketua sudah ada.');
                    redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                } else {
                    $this->proposal->update_penguji($data, $id_penguji);
                    $this->session->set_flashdata('msg-title', 'alert-success');
                    $this->session->set_flashdata('msg', 'Berhasil set ketua penguji.');
                    redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
                }
            } else
            if ($data['status_tim'] == '2') {
                $this->proposal->update_penguji($data, $id_penguji);
                $this->session->set_flashdata('msg-title', 'alert-success');
                $this->session->set_flashdata('msg', 'Berhasil update tim penguji.');
                redirect('dashboardd/proposal/kadep_diterima/plot/' . $id_skripsi);
            }
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardd/proposal/kadep_diterima');
        }
    }

    public function approve() {
        $hand = $this->input->post('hand', TRUE);
        if ($hand == 'center19') {
            $id_skripsi = $this->input->post('id_skripsi', TRUE);
            $gelombang_aktif = $this->gelombang->read_berjalan();

            $data = array(
                'status_skripsi' => 2,
                'id_gelombang' => $gelombang_aktif->id_gelombang
            );

            $this->skripsi->update($data, $id_skripsi);

            $this->session->set_flashdata('msg-title', 'alert-success');
            $this->session->set_flashdata('msg', 'Berhasil approve');
            redirect('dashboardb/skripsi/skripsi_pengajuan');
        } else {
            $this->session->set_flashdata('msg-title', 'alert-danger');
            $this->session->set_flashdata('msg', 'Terjadi Kesalahan');
            redirect('dashboardb/skripsi/skripsi_pengajuan');
        }
    }

    public function bimbingan() {
        $id = $this->uri->segment(5);
        $data = array(
            // PAGE //
            'title' => 'Modul (Mahasiswa)',
            'subtitle' => 'Bimbingan Skripsi',
            'section' => 'backend/baa/skripsi/skripsi_pengajuan_bimbingan',
            // DATA //
            'skripsi' => $this->skripsi->detail($id),
            'bimbingan' => $this->skripsi->read_bimbingan($id)
        );

        if ($data['skripsi']) {
            $this->load->view('backend/index_sidebar', $data);
        } else {
            $data['section'] = 'backend/notification/danger';
            $data['msg'] = 'Tidak ditemukan';
            $data['linkback'] = 'dashboardm/modul/skripsi';
            $this->load->view('backend/index_sidebar', $data);
        }
    }

}

?>