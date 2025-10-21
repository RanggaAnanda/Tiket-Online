<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 align="center"><?php echo $title?></h1>
    <!-- <?php $kode = "123456789";?>
    
    <h3>ini render QRcode</h3>
    <img src="<?php echo site_url('render/QRcode/'.$kode)?>" alt="">

    <h3>ini render Barcode</h3>
    <img src="<?php echo site_url('render/Barcode/'.$kode)?>" alt=""> -->

    <br>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Konser</th>
            <th>Nama</th>
            <th>QRcode</th>
            <th>Barcode</th>
        </tr>
       <?php $no=1 foreach ($data as $row): ?>
       </tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $row->namakonser ?></td>
            <td><?php echo $row->nama ?></td>
            <td><img src="<?php echo site_url('render/QRcode/'.$row->kode)?>" alt=""></td>
            <td><img src="<?php echo site_url('render/Barcode/'.$row->kode)?>" alt=""></td>
        </tr>
        <?php endforeach?>
    </table>
</body>
</html>