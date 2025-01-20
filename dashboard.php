<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'UKM'); // Ubah nama database menjadi `UKM`
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Query ke tabel `ukm` (mengganti `products` dengan `ukm`)
$sql = "SELECT * FROM ukm";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UKM</title>
    <link rel="stylesheet" href="styles/dashboard.css"> <!-- Panggilan ke file CSS -->
</head>
<body>
    <div class="header">
        <h1>Selamat Datang di Dashboard UKM</h1>
        <div class="nav">
            <a href="pendaftaran.php" class="nav-button">Pendaftaran</a>
            <a href="logout.php" class="nav-button">Logout</a>
        </div>
    </div>

    <div class="products">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product">
                    <img src="<?php echo htmlspecialchars($row['foto']); ?>" alt="UKM Image">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <!-- Deskripsi dihapus -->
                    <form action="detail_ukm.php" method="get">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Lihat Lebih Detail</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada UKM yang tersedia.</p>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>UKM Dashboard - Temukan komunitas dan minatmu!</p>
    </footer>
</body>
</html>
