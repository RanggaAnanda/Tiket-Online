<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Pembelian Tiket</title>
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(to right, #e0ecf8, #f4f9ff);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h3 {
      text-align: center;
      margin: 30px 0 20px;
      color: #003366;
      font-weight: bold;
      letter-spacing: 1px;
    }
    .filter-card {
      background: white;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    }
    .table thead {
      background: #003366;
      color: #ffffff;
      font-size: 0.95rem;
    }
    .table td, .table th {
      vertical-align: middle;
      font-size: 0.9rem;
      color: #333;
    }
    .table-hover tbody tr:hover {
      background-color: #eef7ff;
      transition: 0.2s ease-in-out;
    }
    .badge {
      font-size: 0.85rem;
      padding: 6px 12px;
      border-radius: 50px;
    }
    .card-table {
      background: white;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 6px 24px rgba(0, 0, 0, 0.05);
    }
    .btn-home {
      margin-top: 40px;
    }
    .btn {
      transition: all 0.2s ease-in-out;
    }
    .btn:hover {
      transform: translateY(-2px);
    }
    .total-box {
      background: #d4edda;
      padding: 15px 20px;
      border-radius: 12px;
      display: inline-block;
      margin-top: 20px;
      font-weight: bold;
      color: #155724;
      font-size: 1.2rem;
      box-shadow: 0 2px 8px rgba(21, 87, 36, 0.15);
    }
    .table-responsive {
      animation: fadeIn 0.5s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 576px) {
      .container {
        padding: 0 15px;
      }
      .total-box {
        font-size: 1rem;
        padding: 10px 15px;
      }
    }
  </style>
</head>
<body>
  <?php $this->load->view('layout/navbar'); ?>

  <div class="container my-5">
    <h3><i class="fa-solid fa-chart-line me-2 text-primary"></i>Riwayat Pembelian Tiket</h3>

    <!-- Filter -->
    <form method="GET" action="<?= site_url('pembelian/sales') ?>" class="row g-3 mb-4 filter-card">
      <div class="col-md-3">
        <label class="form-label">Tanggal Beli (Mulai)</label>
        <input type="date" name="tanggal_mulai" class="form-control" value="<?= html_escape($this->input->get('tanggal_mulai')) ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label">Tanggal Beli (Selesai)</label>
        <input type="date" name="tanggal_selesai" class="form-control" value="<?= html_escape($this->input->get('tanggal_selesai')) ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label">Konser</label>
        <select name="id_konser" class="form-select">
          <option value="">-- Semua Konser --</option>
          <?php foreach ($list_konser as $k): ?>
            <option value="<?= $k->id_konser ?>" <?= $this->input->get('id_konser') == $k->id_konser ? 'selected' : '' ?>>
              <?= $k->namakonser ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">-- Semua --</option>
          <option value="approved" <?= $this->input->get('status') == 'approved' ? 'selected' : '' ?>>Approved</option>
          <option value="pending" <?= $this->input->get('status') == 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="rejected" <?= $this->input->get('status') == 'rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary me-2"><i class="fa-solid fa-filter me-1"></i> Terapkan</button>
        <a href="<?= site_url('pembelian/sales') ?>" class="btn btn-outline-secondary"><i class="fa-solid fa-rotate-right me-1"></i> Reset</a>
      </div>
    </form>

    <!-- Table -->
    <div class="card-table mt-3">
        <?php $total_keuangan = 0; ?>
        <?php if (!empty($sales)): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="text-center">
              <tr>
                <th>No</th>
                <th>Nama Pembeli</th>
                <th>Nama Konser</th>
                <th>Tanggal Beli</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; $total_keuangan = 0; ?>
              <?php foreach ($sales as $sale): ?>
                <tr>
                  <td class="text-center"><?= $i++ ?></td>
                  <td><?= $sale->nama ?></td>
                  <td><?= $sale->namakonser ?></td>
                  <td class="text-center"><?= date('d M Y', strtotime($sale->tanggal)) ?></td>
                  <td class="text-center"><?= $sale->jumlah ?></td>
                  <td>Rp<?= number_format(($sale->harga ?? 0) * $sale->jumlah, 0, ',', '.') ?></td>
                  <td class="text-center">
                    <span class="badge 
                      <?= $sale->status == 'approved' ? 'bg-success' : ($sale->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') ?>">
                      <i class="fa-solid 
                        <?= $sale->status == 'approved' ? 'fa-check' : ($sale->status == 'pending' ? 'fa-clock' : 'fa-times') ?> me-1"></i>
                      <?= ucfirst($sale->status) ?>
                    </span>
                  </td>
                </tr>
                <?php
                  if ($sale->status == 'approved') {
                    $harga = isset($sale->harga) ? $sale->harga : 0;
                    $total_keuangan += $harga * $sale->jumlah;
                  }
                ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center">
          <i class="fa-solid fa-circle-info me-2"></i>Belum ada riwayat pembelian.
        </div>
      <?php endif; ?>
    </div>

    <!-- Total -->
    <div class="text-end mt-4">
      <div class="total-box">
        Total Pemasukan (Approved): Rp<?= number_format((float)($total_keuangan ?? 0), 0, ',', '.') ?>
      </div>
    </div>

    <!-- Back Button -->
    <div class="text-center">
      <a href="<?= base_url() ?>" class="btn btn-outline-secondary btn-home">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
      </a>
    </div>
  </div>

  <script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
