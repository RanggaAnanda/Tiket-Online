<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('text');
    }

    public function register()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email');

            // Cek apakah email sudah ada
            $cek = $this->User_model->get_by_email($email);
            if ($cek) {
                $this->session->set_flashdata('msg', '<p style="color:red">Email sudah terdaftar, gunakan email lain.</p>');
                redirect('auth/register');
                return;
            }

            // Lanjut registrasi
            $data = [
                'nama'     => $this->input->post('nama'),
                'email'    => $email,
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role'     => 'customer'
            ];

            $this->User_model->register($data);
            $this->session->set_flashdata('msg', '<p style="color:green">Registrasi Berhasil, Silahkan Login</p>');
            redirect('auth/login');
        }

        $this->load->view('auth/register');
    }



    public function login()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->login($email);

            if ($user && password_verify($password, $user->password)) {
                $this->session->set_userdata([
                    'id_user'   => $user->id_user,
                    'nama'      => $user->nama,
                    'email'     => $user->email, 
                    'role'      => $user->role,
                    'logged_in' => TRUE
                ]);
                redirect('auth/home_menu');
            } else {
                $this->session->set_flashdata('msg', 'Email atau Password salah!');
                redirect('auth/login');
            }
        }

        $this->load->view('auth/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function home_menu()
    {
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // Load model konser
        $this->load->model('konser_model');
        
        // Ambil 3 konser terbaru
        $data['konser_terbaru'] = $this->konser_model->get_terbaru(3);

        // Tampilkan view dengan data konser terbaru
        $this->load->view('auth/home_menu', $data);
    }



}
