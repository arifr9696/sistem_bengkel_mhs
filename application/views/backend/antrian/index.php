<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= html_escape($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .hover-up { transition: all 0.2s ease-in-out; }
        .hover-up:hover { transform: translateY(-2px); }
        .transition { transition: all 0.3s ease; }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card glass-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; font-size: 28px;">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-1"><?= html_escape($nama) ?></h5>
                    <p class="text-muted small mb-0">@<?= html_escape($username) ?></p>
                    <span class="badge bg-success mt-2 px-3 py-2 text-uppercase"><?= html_escape($role) ?></span>
                </div>
                <div class="list-group list-group-flush border-top sidebar-menu">
                    <a href="<?= base_url('backend/dashboard') ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="<?= base_url('backend/kendaraan') ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-car-front me-2"></i> Data Kendaraan
                    </a>
                    <a href="<?= base_url('backend/antrian') ?>" class="list-group-item list-group-item-action active">
                        <i class="bi bi-list-ol me-2"></i> Antrean
                    </a>
                    <a href="<?= base_url('backend/servis') ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-tools me-2"></i> Data Servis
                    </a>
                    <a href="<?= base_url('login/logout') ?>" class="list-group-item list-group-item-action text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Log out
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php
                $grouped = [];

                if (!empty($antrian)) {
                    foreach ($antrian as $a) {
                        $grouped[$a->tgl_antrian][] = $a;
                    }

                    krsort($grouped);
                }
            ?>

            <?php if (!empty($grouped)): ?>

                <?php foreach ($grouped as $tgl => $list): ?>
                    <div class="card glass-card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="fw-bold text-primary mb-1">
                                Tanggal <?= date('d/m/Y', strtotime($tgl)) ?>
                            </h4>
                            <a href="<?= base_url('backend/antrian/tambah') ?>" class="btn btn-primary btn-sm shadow-sm hover-up transition">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Antrean
                            </a>
                        </div>

                        <div class="card-body mt-2">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:12%">No. Antrean</th>
                                            <th style="width:25%">Pelanggan</th>
                                            <th style="width:20%">Kendaraan</th>
                                            <th style="width:12%">Status</th>
                                            <th style="width:31%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list as $a): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary text-white queue-badge">
                                                        #<?= str_pad($a->no_antrian, 3, '0', STR_PAD_LEFT) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-dark">
                                                        <?= html_escape($a->nama_pelanggan) ?>
                                                    </div>
                                                    <div class="text-muted small">
                                                        <i class="bi bi-telephone-fill me-1"></i>
                                                        <?= html_escape($a->no_hp) ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold text-primary">
                                                        <?= html_escape($a->merk . ' ' . $a->tipe) ?>
                                                    </div>
                                                    <span class="badge bg-dark font-monospace text-uppercase px-2 py-1 border border-secondary shadow-sm" style="border-radius:4px;">
                                                        <?= html_escape($a->plat_nomor) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                        $badge = 'bg-secondary';

                                                        if ($a->status == 'selesai') {
                                                            $badge = 'bg-success';
                                                        } elseif ($a->status == 'diproses') {
                                                            $badge = 'bg-warning';
                                                        } elseif ($a->status == 'menunggu') {
                                                            $badge = 'bg-info';
                                                        }
                                                    ?>
                                                    <span class="badge <?= $badge ?> text-uppercase">
                                                        <?= html_escape($a->status) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('backend/antrian/edit/' . $a->id) ?>" class="btn btn-sm btn-outline-primary shadow-sm hover-up transition" title="Edit">
                                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                                    </a>
                                                    <a href="<?= base_url('backend/antrian/hapus/' . $a->id) ?>" class="btn btn-sm btn-outline-danger shadow-sm hover-up transition" title="Hapus" onclick="return confirm('Yakin ingin menghapus data antrean ini?')">
                                                        <i class="bi bi-trash me-1"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>

                <div class="card glass-card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold text-primary mb-1">
                            Data Antrean
                        </h4>
                        <a href="<?= base_url('backend/antrian/tambah') ?>" class="btn btn-primary btn-sm shadow-sm hover-up transition">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Antrean
                        </a>
                    </div>

                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-inbox text-muted" style="font-size: 56px;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">
                            Belum ada data antrean
                        </h5>
                        <p class="text-muted mb-4">
                            Data antrean masih kosong. Silakan tambahkan antrean baru untuk mulai mengelola antrean bengkel.
                        </p>
                        <a href="<?= base_url('backend/antrian/tambah') ?>" class="btn btn-primary shadow-sm hover-up transition">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Antrean Sekarang
                        </a>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>