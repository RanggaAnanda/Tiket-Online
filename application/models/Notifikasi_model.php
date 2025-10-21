<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {

    public function buat($id_user, $pesan) 
    {
        $this->db->insert('notifikasi', [
            'id_user' => $id_user,
            'pesan' => $pesan,
            'status' => 'belum_dibaca'
        ]);
    }

    public function get_by_user($id_user) 
    {
        return $this->db->where('id_user', $id_user)
                        ->order_by('tanggal', 'DESC')
                        ->get('notifikasi')->result();
    }

    public function tandai_dibaca($id_user) 
    {
        $this->db->where('id_user', $id_user)
                 ->update('notifikasi', ['status' => 'dibaca']);
    }

    public function jumlah_belum_dibaca($id_user) 
    {
        return $this->db->where('id_user', $id_user)
                        ->where('status', 'belum_dibaca')
                        ->count_all_results('notifikasi');
    }
}
