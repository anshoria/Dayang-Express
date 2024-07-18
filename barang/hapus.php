<?php
session_start();  
require '../config.php';

if (!isset($_SESSION['login'])) {
	header("location: ../index.php");
	exit;
  }

if( isset($_GET["id"]) ) {
	// cek keberhasilan query
	if( hapuspengiriman($_GET["id"]) > 0 ) {
        echo "<script>
				alert('berhasil dihapus!');
				document.location.href = '../home.php';
			  </script>";
	} else {
		echo "<script>
				alert('data gagal dihapus!');
				document.location.href = '../home.php';
			  </script>";
	}
}
?>