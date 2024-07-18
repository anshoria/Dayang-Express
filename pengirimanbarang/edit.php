<?php
session_start();

require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}

$id = $_GET["id"];
$pengiriman_barang = query("SELECT * FROM pengiriman_barang WHERE id = $id");
$p = $pengiriman_barang[0];

if (isset($_POST["ubah"])) {
    if (ubahpengiriman_barang($_POST) > 0) {
        echo "<script>
				alert('data berhasil diubah!');
				document.location.href = '../pengiriman/pengiriman.php';
			  </script>";
    } else {
        echo "<script>
				alert('data gagal diubah!');
				document.location.href = '../pengiriman/pengiriman.php';
			 </script>";
    }
}

?>


<!DOCTYPE html>
<html>

<head>
<title>Pengiriman</title>
    <link rel="icon" href="../img/logo-head-2.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
</head>
<style>
    .card {
        margin: 10px;
    }
</style>
<body>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="container" style="margin-top: 30px; margin-bottom: 30px;">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mt-2">Edit Pengiriman</h2>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id" value="<?php echo $p["id"]; ?>">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Keberangkatan Pengiriman Barang</label>
                        <input type="date" value="<?php echo $p["tanggal"]; ?>" class="form-control" id="tanggal" placeholder="Masukkan tanggal keberangkatan pengiriman barang" name="tanggal" autofocus required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Barang yang dikirim</label>
                        <input type="number" value="<?php echo $p["jumlah_barang"]; ?>" class="form-control" id="jumlah" placeholder="Masukkan jumlah barang" name="jumlah_barang">
                    </div>
                    <div class="mb-5">
                        <button type="submit" name="ubah" class="btn btn-success">Simpan</button>
                        <a type="button" class="btn btn-primary" href="../pengiriman/pengiriman.php">Tutup</a>
                    </div>
                </div>

            </div>




        </div>

    </form>



</body>

</html>