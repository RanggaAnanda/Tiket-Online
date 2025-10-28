<!DOCTYPE html>
<html>
<head>
    <title>Pembelian Tiket</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .card-header {
            background: linear-gradient(to right, #001f3f, #003366);
            color: white;
        }
        .table thead {
            background-color: #003366;
            color: white;
        }
        .btn-primary {
            background-color: #003366;
            border-color: #003366;
        }
        .btn-primary:hover {
            background-color: #002244;
            border-color: #002244;
        }
        .btn-secondary:hover {
            background-color: #6c757d;
        }
        h2, .text-primary {
            color: #003366 !important;
            font-weight: bold;
        }
        .badge.bg-navy {
            background-color: #001f3f;
        }
    </style>
</head>
<body>
    <?php $this->load->view('layout/navbar'); ?>

    <div class="container mt-5 mb-5">

        <?php if ($this->session->flashdata('msg')): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('msg') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow mb-4">
            <div class="card-header">
                <strong>Informasi Konser</strong>
            </div>
            <div class="card-body">
                <p><strong>Nama Konser:</strong> <?= $konser->namakonser ?></span></p>
                <p><strong>Tanggal:</strong> <?= date('d M Y', strtotime($konser->tanggal)) ?></span></p>
                <p><strong>Lokasi:</strong> <?= $konser->lokasi ?></span></p>
            </div>
        </div>

        <form action="<?= site_url('pembelian/beli/' . $konser->id_konser) ?>" method="post">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong>Data Customer</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama lengkap Anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Alamat email aktif" required>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong> Pilih Jenis Tiket</strong>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="text-center">
                                <tr>
                                    <th>Pilih</th>
                                    <th>Jenis Tiket</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Jumlah Beli</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tiket as $index => $t): ?>
                                    <tr class="text-center align-middle">
                                        <td>
                                            <input type="radio" class="form-check-input pilih-radio" name="id_tiket" value="<?= $t->id_tiket ?>" id="radio-<?= $index ?>" <?= $t->stok == 0 ? 'disabled' : '' ?>>
                                        </td>
                                        <td><span class="badge bg-secondary"><?= $t->jenis_tiket ?></span></td>
                                        <td><span class="text-success fw-bold">Rp <?= number_format($t->harga, 0, ',', '.') ?></span></td>
                                        <td>
                                            <?php if ($t->stok == 0): ?>
                                                <span class="badge bg-danger">Habis</span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?= $t->stok ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control jumlah-tiket" name="jumlah[<?= $t->id_tiket ?>]" min="1" max="<?= $t->stok ?>" disabled>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= site_url('konser') ?>" class="btn btn-secondary">← Kembali</a>
                <!-- <button type="submit" name="submit" class="btn btn-primary">🛒 Beli Tiket</button> -->
                <?php if ($this->session->userdata('role') === 'customer'): ?>
                <input type="submit" name="submit" value="Beli Tiket" class="btn btn-primary">
                <?php endif; ?>
            </div>
        </form>
    </div>

    <script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
    // JavaScript untuk mengaktifkan input jumlah hanya jika radio dipilih
    document.querySelectorAll('.pilih-radio').forEach((radio, index) => {
        radio.addEventListener('change', function () {
            // Nonaktifkan semua input jumlah
            document.querySelectorAll('.jumlah-tiket').forEach(input => input.disabled = true);

            // Aktifkan input jumlah yang sesuai dengan radio yang dipilih
            const jumlahInput = document.querySelectorAll('.jumlah-tiket')[index];
            if (jumlahInput) {
                jumlahInput.disabled = false;
                jumlahInput.focus();
            }
        });
    });
</script>

</body>
</html>
