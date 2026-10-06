<?php
class Login extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_in') && $this->session->userdata('role') == 'User') {
            redirect('user/dashboard');
        }
        $this->load->model('M_users', 'm_users');
    }

    public function index() {
        $this->load->view('auth/login');
    }

    public function proses_login() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $user = $this->m_users->lihat_username($username);

        if ($user && $user->role == 'User') {

            // ✅ Cek status akun
            if ($user->status_akun == 'non-aktif') {
                $this->session->set_flashdata('error', 'Akun Anda belum diaktifkan. Hubungi admin untuk mengaktifkan akun.');
                redirect('login');
            }

            if (password_verify($password, $user->password)) {
                $this->session->set_userdata([
                    'id_users'              => $user->id_users,
                    'nama_user'             => $user->nama_user,
                    'username'              => $user->username,
                    'role'                  => $user->role,
                    'logged_in'             => true,
                    'last_activity'         => time(),
                    'is_temporary_password' => $user->is_temporary_password,
                ]);

                // Cek apakah password masih sementara
                if ($user->is_temporary_password == 1) {
                    redirect('user/ganti_password');
                }

                redirect('user/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password Salah! Hubungi admin jika lupa password');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('error', 'Akun Peminjam tidak ditemukan!');
            redirect('login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
