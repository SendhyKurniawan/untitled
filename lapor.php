<?php
$title = "PPKS - Lapor";
include 'header.php';
?>

<?php
$heroTitle1 = "Laporkan";
$heroTitle2 = " Apabila Terjadi Kekerasan Seksual!";
$heroSubtitle = "#GerakBersama #AmanBersama";
$heroButtonLabel = "Lapor Kekerasan!";
$heroImageSrc = "assets/img/hero/laporan.webp";
include 'hero.php';
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaPelapor = $_POST['namaPelapor'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $isiLaporan = $_POST['isiLaporan'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO laporan_kekerasan (nama_pelapor, email, telepon, isi_laporan) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $namaPelapor, $email, $telepon, $isiLaporan);

    if ($stmt->execute()) {
        echo "<script>alert('Laporan berhasil dikirim!');</script>";
    } else {
        echo "<script>alert('Gagal mengirim laporan.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<section class="formlapor grid2c pv">
    <img class="formimg fade-in left" src="assets/img/1.webp" alt="">
    <form id="reportForm" action="" method="POST">
        <label for="namaPelapor" class="fade-in right">Nama Pelapor</label>
        <input type="text" id="namaPelapor" name="namaPelapor" required placeholder="Masukkan Nama Anda" class="fade-in right">

        <label for="email" class="fade-in right">E-mail</label>
        <input type="email" id="email" name="email" required placeholder="Masukkan Email Anda" class="fade-in right">

        <label for="telepon" class="fade-in right">No. Telepon</label>
        <input type="tel" id="telepon" name="telepon" pattern="[0-9]+" required placeholder="Masukkan No. Telepon Anda" class="fade-in right">

        <label for="isiLaporan" class="fade-in right">Isi Laporan Kekerasan</label>
        <textarea id="isiLaporan" name="isiLaporan" required placeholder="Ceritakan insiden kejadian tersebut..." class="fade-in right"></textarea>

        <button type="submit" value="Submit" class="btnhero fade-in right">Lapor!</button>
    </form>
</section>


<?php include 'footer.php'; ?>