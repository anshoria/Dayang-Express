<?php
session_start();
require 'db_conn.php';

if(isset($_COOKIE['set']) && isset($_COOKIE['key'])){
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

if (isset($_POST['submit'])) {

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$username = test_input($_POST['username']);
$password = test_input($_POST['password']);

if (empty($username)) {
    header("Location: index.php?error=Masukkan Username");
} else if (empty($password)) {
    header("Location: index.php?error=Masukkan Password");
} else {



    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        // the user name must be unique
        $row = mysqli_fetch_assoc($result);
        if ($row['password'] === $password) {
            $_SESSION['login'] = true;
            setcookie('set', $row['id'], $cookie_time);
            
            if(isset($_POST['ingat'])){
                $cookie_time = time() + (60 * 60 * 24 * 3);
                setcookie('set', $row['id'], $cookie_time);
                setcookie('key', hash('sha256', $row['username']), $cookie_time);
            }
            header("Location: home.php");
            exit;
        } else {
            header("Location: index.php?error=Username atau Password anda salah!");
        }
    } else {
        header("Location: index.php?error=Username atau Password salah!");
    }
}

}else {
	header("Location: index.php");
}
