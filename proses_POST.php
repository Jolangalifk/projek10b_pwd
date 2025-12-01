<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Form_POST.php');
    exit;
}

// Ambil dan sanitasi input (strip HTML tags, trim, batas panjang)
$nim = strip_tags(trim($_POST['nim'] ?? ''));
$nim = substr($nim, 0, 50); // batasi panjang

$nama = strip_tags(trim($_POST['nama'] ?? ''));
$nama = substr($nama, 0, 200);

$no_hp_raw = trim($_POST['no_hp'] ?? '');
// Hanya simpan karakter yang umum pada nomor telepon (angka, +, spasi, -)
$no_hp = preg_replace('/[^0-9+\- ]/', '', $no_hp_raw);
$no_hp = substr($no_hp, 0, 50);

$umur = isset($_POST['umur']) ? (int)$_POST['umur'] : 0;
if ($umur < 0) $umur = 0;

$tempat_lahir = strip_tags(trim($_POST['tempat_lahir'] ?? ''));
$tempat_lahir = substr($tempat_lahir, 0, 100);

$tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
// (optional) basic date format check YYYY-MM-DD
if ($tanggal_lahir !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_lahir)) {
    $tanggal_lahir = '';
}

$alamat = strip_tags(trim($_POST['alamat'] ?? ''));
$alamat = substr($alamat, 0, 1000);

$kota = strip_tags(trim($_POST['kota'] ?? ''));
$kota = substr($kota, 0, 100);

$jk = strip_tags(trim($_POST['jk'] ?? ''));
$jk = substr($jk, 0, 50);

$status = strip_tags(trim($_POST['status'] ?? ''));
$status = substr($status, 0, 50);

$hobi_arr = $_POST['hobi'] ?? [];
// sanitize setiap pilihan hobi lalu gabungkan
if (is_array($hobi_arr)) {
    $sanitized_hobi = array_map(function ($h) {
        return substr(strip_tags(trim((string)$h)), 0, 100);
    }, $hobi_arr);
    $hobi = implode(', ', $sanitized_hobi);
} else {
    $hobi = '';
}

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

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
    // Escape all output when showing back to the browser
    echo "<h2>Data berhasil disimpan ke database!</h2>";
    echo "<ul>";
    echo "<li>NIM: " . htmlspecialchars($nim, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Nama: " . htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>No HP: " . htmlspecialchars($no_hp, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Umur: " . htmlspecialchars((string)$umur, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Tempat Lahir: " . htmlspecialchars($tempat_lahir, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Tanggal Lahir: " . htmlspecialchars($tanggal_lahir, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Alamat: " . htmlspecialchars($alamat, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Kota: " . htmlspecialchars($kota, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Jenis Kelamin: " . htmlspecialchars($jk, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Status: " . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Hobi: " . htmlspecialchars($hobi, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "<li>Email: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</li>";
    echo "</ul>";
    echo "<p><a href=\"Form_POST.php\">Kembali ke form</a></p>";
} else {
    echo "Insert gagal: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
