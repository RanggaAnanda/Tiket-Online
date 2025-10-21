<?php
    $nama = $this->session->userdata('nama');
    $role = $this->session->userdata('role');
    $CI =& get_instance();
    $segment = $CI->uri->segment(1);

    if ($role == 'admin') {
        $CI->load->model('pembelian_model');
        $pending_verifikasi = $CI->pembelian_model->count_pending_verifikasi();
    }
?>

<style>
  .navbar {
    background-color: #001f3f;
    padding: 0.8rem 1.5rem;
  }

  .navbar-brand span {
    font-weight: 700;
    font-size: 1.4rem;
    letter-spacing: 1px;
    color: #ffffff;
  }

  .navbar-nav .nav-link {
    color: #ffffff;
    margin-left: 10px;
    transition: background-color 0.3s, transform 0.2s;
    border-radius: 6px;
    padding: 8px 12px;
  }

  .navbar-nav .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.15);
    transform: translateY(-1px);
  }

  .nav-link.active {
    font-weight: bold;
    background-color: rgba(255, 255, 255, 0.3);
    color: #fff;
  }

  .btn-search {
    background-color: transparent;
    border: 1px solid white;
    color: white;
    transition: 0.3s ease;
  }

  .btn-search:hover {
    background-color: #ffffff;
    color: #001f3f;
  }

  .badge-dot {
    position: absolute;
    top: 5px;
    right: 2px;
    height: 10px;
    width: 10px;
    background-color: red;
    border-radius: 50%;
    animation: pulse 1.5s infinite;
  }

  @keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0.5; }
    100% { transform: scale(1); opacity: 1; }
  }

  @media (max-width: 768px) {
    .navbar-brand span {
      font-size: 1.1rem;
    }
  }
</style>

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= site_url() ?>">
      <img src="<?= base_url('uploads/logo.png') ?>" alt="Logo" width="40" height="40">
      <span>MUSIC <span style="color:#FFD700;">FEST</span></span>
    </a>

    <!-- Toggle button -->
    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarNav">

      <!-- Search Bar -->
      <form class="d-flex mx-auto" action="<?= site_url('konser/search') ?>" method="get" style="width: 50%;">
        <input class="form-control me-2 rounded-pill" type="search" name="q" placeholder="Cari konser..." aria-label="Search">
        <button class="btn btn-search rounded-pill px-3" type="submit"><i class="fas fa-search"></i></button>

      </form>

      <!-- Right menu -->
      <ul class="navbar-nav ms-auto align-items-center">

        <li class="nav-item">
          <a class="nav-link <?= ($segment == 'home_menu') ? 'active' : '' ?>" href="<?= base_url() ?>">HOME</a>
        </li>
        
        <?php if ($role == 'admin'): ?>
          <li class="nav-item position-relative">
            <a class="nav-link <?= ($segment == 'pembelian' && $CI->uri->segment(2) == 'verifikasi_pembayaran') ? 'active' : '' ?>" 
               href="<?= site_url("pembelian/verifikasi_pembayaran") ?>">
              VERIFIKASI
              <?php if (!empty($pending_verifikasi)): ?>
                <span class="badge-dot"></span>
              <?php endif; ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'pembelian' && $CI->uri->segment(2) == 'sales') ? 'active' : '' ?>" 
               href="<?= site_url("pembelian/sales") ?>">REPORT</a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link <?= ($segment == 'konser') ? 'active' : '' ?>" href="<?= site_url("konser") ?>">TIKET</a>
        </li>

        

        <?php if ($role == 'customer'): ?>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'pembelian' && $CI->uri->segment(2) == 'riwayat') ? 'active' : '' ?>" 
               href="<?= site_url("pembelian/riwayat") ?>">RIWAYAT</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'pembelian' && $CI->uri->segment(2) == 'belum_bayar') ? 'active' : '' ?>" 
               href="<?= site_url("pembelian/belum_bayar") ?>">BELUM BAYAR</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'notifikasi') ? 'active' : '' ?>" 
               href="<?= site_url("notifikasi") ?>">PESAN</a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link text-warning fw-bold" href="<?= site_url("auth/logout") ?>">
            LOGOUT (<?= $nama ?>)
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Font Awesome CDN -->
<script src="https://kit.fontawesome.com/your-own-kit-code.js" crossorigin="anonymous"></script>


