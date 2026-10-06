<?php
class Admin_Alat extends MY_Controller {
    public function __construct() {
    parent::__construct();

    if(!$this->session->userdata('logged_in') || 
       $this->session->userdata('role') != 'Admin') {
        redirect('login');
    }

    $this->load->model('M_alat', 'alat');
    $this->load->helper('url');
}

public function index() {

    $this->load->library('pagination');

    $keyword = $this->input->get('keyword');

    $config['base_url'] = base_url('admin/alat');
    $config['per_page'] = 7;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';

    $config['total_rows'] = $this->alat->count_data($keyword);

    // styling bootstrap
    $config['full_tag_open'] = '<div class="pagination-modern">';
    $config['full_tag_close'] = '</div>';

    $config['num_tag_open'] = '<a class="page-num">';
    $config['num_tag_close'] = '</a>';

    $config['cur_tag_open'] = '<span class="page-num active">';
    $config['cur_tag_close'] = '</span>';

    $config['prev_link'] = FALSE;
    $config['next_link'] = FALSE;
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;

    $this->pagination->initialize($config);

    $start = $this->input->get('page');
    if(!$start) $start = 0;

    $data['alat'] = $this->alat->get_data($config['per_page'], $start, $keyword);
    $data['pagination'] = $this->pagination->create_links();
    $data['title'] = 'Data Alat';
    $data['start'] = $start;
    $data['keyword'] = $keyword;

    $this->load->view('admin/alat/index', $data);
}

public function tambah() {
    $data['title'] = 'Tambah Alat';
    $this->load->view('admin/alat/tambah', $data);
}

public function simpan() {

    // ✅ Cek apakah kode_alat sudah ada
    $kode = $this->input->post('kode_alat', true);
    $cek  = $this->db->get_where('alat', ['kode_alat' => $kode])->row();

    if ($cek) {
        $this->session->set_flashdata('error', 'Kode alat ' . $kode . ' sudah digunakan!');
        redirect('admin/alat/tambah');
    }

    $data = [
        'kode_alat'  => $kode,
        'nama_alat'  => $this->input->post('nama_alat', true),
        'merk'       => $this->input->post('merk', true),
        'warna'      => $this->input->post('warna', true),
        'jumlah'     => $this->input->post('jumlah', true),
        'kondisi'    => $this->input->post('kondisi', true),
        'keterangan' => $this->input->post('keterangan', true),
    ];

    $this->alat->insert($data);
    $this->session->set_flashdata('success', 'Data alat berhasil disimpan');
    redirect('admin/alat');
}

public function edit($id) {
    $data['title'] = 'Edit Alat';
    $data['alat']  = $this->alat->get_by_id($id);
    $this->load->view('admin/alat/edit', $data);
}

public function update($id) {

    $data = [
        'kode_alat' => $this->input->post('kode_alat', true),
        'nama_alat' => $this->input->post('nama_alat', true),
        'merk'      => $this->input->post('merk', true),
        'warna'     => $this->input->post('warna', true),
        'jumlah'    => $this->input->post('jumlah', true),
        'kondisi'   => $this->input->post('kondisi', true),
        'keterangan'=> $this->input->post('keterangan', true),
    ];

    $this->alat->update($id, $data);
    $this->session->set_flashdata('success','Data alat berhasil diubah');
    redirect('admin/alat');
}

public function hapus($id) {
    $this->alat->delete($id);
    $this->session->set_flashdata('success','Data alat berhasil dihapus');
    redirect('admin/alat');
}
public function export()
{
    $data = $this->alat->get_all();

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Alat.xls");

    echo "<table border='1'>";
    echo "<tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Alat</th>
            <th>Merk</th>
            <th>Warna</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
            <th>Keterangan</th>
          </tr>";

    $no = 1;
    foreach ($data as $a) {
        echo "<tr>
                <td>".$no++."</td>
                <td>".$a->kode_alat."</td>
                <td>".$a->nama_alat."</td>
                <td>".$a->merk."</td>
                <td>".$a->warna."</td>
                <td>".$a->jumlah."</td>
                <td>".$a->kondisi."</td>
                <td>".$a->keterangan."</td>
              </tr>";
    }

    echo "</table>";
}
}