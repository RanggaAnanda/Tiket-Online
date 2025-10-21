<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Hasil Pencarian Konser</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
</head>
<body>
<?php $this->load->view('layout/navbar'); ?>

<div class="container mt-5">
    <h3>Hasil Pencarian untuk: <em><?= html_escape($keyword) ?></em></h3>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        <?php if (!empty($konser_terbaru)): ?>
            <?php foreach ($konser_terbaru as $k): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= base_url('uploads/konser/' . $k->photo) ?>" class="card-img-top" alt="<?= $k->namakonser ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $k->namakonser ?></h5>
                            <p class="card-text"><?= date('d M Y', strtotime($k->tanggal)) ?></p>
                            <a href="<?= site_url('konser/detail/' . $k->id_konser) ?>" class="btn btn-primary btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Tidak ditemukan konser dengan kata kunci tersebut.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
