<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model {
    protected $_table = 'users';

    public function lihat_username($username) {
        return $this->db->get_where($this->_table, ['username' => $username])->row();
    }

    public function tambah($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function get_profil_peminjam($id_users) {
        $this->db->select('*');
        $this->db->from('peminjam');
        $this->db->where('id_users', $id_users);
        return $this->db->get()->row();
    }

    // ambil user berdasarkan id
    public function get_by_id($id) {
        return $this->db->get_where($this->_table, ['id_users' => $id])->row();
    }

    // update data user
    public function update($id, $data) {
        return $this->db->where('id_users', $id)->update($this->_table, $data);
    }

    // reset password user (set password sementara)
    public function reset_password($id, $password_sementara) {
        return $this->db->where('id_users', $id)->update($this->_table, [
            'password'              => password_hash($password_sementara, PASSWORD_DEFAULT),
            'is_temporary_password' => 1,
        ]);
    }

    // ubah password user (setelah login pertama)
    public function ubah_password($id, $password_baru) {
        return $this->db->where('id_users', $id)->update($this->_table, [
            'password'              => password_hash($password_baru, PASSWORD_DEFAULT),
            'is_temporary_password' => 0,
        ]);
    }

    // aktivasi akun user oleh admin
    public function aktivasi_akun($id) {
        return $this->db->where('id_users', $id)->update($this->_table, [
            'status_akun' => 'aktif',
        ]);
    }

    // nonaktifkan akun user oleh admin
    public function nonaktif_akun($id) {
        return $this->db->where('id_users', $id)->update($this->_table, [
            'status_akun' => 'non-aktif',
        ]);
    }

    // cek apakah password masih sementara
    public function is_temporary_password($id) {
        $user = $this->db->get_where($this->_table, ['id_users' => $id])->row();
        return $user ? $user->is_temporary_password : false;
    }
}