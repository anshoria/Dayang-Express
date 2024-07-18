<?php
session_start();

require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}

if (isset($_POST["tambah"])) {
    // cek keberhasilan query
    if (tambahsupir($_POST) > 0) {
        echo "<script>
				alert('data berhasil ditambah');
				document.location.href = 'supir.php';
			  </script>";
    } else {
        echo "<script>
				alert('data gagal diinputkan!');
				document.location.href = 'supir.php';
			  </script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Supir</title>
    <link rel="icon" href="../img/logo-head-2.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
</head>
<style>
    .card {
        margin: 15px;
    }
</style>
<body>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="container" style="margin-top: 30px; margin-bottom: 30px;">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mt-2">Tambah Supir</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Supir" name="nama" autofocus required>
                    </div>
                    <div class="mb-3">
                        <label for="mobil" class="form-label">Mobil</label>
                        <input type="text" class="form-control" id="alamat" placeholder="Masukkan Mobil Supir" name="mobil" required>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" placeholder="Masukkan foto" name="foto" required>
                    </div>
                    <div class="mb-3">
                        <em>*Batas upload file maksimal 10 mb</em>
                        <br>
                        <em>*Format file jpg, jpeg, png</em>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-success">Tambah Data</button>
                    <a type="button" class="btn btn-primary" href="supir.php">Tutup</a>

                </div>
            </div>
        </div>

    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

</body>

</html>