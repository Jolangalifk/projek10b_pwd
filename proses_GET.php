<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output dari GET</title>
</head>

<body>
    <h2>Data yang Diterima dari Form GET</h2>

    <?php
    include "connection.php";

    echo "<p>NIM: " . $_GET['nim'] . "</p>";
    echo "<p>Nama: " . $_GET['nama'] . "</p>";
    echo "<p>No HP: " . $_GET['no_hp'] . "</p>";
    echo "<p>Umur: " . $_GET['umur'] . "</p>";
    echo "<p>Tempat Lahir: " . $_GET['tempat_lahir'] . "</p>";
    echo "<p>Tanggal Lahir: " . $_GET['tanggal_lahir'] . "</p>";
    echo "<p>Alamat: " . $_GET['alamat'] . "</p>";

    $kota = $_GET['kota'];
    if ($kota == "Jakarta") {
        echo "<p>Kota: Jakarta</p>";
    } elseif ($kota == "Bandung") {
        echo "<p>Kota: Bandung</p>";
    } elseif ($kota == "Surabaya") {
        echo "<p>Kota: Surabaya</p>";
    } elseif ($kota == "Yogyakarta") {
        echo "<p>Kota: Yogyakarta</p>";
    } elseif ($kota == "Medan") {
        echo "<p>Kota: Medan</p>";
    }
    $jk = $_GET['jk'];
    if ($jk == "Laki-laki") {
        echo "<p>Jenis Kelamin: Laki-laki</p>";
    } else {
        echo "<p>Jenis Kelamin: Perempuan</p>";
    }
    $status = $_GET['status'];
    if ($status == "Belum Kawin") {
        echo "<p>Status: Belum Kawin</p>";
    } else {
        echo "<p>Status: Sudah Kawin</p>";
    }

    if (!empty($_GET['hobi'])) {
        echo "<p>Hobi: " . implode(", ", $_GET['hobi']) . "</p>";
    } else {
        echo "<p>Hobi: Tidak ada</p>";
    }

    echo "<p>Email: " . $_GET['email'] . "</p>";

    // Query Insert ke database
    $sql = "INSERT INTO mhs (nim, nama, no_hp, umur, tempat_lahir, tanggal_lahir, 
    alamat, kota, jk, status, hobi, email)
    VALUES ('$nim', '$nama', '$no_hp', '$umur', '$tempat_lahir', '$tanggal_lahir', 
    '$alamat', '$kota', '$jk', '$status', '$hobi', '$email')";

    if (mysqli_query($conn, $sql)) {
        echo "<h2>Data berhasil disimpan ke database!</h2>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    ?>
</body>

</html>