<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        if (strtolower($this->session->userdata('role')) != 'user') {
            redirect('admin/dashboard');
        }

        $this->load->model('M_peminjaman', 'peminjaman');
        $this->load->model('M_alat', 'alat');
        $this->load->model('M_users', 'm_users');
    }

    public function index() {
        $id_users = $this->session->userdata('id_users');

        $peminjam    = $this->db->get_where('peminjam', ['id_users' => $id_users])->row();
        $id_peminjam = $peminjam ? $peminjam->id_peminjam : 0;

        $data = [
            'title'             => 'Dashboard',
            'content'           => 'user/dashboard',
            'user'              => [
                'nama'      => $this->session->userdata('nama_user'),
                'username'  => $this->session->userdata('username'),
                'role'      => $this->session->userdata('role'),
                'institusi' => $peminjam ? $peminjam->institusi : '-',
                'no_hp'     => $peminjam ? $peminjam->no_hp : '-',
                'alamat'    => $peminjam ? $peminjam->alamat : '-',
            ],
            'total_peminjaman'  => $this->peminjaman->count_by_status($id_peminjam),
            'sedang_dipinjam'   => $this->peminjaman->count_by_status($id_peminjam, 'Dipinjam'),
            'menunggu'          => $this->peminjaman->count_by_status($id_peminjam, 'Menunggu'),
            // ✅ Baru — hitung menunggu konfirmasi user
            'menunggu_konfirmasi' => $this->peminjaman->count_menunggu_konfirmasi_user($id_peminjam),
            'alat_tersedia'     => $this->db->where('kondisi', 'Baik')->where('jumlah >', 0)->count_all_results('alat'),
            'riwayat_terbaru'   => $this->peminjaman->get_recent($id_peminjam, 5),
        ];

        $this->load->view('layouts/user_layout', $data);
    }

    // ✅ Baru — ubah password dari dashboard
    public function ubah_password() {
        $id_users     = $this->session->userdata('id_users');
        $password_lama = $this->input->post('password_lama', true);
        $password_baru = $this->input->post('password_baru', true);

        $user = $this->m_users->get_by_id($id_users);

        if (!password_verify($password_lama, $user->password)) {
            $this->session->set_flashdata('error', 'Password lama tidak sesuai.');
            redirect('user/dashboard');
        }

        if (strlen($password_baru) < 5) {
            $this->session->set_flashdata('error', 'Password baru minimal 5 karakter.');
            redirect('user/dashboard');
        }

        $this->m_users->ubah_password($id_users, $password_baru);
        $this->session->set_userdata('is_temporary_password', 0);
        $this->session->set_flashdata('success', 'Password berhasil diubah.');
        redirect('user/dashboard');
    }

    // ✅ Baru — halaman ganti password sementara
    public function ganti_password() {
        $data['title'] = 'Ganti Password';
        $this->load->view('user/ganti_password', $data);
    }

    // ✅ Baru — proses ganti password sementara
    public function proses_ganti_password() {
        $id_users      = $this->session->userdata('id_users');
        $password_baru = $this->input->post('password_baru', true);

        if (strlen($password_baru) < 5) {
            $this->session->set_flashdata('error', 'Password baru minimal 5 karakter.');
            redirect('user/ganti_password');
        }

        $this->m_users->ubah_password($id_users, $password_baru);
        $this->session->set_userdata('is_temporary_password', 0);
        $this->session->set_flashdata('success', 'Password berhasil diubah. Silakan login kembali.');
        $this->session->sess_destroy();
        redirect('login');
    }
}