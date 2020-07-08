<?php 
//menjalankan session
session_start();

//menggunakan session
if(!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

//menghubungkan dengan file functions
require "functions.php";
//jika tidak ada id di URL
if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
    }
//ambil id dari URL
$id = $_GET['id'];
//query siswa
$sis = query("SELECT * FROM siswa WHERE id = $id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail siswa</title>
</head>
<body>
    <h1>DETAIL SISWA</h1>
    <img src="img/<?= $sis['profile']; ?>" alt="" width="100">
    <ul>
    <li><?= $sis['nisn']; ?></li>
    <li><?= $sis['nama']; ?></li>
    <li><?= $sis['email']; ?></li>
    <li><?= $sis['jurusan']; ?></li>
    <li><a href="ubah.php?id=<?= $sis['id']; ?>">UBAH DATA</a> | <a href="hapus.php?id=<?= $sis['id']; ?>" onclick="return confirm('Apakah anda Yakin??');">HAPUS DATA</a></li>
    <li><a href="index.php">KEMBALI</a></li>
    </ul>
</body>
</html>