<?php
session_start();

require '../config.php';

if (!isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
  }
  
if (isset($_POST["tambah"])) {
    // cek keberhasilan query
    if (tambahpengiriman($_POST) > 0) {
        echo "<script>
				alert('data berhasil ditambah');
				document.location.href = '../home.php';
			  </script>";
    } else {
        echo "<script>
				alert('data gagal diinputkan!');
				document.location.href = '../home.php';
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
        margin: 15px;
    }
</style>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="container" style="margin-top: 30px; margin-bottom: 30px;">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="mt-2">Tambah Barang dan Pengiriman</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Masuk Barang</label>
                        <input type="date" class="form-control" id="tanggal" placeholder="Masukkan Tanggal Masuk Barang" name="tanggal"  autofocus required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Pelanggan" name="nama_pelanggan" autocomplete="on" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Pelanggan</label>
                        <input type="text" class="form-control" id="alamat" placeholder="Masukkan alamat pelanggan" name="alamat" autocomplete="on">
                    </div>
                    <div class="mb-3">
                        <label for="nohp" class="form-label">Nomor HP</label>
                        <input type="number" class="form-control" id="nohp" placeholder="Masukkan Nomor HP" name="nohp" maxlength="13" autocomplete="on">
                    </div>
                    <div class="mb-3">
                        <label for="namabr" class="form-label">Resi</label>
                        <input type="text" class="form-control" id="namabr" placeholder="Masukkan Resi Barang" name="resi" required autocomplete="on">
                    </div>
                    <div class="mb-3">
                        <label for="berat" class="form-label">Berat Barang (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="berat" placeholder="Masukkan Berat Barang" name="berat_barang" required autocomplete="on">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga Pengiriman (Rp)</label>
                        <input type="number" class="form-control" id="harga" placeholder="Masukkan Harga Pengiriman" name="harga" required autocomplete="on">
                    </div>

                    <label for="Ekspedisi" class="form-label">Ekspedisi</label>
                    <div class="input-group mb-3">
                        <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon" name="ekspedisi" id="ekspedisi" required>
                            <option selected></option>
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
                        <label for="cod" class="form-label">Pembayaran COD (Rp)</label>
                        <br><em class="fw-bold">*Lewatkan jika bukan COD!</em>
                        <input type="number" class="form-control mt-2" id="cod" placeholder="Masukkan Pembayaran COD" name="cod" autocomplete="on">
                    </div>
                    <div class="mb-3">
                        <label for="pincod" class="form-label">PIN COD </label>
                        <br><em class="fw-bold">*Lewatkan jika bukan COD!</em>
                        <br><em>*PIN COD akan digunakan untuk catatan COD.</em>
                        <br><em>*misal : erniCODke-2, erniCODke-3.</em>
                        <input type="text" class="form-control mt-2" id="pincod" placeholder="Masukkan PIN COD" name="pincod" autocomplete="on">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Barang</label>
                        <input type="file" class="form-control" id="foto" placeholder="Masukkan foto barang" name="foto">
                    </div>
                    <div class="mb-3">
                        <em>*Batas upload file maksimal 10 mb</em>
                        <br>
                        <em>*Format file jpg, jpeg, png</em>
                    </div>
                    <div class="mb-5">
                        <button type="submit" name="tambah" class="btn btn-success">Tambah Data</button>
                        <a type="button" class="btn btn-primary" href="../home.php">Tutup</a>
                    </div>
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