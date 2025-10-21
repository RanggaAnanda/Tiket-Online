<?php defined('BASEPATH') OR exit('No direct script access allowed');

class konser_model extends CI_Model {

	public function create()
    {
        $data = array (
        'namakonser' => $this->input->post('namakonser'),
        'tanggal'    => $this->input->post('tanggal'),
        'lokasi'     => $this->input->post('lokasi'),
        'deskripsi'  => $this->input->post('deskripsi') // Tambahkan ini
    );

        // Upload foto
        if (!empty($_FILES['photo']['name'])) {
            $config['upload_path']   = './uploads/konser/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name']     = time() . '_' . $_FILES['photo']['name'];
                
            $this->load->library('upload', $config);

        if ($this->upload->do_upload('photo')) {
            $data['photo'] = $this->upload->data('file_name');
        }
    }

        $this->db->insert('konser', $data);
        return $this->db->insert_id(); // untuk ambil id_konser
    }


    public function read() //membatasi query halaman 
    {
        $query=$this->db->get('konser'); //mengambil data dari table petugas
        return $query->result(); //mengembalikan ke controller
    }

    public function read_by($id)
    {
        $this->db->where('id_konser', $id);
        $query=$this->db->get('konser'); //mengambil data dari table petugas
        return $query->row(); //hanya satu data 
    }

    public function update($id) 
    {
        $data = array (
            'namakonser' => $this->input->post('namakonser'),
            'tanggal'    => $this->input->post('tanggal'),
            'lokasi'     => $this->input->post('lokasi'),
            'deskripsi'  => $this->input->post('deskripsi'),
        );


        // Jika ada file foto yang diupload
          if (!empty($_FILES['photo']['name'])) {
        $config['upload_path']   = './uploads/konser/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name']     = time() . '_' . $_FILES['photo']['name'];
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('photo')) {
            // hapus foto lama
            $old = $this->read_by($id);
            if ($old && $old->photo && file_exists('./uploads/konser/' . $old->photo)) {
                unlink('./uploads/konser/' . $old->photo);
            }
            $data['photo'] = $this->upload->data('file_name');
        }
    }

        $this->db->where('id_konser', $id);
        $this->db->update('konser', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_konser',$id); //hapus data petugas dengan id 'sekian'
        $this->db->delete('konser');//run query
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('konser', ['id_konser' => $id])->row();
    }

    public function get_terbaru($limit = 3)
    {
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('konser')->result();
    }

    public function search_by_name($keyword)
    {
        $this->db->like('namakonser', $keyword);
        return $this->db->get('konser')->result();
    }

    public function get_all()
    {
        return $this->db->get('konser')->result();
    }


    
}