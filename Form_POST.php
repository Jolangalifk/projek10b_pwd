<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Mahasiswa</title>
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
            padding: 40px 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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
            font-size: 28px;
            font-weight: 600;
        }

        .header p {
            margin-top: 8px;
            opacity: 0.9;
            font-size: 14px;
        }

        .form-content {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="email"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .radio-group,
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .radio-option,
        .checkbox-option {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            background: #f8f9fa;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .radio-option:hover,
        .checkbox-option:hover {
            background: #e9ecef;
            border-color: #667eea;
        }

        input[type="radio"],
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .radio-option label,
        .checkbox-option label {
            cursor: pointer;
            margin: 0;
            font-weight: 500;
            color: #212529;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .required {
            color: #f5576c;
            margin-left: 3px;
        }

        /* Grid Layout for Radio Buttons on Desktop */
        @media (min-width: 768px) {
            .radio-group-inline {
                flex-direction: row;
                gap: 15px;
            }

            .radio-group-inline .radio-option {
                flex: 1;
            }

            .checkbox-group {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
        }

        @media (max-width: 767px) {
            body {
                padding: 20px 10px;
            }

            .container {
                border-radius: 15px;
            }

            .header {
                padding: 25px 20px;
            }

            .header h2 {
                font-size: 24px;
            }

            .form-content {
                padding: 25px 20px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            input[type="text"],
            input[type="number"],
            input[type="date"],
            input[type="email"],
            select {
                padding: 10px 12px;
                font-size: 14px;
            }

            .submit-btn {
                padding: 12px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .header h2 {
                font-size: 20px;
            }

            .header p {
                font-size: 13px;
            }

            .form-content {
                padding: 20px 15px;
            }
        }

        /* Custom Select Arrow */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23495057' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        /* Input validation styling */
        input:invalid:not(:placeholder-shown),
        select:invalid {
            border-color: #f5576c;
        }

        input:valid:not(:placeholder-shown) {
            border-color: #51cf66;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>📝 Form Input Data Mahasiswa</h2>
            <p>Silakan isi semua data dengan lengkap dan benar</p>
        </div>

        <div class="form-content">
            <form action="proses_POST.php" method="POST">
                <div class="form-group">
                    <label for="nim">NIM <span class="required">*</span></label>
                    <input type="text" id="nim" name="nim" placeholder="Masukkan NIM" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP <span class="required">*</span></label>
                    <input type="text" id="no_hp" name="no_hp" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="form-group">
                    <label for="umur">Umur <span class="required">*</span></label>
                    <input type="number" id="umur" name="umur" placeholder="Masukkan umur" min="17" max="100" required>
                </div>

                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat <span class="required">*</span></label>
                    <input type="text" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" required>
                </div>

                <div class="form-group">
                    <label for="kota">Kota <span class="required">*</span></label>
                    <select id="kota" name="kota" required>
                        <option value="">-- Pilih Kota --</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                        <option value="Medan">Medan</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Makassar">Makassar</option>
                        <option value="Palembang">Palembang</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin <span class="required">*</span></label>
                    <div class="radio-group radio-group-inline">
                        <div class="radio-option">
                            <input type="radio" id="laki-laki" name="jk" value="Laki-laki" required>
                            <label for="laki-laki">👨 Laki-laki</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="perempuan" name="jk" value="Perempuan" required>
                            <label for="perempuan">👩 Perempuan</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status <span class="required">*</span></label>
                    <div class="radio-group radio-group-inline">
                        <div class="radio-option">
                            <input type="radio" id="belum_kawin" name="status" value="Belum Kawin" required>
                            <label for="belum_kawin">Belum Kawin</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="sudah_kawin" name="status" value="Sudah Kawin" required>
                            <label for="sudah_kawin">Sudah Kawin</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Hobi (Pilih minimal 1)</label>
                    <div class="checkbox-group">
                        <div class="checkbox-option">
                            <input type="checkbox" id="membaca" name="hobi[]" value="Membaca">
                            <label for="membaca">📚 Membaca</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="olahraga" name="hobi[]" value="Olahraga">
                            <label for="olahraga">⚽ Olahraga</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="menonton_film" name="hobi[]" value="Menonton Film">
                            <label for="menonton_film">🎬 Menonton Film</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="musik" name="hobi[]" value="Musik">
                            <label for="musik">🎵 Musik</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="travelling" name="hobi[]" value="Travelling">
                            <label for="travelling">✈️ Travelling</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="gaming" name="hobi[]" value="Gaming">
                            <label for="gaming">🎮 Gaming</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
                </div>

                <button type="submit" class="submit-btn">Simpan Data →</button>
            </form>
        </div>
    </div>

    <script>
        // Validasi minimal 1 hobi dipilih
        document.querySelector('form').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="hobi[]"]');
            const checked = Array.from(checkboxes).some(cb => cb.checked);
            
            if (!checked) {
                e.preventDefault();
                alert('Silakan pilih minimal 1 hobi!');
                checkboxes[0].focus();
            }
        });

        // Auto-format nomor HP
        document.getElementById('no_hp').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>
</body>

</html>