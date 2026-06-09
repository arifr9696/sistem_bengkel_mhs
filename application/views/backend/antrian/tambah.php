<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Antrean</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { background: #f4f6f9; min-height: 100vh; }
        .topbar { background: #3167e3; color: #fff; padding: 14px 0; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .brand { font-weight: 700; font-size: 20px; letter-spacing: .2px; }
        .glass-card { border-radius: 14px; background: #fff; }
        .sidebar-menu .list-group-item { border: 0; border-bottom: 1px solid #f1f1f1; padding: 13px 18px; font-weight: 500; }
        .sidebar-menu .list-group-item.active { background: #3167e3; color: #fff; }
        .sidebar-menu .list-group-item:hover { background: #eef3ff; color: #3167e3; }
        .sidebar-menu .list-group-item.active:hover { background: #3167e3; color: #fff; }
        .footer { margin-top: 40px; padding: 18px 0; background: #316CF4; color: #fff; text-align: center; }
        .page-title { font-weight: 700; color: #3167e3; }
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
                    <a href="<?= base_url('backend/dashboard') ?>" class="list-group-item list-group-item-action"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                    <a href="<?= base_url('backend/kendaraan') ?>" class="list-group-item list-group-item-action"><i class="bi bi-car-front me-2"></i> Data Kendaraan</a>
                    <a href="<?= base_url('backend/antrian') ?>" class="list-group-item list-group-item-action active"><i class="bi bi-list-ol me-2"></i> Antrean</a>
                    <a href="<?= base_url('backend/servis') ?>" class="list-group-item list-group-item-action"><i class="bi bi-tools me-2"></i> Data Servis</a>
                    <a href="<?= base_url('login/logout') ?>" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right me-2"></i> Log out</a>
                </div>
            </div>
        </div>

        <!-- Form Input -->
        <div class="col-md-9">
            <div class="card glass-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="page-title mb-1"><i class="bi bi-list-ol me-2"></i> Tambah Antrean</h4>
                    <p class="text-muted small mb-0">Masukkan data pelanggan dan pilih kendaraan untuk membuat nomor antrean otomatis.</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <form action="<?= base_url('backend/antrian/tambah') ?>" method="POST">
                        <div class="mb-3">
                            <label>Pelanggan</label>
                            <select name="id_pelanggan" class="form-control" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php foreach ($pelanggan as $p): ?>
                                    <option value="<?= $p->id ?>"><?= $p->nama ?> (<?= $p->no_hp ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Kendaraan</label>
                            <select name="id_kendaraan" class="form-control" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                <?php foreach ($kendaraan as $k): ?>
                                    <option value="<?= $k->id ?>"><?= $k->plat_nomor ?> - <?= $k->merk ?> <?= $k->tipe ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tgl_antrian">Tanggal Kunjungan</label>
                            <input type="date" name="tgl_antrian" id="tgl_antrian" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Keluhan</label>
                            <textarea class="form-control" name="keluhan" rows="3" placeholder="Masukkan keluhan" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary shadow-sm">Simpan Antrean</button>
                        <a href="<?= base_url('backend/antrian') ?>" class="btn btn-secondary shadow-sm">Batal</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>