<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Tiket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #eaf0f6;
            font-family: 'Segoe UI', sans-serif;
        }
        .payment-box {
            max-width: 650px;
            margin: 50px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }
        h2 {
            font-weight: 700;
            color: #003366;
        }
        .qris-wrapper {
            border: 2px dashed #0d6efd;
            padding: 16px;
            border-radius: 12px;
            background-color: #f8f9fa;
        }
        .qris-wrapper img {
            width: 100%;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            font-weight: 600;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        .btn-outline-secondary {
            border-radius: 10px;
        }
        .detail-box {
            background: #f1f3f6;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .label-title {
            font-weight: 600;
            color: #333;
        }
        .text-success {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<?php $this->load->view('layout/navbar'); ?>

<div class="container">
    <div class="payment-box">
        <h2 class="text-center mb-4"><i class="fa-solid fa-wallet me-2"></i>Konfirmasi Pembayaran</h2>

        <!-- Kode Tiket -->
        <div class="detail-box mb-4">
            <div class="label-title">Kode Tiket:</div>
            <div class="fw-bold"><?= $pembelian->kode ?></div>
        </div>

        <!-- QRIS -->
        <div class="qris-wrapper text-center mb-4">
            <div class="label-title mb-2"><i class="fa-solid fa-qrcode me-1"></i>Scan QRIS untuk Pembayaran</div>
            <img src="<?= base_url('uploads/qris.png') ?>" alt="QRIS">
        </div>

        <!-- Detail Pembelian -->
        <div class="detail-box">
            <p><span class="label-title">Nama Konser:</span> <?= $pembelian->namakonser ?></p>
            <p><span class="label-title">Jumlah Tiket:</span> <?= $pembelian->jumlah ?></p>
            <p><span class="label-title">Harga per Tiket:</span> Rp <?= number_format($pembelian->harga, 0, ',', '.') ?></p>
            <p><span class="label-title">Total Bayar:</span> <span class="fw-bold text-success">Rp <?= number_format($pembelian->jumlah * $pembelian->harga, 0, ',', '.') ?></span></p>
        </div>

        <hr>

        <!-- Upload Form -->
        <form action="<?= site_url('pembelian/upload_bukti/' . $pembelian->id_pembelian) ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="bukti" class="form-label">Upload Bukti Pembayaran (jpg/png/pdf)</label>
                <input type="file" class="form-control" id="bukti" name="bukti" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-2"><i class="fa-solid fa-upload me-2"></i>Upload Sekarang</button>
        </form>

        <div class="text-center mt-4">
            <a href="<?= site_url('pembelian/riwayat') ?>" class="btn btn-outline-secondary">
                ← Lihat Riwayat Pembelian
            </a>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>

</body>
</html>
