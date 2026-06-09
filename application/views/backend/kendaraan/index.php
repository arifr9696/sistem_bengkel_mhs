<div class="container mt-4">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-md-3 mb-4">
            <div class="card glass-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-1"><?= html_escape($this->session->userdata('nama')) ?></h5>
                    <p class="text-muted small mb-0">@<?= html_escape($this->session->userdata('username')) ?></p>
                    <span class="badge bg-success mt-2 px-3 py-2 text-uppercase"><?= html_escape($this->session->userdata('role')) ?></span>
                </div>
                    <div class="list-group list-group-flush border-top">
                        <a href="<?= base_url('backend/dashboard') ?>" class="list-group-item list-group-item-action"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                        <a href="<?= base_url('backend/kendaraan') ?>" class="list-group-item list-group-item-action active"><i class="bi bi-car-front me-2"></i> Data Kendaraan</a>
                        <a href="<?= base_url('backend/antrian') ?>" class="list-group-item list-group-item-action"><i class="bi bi-list-ol me-2"></i> Antrean</a>
                        <a href="<?= base_url('backend/servis') ?>" class="list-group-item list-group-item-action"><i class="bi bi-wrench me-2"></i> Data Servis</a>
                        <a href="#" class="list-group-item list-group-item-action text-danger" onclick="event.preventDefault(); window.location.href='<?= base_url('login/logout') ?>';"><i class="bi bi-box-arrow-right me-2"></i> Log out</a>
                    </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9">
            <!-- Flash Message Alerts -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card glass-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold text-primary mb-1"><i class="bi bi-car-front me-2"></i> Kelola Data Kendaraan</h4>
                        <p class="text-muted small mb-0">Manajemen kendaraan pelanggan yang terdaftar untuk diservis.</p>
                    </div>
                    <a href="<?= base_url('backend/kendaraan/tambah') ?>" class="btn btn-primary btn-sm px-3 py-2 rounded-3 shadow-sm hover-up transition">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Kendaraan
                    </a>
                </div>

                <div class="card-body mt-2">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 25%">Pemilik (Pelanggan)</th>
                                    <th style="width: 20%">Plat Nomor</th>
                                    <th style="width: 25%">Merk &amp; Tipe</th>
                                    <th style="width: 10%">Tahun</th>
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($kendaraan)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox-fill d-block mb-3 text-secondary" style="font-size: 48px;"></i>
                                            <p class="mb-0 fw-semibold">Belum ada data kendaraan</p>
                                            <small>Silakan klik tombol "Tambah Kendaraan" untuk memasukkan data baru.</small>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach ($kendaraan as $k): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <div class="fw-bold text-dark"><?= html_escape($k['nama_pelanggan'] ? $k['nama_pelanggan'] : 'Tidak Diketahui') ?></div>
                                                <div class="text-muted small"><i class="bi bi-telephone-fill me-1"></i><?= html_escape($k['no_hp_pelanggan'] ? $k['no_hp_pelanggan'] : '-') ?></div>
                                            </td>
                                            <td>
                                                <span class="badge bg-dark font-monospace text-uppercase px-3 py-2 border border-secondary shadow-sm" style="font-size: 14px; letter-spacing: 1px; border-radius: 4px;">
                                                    <?= html_escape($k['plat_nomor']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="fw-semibold text-primary"><?= html_escape($k['merk']) ?></div>
                                                <div class="text-muted small"><?= html_escape($k['tipe']) ?></div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary px-2 py-1"><?= html_escape($k['tahun']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?= base_url('backend/kendaraan/edit/' . $k['id']) ?>" class="btn btn-outline-warning" title="Edit Data">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <a href="<?= base_url('backend/kendaraan/delete/' . $k['id']) ?>" class="btn btn-outline-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus data kendaraan [<?= html_escape($k['plat_nomor']) ?>] ini? Semua data antrian yang berelasi dengan kendaraan ini juga akan terhapus.');">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-up { transition: all 0.2s ease-in-out; }
.hover-up:hover { transform: translateY(-2px); }
.transition { transition: all 0.3s ease; }
</style>
