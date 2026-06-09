<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Antrian_model extends CI_Model
{
    public function get_all()
    {
        $this->db->select('
            antrian.id,
            antrian.no_antrian,
            antrian.keluhan,
            antrian.status,
            antrian.tgl_antrian,
            antrian.created_at,
            pelanggan.nama AS nama_pelanggan,
            pelanggan.no_hp,
            kendaraan.merk,
            kendaraan.tipe,
            kendaraan.plat_nomor
        ');
        $this->db->from('antrian');
        $this->db->join('pelanggan', 'pelanggan.id = antrian.id_pelanggan', 'left');
        $this->db->join('kendaraan', 'kendaraan.id = antrian.id_kendaraan', 'left');
        $this->db->order_by('antrian.tgl_antrian', 'DESC');
        $this->db->order_by('antrian.no_antrian', 'ASC');

        return $this->db->get()->result();
    }

    public function get_hari_ini()
    {
        $this->db->select('
            antrian.id,
            antrian.no_antrian,
            antrian.keluhan,
            antrian.status,
            antrian.tgl_antrian,
            pelanggan.nama AS nama_pelanggan,
            pelanggan.no_hp,
            kendaraan.merk,
            kendaraan.tipe,
            kendaraan.plat_nomor
        ');
        $this->db->from('antrian');
        $this->db->join('pelanggan', 'pelanggan.id = antrian.id_pelanggan', 'left');
        $this->db->join('kendaraan', 'kendaraan.id = antrian.id_kendaraan', 'left');
        $this->db->where('antrian.tgl_antrian', date('Y-m-d'));
        $this->db->order_by('antrian.no_antrian', 'ASC');

        return $this->db->get()->result();
    }

    public function delete($id)
    {
        return $this->db->delete('antrian', ['id' => $id]);
    }
}