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
    <title>Pengiriman</title>
    <link rel="icon" href="../img/logo-head-2.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

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
                            <a class="nav-link text-light" href="../pengiriman/pengiriman.php">
                                <div class="sb-nav-link-icon text-light"><i class="fas fa-paper-plane" style="margin-right: 4px;"></i></div>
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
                            <a class="nav-link" href="../laporan/laporan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-book" style="margin-right: 6px;"></i></div>
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
                    <h2 class="mt-4 mb-4">Detail Pengiriman</h2>

                    <?php

                    $id = $_GET["id"];
                    $pengiriman = query("SELECT * FROM pengiriman WHERE id = $id");
                    $no = 1;
                    ?>

                    <?php foreach ($pengiriman as $row) :
                        $stringharga = $row["harga"];
                        $stringharga = str_replace(",", "", $stringharga);
                        $stringharga = str_replace(".", "", $stringharga);
                        $harga = floatval($stringharga);
                        $stringhargaformat = number_format($harga, 0, ",", ".");
                        $stringharga2 = $row["cod"];
                        $stringharga2 = str_replace(",", "", $stringharga2);
                        $stringharga2 = str_replace(".", "", $stringharga2);
                        $harga2 = floatval($stringharga2);
                        $stringhargaformat2 = number_format($harga2, 0, ",", ".");
                    ?>

                        <div>
                            <p><a href="pengiriman.php">Pengiriman</a> / Detail Pengiriman/ <?php echo $row["nama_pelanggan"] ?></p>
                            <div class="card shadow mb-5">
                                <div class="card-header">
                                    <p class="fw-bold" style="margin: 0px;">Informasi Pengiriman</p>
                                </div>
                                <div class="card-body">
                                    <p class="fw-bold">Informasi Pelanggan</p>
                                    <p style="margin: 5px;">Nama : <?php echo $row["nama_pelanggan"]; ?></p>
                                    <p style="margin: 5px;">Alamat : <?php echo $row["alamat"]; ?></p>
                                    <p style="margin: 5px;">Nomor HP : <?php echo $row["nohp"]; ?></p>
                                    <p class="fw-bold">Informasi Barang</p>
                                    <p style="margin: 5px;">Tanggal Masuk : <?php echo $row["tanggal"]; ?></p>
                                    <p style="margin: 5px;">Nomor Resi : <?php echo $row["resi"]; ?></p>
                                    <p style="margin: 5px;">Berat Barang : <?php echo  $row["berat_barang"]; ?> kg</p>
                                    <p style="margin: 5px;">Foto Barang : </p>
                                    <p style="margin: 5px;">
                                        <a href="../img/<?php echo $row['foto']; ?>">
                                            <img src="../img/<?php echo $row['foto']; ?>" width="200" />
                                        </a>
                                    </p>
                                    <em>*pencet foto untuk memperbesar</em>
                                    <p style="margin: 5px;" class="fw-bold mt-3">Informasi Pengiriman</p>
                                    <p style="margin: 5px;" class="fw-bold text-success">Harga Pengiriman : Rp <?php echo  $stringhargaformat; ?></p>
                                    <p style="margin: 5px;" class="fw-bold text-success">Pembayaran COD : Rp <?php echo  $stringhargaformat2; ?></p>
                                    <p style="margin: 5px;" class="fw-bold">Ekspedisi : <?php echo  $row["ekspedisi"]; ?></p>
                                    <p style="margin: 5px;" class="fw-bold">PIN COD : <?php echo  $row["pincod"]; ?></p>
                                    <a href="pengiriman.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm text-white mt-4">Kembali</a>
                                </div>
                            </div>
                        </div>


                    <?php endforeach; ?>


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
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>