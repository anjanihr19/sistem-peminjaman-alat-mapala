<?php

class M_pengguna extends CI_Model{
    protected $_table = 'pengguna';

    // 🛡️ HANYA fungsi ini yang dibutuhkan untuk proses login
    public function lihat_username($username){
        $query = $this->db->get_where($this->_table, ['username' => $username]);
        return $query->row();
    }
    
    // Semua fungsi CRUD lain (lihat, jumlah, lihat_id, tambah, ubah, hapus) telah dihapus.
}