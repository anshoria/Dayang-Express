<?php
session_start();
require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}

if (isset($_POST["submit"])) {

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    // cek keberhasilan query
    $password = test_input($_POST['password']);
    $username = test_input($_POST['username']);

    $confirm = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $conn = koneksi();
    $result = mysqli_query($conn, $confirm);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] == $username) {
            if ($row['password'] === $password) {
                if (isset($_GET["id"])) {
                    // cek keberhasilan query
                    if (hapusadmin($_GET["id"]) > 0) {
                        echo "<script>
                            alert('berhasil dihapus!');
                            document.location.href = 'admin.php';
                          </script>";
                    } else {
                        echo "<script>
                            alert('gagal dihapus!');
                            document.location.href = 'admin.php';
                          </script>";
                    }
                }
            } else {
                echo "<script>
				alert('Password salah!');
			  </script>";
            }
        } else {
            echo "<script>
				alert('Username salah!');
			  </script>";
        }
    } else {
        echo "<script>
				alert('Username atau Password salah!');
			  </script>";
    }
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
    <title>Admin</title>
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
                            <a class="nav-link text-light" href="../admin/admin.php">
                                <div class="sb-nav-link-icon text-light"><i class="fas fa-user" style="margin-right: 7px;"></i></div>
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
                <div class="container d-flex justify-content-center align-items-center" style="min-height: 60vh">
                    <form class="border shadow p-5 rounded bg-light" action="" method="post" style="width: 450px;">

                        <?php $id = $_GET['id'];
                        $sql = query("SELECT * FROM user WHERE id='$id'");
                        foreach ($sql as $row) : ?>
                            <p class="text-center" style="margin: 0px;"><i class="fas fa-2x text-warning fa-exclamation-circle"></i></p>
                            <h6 class="p-1 text-dark text-center mb-3">Login sebagai <?php echo $row['username'] ?> untuk menghapus!</h6>
                        <?php endforeach ?>

                        <div class="mb-1">
                            <label class="form-label text-dark">Username</label>
                            <input class="form-control" type="text" name="username" required autofocus>
                            <br>
                        </div>
                        <div class="mb-1">
                            <label class="form-label text-dark">Password</label>
                            <input class="form-control" type="password" name="password" required>
                            <br>
                        </div>
                        <button type="submit" class="btn btn-success" name="submit">Hapus</button>
                        <a href="admin.php" class="btn btn-primary">Kembali</a>
                    </form>
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