<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_alat extends CI_Model {

    // Ambil data dengan limit, search, dan filter kondisi
    public function get_data($limit, $start, $keyword = null, $kondisi = null) {

        if ($kondisi) {
            $this->db->where('kondisi', $kondisi);
        }

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('nama_alat', $keyword);
            $this->db->or_like('kode_alat', $keyword);
            $this->db->or_like('merk', $keyword);
            $this->db->or_like('warna', $keyword);
            $this->db->or_like('kondisi', $keyword);
            $this->db->group_end();
        }

        return $this->db->get('alat', $limit, $start)->result();
    }

    // Hitung total data untuk pagination
    public function count_data($keyword = null, $kondisi = null) {

        if ($kondisi) {
            $this->db->where('kondisi', $kondisi);
        }

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('nama_alat', $keyword);
            $this->db->or_like('kode_alat', $keyword);
            $this->db->or_like('merk', $keyword);
            $this->db->or_like('warna', $keyword);
            $this->db->or_like('kondisi', $keyword);
            $this->db->group_end();
        }

        return $this->db->count_all_results('alat');
    }

    public function get_by_id($id) {
        return $this->db->get_where('alat', ['id_alat' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('alat', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_alat', $id)->update('alat', $data);
    }

    public function delete($id) {
        return $this->db->where('id_alat', $id)->delete('alat');
    }

    public function get_all() {
        return $this->db->get('alat')->result();
    }
}