<?php
session_start();
require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dayang Express 99</title>
    <link rel="icon" href="../img/logo-head-2.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<style>
    #scrollUpButton {
        display: none;
        position: fixed;
        bottom: 10px;
        right: 15px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        background-color: #555;
        color: white;
        cursor: pointer;
        padding: 5px;
        border-radius: 4px;
    }

    #scrollUpButton i {
        color: white;
    }
</style>


<body onload="window.print();">
        <h2 class="mt-4 text-center text-muted">DAFTAR LAPORAN PENGIRIMAN BARANG</h2><hr class="sidebar-divider my-0">
        <?php
        $awal = $_GET['awal'];
        $akhir = $_GET['akhir']; 
        ?>
        <div style="margin-bottom: -10px;">
        <h6 class="text-muted text-center" style="margin-top: 20px;">PERIODE PENGIRIMAN BARANG <b><?php echo $awal ?></b> s/d <b><?php echo $akhir ?></b> </h6><hr class="sidebar-divider my-0">
        </div>
        
        <div class="mt-3">
            <table class="table my-0 table-center">
                <thead>
                        <th>No.</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Resi</th>
                        <th scope="col">Harga</th>
                </thead>

                <tbody>
                    <?php
                    $awal = $_GET['awal'];
                    $akhir = $_GET['akhir'];
                    $no = 1;
                    $totalharga = 0;
                    $sql = "SELECT * FROM pengiriman WHERE tanggal BETWEEN '$awal' AND '$akhir'";
                    $cod = "SELECT * FROM pengiriman WHERE tanggal BETWEEN '$awal' AND '$akhir' AND ekspedisi='COD'";
                    $pelanggan = "SELECT COUNT(DISTINCT nama_pelanggan) AS JumlahPelanggan FROM pengiriman WHERE tanggal BETWEEN '$awal' AND '$akhir'";
                    $conn = koneksi();
                    $result = $conn->query($sql);
                    $result2 = $conn->query($cod);
                    $result3 = $conn->query($pelanggan);
                    $jumlahharga = $result->num_rows;
                    $jumlahcod = $result2->num_rows;
                    $rowpelanggan = $result3->fetch_assoc();
                    $jumlahpelanggan = $rowpelanggan['JumlahPelanggan'];
                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            $stringharga = $row["harga"];
                            $stringharga = str_replace(",", "", $stringharga);
                            $stringharga = str_replace(".", "", $stringharga);
                            $harga = floatval($stringharga);
                            $stringhargaformat = number_format($harga, 0, ",", ".");
                    ?>
                            <tr>
                                <td><?php echo $no++; ?> </td>
                                <td><?php echo $row['tanggal']; ?> </td>
                                <td><?php echo $row['nama_pelanggan']; ?> </td>
                                <td><?php echo $row['resi']; ?> </td>
                                <td>Rp <?php echo $stringhargaformat; ?> </td>
                                <?php
                                $totalharga += $harga;
                                ?>
                            </tr>
                        <?php }
                    } else {

                        ?>
                        <p class="text-center">Tidak ada data yang cocok dengan rentang tanggal yang dipilih</p>
                    <?php
                    }
                    ?>

                </tbody>
                <tr>
                    <th style="border: none;"><strong></strong></th>
                    <th style="border: none;"><strong></strong></th>
                    <th style="border: none;"><strong></strong></th>
                    <?php
                    // Format nilai uang dengan tanda titik sebagai pemisah ribuan
                    $totalhargaformat = number_format($totalharga, 0, ",", ".");
                    ?>
                    <th style="border: none;">Total Harga</th>
                    <th style="border: none;"><?php echo $totalhargaformat; ?></th>
                </tr>



            </table>

</body>

</html>