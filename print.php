<?php 
	@ob_start();
	session_start();
	if(!empty($_SESSION['admin'])){ }else{
		echo '<script>window.location="login.php";</script>';
        exit;
	}
	require 'config.php';
	include $view;
	$lihat = new view($config);
	$toko = $lihat -> toko();
	$hsl = $lihat -> penjualan();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Print</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        td {
            vertical-align: top;
        }

        .pull-right {
            float: right;
        }

        .clearfix {
            clear: both;
        }

        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }

            .container {
                box-shadow: none;
                border-radius: 0;
                padding: 0;
                margin: 0;
            }

            table {
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid #000;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nota Pembelian</h1>
        <p><?php echo $toko['nama_toko'];?></p>
        <p><?php echo $toko['alamat_toko'];?></p>
        <p>Tanggal : <?php  echo date("j F Y, G:i");?></p>
        <p>Kasir : <?php  echo htmlentities($_GET['nm_member']);?></p>
        <table>
            <tr>
                <th>No.</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
            <?php $no=1; foreach($hsl as $isi){?>
            <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $isi['nama_barang'];?></td>
                <td><?php echo $isi['jumlah'];?></td>
                <td><?php echo $isi['total'];?></td>
            </tr>
            <?php $no++; }?>
        </table>
        <div class="pull-right">
            <?php $hasil = $lihat -> jumlah(); ?>
            <p>Total : Rp.<?php echo number_format($hasil['bayar']);?>,-</p>
            <p>Bayar : Rp.<?php echo number_format(htmlentities($_GET['bayar']));?>,-</p>
            <p>Kembali : Rp.<?php echo number_format(htmlentities($_GET['kembali']));?>,-</p>
        </div>
        <div class="clearfix"></div>
        <p>Terima Kasih Telah berbelanja di toko kami !</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>

