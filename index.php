<?php
//menjalankan session
session_start();

//menggunakan session
if(!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';
// tampung wadah kedalam suatu variabel
$siswa = query("SELECT * FROM siswa");

//ketika tombol cari ditekan
if(isset($_POST['cari'])) {
  $siswa = cari($_POST['keyword']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="logout.php">LOG OUT</a>
    <h1>DAFTAR SISWA</h1>
    <form action="" method= "POST">
    <input type="text" name= "keyword" size="20" placeholder="Masukan keyword pencarian" autocomplete="off" autofocus>
    <button type="submit" name="cari">CARI!</button>
    </form>
    <br>
    <a href="tambah.php">TAMBAH DATA SISWA</a>
    <?php if (empty($siswa)) : ?>
    <p style="color: red; font-style: italic;">Mohon Maaf Data Tidak Ada!!!</p>
    <?php endif; ?>
    <table border = 1 cellpadding="10" cellspacing="0">
    <tr>
    <th>NO</th>
    <th>NAMA</th>
    <th>PROFILE</th>
    <th>LIHAT DETAIL</th>
    </tr>
    <?php 
    $i = 1;
    foreach ($siswa as $sis) : ?>
    <tr>
    <td><?= $i++; ?></td>
    <td><?= $sis['nama']; ?></td>
    <td><img src= "img/<?= $sis['profile']; ?>" width="60"></td>
    <td><a href="detail.php?id=<?= $sis['id']; ?>">CEK</a></td>
    </tr>
    <?php endforeach ; ?>
    </table>
</body>
</html>