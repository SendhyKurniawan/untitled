<?php
$title = "PPKS - Kuis";
include 'config.php';
if (!isset($_SESSION['nim'])) {

    header("Location: loginpage.php");

    exit();
}
// Ambil data pertanyaan dari database
$sql = "SELECT pertanyaan FROM pertanyaan ORDER BY id";
$result = $conn->query($sql);

$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row['pertanyaan'];
    }
}

$totalQuestions = count($questions);

// Ambil parameter `page` dari URL
$step = isset($_GET['page']) ? (int)$_GET['page'] : 0;

if ($step > $totalQuestions + 1) {
    $step = $totalQuestions + 1;
}

if (!isset($_SESSION['answers'])) {
    $_SESSION['answers'] = array_fill(0, $totalQuestions, 0);
}

$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : ''; // Menggunakan nilai sesi jika tersedia, jika tidak, mengisi dengan string kosong

$nim = isset($_SESSION['nim']) ? $_SESSION['nim'] : ''; // Menggunakan nilai sesi jika tersedia, jika tidak, mengisi dengan string kosong 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nama'])) {
        $_SESSION['nama'] = $_POST['nama'];
    }
    if (isset($_POST['answer'])) {
        $_SESSION['answers'][$step - 1] = $_POST['answer'];
    }
    if (isset($_POST['next'])) {
        header("Location: kuis.php?page=" . ($step + 1));
        exit();
    } elseif (isset($_POST['prev'])) {
        header("Location: kuis.php?page=" . ($step - 1));
        exit();
    } elseif (isset($_POST['submit'])) {

        // Simpan ke database
        $nama = $_SESSION['nama']; // Menyimpan nama dari sesi
        $nim = $_SESSION['nim']; // Menyimpan nim dari sesi
        $answers = $_SESSION['answers'];
        $stmt = $conn->prepare("INSERT INTO quiz (nim, responden, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdddddddddd", $nim, $nama, $answers[0], $answers[1], $answers[2], $answers[3], $answers[4], $answers[5], $answers[6], $answers[7], $answers[8], $answers[9]);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit();
    }
}
include 'header.php';
?>

<!-- <?php
        $heroTitle1 = "Mulai Kuis Sekarang";
        $heroTitle2 = "Uji Pengetahuanmu!";
        $heroSubtitle = "Dengan micro-interaction yang menarik, setiap pertanyaan dirancang untuk memberikan wawasan dan meningkatkan kesadaran Anda.";
        $heroButtonLabel = "Lapor Kekerasan!";
        $heroImageSrc = "assets/img/hero/quiz.webp";
        include 'hero.php';
        ?> -->


<section class="questioner pv">
    <div class="questioner-wrap">
        <?php // Periksa apakah pengguna sudah mengisi kuis sebelumnya berdasarkan NIM
        if (isset($_SESSION['nim'])) {
            $nim = $_SESSION['nim'];

            // Query untuk mencari NIM pengguna dalam tabel quiz
            $check_query = "SELECT COUNT(*) AS count FROM quiz WHERE nim = ?";
            $stmt = $conn->prepare($check_query);
            $stmt->bind_param("i", $nim);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Jika NIM pengguna sudah ada dalam tabel quiz, tandai kuis sebagai selesai
            if ($row['count'] > 0) {
                $_SESSION['kuis_selesai'] = true;

                // Tampilkan pesan bahwa kuis sudah diisi
                echo "<p class='quiz-text'>Terima kasih anda sudah mengisi kuis.</p>";

                // Jangan tampilkan formulir kuis lagi
                exit();
            }
        } ?>
        <form class="quiz-content" method="post" action="">
            <div class="quiz-content-wrap">
                <?php if ($step == 0) : ?>
                    <div class="container fade-in top">
                        <label class="quiz-text" for="nama">Konfirmasi nama anda</label>
                        <input class="quiz-input" type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($_SESSION['nama'] ?? ''); ?>" required>
                    </div>
                <?php elseif ($step > 0 && $step <= $totalQuestions) : ?>
                    <!-- pertanyaan -->
                    <p class="quiz-text fade-in bottom"><?php echo ($step) . ". " . htmlspecialchars($questions[$step - 1]); ?></p>

                    <!-- pilihan jawaban -->
                    <div class="container answer fade-in bottom">
                        <label class="fade-in bottom">
                            <input type="radio" name="answer" value="1" required <?php echo isset($_SESSION['answers'][$step - 1]) && $_SESSION['answers'][$step - 1] == 5 ? 'checked' : ''; ?>> Sangat Setuju
                        </label>
                        <label class="fade-in bottom">
                            <input type="radio" name="answer" value="0.80" required <?php echo isset($_SESSION['answers'][$step - 1]) && $_SESSION['answers'][$step - 1] == 4 ? 'checked' : ''; ?>> Setuju
                        </label>
                        <label class="fade-in bottom">
                            <input type="radio" name="answer" value="0.60" required <?php echo isset($_SESSION['answers'][$step - 1]) && $_SESSION['answers'][$step - 1] == 3 ? 'checked' : ''; ?>> Netral
                        </label>
                        <label class="fade-in bottom">
                            <input type="radio" name="answer" value="0.40" required <?php echo isset($_SESSION['answers'][$step - 1]) && $_SESSION['answers'][$step - 1] == 2 ? 'checked' : ''; ?>> Tidak Setuju
                        </label>
                        <label class="fade-in bottom">
                            <input type="radio" name="answer" value="0.20" required <?php echo isset($_SESSION['answers'][$step - 1]) && $_SESSION['answers'][$step - 1] == 1 ? 'checked' : ''; ?>> Sangat Tidak Setuju
                        </label>
                    </div>
                <?php endif; ?>

                <!-- progress button -->
                <div class="quiz-btn">
                    <?php if ($step > 0) : ?>
                        <button type="submit" class="btn fade-in bottom" name="prev">Sebelumnya</button>
                    <?php endif; ?>

                    <?php if ($step < $totalQuestions) : ?>
                        <button type="submit" class="btn fade-in bottom" name="next">Selanjutnya</button>
                    <?php else : ?>
                        <button type="submit" class="btn fade-in bottom" name="submit">Kirim</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>