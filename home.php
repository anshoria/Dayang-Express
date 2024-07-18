<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
  header("location: index.php");
  exit;
}

// Ambil tanggal awal dan akhir tahun ini 
$tanggalAwal = date('Y-01-01');
$tanggalAkhir = date('Y-12-31');

// Query untuk mengambil data pendapatan per minggu pada bulan ini (hanya 4 minggu terakhir)
$queryMinggu = "SELECT WEEK(tanggal) AS minggu, SUM(REPLACE(REPLACE(harga, '.', ''), ',', '.')) AS total_pendapatan FROM pengiriman WHERE tanggal BETWEEN '$tanggalAwal' AND '$tanggalAkhir' GROUP BY WEEK(tanggal) ORDER BY tanggal DESC LIMIT 4";
$conn = koneksi();
$resultMinggu = mysqli_query($conn, $queryMinggu);

// Inisialisasi array untuk menyimpan data total pendapatan per minggu
$dataPendapatanPerMinggu = array();



// Looping hasil query dan simpan data ke array
while ($row = mysqli_fetch_assoc($resultMinggu)) {
  $minggu = $row['minggu'];
  $totalPendapatan = $row['total_pendapatan'];

  // Masukkan data ke dalam array berdasarkan minggu
  $dataPendapatanPerMinggu[$minggu] = $totalPendapatan;
}

$queryBulan = "SELECT MONTH(tanggal) AS bulan, SUM(REPLACE(REPLACE(harga, '.', ''), ',', '.')) AS total_pendapatan FROM pengiriman WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) GROUP BY MONTH(tanggal)";
$resultBulan = mysqli_query($conn, $queryBulan);

// Inisialisasi array untuk menyimpan data total pendapatan per bulan
$dataPendapatanPerBulan = array();

// Looping hasil query dan simpan data ke array
while ($row = mysqli_fetch_assoc($resultBulan)) {
  $bulan = $row['bulan'];
  $totalPendapatan = $row['total_pendapatan'];

  // Masukkan data ke dalam array berdasarkan bulan
  $dataPendapatanPerBulan[$bulan] = $totalPendapatan;
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
  <title>Dayang Express</title>
  <link rel="icon" href="img/logo-head-2.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
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

  
  .container-fluid .bawah {
            margin-bottom: 50px;
        }

  @media only screen and (max-width: 600px) {
    .container-fluid {
      display: grid;
      place-items: center;
    }

    .card {
      width: 100%;
      /* Menggunakan persentase */
      /* atau */
      width: 90vw;
      /* Menggunakan fraksi viewport */
    }

    .tambah {
      display: block;
      margin-bottom: 5px;
      margin-top: 3px;
    }

    .container-fluid .aksi {
      white-space: nowrap;
    }

    .container-fluid .aksi a {
      display: inline-block;
    }
    .container-fluid .grafik {
      margin-top: 15px;
    }

    
    .container-fluid .bawah {
            margin-bottom: 40px;
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
          <li><a class="dropdown-item" href="profil/setting.php">Settings</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="logout.php"><i class="fas fa-power-off"></i> Logout</a></li>
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
                  <img class="mb-1" src="img/<?php echo $row['foto']; ?>" alt="" width="100" height="100" style="border-radius: 50%">
                  <p class="text-light"><?php echo $row["username"]; ?></p>
                <?php endforeach; ?>
              </div>
            </div>
            <div>
              <hr class="sidebar-divider my-0">
              <a class="nav-link text-light" href="home.php">
                <div class="sb-nav-link-icon text-light"><i class="fas fa-tachometer-alt" style="margin-right: 4px;"></i></div>
                Dashboard
              </a>
              <hr class="sidebar-divider my-0">
              <a class="nav-link" href="pengiriman/pengiriman.php">
                <div class="sb-nav-link-icon"><i class="fas fa-paper-plane" style="margin-right: 4px;"></i></div>
                Data Pengiriman
              </a>
              <a class="nav-link" href="pelanggan/pelanggan.php">
                <div class="sb-nav-link-icon"><i class="fas fa-address-card" style="margin-right: 3px;"></i></div>
                Data Pelanggan
              </a>
              <a class="nav-link" href="admin/admin.php">
                <div class="sb-nav-link-icon"><i class="fas fa-user" style="margin-right: 7px;"></i></div>
                Data Admin
              </a>
              <a class="nav-link" href="supir/supir.php">
                <div class="sb-nav-link-icon"><i class="fas fa-car" style="margin-right: 6px;"></i></div>
                Data Supir
              </a>
              <hr class="sidebar-divider my-0">
              <a class="nav-link" href="cod/catatancod.php">
                <div class="sb-nav-link-icon"><i class="fas fa-edit" style="margin-right: 5px;"></i></div>
                Catatan COD
              </a>
              <a class="nav-link" href="laporan/laporan.php">
                <div class="sb-nav-link-icon"><i class="fas fa-book" style="margin-right: 6px;"></i></div>
                Laporan
              </a>
              <hr class="sidebar-divider my-0">
            </div>


          </div>
        </div>
        <div class="text-center">
          <div class="sb-sidenav-footer">
            <img src="img/logo.png" alt="" width="100">
          </div>
        </div>

      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="selamat text-center mt-4">Selamat datang di halaman admin!</h1>
          <p><b>Ada barang baru datang?</b> <a href="barang/tambah.php" class="tambah btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambahkan</a> <a href="lihatgambar/gambar.php" class="tambah btn btn-sm btn-success">Lihat gambar</a></p>
            <div class="card shadow mb-4">
              <div class="card-header">
                <?php
                $query = "SELECT COUNT(*) AS total FROM pengiriman WHERE DATE(tanggal) = CURDATE()";
                $conn = koneksi();
                // Eksekusi query
                $result = mysqli_query($conn, $query);

                // Ambil hasil jumlah data
                $row = mysqli_fetch_assoc($result);
                $totalData = $row['total']; ?>
                <i class="far  fa-bell"></i><i style="margin-left: 5px;"><b><?php echo $totalData ?></b> barang masuk hari ini</i>
              </div>

              <div class="card-body">
                <h4 class="text-center"><i class="fas fa-table"></i> Data Barang</h4>
                <table class="table table-striped" id="datatablesSimple">
                  <thead>
                    <tr>
                      <th scope="col">No.</th>
                      <th scope="col">Tanggal Masuk</th>
                      <th scope="col">Resi</th>
                      <th scope="col">Berat Barang (kg)</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $pengiriman = query("SELECT * FROM pengiriman ORDER BY id DESC");
                    $no = 1;
                    foreach ($pengiriman as $row) :
                    ?>
                      <tr>
                        <td><?php echo $no++; ?> </td>
                        <td><?php echo $row['tanggal']; ?> </td>
                        <td><?php echo $row['resi']; ?> </td>
                        <td><?php echo $row['berat_barang']; ?> kg</td>
                        <td>
                          <div class="aksi">
                            <a href="barang/detail.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm text-white"><i class="fas fa-info-circle"></i></a>
                            <a href="barang/edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-pencil"></i></a>
                            <a href="barang/hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Data ini pada halaman pengiriman barang akan ikut terhapus!')"><i class="fas fa-trash"></i></a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="bawah row">
              <div class="col-md-6">
                <div class="card shadow">
                  <div class="card-header">
                    Pendapatan per Minggu
                  </div>
                  <div class="card-body">
                    <canvas id="chartMinggu"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="grafik card shadow">
                  <div class="card-header">
                    Pendapatan per Bulan
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
  <script src="js/scripts.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>


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
    // Mendefinisikan data total pendapatan per minggu
    const dataPendapatanPerMinggu = <?php echo json_encode($dataPendapatanPerMinggu); ?>;

    // Mendapatkan array minggu dan total pendapatan
    const mingguLabels = Object.keys(dataPendapatanPerMinggu).map(minggu => {
            if (minggu === '<?php echo date('W'); ?>') {
                return 'Minggu ini';
            } else {
                return `Minggu ${minggu}`;
            }
        });
    const totalPendapatanMinggu = Object.values(dataPendapatanPerMinggu);

    // Membuat grafik bar pendapatan per minggu menggunakan Chart.js
    const ctxMinggu = document.getElementById('chartMinggu').getContext('2d');
    const chartMinggu = new Chart(ctxMinggu, {
      type: 'bar',
      data: {
        labels: mingguLabels,
        datasets: [{
          label: 'Total Pendapatan per Minggu',
          data: totalPendapatanMinggu,
          backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna latar belakang batang
          borderColor: 'rgba(54, 162, 235, 1)', // Warna garis batang
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
    const dataPendapatanPerBulan = <?php echo json_encode($dataPendapatanPerBulan); ?>;

    // Mendapatkan bulan-bulan dalam tahun ini
    const tahunIni = moment().year();
    const bulanLabels = [];
    const totalPendapatanBulan = [];

    for (let bulan = 1; bulan <= 6; bulan++) {
      const bulanFormatted = moment(`${tahunIni}-${bulan}`, 'YYYY-MM').format('MMMM');
      bulanLabels.push(bulanFormatted);
      totalPendapatanBulan.push(dataPendapatanPerBulan[bulan] || 0);
    }

    // Membuat grafik bar pendapatan per bulan menggunakan Chart.js
    const ctxBulan = document.getElementById('chartBulan').getContext('2d');
    const chartBulan = new Chart(ctxBulan, {
      type: 'bar',
      data: {
        labels: bulanLabels,
        datasets: [{
          label: 'Total Pendapatan per Bulan',
          data: totalPendapatanBulan,
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