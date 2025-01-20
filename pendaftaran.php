<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'UKM'); // Pastikan nama database adalah 'UKM'
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil daftar UKM dari tabel `ukm`
$sql = "SELECT id, name FROM ukm";
$ukm_list = $conn->query($sql);

// Hitung jumlah UKM yang sudah didaftarkan oleh user
$count_sql = "SELECT COUNT(*) AS count FROM registrations WHERE user_id = ?";
$stmt = $conn->prepare($count_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$count_result = $stmt->get_result();
$registration_count = $count_result->fetch_assoc()['count'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $nim = trim($_POST['nim']);
    $program_studi = $_POST['program_studi'];
    $ukm_id = $_POST['ukm_id'];
    $alasan = trim($_POST['alasan']);

    // Cek duplikasi pendaftaran UKM
    $check_sql = "SELECT * FROM registrations WHERE user_id = ? AND ukm_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $ukm_id);
    $check_stmt->execute();
    $duplicate_result = $check_stmt->get_result();

    if ($duplicate_result->num_rows > 0) {
        $error_message = "Anda sudah mendaftar ke UKM ini. Silakan cek status pendaftaran Anda.";
    } elseif ($registration_count >= 3) {
        $error_message = "Anda hanya bisa mendaftar ke maksimal 3 UKM.";
    } else {
        $insert_sql = "INSERT INTO registrations (user_id, nama, nim, program_studi, ukm_id, alasan) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("isssis", $user_id, $nama, $nim, $program_studi, $ukm_id, $alasan);

        if ($insert_stmt->execute()) {
            $success_message = "Pendaftaran berhasil!";
        } else {
            $error_message = "Pendaftaran gagal: " . $conn->error;
        }
        $insert_stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran UKM</title>
    <link rel="stylesheet" href="styles/pendaftaran.css">
</head>
<body>
    <div class="container">
        <h1>Pendaftaran UKM</h1>
        <?php if (isset($error_message)): ?>
            <div class="popup" id="errorPopup">
                <h2><?php echo htmlspecialchars($error_message); ?></h2>
                <button class="close-btn" onclick="closePopup()">OK, Mengerti</button>
            </div>
            <div class="overlay" id="overlay" onclick="closePopup()"></div>
            <script>
                function showPopup() {
                    document.getElementById('errorPopup').style.display = 'block';
                    document.getElementById('overlay').style.display = 'block';
                }

                function closePopup() {
                    document.getElementById('errorPopup').style.display = 'none';
                    document.getElementById('overlay').style.display = 'none';
                }
                showPopup();
            </script>
        <?php elseif (isset($success_message)): ?>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" required>

            <label for="nim">NIM</label>
            <input type="text" id="nim" name="nim" required>

            <label for="program_studi">Program Studi</label>
            <select id="program_studi" name="program_studi" required>
                <option value="">Pilih Program Studi</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Ilmu Komputer">Ilmu Komputer</option>
                <option value="Teknik Elektro">Teknik Elektro</option>
            </select>

            <label for="ukm_id">Pilih UKM</label>
            <select id="ukm_id" name="ukm_id" required>
                <option value="">Pilih UKM</option>
                <?php while ($row = $ukm_list->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            </select>

            <label for="alasan">Alasan Bergabung</label>
            <textarea id="alasan" name="alasan" rows="4" required></textarea>

            <button type="submit">Daftar</button>
        </form>

        <div class="button-container">
            <a href="dashboard.php" class="back-button">Kembali ke Dashboard</a>
            <p class="status-link">Belum yakin? <a href="status.php">Lihat status pendaftaran Anda di sini</a></p>
        </div>
    </div>
</body>
</html>
