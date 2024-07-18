<?php 
session_start();

if (isset($_SESSION['login'])) {

include "../db_conn.php";

if (isset($_POST['pl']) && isset($_POST['pb'])
    && isset($_POST['k_pb'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$pl = validate($_POST['pl']);
	$pb = validate($_POST['pb']);
	$k_pb = validate($_POST['k_pb']);
    
    if(empty($pl)){
      header("Location: ubahpassword.php?error=Password Lama diperlukan!");
	  exit();
    }else if(empty($pb)){
      header("Location: ubahpassword.php?error=Password Baru diperlukan!");
	  exit();
    }else if($pb !== $k_pb){
      header("Location: ubahpassword.php?error=Konfirmasi Password tidak cocok!");
	  exit();
    }else {
        $id = $_COOKIE['set'];

        $sql = "SELECT password
                FROM user WHERE 
                id='$id' AND password='$pl'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) === 1){
        	
        	$sql_2 = "UPDATE user
        	          SET password='$pb'
        	          WHERE id='$id'";
        	mysqli_query($conn, $sql_2);
            echo "<script>
				alert('password berhasil diubah!');
				document.location.href = 'setting.php';
			  </script>";

        }else {
            echo "<script>
				alert('Password Salah!');
				document.location.href = 'ubahpassword.php';
			  </script>";
        }

    }

    
}else{
	header("Location: ubahpassword.php");
	exit();
}

}else{
     header("Location: ../index.php");
     exit();
}
?>