<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servis extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Servis_model');
        // Hanya mekanik atau admin yang boleh mengakses data servis
        if (!in_array($this->session->userdata('role'), ['admin', 'mekanik'])) {
            redirect('login');
        }
    }

    // Hardcode list sparepart
    private $list_sparepart = [
        ['id' => 1, 'nama' => 'Oli Mesin MPX 1', 'harga' => 50000],
        ['id' => 2, 'nama' => 'Kampas Rem Depan', 'harga' => 45000],
        ['id' => 3, 'nama' => 'Busi NGK', 'harga' => 20000],
        ['id' => 4, 'nama' => 'V-Belt CVT', 'harga' => 120000],
        ['id' => 5, 'nama' => 'Filter Udara', 'harga' => 35000],
    ];

    public function index()
    {
        $data['title'] = 'Data Servis';
        $data['titlePage'] = 'Manajemen Servis (Daftar Antrean)';
        $data['antrian'] = $this->Servis_model->get_all_antrian();
        $this->loadPartials('backend/servis/index', $data);
    }

    public function detail($id_antrian)
    {
        $data['title'] = 'Detail Servis';
        $data['titlePage'] = 'Detail Servis & Sparepart';
        
        $data['antrian'] = $this->Servis_model->get_antrian_by_id($id_antrian);
        if (!$data['antrian']) {
            $this->session->set_flashdata('error', 'Data antrean tidak ditemukan!');
            redirect('backend/servis');
        }

        $data['list_servis'] = $this->Servis_model->get_servis_by_antrian($id_antrian);
        $data['list_sparepart'] = $this->Servis_model->get_sparepart_by_antrian($id_antrian);
        
        $data['master_sparepart'] = $this->list_sparepart;
        
        // Hitung total biaya
        $total_biaya = 0;
        foreach($data['list_servis'] as $s) {
            $total_biaya += $s->biaya_servis;
        }
        foreach($data['list_sparepart'] as $sp) {
            $total_biaya += ($sp->harga_satuan * $sp->qty);
        }
        $data['total_biaya'] = $total_biaya;
        
        $this->loadPartials('backend/servis/detail', $data);
    }

    public function add_item($id_antrian)
    {
        $tipe = $this->input->post('tipe', TRUE);
        $qty = (int)$this->input->post('qty', TRUE);
        if ($qty < 1) $qty = 1;

        if ($tipe === 'servis') {
            $data_servis = [
                'id_antrian' => $id_antrian,
                'jenis_servis' => 'Servis Bengkel Motor',
                'biaya_servis' => 150000 * $qty, // default biaya per qty
                'keterangan' => 'Servis rutin/perbaikan'
            ];
            $this->Servis_model->add_servis($data_servis);
            $this->session->set_flashdata('success', 'Item Servis berhasil ditambahkan!');
        } elseif ($tipe === 'sparepart') {
            $sparepart_id = $this->input->post('sparepart_id', TRUE);
            
            // Cari data sparepart dari hardcode
            $selected_sp = null;
            foreach ($this->list_sparepart as $sp) {
                if ($sp['id'] == $sparepart_id) {
                    $selected_sp = $sp;
                    break;
                }
            }

            if ($selected_sp) {
                $data_sp = [
                    'id_antrian' => $id_antrian,
                    'nama_part' => $selected_sp['nama'],
                    'qty' => $qty,
                    'harga_satuan' => $selected_sp['harga']
                ];
                $this->Servis_model->add_sparepart($data_sp);
                $this->session->set_flashdata('success', 'Item Sparepart berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Sparepart tidak ditemukan!');
            }
        }
        
        // Update status antrian ke diproses otomatis jika belum selesai (opsional, tapi user minta fitur ubah status manual)
        // Cek antrian untuk update status
        $antrian = $this->Servis_model->get_antrian_by_id($id_antrian);
        if ($antrian && $antrian->status == 'menunggu') {
             $this->Servis_model->update_status_antrian($id_antrian, 'diproses');
        }
        
        redirect('backend/servis/detail/' . $id_antrian);
    }

    public function update_status($id_antrian, $status)
    {
        $valid_status = ['menunggu', 'diproses', 'selesai'];
        if (in_array($status, $valid_status)) {
            $this->Servis_model->update_status_antrian($id_antrian, $status);
            $this->session->set_flashdata('success', 'Status antrean berhasil diubah menjadi ' . strtoupper($status) . '!');
        } else {
            $this->session->set_flashdata('error', 'Status tidak valid!');
        }
        redirect('backend/servis/detail/' . $id_antrian);
    }

    public function delete_item($tipe, $id, $id_antrian)
    {
        if ($tipe === 'servis') {
            $this->Servis_model->delete_servis($id);
            $this->session->set_flashdata('success', 'Item Servis berhasil dihapus!');
        } elseif ($tipe === 'sparepart') {
            $this->Servis_model->delete_sparepart($id);
            $this->session->set_flashdata('success', 'Item Sparepart berhasil dihapus!');
        }
        
        redirect('backend/servis/detail/' . $id_antrian);
    }
}
