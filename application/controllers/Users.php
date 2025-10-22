<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Users extends CI_Controller {

    public function __construct() //akses paling pertama kali
    {
        parent::__construct(); //Memanggil konstruktor kelas induk
        // if(! $this->session->userdata('username')) redirect('auth/login');
        // if ($this->session->userdata('usertype') != 'Manager') redirect ('welcome');
        $this->load->model('users_model'); //mengelola data
    }

    public function index() //Daftar user list
    {
        $data['users'] = $this->users_model->read();
        $this->load->view('users/user_list', $data);
    }

    public function add() //menerima inputan
    {
        if ($this->input->post('submit')) {
            $this->users_model->create(); //memanggil model

                //perubahan query jika berhasil, jika query lebih dari 0 maka berhasil
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('msg', '<p style="color:green">User successfully added!!</p>');
                } else {
                    $this->session->set_flashdata('msg', '<p style="color:red">User add failed!!</p>');
                }
                redirect('users'); //mengembalikan ke user list
            }
        $this->load->view('users/user_form');
    }

    public function edit($userid) //edit list berdasarkan id
    {
        if ($this->input->post('submit')) {
            $this->users_model->update($userid); //memanggil model
    
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('msg', '<p style="color:green">User successfully updated!!</p>');
                } else {
                    $this->session->set_flashdata('msg', '<p style="color:red">User update failed!!</p>');
                }
                redirect('users');
        }
        $data['user'] = $this->users_model->read_by($userid); // Use $userid instead of $id
        $this->load->view('users/user_form', $data);
    }

    public function delete($userid) //parameter delete dengan fungsi id
    {
        $this->users_model->delete($userid); //memanggil model

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('msg', '<p style="color:green">User successfully deleted!!</p>'); // Fixed typo
        } else {
            $this->session->set_flashdata('msg', '<p style="color:red">User delete failed!!</p>');
        }

        redirect('users');
}
}
