<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Tiket Konser</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            padding: 0;
        }
        .container {
            width: 100%;
        }
        .logo {
            text-align: center;
            margin-bottom: 15px;
        }
        .poster {
            float: left;
            width: 45%;
        }
        .poster img {
            width: 100%;
        }
        .qrcode {
            float: right;
            width: 45%;
            text-align: right;
        }
        .qrcode img {
            width: 100px;
            height: 100px;
        }
        .qrcode h2 {
            margin: 5px 0;
        }
        .clear {
            clear: both;
        }
        .details {
            margin-top: 20px;
        }
        .details div {
            margin-bottom: 5px;
        }
        .terms {
            margin-top: 20px;
            font-size: 11px;
        }
        .terms ul {
            padding-left: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="file://<?= FCPATH . 'uploads/logo.png' ?>" alt="Logo" height="60">
        </div>

        <div class="poster">
            <img src="file://<?= FCPATH . 'uploads/konser/' . $pembelian->poster ?>" alt="Poster Konser">
        </div>

        <div class="qrcode">
            <h2><?= $pembelian->namakonser ?></h2>
            <img src="file://<?= FCPATH . 'uploads/qrcodes/qrcode_' . $pembelian->id_pembelian . '.png' ?>" alt="QR Code">
            <div>ID: <?= $pembelian->id_pembelian ?></div>
        </div>

        <div class="clear"></div>

        <div class="details">
            <div><strong>Nomor Transaksi:</strong> <?= 'TIKET' . date('ymd', strtotime($pembelian->tanggal)) . '-' . $pembelian->id_pembelian ?></div>
            <div><strong>Harga:</strong> Rp <?= number_format($pembelian->harga, 0, ',', '.') ?></div>
            <div><strong>Lokasi Acara:</strong> <?= $pembelian->lokasi ?></div>
            <div><strong>Nama Customer:</strong> <?= $pembelian->nama ?></div>
            <div><strong>Kategori:</strong> <?= $pembelian->jenis_tiket ?></div>
            <div><strong>Tanggal Acara:</strong> <?= date('Y/m/d', strtotime($pembelian->tanggal)) ?></div>
        </div>

        <div class="terms">
            <h3>Syarat & Ketentuan:</h3>
            <ul>
                <li>Wajib membawa Kartu Identitas.</li>
                <li>E-Ticket yang sah adalah e-ticket yang dibeli melalui official website ini.</li>
                <li>E-ticket tidak dapat di-refund atau diuangkan kembali.</li>
                <li>Tiket yang sudah digunakan tidak dapat dipakai kembali.</li>
                <li>Penonton bertanggung jawab atas e-ticket masing-masing.</li>
                <li>Penyelenggara berhak mengubah atau membatalkan acara tanpa pemberitahuan.</li>
            </ul>
        </div>
    </div>
</body>
</html>
