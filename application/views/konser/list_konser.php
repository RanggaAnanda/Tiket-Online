<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Konser</title>
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-color: #f4f7fc;
      font-family: 'Segoe UI', sans-serif;
    }

    .card-konser {
      border: none;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background: #fff;
    }

    .card-konser:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    .card-img-top {
      height: 200px;
      object-fit: cover;
    }

    .card-body {
      padding: 20px;
    }

    .card-title {
      font-size: 1.1rem;
      font-weight: 600;
    }

    .card-text {
      font-size: 0.95rem;
    }

    .btn-sm {
      border-radius: 30px;
      padding: 6px 16px;
      font-size: 0.85rem;
    }

    .card-footer {
      border-top: 1px solid #eee;
    }

    @media (max-width: 768px) {
      .card-img-top {
        height: 160px;
      }
    }
  </style>
</head>
<body>

<?php $this->load->view('layout/navbar'); ?>

<div class="container mt-5">
  <?php if ($this->session->userdata('role') == 'admin'): ?>
    <div class="mb-4 text-end">
      <a href="<?= site_url('konser/add') ?>" class="btn btn-primary rounded-pill">
        <i class="fa-solid fa-plus"></i> Tambah Konser Baru
      </a>
    </div>
  <?php endif; ?>

  <?= $this->session->flashdata('msg') ?>

  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($konser as $k): ?>
      <div class="col">
        <div class="card card-konser h-100">
          <img src="<?= $k->photo ? base_url('uploads/konser/' . $k->photo) : base_url('assets/default.jpg') ?>" class="card-img-top" alt="<?= $k->namakonser ?>">
          <div class="card-body">
            <h5 class="card-title"><?= character_limiter($k->namakonser, 30) ?></h5>
            <p class="card-text text-muted mb-1"><i class="fa-regular fa-calendar-days"></i> <?= date('d M Y', strtotime($k->tanggal)) ?></p>
            <p class="card-text text-dark"><i class="fa-solid fa-location-dot"></i> <?= $k->lokasi ?></p>
            <div class="d-flex gap-2 mt-3">
              <a href="<?= site_url('konser/detail/' . $k->id_konser) ?>" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-eye"></i> Detail
              </a>
              <a href="<?= site_url('pembelian/form/' . $k->id_konser) ?>" class="btn btn-success btn-sm">
                <i class="fa-solid fa-ticket"></i> Beli Tiket
              </a>
            </div>
          </div>
          <?php if ($this->session->userdata('role') == 'admin'): ?>
            <div class="card-footer bg-light d-flex justify-content-between px-3 py-2">
              <a href="<?= site_url('konser/edit/' . $k->id_konser) ?>" class="btn btn-warning btn-sm">
                <i class="fa-solid fa-pen-to-square"></i> Edit
              </a>
              <a href="<?= site_url('konser/delete/' . $k->id_konser) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus konser ini?')">
                <i class="fa-solid fa-trash"></i> Hapus
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
<?php $this->load->view('layout/footer'); ?>
</body>
</html>
