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
                    <?php if($this->session->userdata('role') == 'admin'): ?>
                    <a href="<?= base_url('backend/kendaraan') ?>" class="list-group-item list-group-item-action"><i class="bi bi-car-front me-2"></i> Data Kendaraan</a>
                    <?php endif; ?>
                    <a href="<?= base_url('backend/antrian') ?>" class="list-group-item list-group-item-action"><i class="bi bi-list-ol me-2"></i> Antrean</a>
                    <a href="<?= base_url('backend/servis') ?>" class="list-group-item list-group-item-action active"><i class="bi bi-tools me-2"></i> Data Servis</a>
                    <a href="#" class="list-group-item list-group-item-action text-danger" onclick="event.preventDefault(); window.location.href='<?= base_url('login/logout') ?>';"><i class="bi bi-box-arrow-right me-2"></i> Log out</a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9">
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
                        <h4 class="fw-bold text-primary mb-1"><i class="bi bi-tools me-2"></i> Daftar Antrean Servis</h4>
                        <p class="text-muted small mb-0">Manajemen antrean perbaikan dan perawatan kendaraan.</p>
                    </div>
                </div>

                <div class="card-body mt-2">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 15%">No. Antrean</th>
                                    <th style="width: 15%">Tanggal</th>
                                    <th style="width: 25%">Pelanggan</th>
                                    <th style="width: 20%">Kendaraan</th>
                                    <th style="width: 15%">Status</th>
                                    <th style="width: 10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($antrian)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox-fill d-block mb-3 text-secondary" style="font-size: 48px;"></i>
                                        <p class="mb-0 fw-semibold">Belum ada data antrean</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach($antrian as $a): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary text-white" style="font-size: 14px;">
                                            #<?= str_pad($a->no_antrian, 3, '0', STR_PAD_LEFT) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($a->tgl_antrian)) ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($a->nama_pelanggan) ?></div>
                                        <div class="text-muted small"><i class="bi bi-telephone-fill me-1"></i><?= $a->no_hp ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-primary"><?= $a->merk . ' ' . $a->tipe ?></div>
                                        <span class="badge bg-dark font-monospace text-uppercase px-2 py-1 border border-secondary shadow-sm" style="border-radius: 4px;">
                                            <?= $a->plat_nomor ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                            $badge = 'bg-secondary';
                                            if($a->status == 'selesai') $badge = 'bg-success';
                                            if($a->status == 'diproses') $badge = 'bg-warning';
                                            if($a->status == 'menunggu') $badge = 'bg-info';
                                        ?>
                                        <span class="badge <?= $badge ?> text-uppercase"><?= $a->status ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('backend/servis/detail/'.$a->id) ?>" class="btn btn-sm btn-outline-primary shadow-sm hover-up transition" title="Detail Antrean">
                                            <i class="bi bi-search me-1"></i> Detail
                                        </a>
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
