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
                    <a href="#" class="list-group-item list-group-item-action text-danger" onclick="event.preventDefault(); window.location.href='<?= base_url('login/logout') ?>';"><i class="bi bi-box-arrow-right me-2"></i> Log out</a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9">
            <!-- Flash Message Alerts -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Validation Errors -->
            <?php if (validation_errors()): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-3" role="alert">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                    <strong>Periksa Input Anda:</strong>
                    <ul class="mb-0 mt-1 small">
                        <?= validation_errors('<li>', '</li>') ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card glass-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="fw-bold text-primary mb-1"><i class="bi bi-pencil-square me-2"></i> Edit Data Kendaraan</h4>
                    <p class="text-muted small mb-0">Ubah formulir di bawah ini untuk memperbarui data kendaraan pelanggan.</p>
                </div>

                <div class="card-body">
                    <form action="<?= base_url('backend/kendaraan/update/' . $kendaraan['id']) ?>" method="POST" class="needs-validation">
                        
                        <!-- Pilihan Pemilik (Pelanggan) -->
                        <div class="mb-3">
                            <label for="id_pelanggan" class="form-label fw-semibold">Pemilik (Pelanggan) <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_pelanggan" name="id_pelanggan" required>
                                <option value="">-- Pilih Pemilik (Pelanggan) --</option>
                                <?php foreach ($pelanggan as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= set_select('id_pelanggan', $p['id'], ($kendaraan['id_pelanggan'] == $p['id'])) ?>>
                                        <?= html_escape($p['nama']) ?> (<?= html_escape($p['no_hp']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Plat Nomor -->
                        <div class="mb-3">
                            <label for="plat_nomor" class="form-label fw-semibold">Plat Nomor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" id="plat_nomor" name="plat_nomor" 
                                   placeholder="Contoh: B 1234 ABC" value="<?= set_value('plat_nomor', $kendaraan['plat_nomor']) ?>" required>
                            <div class="form-text small">Plat nomor kendaraan harus unik dan tidak boleh ganda di sistem.</div>
                        </div>

                        <div class="row">
                            <!-- Merk Kendaraan -->
                            <div class="col-md-6 mb-3">
                                <label for="merk" class="form-label fw-semibold">Merk Kendaraan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="merk" name="merk" 
                                       placeholder="Contoh: Honda, Yamaha, Suzuki" value="<?= set_value('merk', $kendaraan['merk']) ?>" required>
                            </div>

                            <!-- Tipe Kendaraan -->
                            <div class="col-md-6 mb-3">
                                <label for="tipe" class="form-label fw-semibold">Tipe / Model <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tipe" name="tipe" 
                                       placeholder="Contoh: Beat, NMax, GSX" value="<?= set_value('tipe', $kendaraan['tipe']) ?>" required>
                            </div>
                        </div>

                        <!-- Tahun Pembuatan -->
                        <div class="mb-4">
                            <label for="tahun" class="form-label fw-semibold">Tahun Pembuatan <span class="text-danger">*</span></label>
                            <select class="form-select" id="tahun" name="tahun" required>
                                <option value="">-- Pilih Tahun --</option>
                                <?php 
                                $current_year = date('Y');
                                for ($year = $current_year; $year >= 2000; $year--): 
                                ?>
                                    <option value="<?= $year ?>" <?= set_select('tahun', $year, ($kendaraan['tahun'] == $year)) ?>><?= $year ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="<?= base_url('backend/kendaraan') ?>" class="btn btn-light px-4">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
