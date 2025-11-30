<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Form_POST.php');
    exit;
}

// Ambil dan sanitasi input
$nim = trim($_POST['nim'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$umur = isset($_POST['umur']) ? (int)$_POST['umur'] : 0;
$tempat_lahir = trim($_POST['tempat_lahir'] ?? '');
$tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$kota = trim($_POST['kota'] ?? '');
$jk = trim($_POST['jk'] ?? '');
$status = trim($_POST['status'] ?? '');
$hobi_arr = $_POST['hobi'] ?? [];
$hobi = is_array($hobi_arr) ? implode(', ', $hobi_arr) : '';
$email = trim($_POST['email'] ?? '');

// Validasi minimal
if ($nim === '' || $nama === '' || $email === '') {
    echo "Field NIM, Nama, dan Email wajib diisi.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email tidak valid.";
    exit;
}

// Prepared statement untuk mencegah SQL injection
$sql = "INSERT INTO mhs (nim, nama, no_hp, umur, tempat_lahir, tanggal_lahir, alamat, kota, jk, status, hobi, email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    echo 'Prepare failed: ' . mysqli_error($conn);
    exit;
}

mysqli_stmt_bind_param($stmt, "sssissssssss",
    $nim, $nama, $no_hp, $umur, $tempat_lahir, $tanggal_lahir, $alamat, $kota, $jk, $status, $hobi, $email
);

$exec = mysqli_stmt_execute($stmt);
if ($exec) {
    echo "<h2>Data berhasil disimpan ke database!</h2>";
    echo "<p><a href=\"Form_POST.php\">Kembali ke form</a></p>";
} else {
    echo "Insert gagal: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
