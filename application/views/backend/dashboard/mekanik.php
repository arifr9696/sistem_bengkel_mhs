

<div class="container mt-4">
    <div class="row">
        
        <div class="col-md-3 mb-4">
            <div class="card glass-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="bi bi-wrench"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-1"><?= html_escape($nama) ?></h5>
                    <p class="text-muted small mb-0">@<?= html_escape($username) ?></p>
                    <span class="badge bg-success mt-2 px-3 py-2 text-uppercase"><?= html_escape($role) ?></span>
                </div>
                <div class="list-group list-group-flush border-top">
                    <a href="#" class="list-group-item list-group-item-action active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                    <a href="<?= base_url('backend/servis') ?>" class="list-group-item list-group-item-action"><i class="bi bi-tools me-2"></i> Data Servis</a>
                    <a href="#" class="list-group-item list-group-item-action text-danger" onclick="event.preventDefault(); window.location.href='<?= base_url('login/logout') ?>';"><i class="bi bi-box-arrow-right me-2"></i> Log out</a>
                </div>
            </div>
        </div>

        
        <div class="col-md-9">
            <div class="card glass-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="fw-bold text-primary mb-0"><i class="bi bi-grid me-2"></i> Menu Mekanik</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light hover-shadow transition">
                                <h6 class="fw-bold"><i class="bi bi-list-ol text-primary me-2"></i> Daftar Antrian</h6>
                                <p class="small text-muted mb-0">Lihat daftar kendaraan yang sedang mengantri untuk diservis.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light hover-shadow transition">
                                <h6 class="fw-bold"><i class="bi bi-arrow-repeat text-primary me-2"></i> Update Status</h6>
                                <p class="small text-muted mb-0">Ubah status servis (menunggu, diproses, selesai).</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light hover-shadow transition">
                                <h6 class="fw-bold"><i class="bi bi-card-checklist text-primary me-2"></i> Detail Servis</h6>
                                <p class="small text-muted mb-0">Lihat riwayat dan detail servis untuk setiap kendaraan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
.hover-shadow.transition { transition: all 0.3s ease; cursor: pointer; }
.hover-shadow.transition:hover { box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; transform: translateY(-3px); }
</style>


