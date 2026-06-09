<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    /**
     * Ambil semua transaksi dengan join ke antrian, pelanggan, kendaraan
     */
    public function get_all_transaksi()
    {
        $this->db->select('transaksi.*, antrian.no_antrian, pelanggan.nama as nama_pelanggan, pelanggan.no_hp, kendaraan.plat_nomor, kendaraan.merk, kendaraan.tipe');
        $this->db->from('transaksi');
        $this->db->join('antrian',   'antrian.id = transaksi.id_antrian',   'left');
        $this->db->join('pelanggan', 'pelanggan.id = antrian.id_pelanggan', 'left');
        $this->db->join('kendaraan', 'kendaraan.id = antrian.id_kendaraan', 'left');
        $this->db->order_by('transaksi.id', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Ambil transaksi berdasarkan ID
     */
    public function get_transaksi_by_id($id)
    {
        $this->db->select('transaksi.*, antrian.no_antrian, antrian.id_pelanggan, antrian.keluhan, pelanggan.nama as nama_pelanggan, pelanggan.no_hp, kendaraan.plat_nomor, kendaraan.merk, kendaraan.tipe, servis.biaya_servis, sparepart.nama_part, sparepart.harga_satuan');
        $this->db->from('transaksi');
        $this->db->join('antrian',   'antrian.id = transaksi.id_antrian',   'left');
        $this->db->join('pelanggan', 'pelanggan.id = antrian.id_pelanggan', 'left');
        $this->db->join('kendaraan', 'kendaraan.id = antrian.id_kendaraan', 'left');
        $this->db->join('servis',    'servis.id_antrian = transaksi.id_antrian', 'left');
        $this->db->join('sparepart', 'sparepart.id_antrian = transaksi.id_antrian', 'left');
        $this->db->where('transaksi.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Ambil antrian yang sudah selesai diservice dan belum ada transaksinya
     * (Antrian dengan status 'selesai' dan ada data di tabel servis)
     */
    public function get_antrian_siap_bayar()
    {
        $this->db->select('antrian.*, pelanggan.nama as nama_pelanggan, kendaraan.plat_nomor, kendaraan.merk');
        $this->db->from('antrian');
        $this->db->join('pelanggan', 'pelanggan.id = antrian.id_pelanggan');
        $this->db->join('kendaraan', 'kendaraan.id = antrian.id_kendaraan');
        $this->db->join('transaksi', 'transaksi.id_antrian = antrian.id', 'left');
        $this->db->where('antrian.status', 'selesai');
        $this->db->where('transaksi.id IS NULL', null, false);
        $antrians = $this->db->get()->result();
        
        foreach ($antrians as $a) {
            $total = 0;
            
            // Hitung total servis
            $this->db->select_sum('biaya_servis');
            $this->db->where('id_antrian', $a->id);
            $servis = $this->db->get('servis')->row();
            if ($servis && $servis->biaya_servis) {
                $total += $servis->biaya_servis;
            }

            // Hitung total sparepart
            $this->db->select('SUM(harga_satuan * qty) as total_sparepart');
            $this->db->where('id_antrian', $a->id);
            $sparepart = $this->db->get('sparepart')->row();
            if ($sparepart && $sparepart->total_sparepart) {
                $total += $sparepart->total_sparepart;
            }

            $a->biaya_servis = $total; // Assign back as 'biaya_servis' for compatibility with UI
        }

        return $antrians;
    }

    /**
     * Simpan transaksi baru
     */
    public function insert_transaksi($data)
    {
        return $this->db->insert('transaksi', $data);
    }

    /**
     * Update status bayar transaksi
     */
    public function update_transaksi($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('transaksi', $data);
    }

    /**
     * Hapus transaksi
     */
    public function delete_transaksi($id)
    {
        return $this->db->delete('transaksi', ['id' => $id]);
    }
}
