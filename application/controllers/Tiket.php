<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Tiket extends CI_Controller {

     public function __construct() //akses paling pertama kali
    {
        parent::__construct(); //Memanggil konstruktor kelas induk
        $this->load->model('Tiket_model'); //mengelola data
    }

    public function index() //Daftar cat list
	{
        $data['tiket']=$this->Tiket_model->read(); //memanggil model read
        $this->load->view('tiket/tiket_list',$data);
	}

    public function add() //menerima inputan
    {
        if ($this->input->post('submit')) {

            $this->load->model('Tiket_model'); //mengelola data

            //fungsi create
            $this->Tiket_model->create();

            //perubahan query jika berhasil, jika query lebih dari 0 maka berhasil
            if($this->db->affected_rows()>0) {
                $this->session->set_flashdata('msg','<p style="color:green">Tiket successfult added!!</p>');
            } else {
                $this->session->set_flashdata('msg','<p style="color:red">Tiket add failed!!</p>');
            }

            //mengembalikan ke petugas list
            redirect('tiket');
        }
        $this->load->view('Tiket/form_tiket');
    }

    public function edit($id) //edit list berdasarkan id
    {
        if($this->input->post('submit')) {
            $this->Tiket_model->update($id);

            if($this->db->affected_rows()>0) {
                $this->session->set_flashdata('msg','<p style="color:green">Tiket successfult update!!</p>');
            } else {
                $this->session->set_flashdata('msg','<p style="color:red">Tiket update failed!!</p>');
            }

            redirect('tiket');
            } 

        $data['tic']=$this->Tiket_model->read_by($id);
        $this->load->view('tiket/form_tiket', $data);
    }

    public function delete($id) //parameter delete dengan fungsi id
    {
        $this->Tiket_model->delete($id);//memanggil model

        if($this->db->affected_rows()>0) {
            $this->session->set_flashdata('msg','<p style="color:green">Tiket successfult delete!!</p>');
        } else {
            $this->session->set_flashdata('msg','<p style="color:red">Tiket delete failed!!</p>');
        }

        redirect('tiket');
    }

    public function detail($id)
    {
        $data['tic'] = $this->Tiket_model->read_by($id);
        if (!$data['tic']) {
            show_404();
        }
        $this->load->view('tiket/detail', $data);
    }

    public function beli($id_tiket)
    {
        if ($this->input->post('submit')) {
            // Ambil data dari form
            $nama   = $this->input->post('nama');
            $nohp   = $this->input->post('nohp');
            $email  = $this->input->post('email');
            $tanggal_beli = date('Y-m-d');

            // Ambil data tiket dari database
            $tiket = $this->Tiket_model->read_by($id_tiket);
            $namakonser = $tiket->namakonser;

            // Simpan transaksi
            $this->Tiket_model->transaksi($id_tiket, $nama, $nohp, $email, $namakonser);

            // Redirect ke report atau halaman sukses
            redirect('tiket/transaksi');
        }

        // Tampilkan form beli tiket
        $data['tic'] = $this->Tiket_model->read_by($id_tiket);
        $this->load->view('tiket/form_beli', $data);
    }




    public function transaksi()
    {
        $data['tic'] = $this->Tiket_model->get_all_transaksi();
        $this->load->view('tiket/report', $data);
    }

}
