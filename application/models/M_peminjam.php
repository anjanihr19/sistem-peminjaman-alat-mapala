<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_peminjam extends CI_Model {

    /**
     * Mengambil data peminjam dengan pagination dan keyword pencarian
     * Sinkron dengan Controller Admin_Peminjam
     */
    public function get_all_paginate($limit, $start, $keyword = null)
    {
        $this->db->select('peminjam.*, users.username, users.status_akun');
        $this->db->from('peminjam');
        $this->db->join('users', 'users.id_users = peminjam.id_users');

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('peminjam.nama_peminjam', $keyword);
            $this->db->or_like('peminjam.institusi', $keyword);
            $this->db->or_like('peminjam.no_hp', $keyword);
            $this->db->or_like('users.username', $keyword);
            $this->db->group_end();
        }

        $this->db->limit($limit, $start);
        $this->db->order_by('peminjam.id_peminjam', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Menghitung total rows untuk library pagination
     */
    public function count_all($keyword = null)
    {
        $this->db->from('peminjam');
        $this->db->join('users', 'users.id_users = peminjam.id_users');

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('peminjam.nama_peminjam', $keyword);
            $this->db->or_like('peminjam.institusi', $keyword);
            $this->db->or_like('peminjam.no_hp', $keyword);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    /**
     * Detail peminjam berdasarkan ID
     */
    public function get_by_id($id)
    {
        $this->db->select('peminjam.*, users.username, users.status_akun, users.id_users');
        $this->db->from('peminjam');
        $this->db->join('users', 'users.id_users = peminjam.id_users');
        $this->db->where('peminjam.id_peminjam', $id);
        return $this->db->get()->row();
    }

    public function insert($data)
    {
        return $this->db->insert('peminjam', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_peminjam', $id)->update('peminjam', $data);
    }

    public function delete($id)
    {
        // Pastikan record di tabel peminjam dihapus
        return $this->db->where('id_peminjam', $id)->delete('peminjam');
    }

    /**
     * Mengambil daftar user dengan role 'User'
     */
    public function get_users_role_user()
    {
        return $this->db->where('role', 'User')->get('users')->result();
    }
}