<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Konser</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f0f4ff, #ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        .img-fluid {
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .nav-tabs .nav-link {
            font-weight: 600;
            color: #0d6efd;
        }

        .nav-tabs .nav-link.active {
            background-color: #eaf0ff;
            border-bottom: 3px solid #0d6efd;
            color: #0a58ca;
        }

        .card {
            border-radius: 16px;
        }

        .tab-content {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        }

        .tiket-card {
            transition: 0.2s ease;
        }

        .tiket-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .btn-outline-secondary {
            border-radius: 10px;
        }
    </style>
</head>
<body>
<?php $this->load->view('layout/navbar'); ?>

<div class="container mt-5 mb-5">
    <?php if ($konser): ?>
        <div class="row g-4">
            <!-- Poster + Tabs -->
            <div class="col-lg-8">
                <?php if (!empty($konser->photo)): ?>
                    <img src="<?= base_url('uploads/konser/' . $konser->photo) ?>" class="img-fluid" alt="Poster Konser">
                <?php endif; ?>

                <ul class="nav nav-tabs mt-4" id="konserTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="deskripsi-tab" data-bs-toggle="tab" data-bs-target="#deskripsi" type="button" role="tab">Deskripsi</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tiket-tab" data-bs-toggle="tab" data-bs-target="#tiket" type="button" role="tab">Tiket</button>
                    </li>
                </ul>

                <div class="tab-content p-4" id="konserTabContent">
                    <!-- DESKRIPSI -->
                    <div class="tab-pane fade show active" id="deskripsi" role="tabpanel">
                        <h4 class="fw-bold"><?= $konser->namakonser ?></h4>
                        <p><?= nl2br($konser->deskripsi) ?></p>
                    </div>

                    <!-- TIKET -->
                    <div class="tab-pane fade" id="tiket" role="tabpanel">
                        <h5 class="mb-3">Jenis Tiket</h5>

                        <?php usort($tiket, fn($a, $b) => $a->harga - $b->harga); ?>

                        <?php foreach ($tiket as $t): ?>
                            <div class="card tiket-card mb-3 <?= $t->stok > 0 ? 'border-primary bg-light' : 'bg-light' ?>">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold"><?= $t->jenis_tiket ?></h6>
                                            <small class="text-muted">
                                                <i class="bi bi-clock text-primary"></i> Berlaku hingga <?= date('d M Y', strtotime($konser->tanggal)) ?> • 00:00
                                            </small>
                                            <div class="mt-2 text-success fw-bold">Rp<?= number_format($t->harga, 0, ',', '.') ?></div>
                                        </div>
                                        <div>
                                            <?php if ($t->stok == 0): ?>
                                                <span class="badge bg-danger">SOLD OUT</span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?= $t->stok ?> Tersedia</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $konser->namakonser ?></h5>
                        <p><i class="bi bi-calendar-event text-primary"></i> <?= date('d M Y', strtotime($konser->tanggal)) ?></p>
                        <p><i class="bi bi-clock text-primary"></i> <?= $konser->waktu ?? '12:00 - 23:00 WIB' ?></p>
                        <p><i class="bi bi-geo-alt text-primary"></i> <?= $konser->lokasi ?></p>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-end">Harga Mulai</h6>
                        <?php 
                            $harga_terendah = null;
                            foreach ($tiket as $t) {
                                if ($t->stok > 0) {
                                    $harga_terendah = $t->harga;
                                    break;
                                }
                            }
                        ?>
                        <h4 class="text-end text-primary fw-bold">
                            Rp<?= $harga_terendah ? number_format($harga_terendah, 0, ',', '.') : '---' ?>
                        </h4>
                        <a href="<?= site_url('pembelian/form/' . $konser->id_konser) ?>" class="btn btn-primary w-100 mt-3">Beli Tiket</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger text-center">Konser tidak ditemukan.</div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="<?= site_url('konser') ?>" class="btn btn-outline-secondary">← Kembali ke Daftar Konser</a>
    </div>
</div>

<script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
