<?php
session_start();
require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}


// Ambil tanggal awal dan akhir tahun ini 
$tanggalAwal = date('Y-01-01');
$tanggalAkhir = date('Y-12-31');

// Mengambil data total barang per minggu dalam rentang waktu bulan ini
$query = "SELECT WEEK(tanggal) AS minggu, COUNT(*) AS jumlah_barang FROM pengiriman WHERE tanggal BETWEEN '$tanggalAwal' AND '$tanggalAkhir' GROUP BY WEEK(tanggal) ORDER BY tanggal DESC LIMIT 4";
$koneksi = koneksi();
$result = mysqli_query($koneksi, $query);

$dataJumlahBarangPerMinggu = array();

while ($row = mysqli_fetch_assoc($result)) {
    $minggu = $row['minggu'];
    $jumlahBarang = $row['jumlah_barang'];

    $dataJumlahBarangPerMinggu[$minggu] = $jumlahBarang;
}




$queryBulan = "SELECT MONTH(tanggal) AS bulan, COUNT(*) AS total_barang_bulan FROM pengiriman WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) GROUP BY MONTH(tanggal)";
$resultBulan = mysqli_query($koneksi, $queryBulan);

$dataJumlahBarangPerBulan = array();
// Looping hasil query dan simpan data ke array
while ($row = mysqli_fetch_assoc($resultBulan)) {
    $bulan = $row['bulan'];
    $totalBarangBulan = $row['total_barang_bulan'];

    // Masukkan data ke dalam array berdasarkan bulan
    $dataJumlahBarangPerBulan[$bulan] = $totalBarangBulan;
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
    <title>Laporan</title>
    <link rel="icon" href="../img/logo-head-2.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment"></script>
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

    @media only screen and (max-width: 600px) {

    .container-fluid .laporan div{
        display: flex;
  flex-direction: column;
  align-items: center;
    }
    .container-fluid .grafik {
      margin-top: 20px;
    }



  }
  
</style>


<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../index.html">Dayang Express</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">

            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../profil/setting.php">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-power-off"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="profile mt-4">
                            <div class="media text-center">
                                <?php
                                $id = $_COOKIE['set'];
                                $user = query("SELECT * FROM user WHERE id='$id'");
                                foreach ($user as $row) : ?>
                                    <img class="rounded-circle mb-1" src="../img/<?php echo $row['foto']; ?>" alt="" width="100" height="100">
                                    <p class="text-light"><?php echo $row["username"]; ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <hr class="sidebar-divider my-0">
                            <a class="nav-link" href="../home.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt" style="margin-right: 4px;"></i></div>
                                Dashboard
                            </a>
                            <hr class="sidebar-divider my-0">
                            <a class="nav-link " href="../pengiriman/pengiriman.php">
                                <div class="sb-nav-link-icon t"><i class="fas fa-paper-plane" style="margin-right: 4px;"></i></div>
                                Data Pengiriman
                            </a>
                            <a class="nav-link" href="../pelanggan/pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-card" style="margin-right: 3px;"></i></div>
                                Data Pelanggan
                            </a>
                            <a class="nav-link" href="../admin/admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user" style="margin-right: 7px;"></i></div>
                                Data Admin
                            </a>
                            <a class="nav-link" href="../supir/supir.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-car" style="margin-right: 6px;"></i></div>
                                Data Supir
                            </a>
                            <hr class="sidebar-divider my-0">
                            <a class="nav-link" href="../cod/catatancod.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-edit" style="margin-right: 5px;"></i></div>
                                Catatan COD
                            </a>
                            <a class="nav-link text-light" href="../laporan/laporan.php">
                                <div class="sb-nav-link-icon text-light"><i class="fas fa-book" style="margin-right: 6px;"></i></div>
                                Laporan
                            </a>
                            <hr class="sidebar-divider my-0">
                        </div>

                    </div>
                </div>
                <div class="text-center">
                    <div class="sb-sidenav-footer">
                        <img src="../img/logo.png" alt="" width="100">
                    </div>
                </div>

            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <?php
                    if (isset($_POST['submit'])) {
                        $tanggal_awal = $_POST['tanggal_awal'];
                        $tanggal_akhir = $_POST['tanggal_akhir']; ?>
                        <h4 class="text-muted mt-4">Periode Tanggal <b><?php echo $tanggal_awal ?></b> s/d <b><?php echo $tanggal_akhir ?></b> </h4>
                    <?php
                    } else { ?>
                        <h4 class="text-muted mt-4">Periode Tanggal s/d</h4>
                    <?php
                    }
                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <h4 class="text-center"><i class="fas fa-book"></i> Laporan</h4>
                            <form class="laporan" method="POST" action="" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-2 mt-1">
                                        <input type="date" class="form-control" style="width: 250px;" name="tanggal_awal" id="">
                                    </div>
                                    <div class="col-lg-2 mt-1">
                                        <input type="date" class="form-control" style="width: 250px;" name="tanggal_akhir" id="">
                                    </div>
                                    <div class="col-lg-1 mt-2">
                                        <input type="submit" name="submit" value="Tampilkan" class="btn btn-sm btn-primary">
                                    </div>

                                </div>


                            </form>
                            <div class="mt-3">
                                <?php
                                if (isset($_POST['submit'])) {  ?>
                                    <table class="table table-striped" id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Tanggal Masuk</th>
                                                <th scope="col">Nama Pelanggan</th>
                                                <th scope="col">Resi</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">Berat Barang (kg)</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Ekspedisi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $tanggal_awal = $_POST['tanggal_awal'];
                                            $tanggal_akhir = $_POST['tanggal_akhir'];
                                            $no = 1;
                                            $totalharga = 0;
                                            $sql = "SELECT * FROM pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
                                            $cod = "SELECT * FROM pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND ekspedisi='COD'";
                                            $pelanggan = "SELECT COUNT(DISTINCT nama_pelanggan) AS JumlahPelanggan FROM pengiriman WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
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
                                                        <td><?php echo $row['alamat']; ?> </td>
                                                        <td><?php echo $row['berat_barang']; ?> kg</td>
                                                        <td>Rp <?php echo $stringhargaformat; ?> </td>
                                                        <td><?php echo $row['ekspedisi']; ?> </td>
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
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="">
                                                    <i class="fas fa-info-circle text-primary" style="margin: 2px;"></i>
                                                    <?php
                                                    // Format nilai uang dengan tanda titik sebagai pemisah ribuan
                                                    $totalhargaformat = number_format($totalharga, 0, ",", ".");
                                                    ?>
                                                    <p style="margin: 1px;">Total pendapatan : <b class="text-success">Rp <?php echo $totalhargaformat; ?> </b></p>
                                                    <p style="margin: 1px;">Jumlah barang : <b><?php echo $jumlahharga ?></b></p>
                                                    <p style="margin: 1px;">Jumlah COD : <b><?php echo $jumlahcod ?></b></p>
                                                    <p style="margin: 1px;">Jumlah pelanggan : <b><?php echo $jumlahpelanggan ?></b></p>
                                                </div>
                                            </div>
                                        </div>


                                    </table>
                                    <a href="print.php?awal=<?php echo $tanggal_awal; ?> && akhir=<?php echo $tanggal_akhir ?>" target="_blank" class="btn btn-primary mt-2 mb-2">Cetak Laporan</a>
                                <?php
                                } else {
                                ?>
                                    <table class="table table-striped" id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Nama Pelanggan</th>
                                                <th scope="col">Resi</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">Berat Barang (kg)</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Ekspedisi</th>
                                            </tr>
                                        </thead>

                                    </table>
                                <?php
                                } ?>
                            </div>

                        </div>

                    </div>
                    <div class="row mt-4 mb-4">
                        <div class="col-md-6">
                            <div class="card shadow">
                                <div class="card-header">
                                    Jumlah barang masuk per Minggu
                                </div>
                                <div class="card-body">
                                    <canvas id="chartMinggu"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="grafik card shadow">
                                <div class="card-header">
                                    Jumlah barang masuk per Bulan
                                </div>
                                <div class="card-body">
                                    <canvas id="chartBulan"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </main>
            <footer class="py-4 bg-light mt-auto text-center">
                <div class="container-fluid px-4">
                    <div class="text-muted">
                        <h6 class="text-center">&copy; Dayang Express</h6>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>

    <button onclick="scrollToTop()" id="scrollUpButton" title="Go to top"><i class="fas fa-arrow-circle-up"></i></button>


    <script>
        // Show the scroll-up button when user scrolls down 20px from the top of the document
        window.onscroll = function() {
            showScrollUpButton();
        };

        function showScrollUpButton() {
            var scrollUpButton = document.getElementById("scrollUpButton");
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollUpButton.style.display = "block";
            } else {
                scrollUpButton.style.display = "none";
            }
        }

        // Scroll to the top of the document
        function scrollToTop() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>
    <script>
        // Mengambil data total barang per minggu dalam rentang waktu bulan ini dari PHP
        const dataJumlahBarangPerMinggu = <?php echo json_encode ($dataJumlahBarangPerMinggu); ?>;

        // Mendapatkan array minggu dan total pendapatan
        const labels = Object.keys(dataJumlahBarangPerMinggu).map(minggu => {
            if (minggu === '<?php echo date('W'); ?>') {
                return 'Minggu ini';
            } else {
                return `Minggu ${minggu}`;
            }
        });
        const data = Object.values(dataJumlahBarangPerMinggu);

        // Membuat grafik bar total barang per minggu menggunakan Chart.js
        const ctx = document.getElementById('chartMinggu').getContext('2d');
        const chartTotalBarang = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Barang',
                    data: data,
                    backgroundColor: 'rgb(65, 105, 225)', // Warna latar belakang batang
                    borderColor: 'rgb(65, 105, 225)', // Warna garis batang
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0 // Menentukan jumlah digit desimal pada sumbu Y
                        }
                    }
                }
            }
        });
        // Mendefinisikan data total pendapatan per bulan
        const dataJumlahBarangPerBulan = <?php echo json_encode ($dataJumlahBarangPerBulan); ?>;

        // Mendapatkan bulan-bulan dalam tahun ini
        const tahunIni = moment().year();
        const bulanLabels = [];
        const totalBarangBulan = [];

        for (let bulan = 1; bulan <= 6; bulan++) {
            const bulanFormatted = moment(`${tahunIni}-${bulan}`, 'YYYY-MM').format('MMMM');
            bulanLabels.push(bulanFormatted);
            totalBarangBulan.push(dataJumlahBarangPerBulan[bulan] || 0);
        }

        // Membuat grafik bar pendapatan per bulan menggunakan Chart.js
        const ctxBulan = document.getElementById('chartBulan').getContext('2d');
        const chartBulan = new Chart(ctxBulan, {
            type: 'bar',
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: 'Total Barang per Bulan',
                    data: totalBarangBulan,
                    backgroundColor: 'rgba(46, 204, 113, 0.5)', // Warna latar belakang batang
                    borderColor: 'rgba(46, 204, 113, 1)', // Warna garis batang
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0 // Menentukan jumlah digit desimal pada sumbu Y
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>