<?php 
//menjalankan session
session_start();

//menggunakan session
if(!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

//menghubungkan ke file functions
require 'functions.php';
//jika tidak ada id di URL
if(!isset($_GET['id'])){
header("Location: index.php");
exit;
}
//ambil id dari URL
$id = $_GET['id'];
//query data dari id
$sis = query("SELECT * FROM siswa WHERE id = $id");

//mengecek tombol ubah
if (isset($_POST['ubah'])){
    if ( ubah($_POST) > 0){
    echo "<script>
    alert('data berhasil diubah');
    document.location.href= 'index.php';</script>";
    }else{
        echo "data gagal diubah";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ubah data</title>
</head>
<body>
    <h1>FORM UBAH DATA</h1>
    <form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $sis['id']; ?>">
    <ul>
    <li>
    <label>
        NISN : 
        <input type="text" name="nisn" autofocus required value = "<?= $sis['nisn']; ?>">
    </label>
    </li>
    <li>
    <label>
        NAMA : 
        <input type="text" name="nama" autofocus required value = "<?= $sis['nama']; ?>">
    </label>
    </li>
    <li>
    <label>
        EMAIL : 
        <input type="text" name="email" autofocus required value = "<?= $sis['email']; ?>">
    </label>
    </li>
    <li>
    <label>
        JURUSAN :
        <input type="text" name="jurusan" autofocus required value = "<?= $sis['jurusan']; ?>">
    </label>
    </li>
    <li>
    <input type="hidden" name="profile_lama" value="<?= $sis['profile']; ?>">
    <label>
        PROFILE :
        <input type="file" name="profile" autofocus class="gambar" onchange="preview()">
    </label>
    <img src="img/<?= $sis['profile']; ?>" width="150" style="display: block;" class="img-preview">
    </li>
    <li>
    <button type="submit" name="ubah">UBAH DATA</button>
    </li>
    </ul>
    </form>
    <script src="js/try.js">//menghubungkan file script dengan file ubah</script>
</body>
</html>