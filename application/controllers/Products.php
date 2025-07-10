<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model', 'model');
    }

    public function index()
    {
        $this->load->view('v_products');
    }

    public function list()
    {
        $data = $this->model->list();
        echo json_encode($data);
    }

    public function get()
    {
        $data = $this->model->get();
        echo json_encode($data);
    }

    public function tambah()
    {
        $data = $this->model->tambah();
        echo json_encode($data);
    }

    public function edit()
    {
        $data = $this->model->edit();
        echo json_encode($data);
    }

    public function hapus()
    {
        $data = $this->model->hapus();
        echo json_encode($data);
    }
}
