<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Antrian extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('username')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Antrean';
        $data['nama'] = $this->session->userdata('nama');
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');

        $this->db->select('
            antrian.id,
            antrian.no_antrian,
            antrian.keluhan,
            antrian.status,
            antrian.tgl_antrian,
            antrian.created_at,
            pelanggan.nama AS nama_pelanggan,
            pelanggan.no_hp,
            kendaraan.plat_nomor,
            kendaraan.merk,
            kendaraan.tipe
        ');
        $this->db->from('antrian');
        $this->db->join('pelanggan', 'pelanggan.id = antrian.id_pelanggan', 'left');
        $this->db->join('kendaraan', 'kendaraan.id = antrian.id_kendaraan', 'left');
        $this->db->order_by('antrian.tgl_antrian', 'DESC');
        $this->db->order_by('antrian.no_antrian', 'ASC');

        $data['antrian'] = $this->db->get()->result();

        $this->loadPartials('backend/antrian/index', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Antrean';
        $data['nama'] = $this->session->userdata('nama');
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');

        $data['pelanggan'] = $this->db->get('pelanggan')->result();
        $data['kendaraan'] = $this->db->get('kendaraan')->result();

        if ($this->input->method() === 'post') {
            $tgl_antrian = $this->input->post('tgl_antrian', true);
            $id_kendaraan = $this->input->post('id_kendaraan', true);
            $id_pelanggan = $this->input->post('id_pelanggan', true);
            $keluhan = $this->input->post('keluhan', true);

            $this->db->select_max('no_antrian');
            $this->db->where('tgl_antrian', $tgl_antrian);
            $last = $this->db->get('antrian')->row();

            $no_antrian = ($last && $last->no_antrian) ? ((int) $last->no_antrian + 1) : 1;

            $insert = [
                'no_antrian'   => $no_antrian,
                'tgl_antrian'  => $tgl_antrian,
                'id_kendaraan' => $id_kendaraan,
                'id_pelanggan' => $id_pelanggan,
                'keluhan'      => $keluhan,
                'status'       => 'menunggu',
                'created_at'   => date('Y-m-d H:i:s')
            ];

            $this->db->insert('antrian', $insert);

            $this->session->set_flashdata('success', 'Antrean #' . $no_antrian . ' berhasil dibuat.');
            redirect('backend/antrian');
        }

        $this->loadPartials('backend/antrian/tambah', $data);
    }

    public function edit($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'ID antrean tidak valid.');
            redirect('backend/antrian');
        }

        $antrian = $this->db->get_where('antrian', ['id' => $id])->row();

        if (!$antrian) {
            $this->session->set_flashdata('error', 'Data antrean tidak ditemukan.');
            redirect('backend/antrian');
        }

        if ($this->input->method() === 'post') {
            $tgl_antrian = $this->input->post('tgl_antrian', true);
            $id_kendaraan = $this->input->post('id_kendaraan', true);
            $id_pelanggan = $this->input->post('id_pelanggan', true);
            $keluhan = $this->input->post('keluhan', true);
            $status = $this->input->post('status', true);

            if ($tgl_antrian !== $antrian->tgl_antrian) {
                $this->db->select_max('no_antrian');
                $this->db->where('tgl_antrian', $tgl_antrian);
                $last = $this->db->get('antrian')->row();

                $no_antrian = ($last && $last->no_antrian) ? ((int) $last->no_antrian + 1) : 1;
            } else {
                $no_antrian = $antrian->no_antrian;
            }

            $update = [
                'tgl_antrian'  => $tgl_antrian,
                'no_antrian'   => $no_antrian,
                'id_kendaraan' => $id_kendaraan,
                'id_pelanggan' => $id_pelanggan,
                'keluhan'      => $keluhan,
                'status'       => $status
            ];

            $this->db->where('id', $id);
            $this->db->update('antrian', $update);

            $this->session->set_flashdata('success', 'Data antrean berhasil diperbarui.');
            redirect('backend/antrian');
        }

        $data['title'] = 'Edit Antrean';
        $data['nama'] = $this->session->userdata('nama');
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');

        $data['antrian'] = $antrian;
        $data['pelanggan'] = $this->db->get('pelanggan')->result();
        $data['kendaraan'] = $this->db->get('kendaraan')->result();

        $this->loadPartials('backend/antrian/edit', $data);
    }

    public function hapus($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'ID antrean tidak valid.');
            redirect('backend/antrian');
        }

        $antrian = $this->db->get_where('antrian', ['id' => $id])->row();

        if (!$antrian) {
            $this->session->set_flashdata('error', 'Data antrean tidak ditemukan.');
            redirect('backend/antrian');
        }

        $this->db->where('id', $id);
        $this->db->delete('antrian');

        $this->session->set_flashdata('success', 'Antrean berhasil dihapus.');
        redirect('backend/antrian');
    }
}