<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Pembayaran</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f7fc;
        }
        h2 {
            margin-top: 40px;
            margin-bottom: 30px;
            color: #0d6efd;
            font-weight: 700;
            text-align: center;
        }
        .card-verifikasi {
            border-left: 5px solid #0d6efd;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
            padding: 20px 25px;
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 1.2rem;
            color: #0d6efd;
            font-weight: 600;
        }
        .info-item {
            margin-bottom: 8px;
        }
        .info-item i {
            color: #6c757d;
            margin-right: 6px;
        }
        .btn-group-sm .btn {
            font-size: 0.85rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <?php $this->load->view('layout/navbar'); ?>

    <div class="container mb-5">
        <h2><i class="bi bi-shield-check me-2"></i>Verifikasi Pembayaran</h2>

        <?php if ($this->session->flashdata('msg')): ?>
            <div class="alert alert-info text-center"><?= $this->session->flashdata('msg') ?></div>
        <?php endif; ?>

        <?php if (!empty($list)): $no = 1; foreach ($list as $p): ?>
            <div class="card-verifikasi">
                <div class="card-title">#<?= $no++ ?> - <?= $p->nama ?></div>
                <div class="info-item"><i class="bi bi-music-note-beamed"></i><strong>Konser:</strong> <?= $p->namakonser ?></div>
                <div class="info-item"><i class="bi bi-ticket-perforated"></i><strong>Jenis Tiket:</strong> <?= $p->jenis_tiket ?></div>
                <div class="info-item"><i class="bi bi-calendar-event"></i><strong>Tanggal:</strong> <?= date('d M Y', strtotime($p->tanggal)) ?></div>
                <div class="info-item"><i class="bi bi-paperclip"></i><strong>Bukti:</strong>
                    <?php if ($p->bukti): ?>
                        <a href="<?= base_url('uploads/bukti/' . $p->bukti) ?>" target="_blank" class="btn btn-outline-primary btn-sm ms-2">Lihat Bukti</a>
                    <?php else: ?>
                        <span class="text-danger ms-2">Tidak tersedia</span>
                    <?php endif; ?>
                </div>

                <div class="btn-group btn-group-sm mt-3" role="group">
                    <a href="<?= site_url('pembelian/acc/' . $p->id_pembelian) ?>"
                       class="btn btn-success"
                       onclick="return confirm('Terima pembayaran ini?')">
                        <i class="bi bi-check-circle me-1"></i>ACC
                    </a>
                    <a href="<?= site_url('pembelian/tolak/' . $p->id_pembelian) ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Tolak pembayaran ini?')">
                        <i class="bi bi-x-circle me-1"></i>Tolak
                    </a>
                </div>
            </div>
        <?php endforeach; else: ?>
            <div class="alert alert-warning text-center mt-5">Tidak ada pembayaran pending.</div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="<?= site_url('auth/home_menu') ?>" class="btn btn-outline-secondary">← Kembali ke Menu</a>
        </div>
    </div>

    <script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
