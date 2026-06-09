<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan_model extends CI_Model {

    public function get_all()
    {
        $this->db->select('kendaraan.*, pelanggan.nama AS nama_pelanggan, pelanggan.no_hp AS no_hp_pelanggan');
        $this->db->from('kendaraan');
        $this->db->join('pelanggan', 'kendaraan.id_pelanggan = pelanggan.id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('kendaraan.*, pelanggan.nama AS nama_pelanggan, pelanggan.no_hp AS no_hp_pelanggan');
        $this->db->from('kendaraan');
        $this->db->join('pelanggan', 'kendaraan.id_pelanggan = pelanggan.id', 'left');
        $this->db->where('kendaraan.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insert($data)
    {
        return $this->db->insert('kendaraan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('kendaraan', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('kendaraan');
    }

    public function get_pelanggan_list()
    {
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get('pelanggan');
        return $query->result_array();
    }

    public function check_plat_nomor($plat_nomor, $exclude_id = null)
    {
        $this->db->where('plat_nomor', $plat_nomor);
        if ($exclude_id !== null) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('kendaraan');
        return $query->num_rows() > 0;
    }
}
