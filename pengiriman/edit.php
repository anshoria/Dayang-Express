<?php
session_start();

require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}

$id = $_GET["id"];
$pengiriman = query("SELECT * FROM pengiriman WHERE id = $id");
$p = $pengiriman[0];

if (isset($_POST["ubah"])) {
    if (ubahpengiriman($_POST) > 0) {
        echo "<script>
				alert('data berhasil diubah!');
				document.location.href = 'pengiriman.php';
			  </script>";
    } else {
        echo "<script>
				alert('data gagal diubah!');
				document.location.href = 'pengiriman.php';
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
                    <input type="hidden" name="fotolama" value="<?php echo $p["foto"]; ?>">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input value="<?php echo $p["tanggal"]; ?>" type="date" class="form-control" id="tanggal" name="tanggal" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input value="<?php echo $p["nama_pelanggan"]; ?>" type="text" class="form-control" id="nama" name="nama_pelanggan" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Pelanggan</label>
                        <input value="<?php echo $p["alamat"]; ?>" type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="nohp" class="form-label">Nomor HP</label>
                        <input value="<?php echo $p["nohp"]; ?>" type="number" class="form-control" id="nohp" name="nohp" maxlength="13">
                    </div>               
                    <div class="mb-3">
                        <label for="namabr" class="form-label">Resi</label>
                        <input value="<?php echo $p["resi"]; ?>" type="text" class="form-control" id="namabr" name="resi" required>
                    </div>
                    <div class="mb-3">
                        <label for="berat" class="form-label">Berat (kg)</label>
                        <input value="<?php echo $p["berat_barang"]; ?>" type="number" step="0.01" class="form-control" id="berat" name="berat_barang" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga Pengiriman</label>
                        <input value="<?php echo $p["harga"]; ?>" type="number" class="form-control" id="harga" name="harga" required>
                    </div>


                    <label for="Ekspedisi" class="form-label">Ekspedisi</label>
                    <div class="input-group mb-3">
                        <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon" name="ekspedisi" id="ekspedisi" required>
                            <option selected value="<?php echo $p["ekspedisi"]; ?>"><?php echo $p["ekspedisi"]; ?></option>
                            <option value="COD">COD</option>
                            <option value="JNE">JNE</option>
                            <option value="JNT">J&T</option>
                            <option value="Si Cepat">Si Cepat</option>
                            <option value="POS">POS</option>
                            <option value="TIKI">TIKI</option>
                            <option value="Ninja Expess">Ninja Express</option>
                            <option value="Indah Logistik">Indah Logistik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cod" class="form-label">Pembayaran COD (Rp) <em class="fw-bold">*Lewatkan jika bukan COD</em></label>
                        <input value="<?php echo $p["cod"]; ?>" type="number" class="form-control" id="cod" placeholder="Masukkan Pembayaran COD" name="cod">
                    </div>
                    <div class="mb-3">
                        <label for="pincod" class="form-label">PIN COD </label>
                        <br><em class="fw-bold">*Lewatkan jika bukan COD!</em>
                        <br><em>*PIN COD akan digunakan untuk catatan COD.</em>
                        <br><em>*misal : erniCODke-2, erniCODke-3.</em>
                        <input value="<?php echo $p["pincod"]; ?>" type="text" class="form-control mt-2" id="pincod" placeholder="Masukkan PIN COD" name="pincod">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Barang</label>
                        <input value="<?php echo $p["foto"]; ?>" type="file" class="form-control mb-3" id="foto" name="foto">
                        <a href="../img/<?php echo $p['foto']; ?>">
                            <img src="../img/<?php echo $p['foto']; ?>" width="200" />
                        </a>
                        <br />
                        <em>*pencet foto untuk memperbesar</em>
                    </div>
                    <div class="mb-5">
                        <button type="submit" name="ubah" class="btn btn-success">Simpan</button>
                        <a type="button" class="btn btn-primary" href="pengiriman.php">Tutup</a>
                    </div>
                </div>

            </div>




        </div>

    </form>



</body>

</html>