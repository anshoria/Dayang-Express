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

    .container-fluid .tengah h5 {
        margin: 15px;
        font-size: 18px;
    }

    .container-fluid .bawah {
        margin-bottom: 40px;
    }

    @media only screen and (max-width: 600px) {
        .container-fluid {
            place-items: center;
        }


        .container-fluid .aksi {
            white-space: nowrap;
        }

        .tambah {
            display: inline-block;
            margin-bottom: 5px;
            margin-top: 3px;
        }

        .container-fluid .aksi a {
            display: inline-block;
        }

        .container-fluid .bawah {
            margin-bottom: 40px;
        }

        .container-fluid .tengah h5 {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 10px;
            font-size: 15px;
        }

        .judul h4 {
            margin: 5px;
            margin-bottom: 15px;
            line-height: 0px;
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
                    <!-- Modal -->
                    <p class="mb-3 mt-5"><a href="../home.php" class="tambah btn btn-sm btn-success"><i class="fas fa-table"></i> Daftar barang</a> <a href="../cod/catatancod.php" class="tambah btn btn-sm btn-success"><i class="fas fa-edit"></i> Catatan COD</a> <a href="tambah.php" class="tambah btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambahkan</a></p>
                    <div class="card shadow">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <h4 class="text-center"><i class="fas fa-paper-plane"></i> Data Pengiriman</h4>
                            <table class="table table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama Pelanggan</th>
                                        <th scope="col">Resi</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Berat Barang (kg)</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Ekspedisi</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $pengiriman = query("SELECT * FROM pengiriman ORDER BY id DESC");
                                    $no = 1;
                                    foreach ($pengiriman as $row) :
                                        $stringharga = $row["harga"];
                                        $stringharga = str_replace(",", "", $stringharga);
                                        $stringharga = str_replace(".", "", $stringharga);
                                        $harga = floatval($stringharga);
                                        $stringhargaformat = number_format($harga, 0, ",", ".");
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?> </td>
                                            <td><?php echo $row['nama_pelanggan']; ?> </td>
                                            <td><?php echo $row['resi']; ?> </td>
                                            <td><?php echo $row['alamat']; ?> </td>
                                            <td><?php echo $row['berat_barang']; ?> kg</td>
                                            <td>Rp <?php echo $stringhargaformat; ?> </td>
                                            <td><?php echo $row['ekspedisi']; ?> </td>
                                            <td>
                                                <div class="aksi">
                                                    <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm text-white"><i class="fas fa-info-circle"></i></a>
                                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-pencil"></i></a>
                                                    <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fas fa-trash"></i></a>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bawah card shadow mt-4">
                        <div class="tengah card header">
                            <h5 class="">Tandai keberangkatan pengiriman barang!</h5>
                        </div>
                        <div class="card-body">
                            <div class="judul">
                                <h4 class="text-center"><img src="../img/logo-head-2.png" width="50" alt=""> Catatan Pengiriman Barang</h4>
                            </div>
                            <a href="../pengirimanbarang/tambah.php" class="btn btn-primary btn-sm mb-3"><i class="fas fa-plus"></i> Tambahkan</a>
                            <table class="table table-striped" id="datatablesSimple2">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Tanggal Pengiriman Barang</th>
                                        <th scope="col">Jumlah Barang</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pengiriman_barang = query("SELECT * FROM pengiriman_barang ORDER BY id DESC");
                                    $no = 1;
                                    foreach ($pengiriman_barang as $row) : ?>
                                        <tr>
                                            <td><?php echo $no++; ?> </td>
                                            <td><?php echo $row['tanggal']; ?> </td>
                                            <td><?php echo $row['jumlah_barang']; ?> </td>
                                            <td>
                                                <div class="aksi">
                                                    <a href="../PengirimanBarang/edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-pencil"></i></a>
                                                    <a href="../PengirimanBarang/hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            // Simple-DataTables
            // https://github.com/fiduswriter/Simple-DataTables/wiki

            const datatablesSimple = document.getElementById('datatablesSimple2');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
    </script>
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
</body>

</html>