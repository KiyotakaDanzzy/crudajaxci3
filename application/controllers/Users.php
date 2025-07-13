<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model', 'model');
    }

    public function login()
    {
        $this->load->view('v_login');
    }

    public function auth()
    {
        $data = $this->model->auth();
        echo json_encode($data);
    }

    public function logout()
    {
        $this->model->logout();
        redirect('users/login');
    }

    public function list()
    {
        $data = $this->model->list();
        echo json_encode($data);
    }

    public function tambah()
    {
        $data = $this->model->tambah();
        echo json_encode($data);
    }

    public function hapus()
    {
        $data = $this->model->hapus();
        echo json_encode($data);
    }
}