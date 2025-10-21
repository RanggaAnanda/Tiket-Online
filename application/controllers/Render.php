<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Render extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Ciqrcode',$config);
        $this->load->library('Zend');
        $this->load->database();
    }

    public function index()
    {
        $data['title'] = 'belajar';
        $data['data'] = $this->db->get('tiket')->result();
        // echo "<pre>";
        // print_r($data['data']);
        // exit();
        // echo "</pre>";
        $this->load->view('render', $data);
    }

    public function QRcode($kodenya) {
        QRcode::png (
            $kodenya,
            $outfile = false,
            $level = 'QR_ECLEVEL_H',
            $size = 10,
            $margin = 4
        );
    }

    public function Barcode($kodenya) {
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128', 'image', array('text'=> $kodenya));
    }
}