<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1><?= $title ?></h1><br />
    Nama : <?= $this->session->userdata('nama') ?><br />
    Username : <?= $this->session->userdata('username') ?><br />
    <a href="<?= base_url('login/logout') ?>">log out</a>
</body>
</html>