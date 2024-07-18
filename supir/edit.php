<?php
session_start();

require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}

$id = $_GET["id"];
$supir = query("SELECT * FROM supir WHERE id = $id");
$p = $supir[0];

if (isset($_POST["ubah"])) {
    if (ubahsupir($_POST) > 0) {
        echo "<script>
				alert('data berhasil diubah!');
				document.location.href = 'supir.php';
			  </script>";
    } else {
        echo "<script>
				alert('data gagal diubah!');
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

<body>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="container" style="margin-top: 30px; margin-bottom: 30px;">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mt-2">Edit Supir</h2>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id" value="<?php echo $p["id"]; ?>">
                    <input type="hidden" name="fotolama" value="<?php echo $p["foto"]; ?>">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input value="<?php echo $p["nama"]; ?>" type="text" class="form-control" id="nama" name="nama" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Mobil</label>
                        <input value="<?php echo $p["mobil"]; ?>" type="text" class="form-control" id="alamat" name="mobil" required>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input value="<?php echo $p["foto"]; ?>" type="file" class="form-control mb-3" id="foto" name="foto">
                        <a href="../img/<?php echo $p['foto']; ?>">
                            <img src="../img/<?php echo $p['foto']; ?>" width="200" />
                        </a>
                        <br />
                        <em>*pencet foto untuk memperbesar</em>
                    </div>
                    <br />
                    <button type="submit" name="ubah" class="btn btn-success">Simpan</button>
                    <a type="button" class="btn btn-primary" href="pengiriman.php">Tutup</a>
                </div>

            </div>



        </div>

    </form>



</body>

</html>