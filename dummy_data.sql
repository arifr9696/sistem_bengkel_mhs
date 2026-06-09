USE db_bengkel_motor;

-- 1. Insert Pelanggan
INSERT INTO pelanggan (nama, no_hp, alamat) VALUES 
('Budi Santoso', '081234567890', 'Jl. Merdeka No. 10, Mataram'),
('Siti Aminah', '081987654321', 'Jl. Pendidikan No. 5, Mataram'),
('Ahmad Dahlan', '085333444555', 'Jl. Majapahit No. 20, Ampenan');

-- 2. Insert Kendaraan
INSERT INTO kendaraan (id_pelanggan, merk, tipe, plat_nomor, tahun) VALUES 
(1, 'Honda', 'Vario 150', 'DR 1234 AB', '2019'),
(2, 'Yamaha', 'NMAX', 'DR 5678 CD', '2020'),
(3, 'Honda', 'Beat', 'DR 9012 EF', '2018'),
(1, 'Honda', 'CBR 150', 'DR 3456 GH', '2021');

-- 3. Insert Antrian
INSERT INTO antrian (no_antrian, id_kendaraan, id_pelanggan, keluhan, status, tgl_antrian, created_at) VALUES 
(1, 1, 1, 'Ganti oli dan servis rutin', 'selesai', CURDATE(), NOW()),
(2, 2, 2, 'Rem blong dan ganti kampas', 'diproses', CURDATE(), NOW()),
(3, 3, 3, 'Lampu mati dan mesin mbrebet', 'menunggu', CURDATE(), NOW());

-- 4. Insert Sparepart
INSERT INTO sparepart (id_antrian, nama_part, qty, harga_satuan) VALUES 
(1, 'Oli Mesin MPX 2', 1, 50000.00),
(1, 'Busi Vario', 1, 25000.00),
(2, 'Kampas Rem Depan NMAX', 1, 75000.00),
(2, 'Minyak Rem', 1, 15000.00);

-- 5. Insert Servis
INSERT INTO servis (id_antrian, jenis_servis, biaya_servis, keterangan) VALUES 
(1, 'Servis Ringan', 50000.00, 'Servis karburator dan cvt'),
(2, 'Servis Berat', 150000.00, 'Perbaikan sistem pengereman total');

-- 6. Insert Transaksi (For the completed antrian)
INSERT INTO transaksi (id_antrian, total_biaya, bayar, kembalian, tgl_transaksi, status_bayar, created_at) VALUES 
(1, 125000.00, 150000.00, 25000.00, CURDATE(), 'lunas', NOW());
