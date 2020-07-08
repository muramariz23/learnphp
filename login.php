<?php 
//menjalankan session
session_start();
//menggunakan session
if(isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
  }

//hubungkan file functions
require 'functions.php';

//ketika tombol login ditekan
if(isset($_POST['login'])) {
   $login = login($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <h1>FORM LOGIN</h1>
    <?php if(isset($login['error'])) : ?>
    <p><?php echo $login['pesan']; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
    <ul>
    <li>
    <label>
        Username :
        <input type="text" name="username" autofocus autocomplete="off" required>
    </label>
    </li>
    <li>
    <label>
        Password :
        <input type="password" name="password" autocomplete="off" required>
    </label>
    </li>
    <li>
    <button type="submit" name="login">LOGIN</button>
    </li>
    <li>
    <a href="registrasi.php">TAMBAH DATA</a>
    </li>
    </ul>
    </form>
</body>
</html>