<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data (POST)</title>
</head>

<body>
    <h2>Form Input Data Mahasiswa</h2>
    <form action="proses_POST.php" method="POST">
        <label for="nim">NIM:</label><br>
        <input type="text" id="nim" name="nim" required><br><br>

        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="no_hp">No HP:</label><br>
        <input type="text" id="no_hp" name="no_hp" required><br><br>

        <label for="umur">Umur:</label><br>
        <input type="number" id="umur" name="umur" required><br><br>

        <label for="tempat_lahir">Tempat Lahir:</label><br>
        <input type="text" id="tempat_lahir" name="tempat_lahir" required><br><br>

        <label for="tanggal_lahir">Tanggal Lahir:</label><br>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir"required><br><br>

        <label for="alamat">Alamat:</label><br>
        <input type="text" id="alamat" name="alamat" required><br><br>

        <label for="kota">Kota:</label><br>
        <select id="kota" name="kota" required>
            <option value="Jakarta">Jakarta</option>
            <option value="Bandung">Bandung</option>
            <option value="Surabaya">Surabaya</option>
            <option value="Yogyakarta">Yogyakarta</option>
            <option value="Medan">Medan</option>
        </select><br><br>

        <label>Jenis Kelamin:</label><br>
        <input type="radio" id="laki-laki" name="jk" value="Laki-laki" required>
        <label for="laki-laki">Laki-laki</label><br>
        <input type="radio" id="perempuan" name="jk" value="Perempuan" required>
        <label for="perempuan">Perempuan</label><br><br>

        <input type="radio" id="belum_kawin" name="status" value="Belum Kawin" required>
        <label for="belum_kawin">Belum Kawin</label><br>
        <input type="radio" id="sudah_kawin" name="status" value="Sudah Kawin" required>
        <label for="sudah_kawin">Sudah Kawin</label><br><br>

        <label>Hobi:</label><br>
        <input type="checkbox" id="membaca" name="hobi[]" value="Membaca">
        <label for="membaca">Membaca</label><br>
        <input type="checkbox" id="olahraga" name="hobi[]" value="Olahraga">
        <label for="olahraga">Olahraga</label><br>
        <input type="checkbox" id="menonton_film" name="hobi[]" value="Menonton Film">
        <label for="menonton_film">Menonton Film</label><br>
        <input type="checkbox" id="musik" name="hobi[]" value="Musik">
        <label for="musik">Musik</label><br>
        <input type="checkbox" id="travelling" name="hobi[]" value="Travelling">
        <label for="travelling">Travelling</label><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>

</html>