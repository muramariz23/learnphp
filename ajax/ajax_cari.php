<?php 
//require file function diluar folder
require '../functions.php';
//menangkap data dari form cari
$siswa = cari($_GET['keyword']);

?>
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