<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'Admin') {
            $this->session->set_flashdata('error', 'Akses ditolak. Silakan login sebagai Admin.');
            redirect('admin/login');
        }
        $this->load->model('M_peminjaman', 'peminjaman');
        $this->load->model('M_alat', 'alat');
    }

    public function index() {
        $data = [
            'title' => 'Dashboard Admin',
            'user'  => [
                'nama'     => $this->session->userdata('nama_user'),
                'username' => $this->session->userdata('username'),
                'role'     => $this->session->userdata('role'),
            ],
            'menunggu'        => $this->db->where('status', 'Menunggu')->count_all_results('peminjaman'),
            'sedang_dipinjam' => $this->db->where('status', 'Dipinjam')->count_all_results('peminjaman'),
            'total_alat'      => $this->db->count_all('alat'),
            'stok_menipis'    => $this->db->where('jumlah <=', 3)->where('kondisi', 'Baik')->count_all_results('alat'),
            'alat_menipis'    => $this->db->select('nama_alat, kode_alat, jumlah')->where('jumlah <=', 3)->where('kondisi', 'Baik')->get('alat')->result(),
            'peminjaman_terbaru' => $this->peminjaman->get_all_paginate(5, 0),
        ];

        $this->load->view('layouts/admin_layout', $data);
    }

    public function update_akun() {
        $id       = $this->session->userdata('id_users');
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $data_update = ['username' => $username];

        if (!empty($password)) {
            $data_update['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->where('id_users', $id)->update('users', $data_update);
        $this->session->set_userdata('username', $username);
        $this->session->set_flashdata('success', 'Akun berhasil diperbarui!');
        redirect('admin/dashboard');
    }
}