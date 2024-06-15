<?php include 'config.php';
function input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $email_or_nim = input($_POST["email_or_nim"]);
    $password = input($_POST["password"]);
    // Query untuk memeriksa apakah email atau NIM ada dalam database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR nim = ?");
    $stmt->bind_param("ss", $email_or_nim, $email_or_nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Jika email atau NIM ditemukan dalam database
        $row = $result->fetch_assoc();
        $hashed_password = hash('sha256', $password); // Mengenkripsi kata sandi yang dimasukkan oleh pengguna

        // Memeriksa apakah kata sandi cocok
        if ($hashed_password === $row['password']) {
            // Mengatur session
            $_SESSION['loggedin'] = true;
            $_SESSION['nim'] = $row['nim']; // Menyimpan NIM pengguna dalam session
            $_SESSION['nama'] = $row['nama']; // Menyimpan nama pengguna dalam session

            header("Location: index.php");
            exit(); // Pastikan untuk keluar setelah mengirim header
        } else {
            echo "<p style='color:red;'>Kata sandi salah.</p>";
        }
    } else {
        // Jika email atau NIM tidak ditemukan dalam database
        echo "<p style='color:red;'>Akun tidak ditemukan.</p>";
    }

    // Menutup koneksi database
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPKS - Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="login grid2c">
        <div class="login-wrap">
            <div class="logintitle-wrap pv">
                <div class="logintitle fade-in left">Selamat Datang Kembali!</div>
                <div class="loginsubtitle  fade-in left">Silakan masukan akun Anda.</div>
            </div>
            <form action="" method="post" class="fade-in left">
                <div>
                    <label for="email_or_nim">Email/NIM</label>
                    <input type="text" id="email_or_nim" name="email_or_nim" placeholder="Masukkan Email/NIM Anda" required>
                </div>
                <div>
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi Anda" required>
                </div>
                <div>
                    <button type="submit">Masuk</button>
                </div>
            </form>

            <p class="fade-in right">Belum punya akun? <a href="registerpage.php">Buat akun</a></p>
        </div>
        <div class="img-wrap">
            <img class="fade-in right" src="assets/img/loginregis/2.webp">
            <div class="floatinghashtaglogin1  fade-in left">
                <p class="hashtag">#GerakBersama</p>
            </div>
            <div class="floatinghashtaglogin2 fade-in right">
                <p class="hashtag">#AmanBersama</p>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>

</html>