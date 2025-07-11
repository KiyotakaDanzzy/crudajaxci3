<?php
class Product_model extends CI_Model
{
    private $table = 'products';

    public function list()
    {
        $kataKunci = $this->input->get('kataKunci');
        $page = (int) $this->input->get('page') ?: 1;
        $limit = (int) $this->input->get('limit') ?: 8;
        $offset = ($page - 1) * $limit;

        $this->db->from($this->table);
        if (!empty($kataKunci)) {
            $this->db->group_start();
            $this->db->like('name', $kataKunci);
            // $this->db->or_like('description', $kataKunci);
            $this->db->group_end();
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $products = $this->db->get()->result();

        $this->db->from($this->table);
        if (!empty($kataKunci)) {
            $this->db->group_start();
            $this->db->like('name', $kataKunci);
            $this->db->or_like('description', $kataKunci);
            $this->db->group_end();
        }
        $total_items = $this->db->count_all_results();

        return [
            'status' => true,
            'products' => $products,
            'total_items' => $total_items,
            'current_page' => $page,
            'limit' => $limit
        ];
    }

    public function get()
    {
        $id = $this->input->post('id');
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function tambah()
    {
        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price' => $this->input->post('price'),
        ];

        $config['upload_path']   = './uploads/products/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 20480;

        $this->load->library('upload', $config);

        if (!empty($_FILES['image']['name']) && $this->upload->do_upload('image')) {
            $data['image'] = $this->upload->data('file_name');
        }

        $sukses = $this->db->insert($this->table, $data);

        return [
            'status' => $sukses,
            'message' => $sukses ? 'Produk berhasil ditambahkan' : 'Gagal menambahkan produk'
        ];
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price' => $this->input->post('price'),
        ];

        $this->load->library('form_validation');
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('name', 'Nama Produk', 'required|max_length[100]');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            return [
                'status' => false,
                'errors' => $this->form_validation->error_array()
            ];
        }

        if (!empty($_FILES['image']['name'])) {
            $old = $this->db->get_where($this->table, ['id' => $id])->row();
            if ($old && $old->image) {
                $oldPath = './uploads/products/' . $old->image;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $config['upload_path']   = './uploads/products/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['encrypt_name']  = TRUE;
            $config['max_size']      = 20480;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $data['image'] = $this->upload->data('file_name');
            }
        }

        $this->db->where('id', $id);
        $sukses = $this->db->update($this->table, $data);

        return [
            'status' => $sukses,
            'message' => $sukses ? 'Produk berhasil diperbarui' : 'Gagal memperbarui produk'
        ];
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $produk = $this->db->get_where($this->table, ['id' => $id])->row();

        $sukses = $this->db->delete($this->table, ['id' => $id]);

        if ($sukses && $produk && $produk->image) {
            $path = './uploads/products/' . $produk->image;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return [
            'status' => $sukses,
            'message' => $sukses ? 'Produk berhasil dihapus' : 'Gagal menghapus produk'
        ];
    }
}
