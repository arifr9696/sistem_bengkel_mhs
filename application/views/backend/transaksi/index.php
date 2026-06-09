<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0"><i class="bi bi-receipt me-2"></i>Daftar Transaksi Pembayaran</h6>
                    <a href="<?= base_url('backend/transaksi/tambah') ?>" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>Input Transaksi Baru
                    </a>
                </div>

                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>No</th>
                                <th>No. Antrean</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Total Biaya</th>
                                <th>Bayar</th>
                                <th>Kembalian</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($transaksi as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge bg-info text-dark">No. <?= $t->no_antrian ?></span></td>
                                <td>
                                    <strong><?= html_escape($t->nama_pelanggan) ?></strong><br>
                                    <small class="text-muted"><?= $t->no_hp ?></small>
                                </td>
                                <td>
                                    <strong><?= $t->plat_nomor ?></strong><br>
                                    <small class="text-muted"><?= $t->merk ?></small>
                                </td>
                                <td><span class="text-danger fw-bold">Rp <?= number_format($t->total_biaya, 0, ',', '.') ?></span></td>
                                <td>Rp <?= number_format($t->bayar, 0, ',', '.') ?></td>
                                <td class="text-success fw-bold">Rp <?= number_format($t->kembalian, 0, ',', '.') ?></td>
                                <td><?= date('d/m/Y', strtotime($t->tgl_transaksi)) ?></td>
                                <td>
                                    <?php if($t->status_bayar == 'lunas'): ?>
                                        <span class="badge bg-success">LUNAS</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">BELUM</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('backend/transaksi/detail/'.$t->id) ?>" class="btn btn-sm btn-primary me-1" title="Lihat Struk">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('backend/transaksi/hapus/'.$t->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data transaksi ini?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                            <?php if(empty($transaksi)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data transaksi
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
