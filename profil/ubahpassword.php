<?php
session_start();
include "../db_conn.php";
if (isset($_SESSION['login'])) {

?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Ganti Password</title>
		<link rel="icon" href="../img/logo-head-2.png" type="image/png">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	</head>
	<style>

		html,
		body {
			background-image: url('../img/background.jpg');
			background-size: cover;
			background-repeat: no-repeat;
			height: 100%;
			font-family: 'Numans', sans-serif;
		}
		.bg-glass {
      background-color: hsla(0, 0%, 100%, 0.9) !important;
    }
	</style>

	<body>
		<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh">
			<form class="bg-glass border shadow p-5 rounded" action="cekpassword.php" method="post" style="width: 450px;">
				<h2 class="text-center p-3 text-dark">Ganti Password</h2>
				<?php if (isset($_GET['error'])) { ?>
					<p class="error"><?php echo $_GET['error']; ?></p>
				<?php } ?>

				<?php if (isset($_GET['success'])) { ?>
					<p class="success"><?php echo $_GET['success']; ?></p>
				<?php } ?>
				<div class="mb-1">
					<label class="form-label text-dark">Password Lama</label>
					<input class="form-control" type="password" name="pl" >
					<br>
				</div>
				<div class="mb-1">
					<label class="form-label text-dark">Password Baru</label>
					<input class="form-control" type="password" name="pb" >
					<br>
				</div>
				<div class="mb-1">
					<label class="form-label text-dark">Konfirmasi Password Baru</label>
					<input class="form-control" type="password" name="k_pb" >
					<br>
				</div>
				<button type="submit" class="btn btn-success">GANTI</button>
				<a href="setting.php" class="btn btn-primary">Kembali</a>
			</form>
		</div>
	</body>

	</html>

<?php
} else {
	header("Location: ../index.php");
	exit();
}
?>