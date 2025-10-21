<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {


    public function insert($data) 
    {
    $this->db->insert('user', $data);
    }

    public function register($data)
    {
        return $this->db->insert('user', $data);
    }

    public function login($email)
    {
        return $this->db->get_where('user', ['email' => $email])->row();
    }

    public function get_by_email($email)
    {
        return $this->db->get_where('user', ['email' => $email])->row();
    }

}
