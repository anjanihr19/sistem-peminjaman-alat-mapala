<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->cek_session_timeout();
    }

    private function cek_session_timeout() {
        // Jika belum login, tidak perlu cek timeout
        if (!$this->session->userdata('logged_in')) {
            return;
        }

        $last_activity = $this->session->userdata('last_activity');
        $timeout       = 30 * 60; // 30 menit dalam detik

        if ($last_activity && (time() - $last_activity) > $timeout) {
            // Session expired — destroy dan redirect
            $role = $this->session->userdata('role');
            $this->session->sess_destroy();

            if ($role == 'Admin') {
                $this->session->set_flashdata('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
                redirect('admin/login');
            } else {
                $this->session->set_flashdata('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
                redirect('login');
            }
        }

        // Update last_activity setiap ada request
        $this->session->set_userdata('last_activity', time());
    }
}