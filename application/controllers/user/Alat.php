<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in') || 
            $this->session->userdata('role') != 'User') {
            redirect('login');
        }

        $this->load->model('M_alat', 'alat');
        $this->load->helper('url');
        $this->load->library('pagination');
    }

    public function index() {
        $keyword = $this->input->get('keyword');
        $kondisi = 'Baik'; // ✅ Hanya tampilkan alat kondisi Baik

        $config = [
            'base_url'              => base_url('user/alat'),
            'per_page'              => 7,
            'page_query_string'     => TRUE,
            'query_string_segment'  => 'page',
            'total_rows'            => $this->alat->count_data($keyword, $kondisi),
            'full_tag_open'         => '<div class="pagination-modern">',
            'full_tag_close'        => '</div>',
            'num_tag_open'          => '<a class="page-num">',
            'num_tag_close'         => '</a>',
            'cur_tag_open'          => '<span class="page-num active">',
            'cur_tag_close'         => '</span>',
            'prev_link'             => FALSE,
            'next_link'             => FALSE,
            'first_link'            => FALSE,
            'last_link'             => FALSE,
        ];

        $this->pagination->initialize($config);

        $start = $this->input->get('page') ?: 0;

        $data = [
            'alat'       => $this->alat->get_data($config['per_page'], $start, $keyword, $kondisi),
            'pagination' => $this->pagination->create_links(),
            'title'      => 'Inventaris Alat',
            'start'      => $start,
            'keyword'    => $keyword,
        ];

        $this->load->view('user/alat/index', $data);
    }
}