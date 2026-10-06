<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_peminjaman extends CI_Model {

    // --------------------------------------------------------------
    // OPERASI DASAR (CRUD)
    // --------------------------------------------------------------

    public function insert($data) {
        return $this->db->insert('peminjaman', $data);
    }

    public function update_status($id, $data) {
        return $this->db->where('id_peminjaman', $id)->update('peminjaman', $data);
    }

    public function delete($id) {
        return $this->db->where('id_peminjaman', $id)->delete('peminjaman');
    }

    // --------------------------------------------------------------
    // QUERY UNTUK ADMIN
    // --------------------------------------------------------------

    private function _get_peminjaman_select_admin() {
        $this->db->select('peminjaman.*, alat.nama_alat, alat.kode_alat, peminjam.nama_peminjam, peminjam.no_hp, peminjam.institusi, admin_user.username as nama_admin');
        $this->db->from('peminjaman');
        $this->db->join('alat', 'alat.id_alat = peminjaman.id_alat');
        $this->db->join('peminjam', 'peminjam.id_peminjam = peminjaman.id_peminjam');
        $this->db->join('users as admin_user', 'admin_user.id_users = peminjaman.id_admin', 'left');
    }

    public function get_all() {
        $this->_get_peminjaman_select_admin();
        return $this->db->order_by('peminjaman.id_peminjaman', 'DESC')->get()->result();
    }

    public function get_by_id($id) {
        $this->_get_peminjaman_select_admin();
        $this->db->where('peminjaman.id_peminjaman', $id);
        return $this->db->get()->row();
    }

    public function get_all_paginate($limit, $start, $keyword = null) {
        $this->_get_peminjaman_select_admin();
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('peminjam.nama_peminjam', $keyword);
            $this->db->or_like('alat.nama_alat', $keyword);
            $this->db->or_like('alat.kode_alat', $keyword);
            $this->db->or_like('peminjaman.status', $keyword);
            $this->db->or_like('peminjam.institusi', $keyword);
            $this->db->group_end();
        }
        return $this->db->order_by('peminjaman.id_peminjaman', 'DESC')
                        ->limit($limit, $start)
                        ->get()->result();
    }

    public function count_all($keyword = null) {
        $this->db->from('peminjaman');
        $this->db->join('peminjam', 'peminjam.id_peminjam = peminjaman.id_peminjam');
        $this->db->join('alat', 'alat.id_alat = peminjaman.id_alat');
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('peminjam.nama_peminjam', $keyword);
            $this->db->or_like('alat.nama_alat', $keyword);
            $this->db->or_like('peminjaman.status', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    // --------------------------------------------------------------
    // QUERY UNTUK USER (DASHBOARD & RIWAYAT)
    // --------------------------------------------------------------

    public function get_by_user($id_peminjam) {
        return $this->db
            ->select('peminjaman.*, alat.nama_alat, alat.kode_alat')
            ->from('peminjaman')
            ->join('alat', 'alat.id_alat = peminjaman.id_alat')
            ->where('peminjaman.id_peminjam', $id_peminjam)
            ->order_by('peminjaman.id_peminjaman', 'DESC')
            ->get()->result();
    }

    public function get_recent($id_peminjam, $limit = 5) {
        return $this->db
            ->select('peminjaman.*, alat.nama_alat, alat.kode_alat')
            ->from('peminjaman')
            ->join('alat', 'alat.id_alat = peminjaman.id_alat')
            ->where('peminjaman.id_peminjam', $id_peminjam)
            ->order_by('peminjaman.id_peminjaman', 'DESC')
            ->limit($limit)
            ->get()->result();
    }

    public function count_by_status($id_peminjam, $status = null) {
        $this->db->where('id_peminjam', $id_peminjam);
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results('peminjaman');
    }

    public function get_riwayat($id_peminjam, $limit, $start, $keyword = null) {
        $this->db->select('peminjaman.*, alat.nama_alat, alat.kode_alat');
        $this->db->from('peminjaman');
        $this->db->join('alat', 'alat.id_alat = peminjaman.id_alat');
        $this->db->where('peminjaman.id_peminjam', $id_peminjam);

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('alat.nama_alat', $keyword);
            $this->db->or_like('peminjaman.status', $keyword);
            $this->db->group_end();
        }

        return $this->db->order_by('peminjaman.id_peminjaman', 'DESC')
                        ->limit($limit, $start)
                        ->get()->result();
    }

    public function count_riwayat($id_peminjam, $keyword = null) {
        $this->db->from('peminjaman');
        $this->db->join('alat', 'alat.id_alat = peminjaman.id_alat');
        $this->db->where('peminjaman.id_peminjam', $id_peminjam);
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('alat.nama_alat', $keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results();
    }

    // --------------------------------------------------------------
    // FITUR KONFIRMASI & VALIDASI STOK
    // --------------------------------------------------------------

    /**
     * Cek apakah fisik alat tersedia sebelum admin/user setuju
     */
    public function cek_stok_tersedia($id_alat, $jumlah_diminta) {
        $this->db->select('jumlah');
        $this->db->from('alat');
        $this->db->where('id_alat', $id_alat);
        $alat = $this->db->get()->row();
        
        return ($alat && $alat->jumlah >= $jumlah_diminta);
    }

    public function count_menunggu_konfirmasi_user($id_peminjam) {
        $this->db->where('id_peminjam', $id_peminjam);
        $this->db->where('status', 'Menunggu Konfirmasi User');
        return $this->db->count_all_results('peminjaman');
    }

    public function get_menunggu_konfirmasi_user($id_peminjam) {
        $this->db->select('peminjaman.*, alat.nama_alat, alat.kode_alat');
        $this->db->from('peminjaman');
        $this->db->join('alat', 'alat.id_alat = peminjaman.id_alat');
        $this->db->where('peminjaman.id_peminjam', $id_peminjam);
        $this->db->where('peminjaman.status', 'Menunggu Konfirmasi User');
        return $this->db->get()->result();
    }

    public function konfirmasi_user($id, $aksi) {
        $p = $this->get_by_id($id);
        
        if ($aksi == 'setuju') {
            // Validasi Stok Akhir sebelum benar-benar disetujui user
            if (!$this->cek_stok_tersedia($p->id_alat, $p->jml_alat)) {
                return false; // Gagal karena stok habis tiba-tiba
            }

            $status = 'Disetujui';
            
            // POTONG STOK
            $this->db->where('id_alat', $p->id_alat)
                     ->set('jumlah', 'jumlah - ' . (int)$p->jml_alat, FALSE)
                     ->update('alat');
        } else {
            $status = 'Dibatalkan';
        }
        
        return $this->db->where('id_peminjaman', $id)->update('peminjaman', ['status' => $status]);
    }

    public function get_total_dipinjam($id_alat, $tgl_pinjam, $tgl_kembali) {
        $query = $this->db
            ->select('SUM(jml_alat) as total_dipinjam')
            ->from('peminjaman')
            ->where('id_alat', $id_alat)
            ->where_in('status', ['Disetujui', 'Dipinjam'])
            ->group_start()
                ->where("tgl_pinjam <= '$tgl_kembali' AND tgl_kembali >= '$tgl_pinjam'")
            ->group_end()
            ->get()->row();

        return $query->total_dipinjam ? (int)$query->total_dipinjam : 0;
    }
}