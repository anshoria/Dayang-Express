<?php
session_start();
require 'db_conn.php';
if (isset($_COOKIE['set']) && isset($_COOKIE['key'])) {
	$set = $_COOKIE['set'];
	$key = $_COOKIE['key'];

	$sql = "SELECT username FROM user WHERE id='$set'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if ($key === hash('sha256', $row['username'])) {
		$_SESSION['login'] = true;
	}
}

if (isset($_SESSION['login'])) {
	header("Location: home.php");
	exit;
}


?>

<!DOCTYPE html>
<html>

<head>
	<title>Dayang Express 99</title>
	<link rel="icon" href="img/logo-head-2.png" type="image/png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

</head>

<style>
@import url('https://fonts.googleapis.com/css?family=Numans');
html,body{
background-image: url('img/background.jpg');
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
		<form class="bg-glass border shadow p-5 rounded" action="ceklogin.php" method="post" style="width: 450px;">
			<h1 class="text-center p-3">LOGIN</h1>
			<?php if (isset($_GET['error'])) { ?>
				<div class="alert alert-danger" role="alert">
					<?= $_GET['error'] ?>
				</div>
			<?php } ?>
			<div class="mb-3">
				<label for="username" class="form-label text-dark">Username</label>
				<input type="text" class="form-control" name="username" id="username" autofocus required>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label text-dark">Password</label>
				<input type="password" name="password" class="form-control" id="password" required>
			</div>
			<div class="mb-3 row">
				<div class="col-1">
					<input type="checkbox" name="ingat" id="ingat" style="width: 20px; height: 20px;">
				</div>
				<div>
					<label for="ingat" class="form-label text-dark" style="margin-left: 8px;">Ingat saya</label>
				</div>
			</div>

			<button type="submit" class="btn btn-primary" name="submit">LOGIN</button>
		</form>
	</div>

</body>

</html>