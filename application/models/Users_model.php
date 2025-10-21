<?php defined('BASEPATH') OR exit('No direct script access allowed');

class users_model extends CI_Model {

    public function create()
    {
        $data = array (
            'username' => $this->input->post('username'),
            'fullname' => $this->input->post('fullname'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT) // Enkripsi password
            
        );
        $this->db->insert('users', $data);
    }

    public function read()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    public function read_by($userid)
    {
        $this->db->where('userid', $userid); // Gunakan $id
        $query = $this->db->get('users');
        return $query->row();
    }

    public function update($userid) 
    {
        $data = array (
            'username' => $this->input->post('username'),
            'fullname' => $this->input->post('fullname')
        );
        $this->db->where('userid', $userid); // Gunakan $userid
        $this->db->update('users', $data);
    }

    public function delete($userid)
    {
        $this->db->where('userid', $userid);
        $this->db->delete('users');
    }
}
