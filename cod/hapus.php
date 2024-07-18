<?php
session_start();  
require '../config.php';

if( isset($_GET["id"]) ) {
	// cek keberhasilan query
	if( hapuscod($_GET["id"]) > 0 ) {
		header ("Location: catatancod.php");
	} else {
		echo "<script>
				alert('data gagal dihapus!');
				document.location.href = 'catatancod.php';
			  </script>";
	}
}
?>