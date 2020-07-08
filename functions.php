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
    $profile = htmlspecialchars($data['profile']);
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
    mysqli_query($conn, "DELETE FROM siswa WHERE id = $id") or die(mysqli_error($conn));
    return mysqli_affected_rows($conn);
}
//fungsi untuk menubah data
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
    $profile = htmlspecialchars($data['profile']);
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