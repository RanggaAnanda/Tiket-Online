<!DOCTYPE html>
<html>
<head>
    <title>Input Konser & Tiket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f9ff, #ffffff);
        }

        h2 {
            color: #0d6efd;
            font-weight: 700;
        }

        .form-section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        fieldset legend {
            font-size: 1.2rem;
            font-weight: 600;
            color: #0d6efd;
        }

        .btn-success {
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-secondary {
            border-radius: 8px;
        }

        table input {
            border-radius: 6px;
        }
    </style>
</head>
<body>
<?php $this->load->view('layout/navbar'); ?>

<div class="container my-5">
    <h2 class="text-center mb-4"><i class="bi bi-music-note-list me-2"></i>Form Konser & Tiket</h2>

    <?php
    $namakonser = $tanggal = $lokasi = $harga = $stok = $deskripsi = '';
    if (isset($k)) {
        $namakonser = $k->namakonser;
        $tanggal = $k->tanggal;
        $lokasi = $k->lokasi;
        $deskripsi = $k->deskripsi;
    }
    ?>

    <form action="<?= site_url(isset($k) ? 'konser/edit/' . $k->id_konser : 'konser/add') ?>" method="post" enctype="multipart/form-data">

        <!-- Bagian Konser -->
        <fieldset class="form-section">
            <legend>🎤 Data Konser</legend>

            <?php if (!empty($k->photo)): ?>
                <div class="mb-3">
                    <label class="form-label">Foto Saat Ini:</label><br>
                    <img src="<?= base_url('uploads/konser/' . $k->photo) ?>" width="180" class="img-thumbnail rounded">
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Foto Konser:</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Konser:</label>
                <input type="text" name="namakonser" value="<?= $namakonser ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Konser:</label>
                <input type="date" name="tanggal" value="<?= $tanggal ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi Konser:</label>
                <input type="text" name="lokasi" value="<?= $lokasi ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi:</label>
                <textarea name="deskripsi" rows="4" class="form-control" required><?= $deskripsi ?></textarea>
            </div>
        </fieldset>

        <!-- Bagian Tiket -->
        <fieldset class="form-section">
            <legend>🎫 Jenis Tiket</legend>

            <table class="table table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Jenis Tiket</th>
                        <th>Harga (Rp)</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $jenis = ['VVIP', 'VIP', 'REGULER'];
                    $tiket_map = [];

                    if (isset($tiket)) {
                        foreach ($tiket as $t) {
                            $tiket_map[$t->jenis_tiket] = $t;
                        }
                    }

                    foreach ($jenis as $j):
                        $t = isset($tiket_map[$j]) ? $tiket_map[$j] : null;
                    ?>
                        <tr>
                            <td>
                                <strong><?= $j ?></strong>
                                <input type="hidden" name="jenis[]" value="<?= $j ?>">
                            </td>
                            <td>
                                <input type="number" name="harga[]" value="<?= $t ? $t->harga : '' ?>" class="form-control" min="0" required>
                            </td>
                            <td>
                                <input type="number" name="stok[]" value="<?= $t ? $t->stok : '' ?>" class="form-control" min="0" required>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </fieldset>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-end gap-3">
            <a href="<?= site_url('konser') ?>" class="btn btn-secondary">← Kembali</a>
            <button type="submit" name="submit" class="btn btn-success">💾 Simpan</button>
        </div>
    </form>
</div>

<script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
