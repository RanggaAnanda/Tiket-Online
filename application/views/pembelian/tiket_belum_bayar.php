<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Belum Dibayar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(120deg, #e6f0ff, #f0f5ff);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-custom {
            background: #fff;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.12);
        }

        h2 {
            color: #003366;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        h2 i {
            margin-right: 10px;
            color: #0d6efd;
        }

        .table thead {
            background-color: #003366;
            color: white;
        }

        .btn-success {
            background-color: #198754;
            border-radius: 8px;
        }

        .btn-success:hover {
            background-color: #146c43;
        }

        .btn-danger {
            border-radius: 8px;
        }

        .btn-secondary {
            border-radius: 8px;
            font-weight: 500;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .badge-konser {
            font-size: 0.9rem;
            background: #eaf1ff;
            color: #003366;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <?php $this->load->view('layout/navbar'); ?>

    <div class="container py-5">
        <div class="card-custom mx-auto" style="max-width: 1100px;">
            <h2 class="mb-4"><i class="bi bi-clock-history"></i> Tiket Belum Dibayar</h2>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>Konser</th>
                            <th>Tanggal</th>
                            <th>Jenis Tiket</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($belum_bayar)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i>Belum ada tiket yang harus dibayar.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($belum_bayar as $b): ?>
                                <tr class="text-center">
                                    <td><span class="badge-konser"><?= $b->namakonser ?></span></td>
                                    <td><?= date('d M Y', strtotime($b->tanggal)) ?></td>
                                    <td><?= $b->jenis_tiket ?></td>
                                    <td><?= $b->jumlah ?></td>
                                    <td class="fw-bold text-success">Rp <?= number_format($b->jumlah * $b->harga, 0, ',', '.') ?></td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-block">
                                            <a href="<?= site_url('pembelian/pembayaran/' . $b->id_pembelian) ?>" class="btn btn-success btn-sm mb-1">
                                                <i class="bi bi-wallet2 me-1"></i> Bayar
                                            </a>
                                            <a href="<?= site_url('pembelian/cancel/' . $b->id_pembelian) ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin batalkan pesanan ini?')">
                                                <i class="bi bi-x-circle me-1"></i> Batalkan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-4">
                <a href="<?= site_url('auth/home_menu') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Menu
                </a>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
