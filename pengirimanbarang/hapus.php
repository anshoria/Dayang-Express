<?php
session_start();  
require '../config.php';

if( isset($_GET["id"]) ) {
	// cek keberhasilan query
	if( hapuspengiriman_barang($_GET["id"]) > 0 ) {
		echo "<script>
				alert('berhasil dihapus!');
				document.location.href = '../pengiriman/pengiriman.php';
			  </script>";
	} else {
		echo "<script>
				alert('data gagal dihapus!');
				document.location.href = '../pengiriman/pengiriman.php';
			  </script>";
	}
}
?>