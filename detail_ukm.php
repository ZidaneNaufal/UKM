<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'ukm');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['product_id'])) {
    echo "<p>Produk tidak ditemukan.</p>";
    exit();
}

$product_id = intval($_GET['product_id']);

// Mengambil data dari tabel ukm dan ukm_detail
$sql = "SELECT u.*, d.visi, d.misi, d.prestasi, d.jadwal_latihan 
        FROM ukm u
        JOIN ukm_detail d ON u.id = d.ukm_id
        WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<p>Produk tidak ditemukan.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail UKM</title>
    <link rel="stylesheet" href="styles/detail_ukm.css"> <!-- Panggilan ke file CSS eksternal -->
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($product['name'] ?? ""); ?></h1>
        <img src="<?php echo htmlspecialchars($product['foto'] ?? "default.jpg"); ?>" alt="UKM Image" class="product-img">
        <div class="product-info">
            <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($product['description'] ?? "Deskripsi belum tersedia."); ?></p>
        </div>

        <div class="extra-info">
            <h3>Visi dan Misi</h3>
            <ul>
                <li><strong>Visi:</strong> <?php echo htmlspecialchars($product['visi'] ?? "Visi belum tersedia."); ?></li>
                <li><strong>Misi:</strong> <?php echo htmlspecialchars($product['misi'] ?? "Misi belum tersedia."); ?></li>
            </ul>

            <h3>Prestasi</h3>
            <ul>
                <?php
                if (!empty($product['prestasi'])) {
                    $prestasi_list = explode(';', $product['prestasi']);
                    foreach ($prestasi_list as $prestasi) {
                        echo "<li>" . htmlspecialchars($prestasi) . "</li>";
                    }
                } else {
                    echo "<li>Prestasi belum tersedia.</li>";
                }
                ?>
            </ul>

            <h3>Jadwal Latihan</h3>
            <ul>
                <?php
                if (!empty($product['jadwal_latihan'])) {
                    $jadwal_list = explode(';', $product['jadwal_latihan']);
                    foreach ($jadwal_list as $jadwal) {
                        echo "<li>" . htmlspecialchars($jadwal) . "</li>";
                    }
                } else {
                    echo "<li>Jadwal latihan belum tersedia.</li>";
                }
                ?>
            </ul>
        </div>

        <a href="pendaftaran.php" class="back-button">Formulir Pendaftaran</a>
        <a href="dashboard.php" class="back-button">Kembali ke Dashboard</a>
    </div>
</body>
</html>
