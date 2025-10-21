<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pembelian</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #f0f4f8, #dfe8f1);
            min-height: 100vh;
        }

        .riwayat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .riwayat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .riwayat-header {
            font-size: 1.5rem;
            font-weight: 600;
            color: #003366;
        }

        .riwayat-info p {
            margin: 0.25rem 0;
            font-size: 0.95rem;
        }

        .badge-status {
            font-size: 0.85rem;
            padding: 6px 12px;
            border-radius: 20px;
        }

        .icon {
            margin-right: 8px;
        }

        .btn-cetak {
            font-size: 0.9rem;
            border-radius: 8px;
        }

        h2 {
            font-weight: bold;
            color: #003366;
        }
    </style>
</head>
<body>
    <?php $this->load->view('layout/navbar'); ?>

    <div class="container py-5">
        <h2 class="mb-4"><i class="fa-solid fa-ticket-simple me-2"></i>Riwayat Pembelian Tiket</h2>

        <?php if (empty($riwayat)): ?>
            <div class="alert alert-info shadow-sm p-3">
                <i class="fa-solid fa-circle-info me-2"></i>Belum ada riwayat pembelian.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($riwayat as $r): ?>
                    <div class="col-md-6 mb-4">
                        <div class="riwayat-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="riwayat-header mb-2">
                                        <i class="fa-solid fa-music me-2 text-primary"></i><?= $r->namakonser ?>
                                    </div>
                                    <div class="riwayat-info text-muted">
                                        <p><strong>Tanggal:</strong> <?= date('d M Y', strtotime($r->tanggal)) ?></p>
                                        <p><strong>Jenis Tiket:</strong> <?= $r->jenis_tiket ?></p>
                                        <p><strong>Jumlah:</strong> <?= $r->jumlah ?> Tiket</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge badge-status 
                                        <?= $r->status == 'approved' ? 'bg-success' : ($r->status == 'pending' ? 'bg-warning text-dark' : 'bg-secondary') ?>">
                                        <i class="fa-solid 
                                            <?= $r->status == 'approved' ? 'fa-check-circle' : ($r->status == 'pending' ? 'fa-clock' : 'fa-ban') ?> me-1"></i>
                                        <?= ucfirst($r->status) ?>
                                    </span>
                                    <br>
                                    <?php if ($r->status == 'approved'): ?>
                                        <a href="<?= site_url('pembelian/cetak/' . $r->id_pembelian) ?>" target="_blank" class="btn btn-outline-primary btn-sm mt-3 btn-cetak">
                                            <i class="fa-solid fa-download me-1"></i> E-tiket
                                        </a>
                                    <?php else: ?>
                                        <small class="text-muted d-block mt-3">E-tiket belum tersedia</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="mt-4 text-center">
            <a href="<?= site_url('auth/home_menu') ?>" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
