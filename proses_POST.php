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

/* NIM: boleh huruf, angka, titik (.) dan tanda '-' (sesuaikan pola kalau ada format khusus) */
if (!preg_match('/^[A-Za-z0-9.\-]+$/', $nim)) {
    echo "NIM tidak valid — hanya huruf, angka, titik (.) dan tanda '-' yang diperbolehkan (tanpa spasi).";
    exit;
}

/* Nama: hanya huruf (unicode), spasi, apostrof, dan tanda minus */
if (!preg_match('/^[\p{L}\s\'\-]+$/u', $nama)) {
    echo "Nama tidak valid — hanya huruf dan spasi yang diperbolehkan.";
    exit;
}

/* No HP: cek minimal jumlah angka (hapus non-digit untuk pemeriksaan) */
$hp_digits = preg_replace('/\D/', '', $no_hp);
if ($hp_digits === '' || strlen($hp_digits) < 6) {
    echo "Nomor HP tidak valid — masukkan minimal 6 angka.";
    exit;
}

/* Umur: jangkauan wajar */
if ($umur < 0 || $umur > 120) {
    echo "Umur tidak valid.";
    exit;
}

/* Tanggal lahir: jika diisi, pastikan valid (YYYY-MM-DD dan valid calendar date) */
if ($tanggal_lahir !== '') {
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $tanggal_lahir, $m)) {
        echo "Format tanggal lahir tidak valid (harus YYYY-MM-DD).";
        exit;
    }
    $y = (int)$m[1]; $mo = (int)$m[2]; $d = (int)$m[3];
    if (!checkdate($mo, $d, $y)) {
        echo "Tanggal lahir tidak valid.";
        exit;
    }
}

// Prepared statement untuk mencegah SQL injection
$sql = "INSERT INTO mhs (nim, nama, no_hp, umur, tempat_lahir, tanggal_lahir, alamat, kota, jk, status, hobi, email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    echo 'Prepare failed: ' . mysqli_error($conn);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "sssissssssss",
    $nim,
    $nama,
    $no_hp,
    $umur,
    $tempat_lahir,
    $tanggal_lahir,
    $alamat,
    $kota,
    $jk,
    $status,
    $hobi,
    $email
);

$exec = mysqli_stmt_execute($stmt);
if ($exec) {
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Berhasil Disimpan</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }

            .container {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                max-width: 600px;
                width: 100%;
                overflow: hidden;
                animation: slideUp 0.5s ease-out;
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 30px;
                text-align: center;
            }

            .header h2 {
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 5px;
            }

            .success-icon {
                font-size: 48px;
                margin-bottom: 10px;
                animation: scaleIn 0.5s ease-out 0.2s both;
            }

            @keyframes scaleIn {
                from {
                    transform: scale(0);
                }

                to {
                    transform: scale(1);
                }
            }

            .content {
                padding: 30px;
            }

            .data-list {
                list-style: none;
            }

            .data-item {
                padding: 15px;
                margin-bottom: 10px;
                background: #f8f9fa;
                border-radius: 10px;
                border-left: 4px solid #667eea;
                transition: all 0.3s ease;
            }

            .data-item:hover {
                background: #e9ecef;
                transform: translateX(5px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .data-label {
                font-weight: 600;
                color: #495057;
                font-size: 14px;
                display: block;
                margin-bottom: 5px;
            }

            .data-value {
                color: #212529;
                font-size: 16px;
            }

            .footer {
                padding: 20px 30px;
                background: #f8f9fa;
                text-align: center;
            }

            .btn-back {
                display: inline-block;
                padding: 12px 30px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                text-decoration: none;
                border-radius: 25px;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            }

            .btn-back:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
            }

            @media (max-width: 768px) {
                .container {
                    border-radius: 15px;
                }

                .header {
                    padding: 25px 20px;
                }

                .header h2 {
                    font-size: 20px;
                }

                .content {
                    padding: 20px;
                }

                .data-item {
                    padding: 12px;
                }

                .data-label {
                    font-size: 13px;
                }

                .data-value {
                    font-size: 15px;
                }
            }

            @media (max-width: 480px) {
                body {
                    padding: 10px;
                }

                .header h2 {
                    font-size: 18px;
                }

                .success-icon {
                    font-size: 36px;
                }

                .content {
                    padding: 15px;
                }

                .data-item {
                    padding: 10px;
                }

                .btn-back {
                    padding: 10px 25px;
                    font-size: 14px;
                }
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <div class="success-icon">✓</div>
                <h2>Data Berhasil Disimpan!</h2>
            </div>

            <div class="content">
                <ul class="data-list">
                    <li class="data-item">
                        <span class="data-label">NIM</span>
                        <span class="data-value"><?php echo htmlspecialchars($nim, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Nama</span>
                        <span class="data-value"><?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">No HP</span>
                        <span class="data-value"><?php echo htmlspecialchars($no_hp, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Umur</span>
                        <span class="data-value"><?php echo htmlspecialchars((string)$umur, ENT_QUOTES, 'UTF-8'); ?> tahun</span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Tempat Lahir</span>
                        <span class="data-value"><?php echo htmlspecialchars($tempat_lahir, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Tanggal Lahir</span>
                        <span class="data-value"><?php echo htmlspecialchars($tanggal_lahir, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Alamat</span>
                        <span class="data-value"><?php echo htmlspecialchars($alamat, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Kota</span>
                        <span class="data-value"><?php echo htmlspecialchars($kota, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Jenis Kelamin</span>
                        <span class="data-value"><?php echo htmlspecialchars($jk, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Status</span>
                        <span class="data-value"><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Hobi</span>
                        <span class="data-value"><?php echo htmlspecialchars($hobi, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                    <li class="data-item">
                        <span class="data-label">Email</span>
                        <span class="data-value"><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                </ul>
            </div>

            <div class="footer">
                <a href="Form_POST.php" class="btn-back">← Kembali ke Form</a>
            </div>
        </div>
    </body>

    </html>
<?php
} else {
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }

            .error-container {
                background: white;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                text-align: center;
                max-width: 500px;
            }

            .error-icon {
                font-size: 48px;
                color: #f5576c;
            }

            h2 {
                color: #333;
                margin: 20px 0;
            }

            p {
                color: #666;
                margin-bottom: 20px;
            }

            .btn-back {
                display: inline-block;
                padding: 12px 30px;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                color: white;
                text-decoration: none;
                border-radius: 25px;
                font-weight: 600;
            }
        </style>
    </head>

    <body>
        <div class="error-container">
            <div class="error-icon">✕</div>
            <h2>Insert Gagal</h2>
            <p><?php echo htmlspecialchars(mysqli_stmt_error($stmt), ENT_QUOTES, 'UTF-8'); ?></p>
            <a href="Form_POST.php" class="btn-back">← Kembali ke Form</a>
        </div>
    </body>

    </html>
<?php
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>