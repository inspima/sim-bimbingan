<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification extends CI_Model {

    private $config_whatsapp;
    public $element_whatsapp;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        // Init Config
        $this->config_whatsapp['api_key'] = '6tFAtU5SHUxbJ0KAgke5oqahfQP4szKB';
        $this->config_whatsapp['api_url'] = 'https://api.wanotif.id/v1/send';

        $this->element_whatsapp['new_line'] = '
‎';
        $this->element_whatsapp['bold'] = '*';
        $this->element_whatsapp['underline'] = '_';
        $this->element_whatsapp['italic'] = '_';
        //START MODEL
        $this->load->model('backend/user', 'user');
        //END MODEL
    }

    private function whatsapp_new_line($count) {
        $result = '';
        for ($i = 1; $i <= $count; $i++) {
            $result .= $this->element_whatsapp['new_line'];
        }
        return $result;
    }

    private function whatsapp_bold_text($text) {
        return $this->element_whatsapp['bold'] . $text . $this->element_whatsapp['bold'];
    }

    private function whatsapp_italic_text($text) {
        return $this->element_whatsapp['italic'] . $text . $this->element_whatsapp['italic'];
    }

    public function send_whatsapp($notifikasi) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->config_whatsapp['api_url']);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'Apikey' => $this->config_whatsapp['api_key'],
            'Phone' => $notifikasi['no_hp_tujuan'],
            'Message' => $this->whatsapp_bold_text($notifikasi['judul'])
            . $this->whatsapp_new_line(2) . 'Yth. ' . $notifikasi['nama_tujuan']
            . $this->whatsapp_new_line(2) . $notifikasi['isi']
            . $this->whatsapp_new_line(1) . $notifikasi['link']
            . $this->whatsapp_new_line(3) . "Atas Perhatianya"
            . $this->whatsapp_new_line(1) . "Terima Kasih"
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
    }

    public function send($judul, $isi, $jenis, $induk_tujuan, $link = '') {
        // Dosen / Tendik
        if ($jenis == '1') {
            $user = $this->user->read_user($induk_tujuan);
            $pegawai = $this->user->read_tendikdosen($user->username);
            $notifikasi = [
                'judul' => $judul,
                'isi' => $isi,
                'jenis' => $jenis,
                'id_tujuan' => $user->id_user,
                'no_induk_tujuan' => $user->username,
                'nama_tujuan' => $pegawai->nama,
                'no_hp_tujuan' => $user->no_hp,
                'link' => base_url() . $link,
                'waktu' => date('Y-m-d H:i:s')
            ];
            $this->save_notifikasi($notifikasi);
            $this->send_whatsapp($notifikasi);
        }
    }

    public function save_notifikasi($data) {
        $this->db->insert('notifikasi', $data);
    }

    public function update_notifikasi($data, $id) {
        $this->db->where('id_notifikasi', $id);
        $this->db->update('notifikasi', $data);
    }

}
