<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // cek login & role
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
        $this->load->model('user_model');
    }

    public function tambah_admin() {
        $this->load->view('user/tambah_admin');
    }

    public function simpan_admin() {
        $username = $this->input->post('username');
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

        $data = [
            'nama' => $username,
            'password' => $password,
            'role'     => 'admin'
        ];

        $this->user_model->insert($data);
        $this->session->set_flashdata('msg', 'Admin berhasil ditambahkan!');
        redirect('user/tambah_admin');
    }
}
