<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('konser_model');
        $this->load->model('tiket_model');
        $this->load->model('pembelian_model');
    }

    public function form($id_konser)
    {
        $data['konser'] = $this->konser_model->read_by($id_konser);
        $data['tiket']  = $this->tiket_model->read_by_konser($id_konser);
        $this->load->view('pembelian/form_pembelian', $data);
    }

    public function beli($id_konser)
    {
        if ($this->input->post('submit')) {
            $id_tiket = $this->input->post('id_tiket');
            $jumlah_array = $this->input->post('jumlah');
            $jumlah = isset($jumlah_array[$id_tiket]) ? (int)$jumlah_array[$id_tiket] : 0;

            $id_user = $this->session->userdata('id_user');
            if (!$id_user) {
                $this->session->set_flashdata('msg', '<p style="color:red">Silakan login dulu sebelum beli tiket.</p>');
                redirect('auth/login');
                return;
            }

            if ($jumlah <= 0) {
                $this->session->set_flashdata('msg', '<p style="color:red">Jumlah pembelian tidak valid.</p>');
                redirect('pembelian/form/' . $id_konser);
                return;
            }

            $tiket = $this->tiket_model->get_by_id($id_tiket);
            if (!$tiket || $jumlah > $tiket->stok) {
                $this->session->set_flashdata('msg', '<p style="color:red">Stok tidak mencukupi!</p>');
                redirect('pembelian/form/' . $id_konser);
                return;
            }

            $konser = $this->konser_model->read_by($id_konser);

            $kode = uniqid('TIKET');
            $data = [
                'nama'       => $this->input->post('nama'),
                'id_tiket'   => $id_tiket,
                'id_konser'  => $id_konser, // Tambahan fix
                'namakonser' => $konser->namakonser,
                'jumlah'     => $jumlah,
                'tanggal'    => date('Y-m-d H:i:s'),
                'status'     => 'pending',
                'id_user'    => $id_user,
                'kode'       => $kode,
            ];
            $this->pembelian_model->insert($data);

            $id_pembelian = $this->db->insert_id();
            if ($id_pembelian == 0) {
                $this->session->set_flashdata('msg', '<p style="color:red">Gagal menyimpan data pembelian.</p>');
                redirect('pembelian/form/' . $id_konser);
                return;
            }

            $this->pembelian_model->kurangi_stok($id_tiket, $jumlah);
            redirect('pembelian/pembayaran/' . $id_pembelian);
        }
    }

    public function pembayaran($id_pembelian)
    {
        $pembelian = $this->pembelian_model->get_by_id($id_pembelian);
        $tiket = $this->tiket_model->get_by_id($pembelian->id_tiket);
        $pembelian->harga = ($tiket && isset($tiket->harga)) ? $tiket->harga : 0;

        $data['pembelian'] = $pembelian;
        $data['tiket'] = $tiket;
        $data['title'] = 'Konfirmasi Pembayaran Tiket';
        $this->load->view('pembelian/pembayaran', $data);
    }

    public function upload_bukti($id_pembelian)
    {
        $config['upload_path']   = './uploads/bukti/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size']      = 2048;
        $config['file_name']     = 'bukti_' . $id_pembelian . '_' . time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bukti')) {
            $this->session->set_flashdata('msg', $this->upload->display_errors());
            redirect('pembelian/konfirmasi/' . $id_pembelian);
        } else {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            $this->db->where('id_pembelian', $id_pembelian);
            $this->db->update('pembelian', [
                'bukti' => $file_name,
                'status' => 'pending'
            ]);

            $this->session->set_flashdata('msg', '<p style="color:green">Bukti pembayaran berhasil diupload!</p>');
            redirect('pembelian/riwayat');
        }
    }

    public function verifikasi_pembayaran()
    {
        if ($this->session->userdata('role') != 'admin') {
            show_error('Hanya admin yang bisa mengakses halaman ini', 403);
        }

        $data['list'] = $this->pembelian_model->get_pending();
        $this->load->view('user/verifikasi_pembayaran', $data);
    }

    public function acc($id_pembelian)
    {
        if ($this->session->userdata('role') != 'admin') {
            show_error('Forbidden', 403);
        }

        $this->db->update('pembelian', ['status' => 'approved'], ['id_pembelian' => $id_pembelian]);
        $this->load->model('notifikasi_model');

        // Ambil pembelian
        $pembelian = $this->pembelian_model->get_by_id($id_pembelian);
        $pesan = 'Pembayaran tiket "' . $pembelian->namakonser . '" telah disetujui. Tiket siap dicetak!';
        $this->notifikasi_model->buat($pembelian->id_user, $pesan);

        $this->session->set_flashdata('msg', 'Pembayaran berhasil diverifikasi.');
        redirect('pembelian/verifikasi_pembayaran');
    }

    public function tolak($id_pembelian)
    {
        if ($this->session->userdata('role') != 'admin') {
            show_error('Forbidden', 403);
        }

        $this->db->update('pembelian', ['status' => 'rejected'], ['id_pembelian' => $id_pembelian]);
        $this->session->set_flashdata('msg', 'Pembayaran ditolak.');
        redirect('pembelian/verifikasi_pembayaran');
    }

    public function riwayat()
    {
        if (!$this->session->userdata('email')) {
            redirect('auth/login');
        }

        if ($this->session->userdata('role') != 'customer') {
            show_error('Halaman ini hanya bisa diakses oleh customer.', 403);
        }

        $id_user = $this->session->userdata('id_user');
        $data['riwayat'] = $this->pembelian_model->get_by_user($id_user);
        $this->load->view('pembelian/riwayat', $data);
    }

    public function cetak($id_pembelian)
    {
        $this->load->model('Pembelian_model');
        $this->load->library('ciqrcode');

        $data['pembelian'] = $this->Pembelian_model->get_by_id($id_pembelian);

        // QR data
        $qr_code_text = "Tiket: " . strtoupper(substr(md5($id_pembelian), 0, 8));

        $params['data'] = $qr_code_text;
        $params['level'] = 'H';
        $params['size'] = 6;
        $qr_image_name = 'qrcode_' . $id_pembelian . '.png';
        $params['savename'] = FCPATH . 'uploads/qrcodes/' . $qr_image_name;
        $this->ciqrcode->generate($params);

        $data['qr_image'] = base_url('uploads/qrcodes/' . $qr_image_name);
        $this->load->view('pembelian/cetak_tiket', $data);
    }



    public function sale($id) // penjualan
    {
        if ($this->input->post('submit')) {
            $this->pembelian_model->sale($id);

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg','<p style="color:green">Tiket successfully sold!</p>');
            } else {
                $this->session->set_flashdata('msg','<p style="color:red">Tiket sale failed!</p>');
            }
            redirect('pembelian');
        }

        $data['sale'] = $this->pembelian_model->get_by_id($id); // diperbaiki
        $this->load->view('pembelian/form_pembelian', $data);
    }

    public function sales()
    {
        $this->load->model('konser_model');
        $data['list_konser'] = $this->konser_model->get_all(); // ambil semua konser

        // ambil filter GET
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_selesai = $this->input->get('tanggal_selesai');
        $status         = $this->input->get('status');
        $id_konser      = $this->input->get('id_konser');

        $data['sales'] = $this->pembelian_model->get_sales_filtered($tanggal_mulai, $tanggal_selesai, $status, $id_konser);
        $this->load->view('pembelian/report', $data);
    }


    public function belum_bayar()
    {
        $id_user = $this->session->userdata('id_user');
        $this->load->model('pembelian_model');
        $data['belum_bayar'] = $this->pembelian_model->get_belum_bayar($id_user);
        $this->load->view('pembelian/tiket_belum_bayar', $data);
    }

    public function cancel($id_pembelian)
    {
        $id_user = $this->session->userdata('id_user');

        // Cek apakah pembelian milik user dan masih pending
        $pembelian = $this->pembelian_model->get_by_id($id_pembelian);
        if (!$pembelian || $pembelian->id_user != $id_user || $pembelian->status != 'pending') {
            show_error('Pembatalan tidak valid.');
        }

        // Update status menjadi cancelled
        $this->db->where('id_pembelian', $id_pembelian);
        $this->db->update('pembelian', ['status' => 'cancelled']);

        $this->session->set_flashdata('success', 'Pesanan berhasil dibatalkan.');
        redirect('pembelian/belum_bayar');
    }

    public function cetak_pdf($id)
    {
        $this->load->library('Dompdf_gen');
        $data['pembelian'] = $this->pembelian_model->get_by_id($id);

        $html = $this->load->view('pembelian/cetak_tiket_pdf', $data, true);
        $this->dompdf_gen->generate($html, 'E-Tiket_' . $id, true, 'A4', 'portrait');
    }


}
