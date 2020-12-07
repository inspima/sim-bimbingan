<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dokumen extends CI_Model {

    public function __construct() {
        parent::__construct();

        //START MODEL
        $this->load->model('backend/utility/qr', 'qrcode');
        //END MODEL
        // LIBRARY
        $this->load->library('encryption');
    }

    private function generate_slug($string) {
        return strtoupper(str_replace(" ", "-", $string));
    }

    // DOKUMEN

    public function generate_kode($tipe, $jenis, $identitas, $tgl) {
        $kode = '';
        $this->db->from('dokumen d');
        $this->db->where('d.status', 1);
        $count_dokumen = $this->db->count_all_results();
        $kode .= str_pad($count_dokumen + 1, 6, '0', STR_PAD_LEFT);
        $kode .= CODE_DELIMITER . $this->generate_slug($tipe);
        $kode .= CODE_DELIMITER . $this->generate_slug($jenis);
        $kode .= CODE_DELIMITER . $this->generate_slug($identitas);
        $kode .= CODE_DELIMITER . date('m/y', strtotime($tgl));
        return $kode;
    }

    public function detail($id) {
        $this->db->select('*');
        $this->db->from('dokumen');
        $this->db->where('id_dokumen', $id);
        $this->db->where('status', 1);

        $query = $this->db->get();
        return $query->row();
    }

    public function detail_by_data($data) {
        $this->db->select('*');
        $this->db->from('dokumen');
        $this->db->where('identitas', $data['identitas']);
        $this->db->where('tipe', $data['tipe']);
        $this->db->where('jenis', $data['jenis']);
        $this->db->where('status', 1);

        $query = $this->db->get();
        return $query->row();
    }

    public function save($data) {
        $this->db->insert('dokumen', $data);
    }

    public function update($data, $id) {
        $this->db->where('id_dokumen', $id);
        $this->db->update('dokumen', $data);
    }

    // DOKUMEN PERSETUJUAN

    public function generate_persetujuan($datas, $id_dokumen, $id_jenjang, $id_tugas_akhir, $jenis_persetujuan) {
        if ($id_jenjang == JENJANG_S3) {
            foreach ($datas as $data):
                $link_dokumen = base_url() . 'document/persetujuan?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tugas_akhir . '$' . $id_dokumen . '$' . $data['nip'] . '$' . $jenis_persetujuan;
                // QR
                $qr_image = $this->qrcode->generateQrImageName('Persetujuan Dokumen Berita Acara', 'Kualifikasi', $data['nip'], date('Y-m-d'));
                $qr_content = 'Persetujuan dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
                $this->qrcode->generateQr($qr_image, $qr_content);
                $data_dokumen_persetujuan = [
                    'id_dokumen' => $id_dokumen,
                    'identitas' => $data['nip'],
                    'nama' => $data['nama'],
                    'link' => $link_dokumen,
                    'jenis' => $jenis_persetujuan,
                    'qr_image' => PATH_FILE_QR . $qr_image,
                ];
                $dokumen_persetujuan = $this->detail_persetujuan_by_data($data_dokumen_persetujuan);
                if (empty($dokumen_persetujuan)) {
                    $this->save_persetujuan($data_dokumen_persetujuan);
                }
            endforeach;
        }
        if ($id_jenjang == JENJANG_S2) {
            foreach ($datas as $data):
                $link_dokumen = base_url() . 'document/persetujuan?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $id_tugas_akhir . '$' . $id_dokumen . '$' . $data['nip'] . '$' . $jenis_persetujuan;
                // QR
                $qr_image = $this->qrcode->generateQrImageName('Persetujuan Dokumen Berita Acara', 'Proposal', $data['nip'], date('Y-m-d'));
                $qr_content = 'Persetujuan dokumen ' . $link_dokumen; //data yang akan di jadikan QR CODE
                $this->qrcode->generateQr($qr_image, $qr_content);
                $data_dokumen_persetujuan = [
                    'id_dokumen' => $id_dokumen,
                    'identitas' => $data['nip'],
                    'nama' => $data['nama'],
                    'link' => $link_dokumen,
                    'jenis' => $jenis_persetujuan,
                    'qr_image' => PATH_FILE_QR . $qr_image,
                ];
                $dokumen_persetujuan = $this->detail_persetujuan_by_data($data_dokumen_persetujuan);
                if (empty($dokumen_persetujuan)) {
                    $this->save_persetujuan($data_dokumen_persetujuan);
                }
            endforeach;
        }
    }

    public function read_persetujuan($id_dokumen) {
        $this->db->select('*');
        $this->db->from('dokumen_persetujuan');
        $this->db->where('id_dokumen', $id_dokumen);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function detail_persetujuan_by_data($data) {
        $this->db->select('*');
        $this->db->from('dokumen_persetujuan');
        $this->db->where('identitas', $data['identitas']);
        $this->db->where('jenis', $data['jenis']);
        $this->db->where('id_dokumen', $data['id_dokumen']);

        $query = $this->db->get();
        return $query->row();
    }

    public function detail_persetujuan($id) {
        $this->db->select('*');
        $this->db->from('dokumen_persetujuan');
        $this->db->where('id_dokumen_persetujuan', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function save_persetujuan($data) {
        $this->db->insert('dokumen_persetujuan', $data);
    }

    public function update_persetujuan($data, $id) {
        $this->db->where('id_dokumen_persetujuan', $id);
        $this->db->update('dokumen_persetujuan', $data);
    }

}

?>
 