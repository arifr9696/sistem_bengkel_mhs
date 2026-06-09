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
                    <a href="<?= base_url('backend/servis') ?>" class="list-group-item list-group-item-action active"><i class="bi bi-tools me-2"></i> Data Servis</a>
                    <a href="#" class="list-group-item list-group-item-action text-danger" onclick="event.preventDefault(); window.location.href='<?= base_url('login/logout') ?>';"><i class="bi bi-box-arrow-right me-2"></i> Log out</a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-primary mb-0"><i class="bi bi-card-checklist me-2"></i> Detail Servis</h4>
                <a href="<?= base_url('backend/servis') ?>" class="btn btn-outline-secondary btn-sm shadow-sm hover-up transition">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Info Antrean & Total Biaya -->
                <div class="col-lg-5">
                    <div class="card glass-card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <h6 class="fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i>Info Antrean</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">No. Antrean</span>
                                <strong class="text-dark">#<?= str_pad($antrian->no_antrian, 3, '0', STR_PAD_LEFT) ?></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tanggal</span>
                                <strong class="text-dark"><?= date('d/m/Y', strtotime($antrian->tgl_antrian)) ?></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                <span class="text-muted">Status</span>
                                <div>
                                    <?php
                                        $badge = 'bg-secondary';
                                        if($antrian->status == 'selesai') $badge = 'bg-success';
                                        if($antrian->status == 'diproses') $badge = 'bg-warning';
                                        if($antrian->status == 'menunggu') $badge = 'bg-info';
                                    ?>
                                    <span class="badge <?= $badge ?> me-1"><?= strtoupper($antrian->status) ?></span>
                                    
                                    <!-- Dropdown Status -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.1rem 0.5rem; font-size: 0.75rem;">
                                            Ubah
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            <li><a class="dropdown-item" href="<?= base_url('backend/servis/update_status/'.$antrian->id.'/menunggu') ?>"><i class="bi bi-clock me-2 text-info"></i>Menunggu</a></li>
                                            <li><a class="dropdown-item" href="<?= base_url('backend/servis/update_status/'.$antrian->id.'/diproses') ?>"><i class="bi bi-arrow-repeat me-2 text-warning"></i>Diproses</a></li>
                                            <li><a class="dropdown-item" href="<?= base_url('backend/servis/update_status/'.$antrian->id.'/selesai') ?>"><i class="bi bi-check-circle me-2 text-success"></i>Selesai</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr class="border-secondary opacity-25">
                            <div class="mb-2">
                                <span class="text-muted d-block small">Pelanggan</span>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($antrian->nama_pelanggan) ?></div>
                                <div class="small text-muted"><i class="bi bi-telephone me-1"></i> <?= $antrian->no_hp ?></div>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted d-block small">Kendaraan</span>
                                <div class="fw-bold text-dark"><?= $antrian->merk . ' ' . $antrian->tipe ?></div>
                            </div>
                            <div class="mb-3">
                                <span class="text-muted d-block small">Plat Nomor / Tahun</span>
                                <span class="badge bg-dark font-monospace px-2 py-1"><?= $antrian->plat_nomor ?></span> <span class="text-muted small">/ <?= $antrian->tahun ?></span>
                            </div>
                            <hr class="border-secondary opacity-25">
                            <div>
                                <span class="text-muted d-block small mb-1">Keluhan</span>
                                <p class="text-dark small mb-0 bg-light p-2 rounded border"><?= nl2br(htmlspecialchars($antrian->keluhan)) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-primary text-white shadow-sm border-0 text-center hover-up transition">
                        <div class="card-body py-4">
                            <h6 class="text-white-50 mb-2">Total Biaya Servis</h6>
                            <h2 class="fw-bold mb-0">Rp <?= number_format($total_biaya, 0, ',', '.') ?></h2>
                        </div>
                    </div>
                </div>

                <!-- Tabel Item Servis & Sparepart -->
                <div class="col-lg-7">
                    <div class="card glass-card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <h6 class="fw-bold mb-0"><i class="bi bi-tools text-success me-2"></i>Item Servis & Sparepart</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 15%">Tipe</th>
                                            <th style="width: 40%">Nama Item</th>
                                            <th style="width: 15%" class="text-center">Qty</th>
                                            <th style="width: 20%" class="text-end">Subtotal</th>
                                            <th style="width: 10%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($list_servis) && empty($list_sparepart)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox d-block mb-2 text-secondary" style="font-size: 24px;"></i>
                                                    Belum ada item ditambahkan
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                        <!-- Loop Servis -->
                                        <?php foreach($list_servis as $s): ?>
                                            <tr>
                                                <td><span class="badge bg-info bg-opacity-10 text-info border border-info"><i class="bi bi-wrench me-1"></i> Servis</span></td>
                                                <td>
                                                    <div class="fw-bold text-dark"><?= $s->jenis_servis ?></div>
                                                    <div class="small text-muted"><?= $s->keterangan ?></div>
                                                </td>
                                                <td class="text-center">1</td>
                                                <td class="text-end fw-bold">Rp <?= number_format($s->biaya_servis, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('backend/servis/delete_item/servis/'.$s->id.'/'.$antrian->id) ?>" 
                                                       class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus item servis ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <!-- Loop Sparepart -->
                                        <?php foreach($list_sparepart as $sp): ?>
                                            <tr>
                                                <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary"><i class="bi bi-gear me-1"></i> Part</span></td>
                                                <td>
                                                    <div class="fw-bold text-dark"><?= $sp->nama_part ?></div>
                                                    <div class="small text-success">@ Rp <?= number_format($sp->harga_satuan, 0, ',', '.') ?></div>
                                                </td>
                                                <td class="text-center"><?= $sp->qty ?></td>
                                                <td class="text-end fw-bold">Rp <?= number_format($sp->harga_satuan * $sp->qty, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('backend/servis/delete_item/sparepart/'.$sp->id.'/'.$antrian->id) ?>" 
                                                       class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus item sparepart ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <?php if(!empty($list_servis) || !empty($list_sparepart)): ?>
                                    <tfoot>
                                        <tr class="table-light">
                                            <td colspan="3" class="text-end fw-bold">TOTAL BIAYA</td>
                                            <td class="text-end fw-bold text-primary">Rp <?= number_format($total_biaya, 0, ',', '.') ?></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Form Tambah Item -->
                    <div class="card glass-card shadow-sm border-0 border-top border-warning border-3">
                        <div class="card-body">
                            <h6 class="mb-3 fw-bold text-warning"><i class="bi bi-plus-circle me-2"></i>Tambah Item</h6>
                            <form action="<?= base_url('backend/servis/add_item/'.$antrian->id) ?>" method="POST">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label small text-muted mb-1">Tipe</label>
                                        <select name="tipe" id="tipeSelect" class="form-select" required onchange="toggleItemSelect()">
                                            <option value="">-- Pilih --</option>
                                            <option value="servis">Servis Jasa</option>
                                            <option value="sparepart">Sparepart</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-5" id="servisGroup" style="display:none;">
                                        <label class="form-label small text-muted mb-1">Jenis Servis</label>
                                        <input type="text" class="form-control bg-light" value="Servis Bengkel Motor (Rp 150.000)" disabled>
                                    </div>

                                    <div class="col-md-5" id="sparepartGroup" style="display:none;">
                                        <label class="form-label small text-muted mb-1">Pilih Sparepart</label>
                                        <select name="sparepart_id" class="form-select">
                                            <option value="">-- Pilih Sparepart --</option>
                                            <?php foreach($master_sparepart as $ms): ?>
                                                <option value="<?= $ms['id'] ?>"><?= $ms['nama'] ?> - Rp <?= number_format($ms['harga'], 0, ',', '.') ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label small text-muted mb-1">Qty</label>
                                        <input type="number" name="qty" class="form-control text-center" value="1" min="1" required>
                                    </div>

                                    <div class="col-12 col-md-auto">
                                        <button type="submit" class="btn btn-primary px-4 text-nowrap hover-up transition" style="min-height: 38px;">
                                            <i class="bi bi-save me-1"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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

<script>
function toggleItemSelect() {
    const tipe = document.getElementById('tipeSelect').value;
    const servisGroup = document.getElementById('servisGroup');
    const sparepartGroup = document.getElementById('sparepartGroup');
    
    if (tipe === 'servis') {
        servisGroup.style.display = 'block';
        sparepartGroup.style.display = 'none';
        document.querySelector('select[name="sparepart_id"]').removeAttribute('required');
    } else if (tipe === 'sparepart') {
        servisGroup.style.display = 'none';
        sparepartGroup.style.display = 'block';
        document.querySelector('select[name="sparepart_id"]').setAttribute('required', 'required');
    } else {
        servisGroup.style.display = 'none';
        sparepartGroup.style.display = 'none';
        document.querySelector('select[name="sparepart_id"]').removeAttribute('required');
    }
}
</script>

