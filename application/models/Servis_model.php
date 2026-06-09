<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servis_model extends CI_Model {

    // Ambil semua antrian (termasuk pelanggan dan kendaraan)
    public function get_all_antrian()
    {
        $this->db->select('antrian.*, pelanggan.nama as nama_pelanggan, pelanggan.no_hp, kendaraan.merk, kendaraan.tipe, kendaraan.plat_nomor, kendaraan.tahun');
        $this->db->from('antrian');
        $this->db->join('pelanggan', 'pelanggan.id = antrian.id_pelanggan', 'left');
        $this->db->join('kendaraan', 'kendaraan.id = antrian.id_kendaraan', 'left');
        $this->db->order_by('antrian.id', 'DESC');
        return $this->db->get()->result();
    }

    // Ambil detail satu antrian
    public function get_antrian_by_id($id)
    {
        $this->db->select('antrian.*, pelanggan.nama as nama_pelanggan, pelanggan.no_hp, kendaraan.merk, kendaraan.tipe, kendaraan.plat_nomor, kendaraan.tahun');
        $this->db->from('antrian');
        $this->db->join('pelanggan', 'pelanggan.id = antrian.id_pelanggan', 'left');
        $this->db->join('kendaraan', 'kendaraan.id = antrian.id_kendaraan', 'left');
        $this->db->where('antrian.id', $id);
        return $this->db->get()->row();
    }

    // Ambil list item servis untuk antrian ini
    public function get_servis_by_antrian($id_antrian)
    {
        $this->db->where('id_antrian', $id_antrian);
        return $this->db->get('servis')->result();
    }

    // Ambil list item sparepart untuk antrian ini
    public function get_sparepart_by_antrian($id_antrian)
    {
        $this->db->where('id_antrian', $id_antrian);
        return $this->db->get('sparepart')->result();
    }

    // Tambah item servis
    public function add_servis($data)
    {
        return $this->db->insert('servis', $data);
    }

    // Tambah item sparepart
    public function add_sparepart($data)
    {
        return $this->db->insert('sparepart', $data);
    }

    // Hapus item servis
    public function delete_servis($id)
    {
        return $this->db->delete('servis', ['id' => $id]);
    }

    // Hapus item sparepart
    public function delete_sparepart($id)
    {
        return $this->db->delete('sparepart', ['id' => $id]);
    }

    // Ubah status antrian
    public function update_status_antrian($id_antrian, $status)
    {
        $this->db->where('id', $id_antrian);
        return $this->db->update('antrian', ['status' => $status]);
    }
}
