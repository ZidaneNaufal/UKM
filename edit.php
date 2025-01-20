<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'ukm');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$registration_id = intval($_GET['id']);

// Ambil data pendaftaran berdasarkan ID dan pastikan milik user yang login
$sql = "SELECT * FROM registrations WHERE id = ? AND user_id = ? AND status = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $registration_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$registration = $result->fetch_assoc();

if (!$registration) {
    echo "<p>Pendaftaran tidak ditemukan atau tidak dapat diedit.</p>";
    echo '<a href="status.php">Kembali ke Status Pendaftaran</a>';
    exit();
}

// Proses update jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $program_studi = trim($_POST['program_studi']);
    $alasan = trim($_POST['alasan']);

    $update_sql = "UPDATE registrations SET nama = ?, program_studi = ?, alasan = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $nama, $program_studi, $alasan, $registration_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Pendaftaran berhasil diperbarui!'); window.location.href = 'status.php';</script>";
    } else {
        echo "<p>Gagal memperbarui pendaftaran: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pendaftaran</title>
    <link rel="stylesheet" href="styles/edit.css">
</head>
<body>
    <div class="container">
        <h1>Edit Pendaftaran UKM</h1>
        <form method="POST">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($registration['nama']); ?>" required>

            <label for="program_studi">Program Studi</label>
            <select id="program_studi" name="program_studi" required>
                <option value="Teknik Informatika" <?php echo ($registration['program_studi'] === 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                <option value="Sistem Informasi" <?php echo ($registration['program_studi'] === 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                <option value="Ilmu Komputer" <?php echo ($registration['program_studi'] === 'Ilmu Komputer') ? 'selected' : ''; ?>>Ilmu Komputer</option>
                <option value="Teknik Elektro" <?php echo ($registration['program_studi'] === 'Teknik Elektro') ? 'selected' : ''; ?>>Teknik Elektro</option>
            </select>

            <label for="alasan">Alasan Bergabung</label>
            <textarea id="alasan" name="alasan" rows="4" required><?php echo htmlspecialchars($registration['alasan']); ?></textarea>

            <button type="submit">Perbarui Pendaftaran</button>
        </form>
        <a href="status.php" class="back-button">Kembali ke Status Pendaftaran</a>
    </div>
</body>
</html>
