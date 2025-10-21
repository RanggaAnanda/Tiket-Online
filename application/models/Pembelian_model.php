<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian_model extends CI_Model {

    public function insert($data)
    {
        $this->db->insert('pembelian', $data);
    }

    public function get_all()
    {
        $this->db->select('pembelian.*, tiket.jenis_tiket,konser.namakonser');
        $this->db->from('pembelian');
        $this->db->join('tiket', 'tiket.id_tiket = pembelian.id_tiket');
        return $this->db->get()->result();
    }

    public function get_pending()
    {
        $this->db->select('pembelian.*, user.nama as nama, tiket.jenis_tiket');
        $this->db->from('pembelian');
        $this->db->join('user', 'user.id_user = pembelian.id_user');
        $this->db->join('tiket', 'tiket.id_tiket = pembelian.id_tiket');
        $this->db->join('konser', 'konser.id_konser = tiket.id_konser');
        $this->db->where('pembelian.status', 'pending');
        $this->db->order_by('pembelian.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function update_status_pembayaran($id_pembelian, $status)
    {
        $this->db->where('id_pembelian', $id_pembelian);
        $this->db->update('pembelian', ['status' => $status]);
    }

    public function kurangi_stok($id_tiket, $jumlah)
    {
        $this->db->where('id_tiket', $id_tiket);
        $this->db->set('stok', 'stok - ' . (int) $jumlah, FALSE); // FALSE = biar gak di-escape
        $this->db->update('tiket');
    }

    public function get_by_id($id_pembelian)
    {
        $this->db->select('pembelian.*, konser.namakonser, konser.tanggal, konser.lokasi, konser.photo as poster, tiket.harga, tiket.jenis_tiket');

        $this->db->from('pembelian');
        $this->db->join('tiket', 'tiket.id_tiket = pembelian.id_tiket');
        $this->db->join('konser', 'konser.id_konser = tiket.id_konser');
        $this->db->where('pembelian.id_pembelian', $id_pembelian);
        return $this->db->get()->row();
    }


    public function get_by_user($id_user)
    {
        $this->db->select('pembelian.*, konser.namakonser, konser.tanggal, tiket.jenis_tiket');
        $this->db->from('pembelian');
        $this->db->join('tiket', 'tiket.id_tiket = pembelian.id_tiket');
        $this->db->join('konser', 'konser.id_konser = tiket.id_konser');
        $this->db->where('pembelian.id_user', $id_user);
        $this->db->order_by('pembelian.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function sale($id)
    {
        $data = array (
            'tanggal_beli' => $this->input->post('tanggal_beli'),
            'nama' => $this->input->post('nama'),
            'nohp' => $this->input->post('nohp'),   
            'email' => $this->input->post('email'),
            'namakonser' => $this->input->post('namakonser'),
            'id_tiket' => $id
        );
        $this->db->insert('report', $data);

        // Tambahkan update status
        $this->db->set('status', 'approve');
        $this->db->where('id_pembelian', $id);
        $this->db->update('pembelian');
    }

    public function sales($filter = [])
    {
        $this->db->select('pembelian.id_pembelian, pembelian.id_user, user.nama, pembelian.id_tiket, pembelian.jumlah, pembelian.tanggal, pembelian.status, konser.namakonser, tiket.harga');
        $this->db->from('pembelian');
        $this->db->join('user', 'user.id_user = pembelian.id_user');
        $this->db->join('tiket', 'tiket.id_tiket = pembelian.id_tiket');
        $this->db->join('konser', 'konser.id_konser = tiket.id_konser');

        // Filter by tanggal beli
        if (!empty($filter['tanggal_mulai'])) {
            $this->db->where('pembelian.tanggal >=', $filter['tanggal_mulai']);
        }
        if (!empty($filter['tanggal_selesai'])) {
            $this->db->where('pembelian.tanggal <=', $filter['tanggal_selesai']);
        }

        // Filter by status
        if (!empty($filter['status'])) {
            $this->db->where('pembelian.status', $filter['status']);
        }

        return $this->db->get()->result();
    }




    public function get_belum_bayar($id_user)
    {
        $this->db->select('pembelian.*, tiket.jenis_tiket, tiket.harga, konser.namakonser, konser.tanggal');
        $this->db->from('pembelian');
        $this->db->join('tiket', 'tiket.id_tiket = pembelian.id_tiket');
        $this->db->join('konser', 'konser.id_konser = pembelian.id_konser');
        $this->db->where('pembelian.id_user', $id_user);
        $this->db->where('pembelian.status', 'pending');
        $this->db->group_start(); // ( buka kurung
            $this->db->where('pembelian.bukti', null);
            $this->db->or_where('pembelian.bukti', '');
        $this->db->group_end(); // ) tutup kurung
        return $this->db->get()->result();
    }


    public function count_pending_verifikasi() {
        return $this->db->where('status', 'pending')->count_all_results('pembelian');
    }


    public function get_sales_filtered($tanggal_mulai = null, $tanggal_selesai = null, $status = null, $id_konser = null)
    {
        $this->db->select('pembelian.*, konser.namakonser, tiket.harga');
        $this->db->from('pembelian');
        $this->db->join('tiket', 'tiket.id_tiket = pembelian.id_tiket');
        $this->db->join('konser', 'konser.id_konser = pembelian.id_konser');

        if (!empty($tanggal_mulai)) {
            $this->db->where('DATE(pembelian.tanggal) >=', $tanggal_mulai);
        }
        if (!empty($tanggal_selesai)) {
            $this->db->where('DATE(pembelian.tanggal) <=', $tanggal_selesai);
        }
        if (!empty($status)) {
            $this->db->where('pembelian.status', $status);
        }
        if (!empty($id_konser)) {
            $this->db->where('pembelian.id_konser', $id_konser);
        }

        $this->db->order_by('pembelian.tanggal', 'DESC');
        return $this->db->get()->result();
    }



}
