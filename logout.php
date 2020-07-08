<?php 
//menggunakan session
session_start();
//menghapus status login
session_destroy();
header("Location: login.php");
exit;
?>