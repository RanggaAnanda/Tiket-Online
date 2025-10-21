<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konser extends CI_Controller {

    public function __construct() //akses paling pertama kali
    {
        parent::__construct(); //Memanggil konstruktor kelas induk
        $this->load->model('konser_model'); //mengelola data
        $this->load->helper('text');

    }

    public function index() //Daftar cat list
	{
        $data['konser']=$this->konser_model->read(); //memanggil model read
        $this->load->view('konser/list_konser',$data);
	}

    public function add()
    {
        if ($this->input->post('submit')) {
            $this->load->model('konser_model');
            $this->load->model('tiket_model');
            $this->load->model('notifikasi_model');

            // Simpan data konser
            $id_konser = $this->konser_model->create();

            // Ambil input tiket
            $jenis     = $this->input->post('jenis');
            $harga     = $this->input->post('harga');
            $stok      = $this->input->post('stok');
            $deskripsi = $this->input->post('deskripsi');

            $tiket_data = [];
            for ($i = 0; $i < count($jenis); $i++) {
                $tiket_data[] = [
                    'id_konser'   => $id_konser,
                    'jenis_tiket' => $jenis[$i],
                    'harga'       => $harga[$i],
                    'stok'        => $stok[$i],
                    'deskripsi'   => $deskripsi[$i]
                ];
            }

            // Simpan semua jenis tiket sekaligus
            $this->tiket_model->insert_batch($tiket_data);

            // Kirim notifikasi ke semua customer
            $users = $this->db->get_where('user', ['role' => 'customer'])->result();
            foreach ($users as $user) {
                $pesan = 'Konser baru "' . $this->input->post('namakonser') . '" telah tersedia!';
                $this->notifikasi_model->buat($user->id_user, $pesan);
            }

            $this->session->set_flashdata('msg', '<p style="color:green">Konser dan tiket berhasil disimpan!</p>');
            redirect('konser');
        }

        $this->load->view('konser/form_konser');
    }



    public function edit($id)
{
    $this->load->model('konser_model');
    $this->load->model('tiket_model');

    $data['k'] = $this->konser_model->get_by_id($id);
    $data['tiket'] = $this->tiket_model->read_by_konser($id);

    if ($this->input->post('submit')) {
        // Simpan perubahan konser
        $konserData = [
            'namakonser' => $this->input->post('namakonser'),
            'tanggal'    => $this->input->post('tanggal'),
            'lokasi'     => $this->input->post('lokasi'),
            'deskripsi'  => $this->input->post('deskripsi')
        ];
        $this->konser_model->update($id, $konserData);

        // Ambil input tiket
        $jenis = $this->input->post('jenis');
        $harga = $this->input->post('harga');
        $stok  = $this->input->post('stok');

        // Siapkan data baru
        $tiketBaru = [];
        for ($i = 0; $i < count($jenis); $i++) {
            $tiketBaru[] = [
                'id_konser'   => $id,
                'jenis_tiket' => $jenis[$i],
                'harga'       => $harga[$i],
                'stok'        => $stok[$i]
            ];
        }

        // Hapus tiket lama, masukkan tiket baru
        $this->tiket_model->delete_by_konser($id);
        $this->tiket_model->insert_batch($tiketBaru);

        redirect('konser');
    }

    $this->load->view('konser/form_konser', $data);
}



    public function delete($id) //parameter delete dengan fungsi id
    {
        $this->konser_model->delete($id);//memanggil model

        if($this->db->affected_rows()>0) {
            $this->session->set_flashdata('msg','<p style="color:green">konser successfult delete!!</p>');
        } else {
            $this->session->set_flashdata('msg','<p style="color:red">konser delete failed!!</p>');
        }

        redirect('konser');
    }

    public function detail($id)
    {
        $this->load->model('tiket_model');
        
        $data['konser'] = $this->konser_model->read_by($id);
        $data['tiket']  = $this->tiket_model->read_by_konser($id);

        $this->load->view('konser/detail_konser', $data);
    }

    public function search()
    {
        $q = $this->input->get('q');
        $data['konser_terbaru'] = $this->konser_model->search_by_name($q);
        $data['keyword'] = $q;
        $this->load->view('konser/search_result', $data);
    }



}
