<?php
session_start();

require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}


$id = $_GET["id"];
$cod = query("SELECT * FROM catatancod WHERE id = $id");
$p = $cod[0];

if (isset($_POST["ubah"])) {
    if (ubahcod($_POST) > 0) {
        echo "<script>
				alert('data berhasil diubah!');
				document.location.href = 'catatancod.php';
			  </script>";
    } else {
        echo "<script>
				alert('data gagal diubah!');
				document.location.href = 'catatancod.php';
			 </script>";
    }
}

?>


<!DOCTYPE html>
<html>

<head>
<title>Catatan COD</title>
    <link rel="icon" href="../img/logo-head-2.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
</head>

<body>

    <form action="" method="post">
        <div class="container" style="margin-top: 30px; margin-bottom: 30px;">
            <div class="card shadow">

                <div class="card-header">
                    <h2 class="mt-2">Edit COD</h2>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id" value="<?php echo $p["id"]; ?>">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input value="<?php echo $p["nama"]; ?>" type="text" class="form-control" id="nama" name="nama" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="pin" class="form-label">PIN COD</label>
                        <input value="<?php echo $p["pin"]; ?>" type="text" class="form-control" id="pin" placeholder="Masukkan PIN COD" name="pin" required>
                    </div>
                    <div class="mb-3">
                        <label for="saldo" class="form-label">Saldo (Rp)</label>
                        <input value="<?php echo $p["saldo"]; ?>" type="number" class="form-control" id="saldo" name="saldo" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input value="<?php echo $p["tanggal"]; ?>" type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <label for="status" class="form-label">Status</label>
                    <div class="input-group mb-3">
                        <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon" name="status" id="status" required>
                            <option selected value="<?php echo $p["status"]; ?>"><?php echo $p["status"]; ?></option>
                            <option value="Selesai">Selesai</option>
                            <option value="Belum Selesai">Belum Selesai</option>
                        </select>
                    </div>
                    <em>*nama harus <em class="fw-bold">sama</em> dengan yang telah diisi pada halaman pengiriman</em>
                    <br><em>*masukkan pin yang sama dengan yang ingin dicatat</em>
                    <div class="mt-3">
                        <button type="submit" name="ubah" class="btn btn-success">Simpan</button>
                        <a type="button" class="btn btn-primary" href="catatancod.php">Tutup</a>
                    </div>

                </div>


            </div>

    </form>



</body>

</html>