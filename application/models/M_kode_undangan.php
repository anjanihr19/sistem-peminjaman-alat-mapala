<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kode_undangan extends CI_Model {

    protected $_table = 'kode_undangan';

    public function generate_kode() {
        // Tetap menggunakan format Anda MYP-XXXXXX
        return 'MYP-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
    }

    public function insert($kode) {
        // Ambil ID admin yang membuat kode dari session
        $id_admin = $this->session->userdata('id_users');
        
        return $this->db->insert($this->_table, [
            'kode'       => $kode,
            'is_used'    => 0,
            'id_admin'   => $id_admin, // Menyimpan siapa admin yang generate
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function cek_kode($kode) {
        return $this->db->get_where($this->_table, [
            'kode'    => $kode,
            'is_used' => 0,
        ])->row();
    }

    public function gunakan_kode($kode, $id_users) {
        return $this->db->where('kode', $kode)->update($this->_table, [
            'is_used'  => 1,
            'id_users' => $id_users, // User yang memakai kode saat daftar
            'used_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_all() {
        // JOIN ke tabel users agar tahu siapa yang memakai kode tersebut
        $this->db->select('kode_undangan.*, users.username, users.nama_user');
        $this->db->from($this->_table);
        $this->db->join('users', 'users.id_users = kode_undangan.id_users', 'left');
        $this->db->order_by('kode_undangan.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function delete($id) {
        // Sesuai Gambar 1, nama primary key adalah id_kode
        return $this->db->where('id_kode', $id)->delete($this->_table);
    }
}