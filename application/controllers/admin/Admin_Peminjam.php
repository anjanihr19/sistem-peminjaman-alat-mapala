<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Peminjam extends MY_Controller {

    public function __construct() {
        parent::__construct();

        // Pastikan admin sudah login
        if(!$this->session->userdata('logged_in') ||
           $this->session->userdata('role') != 'Admin') {
            redirect('login'); // Sesuaikan dengan route login Anda
        }

        $this->load->model('M_peminjam', 'peminjam');
        $this->load->library('pagination');
    }

    public function index() {
    $keyword = $this->input->get('keyword');

    $config['base_url'] = base_url('admin/peminjam');
    $config['total_rows'] = $this->peminjam->count_all($keyword); // Gunakan alias 'peminjam'
    $config['per_page'] = 7;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';
    
    // PENTING: Agar keyword pencarian tidak hilang saat klik halaman 2, 3, dst.
    $config['reuse_query_string'] = TRUE; 

    // --- Styling Pagination (Sesuai kode Anda sebelumnya) ---
    $config['full_tag_open'] = '<div class="pagination-modern">';
    $config['full_tag_close'] = '</div>';
    $config['num_tag_open'] = '<a class="page-num">';
    $config['num_tag_close'] = '</a>';
    $config['cur_tag_open'] = '<span class="page-num active">';
    $config['cur_tag_close'] = '</span>';
    $config['prev_link'] = FALSE;
    $config['next_link'] = FALSE;
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;

    $this->pagination->initialize($config);

    $start = $this->input->get('page');
    if(!$start) $start = 0;

    $data['peminjam'] = $this->peminjam->get_all_paginate($config['per_page'], $start, $keyword);
    $data['pagination'] = $this->pagination->create_links();
    $data['title'] = 'Data Peminjam';
    $data['start'] = $start;
    $data['keyword'] = $keyword;

    $this->load->view('admin/peminjam/index', $data);
}

    public function edit($id)
    {
        $data['title']    = 'Edit Peminjam';
        $data['peminjam'] = $this->peminjam->get_by_id($id);
        
        if (!$data['peminjam']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('admin/peminjam');
        }
        
        $this->load->view('admin/peminjam/edit', $data);
    }

    public function update($id)
    {   
        $nama = $this->input->post('nama_peminjam', true);
        
        $data_peminjam = [
            'nama_peminjam' => $nama,
            'alamat'        => $this->input->post('alamat', true),
            'no_hp'         => $this->input->post('no_hp', true),
            'institusi'     => $this->input->post('institusi', true),
        ];

        $this->db->trans_start();

        // Ambil info peminjam untuk mendapatkan id_users
        $peminjam = $this->peminjam->get_by_id($id);
        $id_users = $peminjam->id_users;

        // 1. Update tabel peminjam
        $this->peminjam->update($id, $data_peminjam);

        // 2. Update nama di tabel users (kolom: nama_user sesuai Gambar 1)
        $this->db->where('id_users', $id_users)
                 ->update('users', ['nama_user' => $nama]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal memperbarui data');
        } else {
            $this->session->set_flashdata('success', 'Data berhasil diupdate');
        }
        
        redirect('admin/peminjam');
    }

    public function hapus($id)
    {
        // Sebaiknya hapus juga akun di tabel users jika peminjam dihapus
        $peminjam = $this->peminjam->get_by_id($id);
        if ($peminjam) {
            $this->db->trans_start();
            $this->peminjam->delete($id);
            $this->db->where('id_users', $peminjam->id_users)->delete('users');
            $this->db->trans_complete();
            
            $this->session->set_flashdata('success','Data peminjam dan akun berhasil dihapus');
        }
        
        redirect('admin/peminjam');
    }

    // --- FITUR STATUS AKUN (Sesuai Gambar 1: status_akun enum) ---

    public function aktivasi($id) {
        // Update menggunakan id_users karena ini terkait tabel users
        $this->db->where('id_users', $id)->update('users', ['status_akun' => 'aktif']);
        $this->session->set_flashdata('success', 'Akun berhasil diaktifkan.');
        redirect('admin/peminjam');
    }

    public function nonaktif($id) {
        // Parameter kedua adalah string 'non-aktif' sesuai ENUM di database Anda
        $this->db->where('id_users', $id)->update('users', ['status_akun' => 'non-aktif']);
        $this->session->set_flashdata('success', 'Akun berhasil dinonaktifkan.');
        redirect('admin/peminjam');
    }

    public function reset_password($id) {
        $password_sementara = 'MYP' . rand(1000, 9999);
        $data_update = [
            'password'              => password_hash($password_sementara, PASSWORD_DEFAULT),
            'is_temporary_password' => 1 // Menandai password sementara sesuai Gambar 1
        ];
        
        $this->db->where('id_users', $id)->update('users', $data_update);
        $this->session->set_flashdata('success', 'Password direset menjadi: <b>' . $password_sementara . '</b>');
        redirect('admin/peminjam');
    }

    // --- FITUR KODE UNDANGAN ---

    public function kode_undangan() {
        $this->load->model('M_kode_undangan', 'm_kode');
        $data['title']         = 'Kelola Kode Undangan';
        $data['kode_undangan'] = $this->m_kode->get_all();
        $this->load->view('admin/peminjam/kode_undangan', $data);
    }

    public function generate_kode() {
        $this->load->model('M_kode_undangan', 'm_kode');
        $kode = strtoupper(substr(md5(rand()), 0, 8)); // Generate kode unik 8 karakter
        
        $data_insert = [
            'kode'       => $kode,
            'is_used'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('kode_undangan', $data_insert);
        $this->session->set_flashdata('success', 'Kode undangan baru berhasil dibuat: ' . $kode);
        redirect('admin/peminjam/kode_undangan');
    }
}