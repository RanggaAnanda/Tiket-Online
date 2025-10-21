<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #eaf2ff, #f8fbff);
            font-family: 'Segoe UI', sans-serif;
        }

        .notifikasi-box {
            max-width: 900px;
            margin: 60px auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 30px;
        }

        .notifikasi-item {
            border-left: 5px solid #0d6efd;
            background-color: #f9fbff;
            padding: 18px 24px;
            margin-bottom: 16px;
            border-radius: 12px;
            transition: all 0.2s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .notifikasi-item:hover {
            background-color: #eef6ff;
            transform: translateY(-2px);
        }

        .notifikasi-text {
            display: flex;
            align-items: center;
            color: #333;
        }

        .notifikasi-icon {
            font-size: 1.5rem;
            color: #0d6efd;
            margin-right: 15px;
        }

        .notifikasi-time {
            font-size: 0.9rem;
            color: #888;
            white-space: nowrap;
        }

        .btn-back {
            margin-top: 30px;
            font-weight: 500;
            border-radius: 10px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <?php $this->load->view('layout/navbar'); ?>

    <div class="container">
        <div class="notifikasi-box">
            <h2><i class="bi bi-bell-fill me-2"></i> Notifikasi Kamu</h2>

            <?php if (empty($notifikasi)): ?>
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>Belum ada pesan baru.
                </div>
            <?php else: ?>
                <?php foreach ($notifikasi as $n): ?>
                    <div class="notifikasi-item">
                        <div class="notifikasi-text">
                            <i class="bi bi-info-circle-fill notifikasi-icon"></i>
                            <?= $n->pesan ?>
                        </div>
                        <div class="notifikasi-time">
                            <?= date('d M Y H:i', strtotime($n->tanggal)) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="text-center">
                <a href="<?= site_url('auth/home_menu') ?>" class="btn btn-outline-primary btn-back">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Menu
                </a>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
