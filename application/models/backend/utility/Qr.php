<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Qr extends CI_Model {

    public $config;

    public function __construct() {
        parent::__construct();
        // LIBRARY
        $this->load->library('encryption');
        // QR
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $this->config['cacheable'] = true; //boolean, the default is true
        $this->config['cachedir'] = 'application/cache/'; //string, the default is application/cache/
        $this->config['errorlog'] = 'application/logs/'; //string, the default is application/logs/
        $this->config['imagedir'] = REAL_PATH_FILE_QR; //direktori penyimpanan qr code
        $this->config['quality'] = true; //boolean, the default is true
        $this->config['size'] = '1024'; //interger, the default is 1024
        $this->config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
        $this->config['white'] = array(70, 130, 180); // array, default is array(0,0,0)
    }

    private function generate_slug($string) {
        return strtoupper(str_replace(" ", FILE_NAME_DELIMITER, $string));
    }

    // DOKUMEN


    public function generateQrImageName($tipe, $jenis, $identitas, $tgl) {
        $result = '';
        $result .= $this->generate_slug($tipe);
        $result .= FILE_NAME_DELIMITER . $this->generate_slug($jenis);
        $result .= FILE_NAME_DELIMITER . $this->generate_slug($identitas);
        $result .= FILE_NAME_DELIMITER . date('dmy', strtotime($tgl)) . '.png';
        return $result;
    }

    public function generateQr($image_name, $content) {
        $this->ciqrcode->initialize($this->config);
        //buat name dari qr code sesuai dengan nip
        $params['data'] = $content; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $this->config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params);
    }

}
