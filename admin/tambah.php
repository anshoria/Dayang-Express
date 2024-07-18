<?php
session_start();

require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}

if (isset($_POST["tambah"])) {
    // cek keberhasilan query
    if (tambahadmin($_POST) > 0) {
        echo "<script>
				alert('data berhasil ditambah');
				document.location.href = 'admin.php';
			  </script>";
    } else {
        echo "<script>
				alert('data gagal diinputkan!');
				document.location.href = 'admin.php';
			  </script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <link rel="icon" href="../img/logo-head-2.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
</head>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="container" style="margin-top: 30px; margin-bottom: 30px;">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mt-2">Tambah Admin</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="password" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan Username" name="username" autofocus required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" placeholder="Masukkan Password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" placeholder="Masukkan foto" name="foto" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                    <a type="button" class="btn btn-primary" href="admin.php">Tutup</a>
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