<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kendaraan_model');

        // Proteksi Halaman: Hanya Admin yang bisa mengakses CRUD Kendaraan
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
        if ($this->session->userdata('role') !== 'admin') {
            redirect('backend/dashboard');
        }
    }

    public function index()
    {
        $data['title'] = 'Kelola Data Kendaraan';
        $data['titlePage'] = $data['title'];
        $data['kendaraan'] = $this->Kendaraan_model->get_all();
        
        $this->loadPartials('backend/kendaraan/index', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Kendaraan';
        $data['titlePage'] = $data['title'];
        $data['pelanggan'] = $this->Kendaraan_model->get_pelanggan_list();

        $this->loadPartials('backend/kendaraan/tambah', $data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('id_pelanggan', 'Pemilik (Pelanggan)', 'required', [
            'required' => '%s harus dipilih.'
        ]);
        $this->form_validation->set_rules('merk', 'Merk Kendaraan', 'required', [
            'required' => '%s tidak boleh kosong.'
        ]);
        $this->form_validation->set_rules('tipe', 'Tipe Kendaraan', 'required', [
            'required' => '%s tidak boleh kosong.'
        ]);
        $this->form_validation->set_rules('plat_nomor', 'Plat Nomor', 'required', [
            'required' => '%s tidak boleh kosong.'
        ]);
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|exact_length[4]', [
            'required' => '%s tidak boleh kosong.',
            'numeric' => '%s harus berupa angka.',
            'exact_length' => '%s harus terdiri dari 4 digit tahun.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $plat_nomor = strtoupper(trim($this->input->post('plat_nomor')));
            
            // Cek keunikan plat nomor
            if ($this->Kendaraan_model->check_plat_nomor($plat_nomor)) {
                $this->session->set_flashdata('error', 'Plat Nomor <strong>' . $plat_nomor . '</strong> sudah terdaftar di sistem!');
                redirect('backend/kendaraan/tambah');
            } else {
                $data = [
                    'id_pelanggan' => $this->input->post('id_pelanggan'),
                    'merk' => $this->input->post('merk'),
                    'tipe' => $this->input->post('tipe'),
                    'plat_nomor' => $plat_nomor,
                    'tahun' => $this->input->post('tahun')
                ];

                if ($this->Kendaraan_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data kendaraan berhasil ditambahkan!');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data kendaraan.');
                }
                redirect('backend/kendaraan');
            }
        }
    }

    public function edit($id)
    {
        $kendaraan = $this->Kendaraan_model->get_by_id($id);
        if (!$kendaraan) {
            $this->session->set_flashdata('error', 'Data kendaraan tidak ditemukan!');
            redirect('backend/kendaraan');
        }

        $data['title'] = 'Edit Kendaraan';
        $data['titlePage'] = $data['title'];
        $data['kendaraan'] = $kendaraan;
        $data['pelanggan'] = $this->Kendaraan_model->get_pelanggan_list();

        $this->loadPartials('backend/kendaraan/edit', $data);
    }

    public function update($id)
    {
        $kendaraan = $this->Kendaraan_model->get_by_id($id);
        if (!$kendaraan) {
            $this->session->set_flashdata('error', 'Data kendaraan tidak ditemukan!');
            redirect('backend/kendaraan');
        }

        $this->form_validation->set_rules('id_pelanggan', 'Pemilik (Pelanggan)', 'required', [
            'required' => '%s harus dipilih.'
        ]);
        $this->form_validation->set_rules('merk', 'Merk Kendaraan', 'required', [
            'required' => '%s tidak boleh kosong.'
        ]);
        $this->form_validation->set_rules('tipe', 'Tipe Kendaraan', 'required', [
            'required' => '%s tidak boleh kosong.'
        ]);
        $this->form_validation->set_rules('plat_nomor', 'Plat Nomor', 'required', [
            'required' => '%s tidak boleh kosong.'
        ]);
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|exact_length[4]', [
            'required' => '%s tidak boleh kosong.',
            'numeric' => '%s harus berupa angka.',
            'exact_length' => '%s harus terdiri dari 4 digit tahun.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $plat_nomor = strtoupper(trim($this->input->post('plat_nomor')));
            
            // Cek keunikan plat nomor (kecuali id kendaraan yang sedang diedit)
            if ($this->Kendaraan_model->check_plat_nomor($plat_nomor, $id)) {
                $this->session->set_flashdata('error', 'Plat Nomor <strong>' . $plat_nomor . '</strong> sudah digunakan oleh kendaraan lain!');
                redirect('backend/kendaraan/edit/' . $id);
            } else {
                $data = [
                    'id_pelanggan' => $this->input->post('id_pelanggan'),
                    'merk' => $this->input->post('merk'),
                    'tipe' => $this->input->post('tipe'),
                    'plat_nomor' => $plat_nomor,
                    'tahun' => $this->input->post('tahun')
                ];

                if ($this->Kendaraan_model->update($id, $data)) {
                    $this->session->set_flashdata('success', 'Data kendaraan berhasil diperbarui!');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data kendaraan.');
                }
                redirect('backend/kendaraan');
            }
        }
    }

    public function delete($id)
    {
        $kendaraan = $this->Kendaraan_model->get_by_id($id);
        if (!$kendaraan) {
            $this->session->set_flashdata('error', 'Data kendaraan tidak ditemukan!');
            redirect('backend/kendaraan');
        }

        if ($this->Kendaraan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data kendaraan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data kendaraan.');
        }
        redirect('backend/kendaraan');
    }
}
