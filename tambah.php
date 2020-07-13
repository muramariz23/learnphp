<?php 
//menjalankan session
session_start();

//menggunakan session
if(!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

//mengecek tombol tambah
if (isset($_POST['tambah'])){
    if ( tambah($_POST) > 0){
    echo "<script>
    alert('data berhasil ditambahkan');
    document.location.href= 'index.php';</script>";
    }else{
        echo "data gagal ditambahkan";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tambah data</title>
</head>
<body>
    <h1>FORM TAMBAH DATA</h1>
    <form action="" method="POST" enctype="multipart/form-data">
    <ul>
    <li>
    <label>
        NISN : 
        <input type="text" name="nisn" autofocus required>
    </label>
    </li>
    <li>
    <label>
        NAMA : 
        <input type="text" name="nama" autofocus required>
    </label>
    </li>
    <li>
    <label>
        EMAIL : 
        <input type="text" name="email" autofocus required>
    </label>
    </li>
    <li>
    <label>
        JURUSAN :
        <input type="text" name="jurusan" autofocus required>
    </label>
    </li>
    <li>
    <label>
        PROFILE :
        <input type="file" name="profile" autofocus class="gambar" onchange="preview()">
    </label>
    <img src="img/no_photo.jpg" width="150" style="display: block;" class="img-preview">
    </li>
    <li>
    <button type="submit" name="tambah">TAMBAH DATA</button>
    </li>
    </ul>
    </form>

<script src="js/try.js">//menghubungkan file tambah dengan file javascript</script>
</body>
</html>