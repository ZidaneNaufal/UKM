<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'ukm');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = intval($_GET['id']);  // ID pendaftaran mahasiswa

// Update status menjadi "Diterima"
$sql = "UPDATE registrations SET status = 'approved' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin_dashboard.php?success=approve");
    exit();
} else {
    echo "<script>alert('Gagal menyetujui pendaftaran.'); window.location.href='admin_dashboard.php';</script>";
}

$stmt->close();
$conn->close();
?>
