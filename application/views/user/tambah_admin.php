<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Admin</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
    <?php $this->load->view('layout/navbar'); ?>

    <div class="container">
        <div class="form-container">
            <h3 class="text-center text-primary mb-4">Tambah User Admin</h3>

            <?php if ($this->session->flashdata('msg')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('msg') ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('user/simpan_admin') ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Tambah Admin</button>
                    <a href="<?= site_url('users') ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
