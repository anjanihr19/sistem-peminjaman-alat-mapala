<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Peminjaman extends MY_Controller {

    public function __construct() {
        parent::__construct();

        // Cek login admin
        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') != 'Admin') {
            redirect('admin/login');
        }

        $this->load->model('M_peminjaman', 'peminjaman');
    }

    public function index() {
        $this->load->library('pagination');
        $keyword = $this->input->get('keyword');

        $config = [
            'base_url'             => base_url('admin/peminjaman'),
            'per_page'             => 10,
            'page_query_string'    => TRUE,
            'query_string_segment' => 'page',
            'reuse_query_string'   => TRUE,
            'total_rows'           => $this->peminjaman->count_all($keyword),
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
            'title'      => 'Data Peminjaman Alat',
            'peminjaman' => $this->peminjaman->get_all_paginate($config['per_page'], $start, $keyword),
            'pagination' => $this->pagination->create_links(),
            'start'      => $start,
            'keyword'    => $keyword,
        ];

        $this->load->view('admin/peminjaman/index', $data);
    }

    /**
     * Menampilkan Halaman Edit/Nego Peminjaman
     * Aturan: Hanya bisa diakses jika status masih 'Menunggu'
     */
    public function edit($id) {
        $peminjaman = $this->peminjaman->get_by_id($id);

        if (!$peminjaman) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('admin/peminjaman');
        }

        if ($peminjaman->status !== 'Menunggu') {
            $this->session->set_flashdata('error', 'Nego hanya bisa dilakukan pada pengajuan baru (Menunggu).');
            redirect('admin/peminjaman');
        }

        $data = [
            'title'      => 'Proses Peminjaman',
            'peminjaman' => $peminjaman
        ];

        $this->load->view('admin/peminjaman/edit', $data);
    }

    /**
     * Logika Nego, Setuju Langsung, atau Tolak
     */
    public function ajukan_perubahan($id) {
        $submit_type   = $this->input->post('submit_type'); 
        $id_user_admin = $this->session->userdata('id_users');
        $peminjaman    = $this->peminjaman->get_by_id($id);

        if (!$peminjaman) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('admin/peminjaman');
        }

        if ($submit_type === 'setuju_langsung') {
            // 1. VALIDASI STOK SEBELUM SETUJU
            if (!$this->peminjaman->cek_stok_tersedia($peminjaman->id_alat, $peminjaman->jml_alat)) {
                $this->session->set_flashdata('error', 'Stok alat tidak mencukupi! Silakan lakukan NEGO jumlah alat.');
                redirect('admin/peminjaman/edit/'.$id);
            }

            $data_update = [
                'status'   => 'Disetujui',
                'id_admin' => $id_user_admin
            ];

            // Potong Stok
            $this->db->where('id_alat', $peminjaman->id_alat)
                     ->set('jumlah', 'jumlah - ' . (int)$peminjaman->jml_alat, FALSE)
                     ->update('alat');

            $msg = 'Peminjaman disetujui langsung, stok alat telah dikurangi.';

        } elseif ($submit_type === 'tolak') {
            // 2. JALUR TOLAK (Harus ada alasan)
            $alasan = $this->input->post('alasan_perubahan', true);
            if (empty($alasan)) {
                $this->session->set_flashdata('error', 'Alasan penolakan wajib diisi.');
                redirect('admin/peminjaman/edit/'.$id);
            }

            $data_update = [
                'status'           => 'Ditolak',
                'alasan_perubahan' => $alasan,
                'id_admin'         => $id_user_admin
            ];
            $msg = 'Peminjaman telah ditolak.';

        } else {
            // 3. JALUR NEGO (Menunggu Konfirmasi User)
            $alasan = $this->input->post('alasan_perubahan', true);
            if (empty($alasan)) {
                $this->session->set_flashdata('error', 'Alasan perubahan wajib diisi untuk negosiasi.');
                redirect('admin/peminjaman/edit/'.$id);
            }

            $data_update = [
                'tgl_pinjam'       => $this->input->post('tgl_pinjam', true),
                'tgl_kembali'      => $this->input->post('tgl_kembali', true),
                'jml_alat'         => (int)$this->input->post('jml_alat', true),
                'alasan_perubahan' => $alasan,
                'status'           => 'Menunggu Konfirmasi User', 
                'id_admin'         => $id_user_admin,
            ];
            $msg = 'Draft nego dikirim ke user. Menunggu persetujuan user.';
        }

        $this->db->where('id_peminjaman', $id)->update('peminjaman', $data_update);
        $this->session->set_flashdata('success', $msg);
        redirect('admin/peminjaman');
    }

    public function export()
{
    $data = $this->peminjaman->get_all();

    // Bersihkan buffer output sebelum kirim header
    if (ob_get_length()) ob_end_clean();

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Peminjaman.xls");
    header("Cache-Control: max-age=0");
    header("Pragma: public");

    echo "<table border='1'>";
    echo "<tr>
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Institusi</th>
            <th>No HP</th>
            <th>Kode Alat</th>
            <th>Nama Alat</th>
            <th>Jumlah</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Tgl Realisasi Kembali</th>
            <th>Status</th>
            <th>Admin</th>
            <th>Alasan</th>
          </tr>";

    $no = 1;
    foreach ($data as $p) {
        $tgl_pinjam    = $p->tgl_pinjam                   ? date('d/m/Y', strtotime($p->tgl_pinjam))                   : '-';
        $tgl_kembali   = $p->tgl_kembali                  ? date('d/m/Y', strtotime($p->tgl_kembali))                  : '-';
        $tgl_realisasi = !empty($p->tgl_realisasi_kembali) ? date('d/m/Y', strtotime($p->tgl_realisasi_kembali))       : '-';
        $nama_admin    = !empty($p->nama_admin)            ? $p->nama_admin                                            : '-';
        $alasan        = !empty($p->alasan_perubahan)      ? $p->alasan_perubahan                                      : '-';

        echo "<tr>
                <td>".$no++."</td>
                <td>".$p->nama_peminjam."</td>
                <td>".$p->institusi."</td>
                <td>".$p->no_hp."</td>
                <td>".$p->kode_alat."</td>
                <td>".$p->nama_alat."</td>
                <td>".$p->jml_alat."</td>
                <td>".$tgl_pinjam."</td>
                <td>".$tgl_kembali."</td>
                <td>".$tgl_realisasi."</td>
                <td>".$p->status."</td>
                <td>".$nama_admin."</td>
                <td>".$alasan."</td>
              </tr>";
    }

    echo "</table>";
    exit();
}
    public function update_status_modal($id) {
    $status  = $this->input->post('status', true);
    $tanggal_input = $this->input->post('tanggal', true); // Tanggal dari modal
    $peminjaman = $this->peminjaman->get_by_id($id);

    if (!$peminjaman) {
        $this->session->set_flashdata('error', 'Data tidak ditemukan.');
        redirect('admin/admin_peminjaman');
    }

    $data_update = ['status' => $status];

    // --- VALIDASI LOGIKA TANGGAL ---
    
    if ($status === 'Dipinjam') {
        // Tanggal dipinjam tidak boleh lebih besar dari tanggal estimasi kembali (tgl_kembali)
        if ($tanggal_input > $peminjaman->tgl_kembali) {
            $this->session->set_flashdata('error', 'Gagal: Tanggal dipinjam tidak boleh melebihi estimasi tanggal kembali (' . date('d/m/Y', strtotime($peminjaman->tgl_kembali)) . ').');
            redirect('admin/admin_peminjaman');
        }
        $data_update['tgl_pinjam'] = $tanggal_input;

    } elseif ($status === 'Dikembalikan') {
        // Tanggal realisasi kembali tidak boleh LEBIH AWAL dari tanggal mulai pinjam
        if ($tanggal_input < $peminjaman->tgl_pinjam) {
            $this->session->set_flashdata('error', 'Gagal: Tanggal kembali tidak boleh lebih awal dari tanggal pinjam (' . date('d/m/Y', strtotime($peminjaman->tgl_pinjam)) . ').');
            redirect('admin/admin_peminjaman');
        }
        $data_update['tgl_realisasi_kembali'] = $tanggal_input;
        
        // Kembalikan stok
        $this->db->where('id_alat', $peminjaman->id_alat)
                 ->set('jumlah', 'jumlah + ' . (int)$peminjaman->jml_alat, FALSE)
                 ->update('alat');
    }

    // Eksekusi update
    $this->peminjaman->update_status($id, $data_update);
    $this->session->set_flashdata('success', 'Status berhasil diperbarui menjadi ' . $status);
    redirect('admin/admin_peminjaman');
}
}
