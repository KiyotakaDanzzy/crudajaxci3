<?php
class Users_model extends CI_Model
{
    private $table = 'users';

    public function auth()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where($this->table, ['username' => $username])->row();

        if (!$user) {
            return ['status' => false, 'message' => 'Username tidak ada dalam data'];
        }

        if (!password_verify($password, $user->password)) {
            return ['status' => false, 'message' => 'Password salah'];
        }

        $this->session->set_userdata([
            'id_user' => $user->id_user,
            'username' => $user->username,
            'role' => $user->role,
            'logged_in' => true
        ]);

        return ['status' => true, 'role' => $user->role];
    }

    public function logout()
    {
        $this->session->sess_destroy();
    }

    public function list()
    {
        return $this->db->get($this->table)->result();
    }

    public function tambah()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[50]|is_unique[users.username]');

        if ($this->form_validation->run() == FALSE) {
            return [
                'status' => false,
                'errors' => $this->form_validation->error_array()
            ];
        }

        $data = [
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role' => $this->input->post('role')
        ];

        $this->db->insert($this->table, $data);

        return [
            'status' => true,
            'message' => 'Berhasil menambahkan user'
        ];
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $this->db->delete($this->table, ['id_user' => $id]);

        return [
            'status' => true,
            'message' => 'Berhasil menghapus user'
        ];
    }
}