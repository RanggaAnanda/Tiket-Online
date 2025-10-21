<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tiket_model extends CI_Model {

    public function insert_batch($data)
    {
        $this->db->insert_batch('tiket', $data);
    }

      public function read()
    {
        // Mengambil semua data dari tabel tiket
        return $this->db->get('tiket')->result();
    }

    public function read_by_konser($id_konser)
    {
        $this->db->where('id_konser', $id_konser);
        $query = $this->db->get('tiket');
        return $query->result();
    }

    
    public function get_by_id($id)
    {
        //return $this->db->get_where('pembelian', ['id_pembelian' => $id])->row();
        return $this->db->get_where('tiket', ['id_tiket' => $id])->row();
    }

    public function read_by_konser1($id_konser)
    {
        return $this->db->get_where('tiket', ['id_konser' => $id_konser])->result();
    }

        public function kurangi_stok($id_konser, $jenis_tiket, $jumlah) {
        $this->db->set('stok', 'stok - ' . (int)$jumlah, FALSE);
        $this->db->where('id_konser', $id_konser);
        $this->db->where('jenis_tiket', $jenis_tiket);
        $this->db->update('tiket');
    }

    public function update($id)
    {
        $data = array(
            'jenis_tiket' => $this->input->post('jenis_tiket'),
            'harga' => $this->input->post('harga'),
            'stok' => $this->input->post('stok'),
            'deskripsi' => $this->input->post('deskripsi')
        );

        $this->db->where('id_tiket', $id);
        return $this->db->update('tiket', $data);
    }

    public function delete_by_konser($id_konser)
    {
        $this->db->where('id_konser', $id_konser);
        $this->db->delete('tiket');
    }








}
