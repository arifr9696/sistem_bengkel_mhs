<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
        // Hanya kasir dan admin yang boleh mengakses transaksi
        if (!in_array($this->session->userdata('role'), ['admin', 'kasir'])) {
            redirect('login');
        }
    }

    /**
     * Daftar semua transaksi
     */
    public function index()
    {
        $data['title']     = 'Data Transaksi';
        $data['titlePage'] = 'Manajemen Transaksi Pembayaran';
        $data['transaksi'] = $this->Transaksi_model->get_all_transaksi();
        $this->loadPartials('backend/transaksi/index', $data);
    }

    /**
     * Form input transaksi baru
     */
    public function tambah()
    {
        $data['title']     = 'Tambah Transaksi';
        $data['titlePage'] = 'Input Transaksi Pembayaran';
        $data['antrian']   = $this->Transaksi_model->get_antrian_siap_bayar();
        $this->loadPartials('backend/transaksi/tambah', $data);
    }

    /**
     * Proses simpan transaksi baru
     */
    public function simpan()
    {
        $id_antrian  = $this->input->post('id_antrian', TRUE);
        $total_biaya = $this->input->post('total_biaya', TRUE);
        $bayar       = $this->input->post('bayar', TRUE);
        $kembalian   = (float)$bayar - (float)$total_biaya;

        if ($kembalian < 0) {
            $this->session->set_flashdata('error', 'Uang bayar kurang dari total tagihan!');
            redirect('backend/transaksi/tambah');
        }

        $data = [
            'id_antrian'    => $id_antrian,
            'total_biaya'   => $total_biaya,
            'bayar'         => $bayar,
            'kembalian'     => $kembalian,
            'tgl_transaksi' => date('Y-m-d'),
            'status_bayar'  => 'lunas',
        ];

        if ($this->Transaksi_model->insert_transaksi($data)) {
            $this->session->set_flashdata('success', 'Transaksi berhasil disimpan! Kembalian: Rp ' . number_format($kembalian, 0, ',', '.'));
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan transaksi!');
        }

        redirect('backend/transaksi');
    }

    /**
     * Detail / struk transaksi
     */
    public function detail($id)
    {
        $data['title']     = 'Detail Transaksi';
        $data['titlePage'] = 'Struk Pembayaran';
        $data['transaksi'] = $this->Transaksi_model->get_transaksi_by_id($id);

        if (!$data['transaksi']) {
            $this->session->set_flashdata('error', 'Data transaksi tidak ditemukan.');
            redirect('backend/transaksi');
        }

        $this->loadPartials('backend/transaksi/detail', $data);
    }

    /**
     * Hapus transaksi
     */
    public function hapus($id)
    {
        if ($this->Transaksi_model->delete_transaksi($id)) {
            $this->session->set_flashdata('success', 'Data transaksi berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data transaksi.');
        }
        redirect('backend/transaksi');
    }
}
