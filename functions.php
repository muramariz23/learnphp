<?php 
//fungsi untuk koneksi ke database
function koneksi(){
    return mysqli_connect('localhost', 'root', '', 'data_siswa');
}
//fungsi untuk query database
function query($query){
    $conn = koneksi();
    $result = mysqli_query($conn, $query);
//jika hanya satu data
    if( mysqli_num_rows($result) == 1){
        return mysqli_fetch_assoc($result);
    }
    //untuk data yang banyak
    //buat variabel untuk wadah
$rows = [];
//ubah data menjadi array
while ($row = mysqli_fetch_assoc($result)) {
    $rows[]= $row; 
    }
    return $rows;
}
//fungsi untuk mengupload file
function upload(){
    //mengambil data gambar
    $nama_file = $_FILES['profile']['name'];
    $type_file = $_FILES['profile']['type'];
    $ukuran_file = $_FILES['profile']['size'];
    $error = $_FILES['profile']['error'];
    $tmp_file = $_FILES['profile']['tmp_name'];

    //ketika gambar tidak dipilih
    if($error == 4) {
//         echo "<script>
//     alert('silahkan pilih gambar terlebih dahulu!');
// </script>";
return "no_photo.jpg";
    }
    //cek extensi file
    $daftar_gambar = ['jpg', 'jpeg', 'png'];
    $extensi = explode('.', $nama_file);
    $extensi = strtolower(end($extensi));
    if(!in_array($extensi, $daftar_gambar)){
        echo "<script>
        alert('extensi gambar tidak bisa dipakai/bukan gambar!');
    </script>";
    return false;
    }
    //mengecek type file
    if($type_file != 'image/jpeg' && $type_file != 'image/png'){
        echo "<script>
        alert('extensi gambar tidak bisa dipakai/bukan gambar!');
    </script>";
    return false;
    }
    //mengecek ukuran file
    //maksimal 5Mb / 5000000 byte
    if ($ukuran_file > 5000000) {
        echo "<script>
        alert('ukuran gambar terlalu besar!');
    </script>";
    return false;
    }
    //lolos pengecekan
    //generate nama file baru agar tidak ada kesamaan nama
    $nama_file_baru = uniqid();
    $nama_file_baru .= '.';
    $nama_file_baru .= $extensi;
    //siap untuk di upload
    move_uploaded_file($tmp_file, 'img/' . $nama_file_baru);

    return $nama_file_baru;
}

//fungsi untuk tambah
function tambah($data)
{
    //koneksi ke database
    $conn = koneksi();
    //mewadahi setiap data kedalam sebuah variabel
    $nisn = htmlspecialchars($data['nisn']);
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $jurusan = htmlspecialchars($data['jurusan']);
    //$profile = htmlspecialchars($data['profile']);

    //mengambil gambar dari data
    $profile = upload();
    //pengecekan gambar jika kosong
    if(!$profile) {
        return false;
    }
    //memasukan data ke database melalui wadah variabel
    $query = "INSERT INTO siswa VALUES (null, '$nisn', '$nama', '$email', '$jurusan', '$profile')";
    //melakukan query
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    //mengecek error dari mysql
    echo mysqli_error($conn);
    //membalikkan nilai
    return mysqli_affected_rows($conn);
}
//fungsi untuk menghapus data
function hapus($id){
    $conn = koneksi();
    //menghapus gambar
    $sis = query("SELECT * FROM siswa WHERE id = $id");
    if ($sis['profile'] != 'nophoto.jpg') {
        unlink('img/' . $sis['profile']);
    }
    

    mysqli_query($conn, "DELETE FROM siswa WHERE id = $id") or die(mysqli_error($conn));
    return mysqli_affected_rows($conn);
}
//fungsi untuk mengubah data
function ubah($data)
{
    //koneksi ke database
    $conn = koneksi();
    //mewadahi setiap data kedalam sebuah variabel
    $id = $data['id'];
    $nisn = htmlspecialchars($data['nisn']);
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $profile_lama = htmlspecialchars($data['profile_lama']);
    //update gambar
    $profile = upload();
    if (!$profile) {
        return false;
    }

    if ($profile == 'nophoto.jpg') {
        $profile = $profile_lama;
    }

    //memasukan data ke database melalui wadah variabel
    $query = "UPDATE siswa SET
                nisn = '$nisn',
                nama = '$nama',
                email = '$email',
                jurusan = '$jurusan',
                profile = '$profile'
                WHERE id = $id;";
    //melakukan query
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    //mengecek error dari mysql
    echo mysqli_error($conn);
    //membalikkan nilai
    return mysqli_affected_rows($conn);
}

//fungsi untuk mencari
function cari($keyword){
    $conn = koneksi();
    //query
    $query = "SELECT * FROM siswa WHERE nama LIKE '%$keyword%'";
    //result query
    $result = mysqli_query($conn, $query);
    //buat variabel untuk wadah
$rows = [];
//ubah data menjadi array
while ($row = mysqli_fetch_assoc($result)) {
    $rows[]= $row; 
    }
    return $rows;
}

//fungsi untuk login
function login($data)
{
    //koneksi database
    $conn = koneksi();

    //mewadahi data dalam sebuah variabel

    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);
//cek username sesuai data
if ($user = query("SELECT * FROM user WHERE username = '$username'")) {
    //cek password
    if(password_verify($password, $user['password'])){
    //set session
    $_SESSION['login'] = true;
    header("Location: index.php");
    exit;
    }
    } 
        return [
            'error' => true,
            'pesan' => 'Username/Password Salah!!!'
        ];

}

function registrasi($data)
{
    //koneksi ke database
    $conn = koneksi();
    //mengambil data dari form registrasi
    $username = htmlspecialchars(strtolower($data['username']));
    $password1 = mysqli_real_escape_string($conn, $data['password1']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);
//serangkaian pengecekan untuk form registrasi
//jika form kosong
if(empty($username) || empty($password1) || empty($password2)) {
    echo "<script>
            alert('username / password tidak boleh kosong !');
            document.location.href = 'registrasi.php';
        </script>";
    return false;
}
//jika username sudah ada
if (query("SELECT * FROM user WHERE username = '$username'")){
    echo "<script>
    alert('username sudah terdaftar, coba username lain !');
    document.location.href = 'registrasi.php';
</script>";
return false;
}
//jika konfirmasi password tidak sesuai
if ($password1 !== $password2) {
    echo "<script>
    alert('konfirmasi password tidak sesuai, silahkan coba lagi !');
    document.location.href = 'registrasi.php';
</script>";
return false;
}
//jika password < 5 digit
if(strlen($password1) < 5) {
    echo "<script>
    alert('password terlalu pendek, isi 5-8 digit angka !');
    document.location.href = 'registrasi.php';
</script>";
return false;
}
//jika password > 5 digit
if(strlen($password1) > 5) {
    echo "<script>
    alert('password terlalu panjang, isi 5-8 digit angka !');
    document.location.href = 'registrasi.php';
</script>";
return false;
}

//jika password & username sudah selesai
//enkripsi password
$password_baru = password_hash($password1, PASSWORD_DEFAULT);
//insert kedalam tabel user

$query = "INSERT INTO user VALUES (null, '$username', '$password_baru')";
mysqli_query($conn, $query) or die(mysqli_error($conn));
return mysqli_affected_rows($conn);

}
?>