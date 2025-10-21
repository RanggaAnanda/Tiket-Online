<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Tiket Konser</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 30px;
            background-color: #f1f1f1;
        }
        .container {
            width: 800px;
            background: #fff;
            padding: 30px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .title {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px dashed #ccc;
            padding-bottom: 20px;
        }
        .left img {
            width: 100%;
            max-width: 280px;
            border-radius: 8px;
        }
        .right {
            text-align: right;
        }
        .right h2 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }
        .right img {
            margin-top: 10px;
            width: 120px;
            height: 120px;
        }
        .right div {
            font-size: 14px;
            color: #888;
        }
        .details {
            margin-top: 25px;
            line-height: 1.6;
        }
        .details div {
            margin: 5px 0;
            font-size: 16px;
        }
        .details strong {
            color: #333;
        }
        .terms {
            margin-top: 30px;
            font-size: 14px;
            color: #555;
        }
        .terms h3 {
            color:rgb(0, 0, 0);
            margin-bottom: 10px;
        }
        .terms ul {
            padding-left: 20px;
        }
        .terms li {
            margin-bottom: 6px;
        }
    </style>
</head>
    

<body>
    <div class="container">
        <div class="title">
            <img src="<?= base_url('uploads/logo.png') ?>" alt="MUSIC FEST Logo" style="height:80px;">
        </div>

        <div class="header">
            <div class="left">
                <img src="<?= base_url('uploads/konser/' . $pembelian->poster) ?>" alt="Poster Konser">
            </div>
            <div class="right">
                <h2><?= $pembelian->namakonser ?></h2>
                <img src="<?= base_url('uploads/qrcodes/qrcode_' . $pembelian->id_pembelian . '.png') ?>" alt="QR Code">
                <div>ID: <?= $pembelian->id_pembelian ?></div>
            </div>
        </div>

        <div class="details">
            <div><strong>Nomor Transaksi:</strong> <?= 'TIKET' . date('ymd', strtotime($pembelian->tanggal)) . '-' . $pembelian->id_pembelian ?></div>
            <div><strong>Nama Customer:</strong> <?= $pembelian->nama ?></div>
            <div><strong>Kategori:</strong> <?= $pembelian->jenis_tiket ?></div>
            <div><strong>Harga:</strong> Rp <?= number_format($pembelian->harga, 0, ',', '.') ?></div>
            <div><strong>Lokasi Acara:</strong> <?= $pembelian->lokasi ?></div>
            <div><strong>Tanggal Acara:</strong> <?= date('Y/m/d', strtotime($pembelian->tanggal)) ?></div>
        </div>

        <div class="terms">
            <h3>Syarat & Ketentuan:</h3>
            <ul>
                <li>Wajib membawa Kartu Identitas.</li>
                <li>E-Ticket yang sah adalah e-ticket yang dibeli melalui official website ini.</li>
                <li>E-ticket tidak dapat di-refund atau diuangkan kembali dengan alasan apapun.</li>
                <li>Kami tidak bertanggung jawab atas tiket yang dibeli di luar website resmi ini.</li>
                <li>Tidak memperbolehkan penonton masuk apabila e-ticket telah digunakan oleh orang lain atau tidak valid.</li>
                <li>Penyelenggara berhak memindah acara, mengubah, dan mengakhiri tanpa pemberitahuan sebelumnya.</li>
            </ul>
        </div>
        
    </div>
</body>
</html>
