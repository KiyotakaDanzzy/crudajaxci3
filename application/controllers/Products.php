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
        $this->load->library('pagination');
    }

    public function index()
    {
        $this->load->view('v_products');
    }

    public function ajax_search()
    {
        $kata = $this->input->get('keyword');
        $data['products'] = $this->Product_model->ambil_semua_produk($kata);
        $this->load->view('ajax_product_cards', $data);
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

        if (is_array($hasilUpdate)) {
            $this->output->set_status_header(400);
            $this->_json_output($hasilUpdate);
        } else if ($hasilUpdate === TRUE) {
            $this->_json_output([
                'status' => TRUE,
                'message' => 'Produk berhasil diperbarui'
            ]);
        } else {
            $this->output->set_status_header(500);
            $this->_json_output([
                'status' => FALSE,
                'message' => 'Gagal memperbarui produk'
            ]);
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

    private function _validate()
    {
        $this->form_validation->set_rules('name', 'Nama Produk', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('price', 'Harga', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $errors = [
                'name'  => form_error('name'),
                'price' => form_error('price'),
            ];
            $this->output->set_status_header(400);
            $this->_json_output(['status' => FALSE, 'errors' => $errors]);
            exit();
        }
    }

    private function _json_output($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
