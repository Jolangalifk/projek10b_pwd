<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "udinus";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// connection.php sekarang hanya berisi koneksi (tanpa output HTML)

?>