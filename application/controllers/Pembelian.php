<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Pembelian";
        $data['barangmasuk'] = $this->admin->getBarangMasuk();
        $this->template->load('templates/dashboard', 'pembelian/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim|numeric|greater_than[0]');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pembelian";
            $data['supplier'] = $this->admin->get('supplier');
            $data['barang'] = $this->admin->get('barang');

            // Mendapatkan dan men-generate kode transaksi barang masuk
            $kode = 'T-BM-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_masuk', 'id_barang_masuk', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_masuk'] = $kode . $number;

            $this->template->load('templates/dashboard', 'pembelian/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('barang_masuk', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan. Tunggu Admin untuk verifikasi');
                redirect('pembelian');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('pembelian/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pembelian";
            $data['supplier'] = $this->admin->get('supplier');
            $data['barang'] = $this->admin->get('barang');
            $data['barang_masuk'] = $this->admin->get('barang_masuk',['id_barang_masuk' => $id]);

            $this->template->load('templates/dashboard', 'pembelian/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->update('barang_masuk','id_barang_masuk',$id, $input);
            
            if ($insert) {
                set_pesan('data berhasil diVerifikasi.');
                // $this->toggle2($id);
                redirect('pembelian');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('pembelian/edit'.$id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_masuk', 'id_barang_masuk', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('pembelian');
    }

    public function toggle2($getId)
    {
        $id = encode_php_tags($getId);
        $status = $this->admin->get('barang_masuk', ['id_barang_masuk' => $id])['is_verifikasi'];
        $toggle = $status ? 0 : 1; //Jika Pembelian terfivikasi maka tidak verifikasi, begitu pula sebaliknya
        $pesan = $toggle ? 'Pembelian Terverifikasi' : 'Pembelian Terverifikasi';

        if ($this->admin->update('barang_masuk', 'id_barang_masuk', $id,['is_verifikasi' => $toggle])) {
            set_pesan($pesan);
        }
        redirect('pembelian');
    }

    public function toggle($getId)
    {
        $id = encode_php_tags($getId);
        $status = $this->admin->get('barang_masuk', ['id_barang_masuk' => $id])['is_verifikasi'];
        $total = $this->admin->get('barang_masuk', ['id_barang_masuk' => $id])['jumlah_masuk'];
        $toggle = $status ? 0 : 1; //Jika Pembelian terfivikasi maka tidak verifikasi, begitu pula sebaliknya
        $pesan = $toggle ? 'Pembelian Terverifikasi' : 'Pembelian Terverifikasi';

        $input = ['is_verifikasi'=>$toggle,'jumlah_keseluruhan'=>$total ];

        if ($this->admin->update('barang_masuk', 'id_barang_masuk', $id, $input)) {
            set_pesan($pesan);
        }
        redirect('pembelian');
    }
}
