<?php  
session_start();
session_unset();
session_destroy();

$cookie_time2 = time() - (61 * 60 * 24 * 3);
setcookie('set', '', $cookie_time2);
setcookie('key', '', $cookie_time2);
header("Location: index.php");
