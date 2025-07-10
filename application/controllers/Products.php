<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('v_products');
    }

    public function ajax_list()
    {
        $keyword = $this->input->get('keyword');
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : 8;
        
        $offset = ($page - 1) * $limit;

        $products = $this->Product_model->get_paginated_products($keyword, $limit, $offset);
        $total_items = $this->Product_model->count_all_products($keyword);

        $response = [
            'status' => true,
            'products' => $products,
            'total_items' => $total_items,
            'current_page' => $page,
            'limit' => $limit
        ];

        $this->_json_output($response);
    }
    
    public function ajax_get($id)
    {
        $data = $this->Product_model->get_product_by_id($id);
        $this->_json_output($data);
    }

    public function ajax_add()
    {
        $hasilTambah = $this->Product_model->tambah_produk($this->input->post());
        if ($hasilTambah) {
            $this->_json_output(['status' => TRUE]);
        } else {
            $this->_json_output(['status' => FALSE, 'message' => 'Gagal menyimpan data.']);
        }
    }

    public function ajax_update()
    {
        $id = $this->input->post('id');
        $postData = $this->input->post();
        $fileData = $_FILES;

        $hasilUpdate = $this->Product_model->update_produk($id, $postData, $fileData);

        if (is_array($hasilUpdate) && isset($hasilUpdate['errors'])) {
            $this->output->set_status_header(400);
            $this->_json_output($hasilUpdate);
        } else if ($hasilUpdate === TRUE) {
            $this->_json_output(['status' => TRUE, 'message' => 'Produk berhasil diperbarui']);
        } else {
            $this->output->set_status_header(500);
            $this->_json_output(['status' => FALSE, 'message' => 'Gagal memperbarui produk']);
        }
    }

    public function ajax_delete($id)
    {
        $hasilHapus = $this->Product_model->hapus_produk($id);
        if ($hasilHapus) {
            $this->_json_output(['status' => TRUE]);
        } else {
            $this->_json_output(['status' => FALSE, 'message' => 'Gagal menghapus data.']);
        }
    }

    private function _json_output($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}