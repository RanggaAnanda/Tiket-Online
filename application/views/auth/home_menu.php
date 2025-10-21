<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home - Tiket Konser</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap & FontAwesome -->
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .carousel-item img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 16px;
    }

    .carousel-inner {
      border-radius: 16px;
      overflow: hidden;
    }

    .carousel {
      margin-top: 20px;
    }

    .card-konser {
      border: none;
      border-radius: 16px;
      overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .card-konser:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .card-konser .card-img-top {
      height: 200px;
      object-fit: cover;
    }

    .card-title {
      font-size: 1.1rem;
      font-weight: bold;
    }

    .btn-outline-primary, .btn-success, .btn-outline-secondary {
      border-radius: 30px;
      padding: 8px 18px;
      font-size: 0.9rem;
    }

    .btn-outline-primary:hover {
      background-color: #001f3f;
      color: #fff;
    }

    h3 {
      font-weight: 700;
      color: #001f3f;
      text-align: center;
    }

    .text-muted {
      font-size: 0.9rem;
    }

    .mt-5 {
      margin-top: 4rem !important;
    }

    .btn-outline-secondary:hover {
      background-color: #d4d4d4;
    }

    @media (max-width: 768px) {
      .carousel-item img {
        height: 250px;
      }
      .card-konser .card-img-top {
        height: 160px;
      }
    }
  </style>
</head>
<body>

<?php $this->load->view('layout/navbar'); ?>

<!-- Carousel -->
<div id="demo" class="carousel slide carousel-fade container" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <?php for ($i = 0; $i < 5; $i++): ?>
      <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>"></button>
    <?php endfor; ?>
  </div>

  <div class="carousel-inner">
    <?php
    $banners = ['Banner6.svg', 'Banner2.svg', 'Banner4.svg', 'Banner7.svg', 'Banner8.svg'];
    foreach ($banners as $i => $banner): ?>
      <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
        <img src="<?= base_url('uploads/' . $banner) ?>" class="d-block w-100">
      </div>
    <?php endforeach; ?>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- Konser Terbaru -->
<div class="container mt-5">
  <h3 class="mb-4">Konser Terbaru</h3>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($konser_terbaru as $k): ?>
      <div class="col">
        <div class="card card-konser h-100">
          <img src="<?= $k->photo ? base_url('uploads/konser/' . $k->photo) : base_url('assets/default.jpg') ?>" class="card-img-top" alt="<?= $k->namakonser ?>">
          <div class="card-body">
            <h5 class="card-title"><?= character_limiter($k->namakonser, 30) ?></h5>
            <p class="card-text text-muted mb-1"><i class="fa-regular fa-calendar-days"></i> <?= date('d M Y', strtotime($k->tanggal)) ?></p>
            <p class="card-text fw-semibold text-dark"><i class="fa-solid fa-location-dot"></i> <?= $k->lokasi ?></p>
            <a href="<?= site_url('konser/detail/' . $k->id_konser) ?>" class="btn btn-outline-primary btn-sm mt-2">Lihat Detail</a>
            <a href="<?= site_url('pembelian/form/' . $k->id_konser) ?>" class="btn btn-success btn-sm mt-2">Beli Tiket</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Lihat Semua -->
<div class="text-center mt-4 mb-5">
  <a href="<?= site_url('konser') ?>" class="btn btn-outline-secondary">Lihat Semua Konser</a>
</div>

<?php $this->load->view('layout/footer'); ?>
<script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
