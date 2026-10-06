<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Login extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in') && $this->session->userdata('role') == 'Admin') {
            redirect('admin/dashboard');
        }
        if($this->session->userdata('logged_in') && $this->session->userdata('role') == 'User') {
            redirect('user/dashboard');
        }
        $this->load->model('M_users', 'm_users');
    }

    public function index() {
        $this->load->view('auth/admin_login');
    }

    public function proses_login() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $user = $this->m_users->lihat_username($username);

        if ($user && $user->role == 'Admin') {
            // ✅ Gunakan password_verify (bukan plain text comparison)
            if (password_verify($password, $user->password)) {
                $this->session->set_userdata([
                    'id_users'  => $user->id_users,
                    'nama_user' => $user->nama_user,
                    'username'  => $user->username,
                    'role'      => 'Admin',
                    'logged_in' => TRUE,
                    'last_activity' => time(),
                ]);
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password Admin Salah!');
                redirect('admin/login');
            }
        } else {
            $this->session->set_flashdata('error', 'Akses Ditolak! Anda bukan Admin.');
            redirect('admin/login');
        }
    }
}