
CREATE DATABASE IF NOT EXISTS `db_bengkel_motor`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `db_bengkel_motor`;

CREATE TABLE IF NOT EXISTS `user` (
  `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama`     VARCHAR(100) NOT NULL,
  `username` VARCHAR(50)  NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role`     ENUM('admin','mekanik','kasir') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`nama`, `username`, `password`, `role`) VALUES
('Administrator', 'admin',   '$2y$10$2.iCyjri3dausc2E0PS.0eykQUZEGYcjioh.frbsRCR3X6.qMuMTq', 'admin'),
('Mekanik Utama', 'mekanik', '$2y$10$tj.xPl3.EzA4PwEWd66VZ.gZGMpnAXfBZcbCV74tie27G2NWKTRma', 'mekanik'),
('Kasir Utama',   'kasir',   '$2y$10$x7vCAaIl3rbn4XbwbTtb6OS7eXeR5OVO2Kt0iOaTCSk4Vp6A1DS5u', 'kasir')
ON DUPLICATE KEY UPDATE
  `nama` = VALUES(`nama`), `password` = VALUES(`password`), `role` = VALUES(`role`);

CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama`     VARCHAR(100) NOT NULL,
  `no_hp`    VARCHAR(20)  NOT NULL,
  `alamat`   TEXT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_no_hp` (`no_hp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `kendaraan` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pelanggan` INT UNSIGNED NOT NULL,
  `merk`         VARCHAR(50) NOT NULL,
  `tipe`         VARCHAR(50) NOT NULL,
  `plat_nomor`   VARCHAR(20) NOT NULL,
  `tahun`        YEAR        NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_plat` (`plat_nomor`),
  KEY `fk_kendaraan_pelanggan` (`id_pelanggan`),
  CONSTRAINT `fk_kendaraan_pelanggan`
    FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `antrian` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `no_antrian`   INT          NOT NULL,
  `id_kendaraan` INT UNSIGNED NOT NULL,
  `id_pelanggan` INT UNSIGNED NOT NULL,
  `keluhan`      TEXT,
  `status`       ENUM('menunggu','diproses','selesai') NOT NULL DEFAULT 'menunggu',
  `tgl_antrian`  DATE         NOT NULL,
  `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_antrian_kendaraan` (`id_kendaraan`),
  KEY `fk_antrian_pelanggan` (`id_pelanggan`),
  CONSTRAINT `fk_antrian_kendaraan`
    FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id`),
  CONSTRAINT `fk_antrian_pelanggan`
    FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `servis` (
  `id`          INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  `id_antrian`  INT UNSIGNED   NOT NULL,
  `jenis_servis` VARCHAR(100)  NOT NULL,
  `biaya_servis` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `keterangan`  TEXT,
  PRIMARY KEY (`id`),
  KEY `fk_servis_antrian` (`id_antrian`),
  CONSTRAINT `fk_servis_antrian`
    FOREIGN KEY (`id_antrian`) REFERENCES `antrian` (`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `sparepart` (
  `id`          INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  `id_antrian`  INT UNSIGNED   NOT NULL,
  `nama_part`   VARCHAR(100)   NOT NULL,
  `qty`         INT            NOT NULL DEFAULT 1,
  `harga_satuan` DECIMAL(12,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_sparepart_antrian` (`id_antrian`),
  CONSTRAINT `fk_sparepart_antrian`
    FOREIGN KEY (`id_antrian`) REFERENCES `antrian` (`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `transaksi` (
  `id`           INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  `id_antrian`   INT UNSIGNED   NOT NULL,
  `total_biaya`  DECIMAL(12,2)  NOT NULL DEFAULT 0,
  `bayar`        DECIMAL(12,2)  NOT NULL DEFAULT 0,
  `kembalian`    DECIMAL(12,2)  NOT NULL DEFAULT 0,
  `tgl_transaksi` DATE          NOT NULL,
  `status_bayar` ENUM('belum','lunas') NOT NULL DEFAULT 'belum',
  `created_at`   TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_antrian` (`id_antrian`),
  CONSTRAINT `fk_transaksi_antrian`
    FOREIGN KEY (`id_antrian`) REFERENCES `antrian` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
