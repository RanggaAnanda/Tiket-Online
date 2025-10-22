<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('notifikasi_model');
    }

    public function index() 
    {
        $id_user = $this->session->userdata('id_user');
        $data['notifikasi'] = $this->notifikasi_model->get_by_user($id_user);
        $this->notifikasi_model->tandai_dibaca($id_user);
        $this->load->view('notifikasi/index', $data);
    }
}
