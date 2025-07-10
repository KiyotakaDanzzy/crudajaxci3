<?php
class Product_model extends CI_Model
{
    private $table = 'products';

    public function get_paginated_products($keyword = null, $limit = 10, $offset = 0)
    {
        $this->db->from($this->table);
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('name', $keyword);
            $this->db->or_like('description', $keyword);
            $this->db->group_end();
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_all_products($keyword = null)
    {
        $this->db->from($this->table);
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('name', $keyword);
            $this->db->or_like('description', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }
    
    public function get_product_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function update_produk($id, $postData, $fileData)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('name', 'Nama Produk', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('price', 'Harga', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE) {
            return ['status' => FALSE, 'errors' => $this->form_validation->error_array()];
        }

        $datauUpdate = [
            'name' => $postData['name'],
            'description' => $postData['description'],
            'price' => $postData['price'],
        ];

        if (!empty($fileData['image']['name'])) {
            $produkLama = $this->get_product_by_id($id);
            if ($produkLama && $produkLama->image) {
                $pathFileLama = './uploads/products/' . $produkLama->image;
                if (file_exists($pathFileLama)) {
                    unlink($pathFileLama);
                }
            }

            $config['upload_path']   = './uploads/products/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['encrypt_name']  = TRUE;
            $config['max_size']      = 20480;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $datauUpdate['image'] =  $this->upload->data('file_name');
            }
        }

        $this->db->where('id', $id);
        return $this->db->update('products', $datauUpdate);
    }

    public function hapus_produk($id)
    {
        $product = $this->get_product_by_id($id);
        $status_hapus = $this->db->delete('products', ['id' => $id]);

        if ($status_hapus && $product && $product->image) {
            $filePath = './uploads/products/' . $product->image;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        return $status_hapus;
    }

    public function tambah_produk($kirimData)
    {
        $datauSimpan = [
            'name' => $kirimData['name'],
            'description' => $kirimData['description'],
            'price' => $kirimData['price'],
        ];

        $config['upload_path']   = './uploads/products/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 20480;

        $this->load->library('upload', $config);

        if (!empty($_FILES['image']['name']) && $this->upload->do_upload('image')) {
            $datauSimpan['image'] =  $this->upload->data('file_name');
        }
        return $this->db->insert($this->table, $datauSimpan);
    }
}