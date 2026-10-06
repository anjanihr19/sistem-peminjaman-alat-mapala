<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') != 'User') {
            redirect('login');
        }

        $this->load->model('M_peminjaman', 'peminjaman');
        $this->load->model('M_alat', 'alat');
    }

    // Form tambah peminjaman
    public function tambah($id_alat) {
        $alat = $this->alat->get_by_id($id_alat);

        if (!$alat) {
            $this->session->set_flashdata('error', 'Alat tidak ditemukan.');
            redirect('user/alat');
        }

        $data = [
            'title' => 'Form Peminjaman',
            'alat'  => $alat,
        ];

        $this->load->view('user/peminjaman/tambah', $data);
    }

    public function simpan() {
        $id_users    = $this->session->userdata('id_users');
        $id_alat     = $this->input->post('id_alat', true);
        $jml_alat    = (int)$this->input->post('jml_alat', true);
        $tgl_pinjam  = $this->input->post('tgl_pinjam', true);
        $tgl_kembali = $this->input->post('tgl_kembali', true);

        // ✅ Validasi tanggal kembali tidak boleh sebelum tanggal pinjam
        if ($tgl_kembali < $tgl_pinjam) {
            $this->session->set_flashdata('error', 'Tanggal kembali tidak boleh sebelum tanggal pinjam.');
            redirect('user/peminjaman/tambah/' . $id_alat);
        }

        // ✅ Ambil data alat
        $alat = $this->alat->get_by_id($id_alat);

        if (!$alat) {
            $this->session->set_flashdata('error', 'Alat tidak ditemukan.');
            redirect('user/alat');
        }

        // ✅ Hitung stok tersedia pada rentang tanggal
        $total_dipinjam  = $this->peminjaman->get_total_dipinjam($id_alat, $tgl_pinjam, $tgl_kembali);
        $stok_tersedia   = $alat->jumlah - $total_dipinjam;

        if ($jml_alat > $stok_tersedia) {
            $this->session->set_flashdata('error', 
                'Stok tidak mencukupi pada tanggal tersebut. ' .
                'Tersedia: <strong>' . $stok_tersedia . ' unit</strong> ' .
                'dari ' . $alat->jumlah . ' unit total.'
            );
            redirect('user/peminjaman/tambah/' . $id_alat);
        }

        // ✅ Ambil id_peminjam
        $peminjam = $this->db->get_where('peminjam', ['id_users' => $id_users])->row();

        if (!$peminjam) {
            $this->session->set_flashdata('error', 'Data peminjam tidak ditemukan.');
            redirect('user/alat');
        }

        // ✅ Ambil id_admin
        $admin = $this->db->get_where('users', ['role' => 'Admin'])->row();

        $data = [
            'id_peminjam'  => $peminjam->id_peminjam,
            'id_alat'      => $id_alat,
            'tgl_pinjam'   => $tgl_pinjam,
            'tgl_kembali'  => $tgl_kembali,
            'jml_alat'     => $jml_alat,
            'status'       => 'Menunggu',
            'id_admin'     => $admin ? $admin->id_users : NULL,
        ];

        $this->peminjaman->insert($data);
        $this->session->set_flashdata('success', 
            'Peminjaman berhasil diajukan! Silakan tunggu konfirmasi admin.'
        );
        redirect('user/peminjaman/riwayat');
    }

    public function batal($id) {
        $id_users = $this->session->userdata('id_users');

        // Ambil data peminjaman
        $peminjaman = $this->peminjaman->get_by_id($id);

        if (!$peminjaman) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan.');
            redirect('user/peminjaman/riwayat');
        }

        // Pastikan peminjaman milik user ini
        $peminjam = $this->db->get_where('peminjam', ['id_users' => $id_users])->row();
        if (!$peminjam || $peminjaman->id_peminjam != $peminjam->id_peminjam) {
            $this->session->set_flashdata('error', 'Anda tidak berhak membatalkan peminjaman ini.');
            redirect('user/peminjaman/riwayat');
        }

        // Hanya boleh batalkan jika status Menunggu atau Disetujui
        if (!in_array($peminjaman->status, ['Menunggu', 'Disetujui'])) {
            $this->session->set_flashdata('error', 'Peminjaman dengan status "' . $peminjaman->status . '" tidak dapat dibatalkan.');
            redirect('user/peminjaman/riwayat');
        }

        $this->peminjaman->delete($id);
        $this->session->set_flashdata('success', 'Peminjaman berhasil dibatalkan.');
        redirect('user/peminjaman/riwayat');
        }
        
        // Riwayat peminjaman user
    public function riwayat() {
        $this->load->library('pagination');

        $id_users = $this->session->userdata('id_users');
        $peminjam = $this->db->get_where('peminjam', ['id_users' => $id_users])->row();
        $id_peminjam = $peminjam ? $peminjam->id_peminjam : 0;

        $keyword = $this->input->get('keyword');

        $config = [
            'base_url'             => base_url('user/peminjaman/riwayat'),
            'per_page'             => 7,
            'page_query_string'    => TRUE,
            'query_string_segment' => 'page',
            'total_rows'           => $this->peminjaman->count_riwayat($id_peminjam, $keyword),
            'full_tag_open'        => '<div class="pagination-modern">',
            'full_tag_close'       => '</div>',
            'num_tag_open'         => '<a class="page-num">',
            'num_tag_close'        => '</a>',
            'cur_tag_open'         => '<span class="page-num active">',
            'cur_tag_close'        => '</span>',
            'prev_link'            => FALSE,
            'next_link'            => FALSE,
            'first_link'           => FALSE,
            'last_link'            => FALSE,
        ];

        $this->pagination->initialize($config);

        $start = $this->input->get('page') ?: 0;

        $data = [
            'title'      => 'Riwayat Peminjaman',
            'peminjaman' => $this->peminjaman->get_riwayat($id_peminjam, $config['per_page'], $start, $keyword),
            'pagination' => $this->pagination->create_links(),
            'start'      => $start,
            'keyword'    => $keyword,
        ];

        $this->load->view('user/peminjaman/riwayat', $data);
    }
        // ✅ Baru — user konfirmasi perubahan dari admin
    public function konfirmasi($id) {
        $aksi     = $this->input->post('aksi', true);
        $id_users = $this->session->userdata('id_users');

        $peminjaman = $this->peminjaman->get_by_id($id);

        if (!$peminjaman) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan.');
            redirect('user/peminjaman/riwayat');
        }

        // Pastikan status Menunggu Konfirmasi User
        if ($peminjaman->status != 'Menunggu Konfirmasi User') {
            $this->session->set_flashdata('error', 'Peminjaman ini tidak memerlukan konfirmasi.');
            redirect('user/peminjaman/riwayat');
        }

        $this->peminjaman->konfirmasi_user($id, $aksi);

        if ($aksi == 'setuju') {
            // ✅ Kirim notifikasi WA invoice ke peminjam
            $this->session->set_flashdata('success', 'Peminjaman disetujui! Silakan ambil alat di Sekretariat MAYAPALA dengan membawa KTM.');
        } else {
            $this->session->set_flashdata('success', 'Peminjaman berhasil dibatalkan.');
        }

        redirect('user/peminjaman/riwayat');
    }
    
}