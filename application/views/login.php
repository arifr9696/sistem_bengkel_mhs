

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card glass-card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4 text-primary fw-bold">Login Bengkel</h3>

        <?php if($this->session->flashdata('message')): ?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <?= $this->session->flashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('login/index') ?>">
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">MASUK</button>
        </form>

        <div class="text-center mt-3 text-muted small">
            Role yang tersedia: <strong>Admin, Mekanik, Kasir</strong>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
