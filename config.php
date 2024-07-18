<?php

// koneksi ke database
function koneksi()
{
	$conn = mysqli_connect("localhost", "root", "", "dayangexpress") or die("koneksi gagal");
	return $conn;
}


function query($query)
{
	$conn = koneksi();

	$result = mysqli_query($conn, $query);
	$rows = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}

	return $rows;
}



function upload()
{

	$namaFile = $_FILES['foto']['name'];
	$ukuranFile = $_FILES['foto']['size'];
	$error = $_FILES['foto']['error'];
	$tmpName = $_FILES['foto']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload
	if ($error === 4) {
		echo "<script>
				alert('pilih gambar terlebih dahulu!');
			  </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('yang anda upload bukan gambar!');
			  </script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 10000000) {
		echo "<script>
				alert('ukuran gambar terlalu besar!');
			  </script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, '../img/' . $namaFileBaru);

	return $namaFileBaru;
}


function tambahpengiriman($data)
{
	$conn = koneksi();

	// Menangkap data yang di kirim dari form
	$nama_pelanggan = htmlspecialchars($data['nama_pelanggan']);
	$alamat = htmlspecialchars($data['alamat']);
	$nohp = htmlspecialchars($data['nohp']);
	$tanggal = htmlspecialchars($data['tanggal']);
	$resi = htmlspecialchars($data['resi']);
	$berat_barang = htmlspecialchars($data['berat_barang']);
	$harga = htmlspecialchars($data['harga']);
	$cod = htmlspecialchars($data['cod']);
	$ekspedisi = htmlspecialchars($data['ekspedisi']);
	$pincod = htmlspecialchars($data['pincod']);
	$foto = upload();
	if (!$foto) {
		return false;
	}

	// insert data ke database
	$query = "INSERT INTO pengiriman
VALUES
('','$nama_pelanggan','$alamat','$nohp','$tanggal','$resi','$berat_barang','$harga','$cod','$ekspedisi','$pincod','$foto')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapuspengiriman($id)
{
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM pengiriman WHERE id = $id");

	return mysqli_affected_rows($conn);
}


function ubahpengiriman($data)
{
	$conn = koneksi();

	$id = ($data["id"]);
	// Menangkap data yang di kirim dari form
	$nama_pelanggan = htmlspecialchars($data['nama_pelanggan']);
	$alamat = htmlspecialchars($data['alamat']);
	$nohp = htmlspecialchars($data['nohp']);
	$tanggal = htmlspecialchars($data['tanggal']);
	$resi = htmlspecialchars($data['resi']);
	$berat_barang = htmlspecialchars($data['berat_barang']);
	$harga = htmlspecialchars($data['harga']);
	$cod = htmlspecialchars($data['cod']);
	$ekspedisi = htmlspecialchars($data['ekspedisi']);
	$pincod = htmlspecialchars($data['pincod']);
	$fotolama = htmlspecialchars($data["fotolama"]);

	if ($_FILES['foto']['error'] === 4) {
		$foto = $fotolama;
	} else {
		$foto = upload();
	}


	$query = "UPDATE pengiriman SET 	
				nama_pelanggan = '$nama_pelanggan',
                alamat = '$alamat',
                nohp = '$nohp',
				tanggal = '$tanggal',
                resi = '$resi',
				berat_barang = '$berat_barang',
				harga = '$harga',
				cod = '$cod',
				ekspedisi = '$ekspedisi',
				pincod = '$pincod',
				foto = '$foto'
			  WHERE id = $id";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubahpengiriman2($data)
{
	$conn = koneksi();

	$id = ($data["id"]);
	// Menangkap data yang di kirim dari form
	$nama_pelanggan = htmlspecialchars($data['nama_pelanggan']);
	$alamat = htmlspecialchars($data['alamat']);
	$nohp = htmlspecialchars($data['nohp']);
	$tanggal = htmlspecialchars($data['tanggal']);
	$resi = htmlspecialchars($data['resi']);
	$berat_barang = htmlspecialchars($data['berat_barang']);
	$harga = htmlspecialchars($data['harga']);
	$cod = htmlspecialchars($data['cod']);
	$ekspedisi = htmlspecialchars($data['ekspedisi']);



	$query = "UPDATE pengiriman SET 	
				nama_pelanggan = '$nama_pelanggan',
                alamat = '$alamat',
                nohp = '$nohp',
				tanggal = '$tanggal',
                resi = '$resi',
				berat_barang = '$berat_barang',
				harga = '$harga',
				cod = '$cod',
				ekspedisi = '$ekspedisi'
			  WHERE id = $id";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function tambahadmin($data)
{
	$conn = koneksi();

	// Menangkap data yang di kirim dari form
	$username = htmlspecialchars($data['username']);
	$password = htmlspecialchars($data['password']);
	$foto = upload();
	if (!$foto) {
		return false;
	}

	// insert data ke database
	$query = "INSERT INTO user
VALUES
('','$username','$password','$foto')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapusadmin($id)
{
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM user WHERE id = $id");

	return mysqli_affected_rows($conn);
}


function ubahprofil($data)
{
	$conn = koneksi();

	$id = ($data["id"]);
	// Menangkap data yang di kirim dari form
	$username = htmlspecialchars($data['username']);
	$fotolama = htmlspecialchars($data["fotolama"]);

	if ($_FILES['foto']['error'] === 4) {
		$foto = $fotolama;
	} else {
		$foto = upload();
	}

	$query = "UPDATE user SET 	
				username = '$username',
                foto = '$foto'
			  WHERE id = $id";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function tambahsupir($data)
{
	$conn = koneksi();

	// Menangkap data yang di kirim dari form
	$nama = htmlspecialchars($data['nama']);
	$foto = upload();
	if (!$foto) {
		return false;
	}
	$mobil = htmlspecialchars($data['mobil']);

	// insert data ke database
	$query = "INSERT INTO supir
VALUES
('','$nama','$foto','$mobil')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapussupir($id)
{
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM supir WHERE id = $id");

	return mysqli_affected_rows($conn);
}


function ubahsupir($data)
{
	$conn = koneksi();

	$id = ($data["id"]);
	// Menangkap data yang di kirim dari form
	$nama = htmlspecialchars($data['nama']);
	$fotolama = htmlspecialchars($data["fotolama"]);

	if ($_FILES['foto']['error'] === 4) {
		$foto = $fotolama;
	} else {
		$foto = upload();
	}
	$mobil = htmlspecialchars($data['mobil']);


	$query = "UPDATE supir SET 	
				nama = '$nama',
                foto = '$foto',
                mobil = '$mobil'
			  WHERE id = $id";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}



function tambahcod($data)
{
	$conn = koneksi();

	// Menangkap data yang di kirim dari form
	$nama = htmlspecialchars($data['nama']);
	$pin = htmlspecialchars($data['pin']);
	$saldo = htmlspecialchars($data['saldo']);
	$tanggal = htmlspecialchars($data['tanggal']);
	$status = htmlspecialchars($data['status']);

	// insert data ke database
	$query = "INSERT INTO catatancod
VALUES
('','$nama','$pin','$saldo','$tanggal','$status')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function ubahcod($data)
{
	$conn = koneksi();

	$id = ($data["id"]);
	// Menangkap data yang di kirim dari form
	$nama = htmlspecialchars($data['nama']);
	$pin = htmlspecialchars($data['pin']);
	$saldo = htmlspecialchars($data["saldo"]);
	$tanggal = htmlspecialchars($data["tanggal"]);
	$status = htmlspecialchars($data["status"]);


	$query = "UPDATE catatancod SET 	
				nama = '$nama',
				pin = '$pin',
                saldo = '$saldo',
                tanggal = '$tanggal',
				status = '$status'
			  WHERE id = $id";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}





function hapuscod($id)
{
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM catatancod WHERE id = $id");

	return mysqli_affected_rows($conn);
}



function tambahpengiriman_barang($data)
{
	$conn = koneksi();

	// Menangkap data yang di kirim dari form
	$tanggal = htmlspecialchars($data['tanggal']);
	$jumlah = htmlspecialchars($data['jumlah_barang']);

	// insert data ke database
	$query = "INSERT INTO pengiriman_barang
VALUES
('','$tanggal','$jumlah')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function hapuspengiriman_barang($id)
{
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM pengiriman_barang WHERE id = $id");

	return mysqli_affected_rows($conn);
}


function ubahpengiriman_barang($data)
{
	$conn = koneksi();

	$id = ($data["id"]);
	// Menangkap data yang di kirim dari form
	$tanggal = htmlspecialchars($data['tanggal']);
	$jumlah = htmlspecialchars($data['jumlah_barang']);

	$query = "UPDATE pengiriman_barang SET 	
				tanggal = '$tanggal',
                jumlah_barang = '$jumlah'
			  WHERE id = $id";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}