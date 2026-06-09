<div class="container-fluid pt-4 px-4">
    <div class="row g-4 justify-content-center">
        <div class="col-sm-12 col-xl-8">
            <div class="bg-light rounded h-100 p-4 shadow-sm">
                <h6 class="mb-4"><i class="bi bi-receipt me-2"></i>Form Input Transaksi Pembayaran</h6>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(empty($antrian)): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Tidak ada antrean siap bayar.</strong><br>
                        Pastikan mekanik sudah menginput data servis dan status antrean sudah <em>selesai</em> terlebih dahulu.
                    </div>
                    <a href="<?= base_url('backend/transaksi') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                <?php else: ?>
                <form action="<?= base_url('backend/transaksi/simpan') ?>" method="POST" id="formTransaksi">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Antrean Servis (Siap Bayar)</label>
                        <select name="id_antrian" id="id_antrian" class="form-select" required onchange="loadBiaya(this)">
                            <option value="">-- Pilih Antrean yang Sudah Selesai --</option>
                            <?php foreach($antrian as $a): ?>
                                <option value="<?= $a->id ?>" data-biaya="<?= $a->biaya_servis ?>">
                                    No. <?= $a->no_antrian ?> - <?= html_escape($a->nama_pelanggan) ?> (<?= $a->plat_nomor ?> - <?= $a->merk ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-success"><i class="bi bi-info-circle me-1"></i>Hanya menampilkan antrean berstatus <strong>Selesai</strong> yang belum dibayar.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Total Biaya Servis</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="display_total" class="form-control" readonly placeholder="Pilih antrean terlebih dahulu" style="background:#e9ecef;">
                            <input type="hidden" name="total_biaya" id="total_biaya" value="0">
                        </div>
                        <small class="text-muted">Total biaya dihitung otomatis dari data servis (Harga Sparepart × 150.000)</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Uang Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="bayar" id="bayar" class="form-control" placeholder="Masukkan nominal uang bayar" min="0" required oninput="hitungKembalian()">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Kembalian</label>
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white">Rp</span>
                            <input type="text" id="display_kembalian" class="form-control fw-bold text-success fs-5" readonly value="0" style="background:#e9ecef;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('backend/transaksi') ?>" class="btn btn-secondary me-2">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-success" id="btnSimpan" disabled>
                            <i class="bi bi-save me-1"></i>Simpan Transaksi
                        </button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function formatRupiah(angka) {
        return angka.toLocaleString('id-ID');
    }

    function loadBiaya(selectEl) {
        const selected = selectEl.options[selectEl.selectedIndex];
        const biaya    = parseFloat(selected.getAttribute('data-biaya')) || 0;
        
        document.getElementById('total_biaya').value     = biaya;
        document.getElementById('display_total').value   = formatRupiah(biaya);
        document.getElementById('bayar').value           = '';
        document.getElementById('display_kembalian').value = '0';
        document.getElementById('btnSimpan').disabled    = true;
        
        hitungKembalian();
    }

    function hitungKembalian() {
        const total     = parseFloat(document.getElementById('total_biaya').value) || 0;
        const bayar     = parseFloat(document.getElementById('bayar').value) || 0;
        const kembalian = bayar - total;
        const btnSimpan = document.getElementById('btnSimpan');
        const displayKembalian = document.getElementById('display_kembalian');

        if (kembalian >= 0 && bayar > 0 && total > 0) {
            displayKembalian.value = formatRupiah(kembalian);
            displayKembalian.classList.remove('text-danger');
            displayKembalian.classList.add('text-success');
            btnSimpan.disabled = false;
        } else if (bayar > 0 && total > 0) {
            displayKembalian.value = 'Uang kurang: Rp ' + formatRupiah(Math.abs(kembalian));
            displayKembalian.classList.remove('text-success');
            displayKembalian.classList.add('text-danger');
            btnSimpan.disabled = true;
        } else {
            displayKembalian.value = '0';
            btnSimpan.disabled = true;
        }
    }
</script>
