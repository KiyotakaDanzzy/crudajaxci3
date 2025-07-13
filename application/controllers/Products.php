<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('users/login');
        }
        $this->load->model('Product_model', 'model');
    }

    public function index()
    {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('products/tampil');
        }
        $this->load->view('v_products');
    }

    public function tampil()
    {
        $this->load->view('v_product_tersedia');
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
        if ($this->session->userdata('role') !== 'admin') {
            echo json_encode(['status' => false, 'message' => 'Akses ditolak']);
            return;
        }
        $data = $this->model->tambah();
        echo json_encode($data);
    }

    public function edit()
    {
        if ($this->session->userdata('role') !== 'admin') {
            echo json_encode(['status' => false, 'message' => 'Akses ditolak']);
            return;
        }
        $data = $this->model->edit();
        echo json_encode($data);
    }

    public function hapus()
    {
        if ($this->session->userdata('role') !== 'admin') {
            echo json_encode(['status' => false, 'message' => 'Akses ditolak']);
            return;
        }
        $data = $this->model->hapus();
        echo json_encode($data);
    }
}