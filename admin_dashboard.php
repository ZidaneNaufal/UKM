<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'ukm'); // Menggunakan database 'ukm'
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data UKM
$ukm_result = $conn->query("SELECT * FROM ukm");

// Hitung jumlah anggota berdasarkan pendaftaran UKM
$registration_count_sql = "SELECT ukm_id, COUNT(*) AS total FROM registrations GROUP BY ukm_id";
$registration_count_result = $conn->query($registration_count_sql);
$registration_count = [];
while ($row = $registration_count_result->fetch_assoc()) {
    $registration_count[$row['ukm_id']] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="styles/admin_dashboard.css">
</head>
<body>
    <div class="header">
        <h1>Selamat Datang, Admin</h1>
        <nav>
            <a href="logout.php" class="logout-button">Logout</a>
        </nav>
    </div>

    <div class="content">
        <h2>Daftar UKM</h2>
        <a href="add_ukm.php" class="add-button">Tambah UKM Baru</a>
        <table border="1">
            <tr>
                <th>Nama UKM</th>
                <th>Deskripsi</th>
                <th>Jumlah Anggota</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $ukm_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo isset($registration_count[$row['id']]) ? $registration_count[$row['id']] : 0; ?></td>
                    <td>
                        <a href="edit_ukm.php?id=<?php echo $row['id']; ?>" class="edit-button">Edit</a>
                        <a href="delete_ukm.php?id=<?php echo $row['id']; ?>" class="delete-button" onclick="return confirm('Yakin ingin menghapus UKM ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>Daftar Pendaftaran Mahasiswa</h2>
        <?php
        // Query untuk daftar pendaftaran mahasiswa
        $registration_result = $conn->query("
            SELECT r.*, u.username, k.name AS ukm_name 
            FROM registrations r 
            JOIN users u ON r.user_id = u.id 
            JOIN ukm k ON r.ukm_id = k.id 
            ORDER BY r.id DESC
        ");
        ?>
        <table border="1">
            <tr>
                <th>Nama Mahasiswa</th>
                <th>UKM</th>
                <th>Alasan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $registration_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['ukm_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['alasan']); ?></td>
                    <td>
                        <?php if ($row['status'] === 'approved'): ?>
                            <span style="color: green; font-weight: bold;">Diterima</span>
                        <?php elseif ($row['status'] === 'rejected'): ?>
                            <span style="color: red; font-weight: bold;">Ditolak</span>
                        <?php else: ?>
                            <span style="color: orange; font-weight: bold;">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['status'] === 'pending'): ?>
                            <a href="approve_registration.php?id=<?php echo $row['id']; ?>" class="approve-button">Setujui</a>
                            <a href="reject_registration.php?id=<?php echo $row['id']; ?>" class="reject-button">Tolak</a>
                        <?php else: ?>
                            <span>Tidak ada tindakan</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
