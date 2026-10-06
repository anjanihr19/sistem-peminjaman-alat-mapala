<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_kode_undangan', 'm_kode');
    }

    public function index() {
        $this->load->view('auth/register');
    }

    public function proses_daftar() {
        $this->form_validation->set_rules('nama_user', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('nomor_induk', 'Nomor Induk Anggota', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim');
        $this->form_validation->set_rules('institusi', 'Institusi', 'required|trim');
        $this->form_validation->set_rules('kode_undangan', 'Kode Undangan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('register');
        }
        // Tambahkan setelah validasi password
        $password      = $this->input->post('password', true);
        $konfirmasi    = $this->input->post('password_konfirmasi', true);

        if ($password !== $konfirmasi) {
            $this->session->set_flashdata('error', 'Password dan konfirmasi password tidak cocok.');
            redirect('register');
}
        // Validasi kode undangan
        $kode = $this->input->post('kode_undangan', true);
        $cek_kode = $this->m_kode->cek_kode($kode);

        if (!$cek_kode) {
            $this->session->set_flashdata('error', 'Kode undangan tidak valid atau sudah digunakan.');
            redirect('register');
        }

        $data_user = [
            'nama_user'     => $this->input->post('nama_user', true),
            'nomor_induk'   => $this->input->post('nomor_induk', true),
            'username'      => $this->input->post('username', true),
            'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role'          => 'User',
            'status_akun'   => 'non-aktif', // ✅ default non-aktif
        ];

        $this->db->trans_start();

        $this->db->insert('users', $data_user);
        $id_users = $this->db->insert_id();

        $data_peminjam = [
            'id_users'      => $id_users,
            'nama_peminjam' => $data_user['nama_user'],
            'alamat'        => $this->input->post('alamat', true),
            'no_hp'         => $this->input->post('no_hp', true),
            'institusi'     => $this->input->post('institusi', true),
        ];

        $this->db->insert('peminjam', $data_peminjam);

        // Tandai kode undangan sudah digunakan
        $this->m_kode->gunakan_kode($kode, $id_users);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem.');
            redirect('register');
        }

        $this->session->set_flashdata('success', 'Pendaftaran berhasil! Hubungi admin untuk mengaktifkan akun Anda.');
        redirect('login');
    }
}