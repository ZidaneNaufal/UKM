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

// Query untuk mengambil data pendaftaran
$sql = "SELECT r.id, r.nama, r.program_studi, u.name AS ukm_name, r.alasan, r.status 
        FROM registrations r 
        JOIN ukm u ON r.ukm_id = u.id 
        WHERE r.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran</title>
    <link rel="stylesheet" href="styles/status.css">
</head>
<body>
    <div class="container">
        <h1>Status Pendaftaran UKM</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Nama</th>
                    <th>Program Studi</th>
                    <th>UKM</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['program_studi']); ?></td>
                        <td><?php echo htmlspecialchars($row['ukm_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['alasan']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <?php if ($row['status'] === 'pending'): ?>
                                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Belum ada pendaftaran yang dilakukan.</p>
        <?php endif; ?>
        <a href="dashboard.php" class="back-button">Kembali ke Dashboard</a>
    </div>
</body>
</html>
