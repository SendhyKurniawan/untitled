<?php include 'config.php';
// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk mencegah SQL Injection dan XSS
function input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = input($_POST["email"]);
    $nama = input($_POST["nama"]);
    $nim = input($_POST["nim"]);
    $password = input($_POST["password"]);
    $confirm_password = input($_POST["password"]);

    // Validasi data
    if ($password !== $confirm_password) {
        die("Kata sandi tidak cocok.");
    }

    // Enkripsi kata sandi menggunakan SHA-256
    $hashed_password = hash('sha256', $password);

    // Query untuk menyimpan data ke database
    $sql = "INSERT INTO users (nim, nama, email, password) VALUES ('$nim', '$nama', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: loginpage.php");
        echo "Registrasi berhasil!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPKS - Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="register grid2c">
        <div class="register-wrap">
            <div class="registertitle-wrap pv">
                <div class="registertitle  fade-in right">Selamat Datang Kembali!</div>
                <div class="registersubtitle fade-in right">Silakan masukan akun Anda.</div>
            </div>
            <form action="" method="post" class="fade-in right">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Anda" required>
                </div>
                <div class="grid2c regemail">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan Email Anda" required>
                    </div>
                    <div>
                        <label for="nim">NIM</label>
                        <input type="number" id="nim" name="nim" placeholder="Masukkan NIM Anda" required>
                    </div>
                </div>
                <div>
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi Anda" required>
                </div>
                <div>
                    <label for="password">Konfirmasi Sandi Anda</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi Anda" required>
                </div>
                <div>
                    <button type="submit">Daftar</button>
                </div>
            </form>
            <p class="fade-in right">Sudah memiliki akun? <a href="loginpage.php">Masuk</a></p>
        </div>
        <div class="img-wrap">
            <img class="fade-in left" src="assets/img/loginregis/1.webp">
            <div class="floatinghashtagregister1 fade-in right">
                <p class="hashtag">#GerakBersama</p>
            </div>
            <div class="floatinghashtagregister2 fade-in left">
                <p class="hashtag">#AmanBersama</p>
            </div>
        </div>
    </section>
    <script src="script.js"></script>
</body>

</html>