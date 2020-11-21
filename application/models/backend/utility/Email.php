<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends CI_Model {

    private $config;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        // Config
        $this->config = [
            'protocol' => 'sendmail',
            'mailpath' => '/usr/sbin/sendmail',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE,
            'mailtype' => 'html',
        ];
        // Load library
        $this->load->library('email');
    }

    function send_registration($email, $username, $password) {
        $this->email->initialize($this->config);
        $this->email->from('iuris@fh.unair.ac.id', 'IURIS Admin');
        $this->email->to($email);

        $this->email->subject('Informasi Akun');
        $this->email->message(
                '<p> Silahkan masuk menggunakan akun dibawah ini</p>'
                . '<p>'
                . 'Username : <b>' . $username . '</b><br/>'
                . 'Password : <b>' . $password . '</b><br/>'
                . '</p>'
                . '<p>Silahkan upload Bukti KRS pada menu <b>Verifikasi</b></p>'
                . '<p><b>Terima Kasih</b></p>'
        );

        $this->email->send();
    }

    function send_verified($email, $name) {
        $this->email->initialize($this->config);
        $this->email->from('iuris@fh.unair.ac.id', 'IURIS Admin');
        $this->email->to($email);

        $this->email->subject('Akun telah diverifikasi');
        $this->email->message(
                '<p> Dear, ' . $name . '</p>'
                . '<p>'
                . '<p>Akun Mahasiswa anda sudah berhasil diverifikasi</p>'
                . '<p><b>Terima Kasih</b></p>'
        );

        $this->email->send();
    }

}
