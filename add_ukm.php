<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'ukm');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $visi = $_POST['visi'];
    $misi = $_POST['misi'];
    $prestasi = $_POST['prestasi'];
    $jadwal_latihan = $_POST['jadwal_latihan'];

    // Proses upload foto
    $target_dir = "uploads/";
    $file_name = basename($_FILES["foto"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        // Masukkan data ke tabel ukm
        $sql_ukm = "INSERT INTO ukm (name, description, foto) VALUES (?, ?, ?)";
        $stmt_ukm = $conn->prepare($sql_ukm);
        $stmt_ukm->bind_param("sss", $name, $description, $target_file);

        if ($stmt_ukm->execute()) {
            // Ambil ID UKM yang baru ditambahkan
            $ukm_id = $conn->insert_id;

            // Masukkan data ke tabel ukm_detail
            $sql_detail = "INSERT INTO ukm_detail (ukm_id, visi, misi, prestasi, jadwal_latihan) VALUES (?, ?, ?, ?, ?)";
            $stmt_detail = $conn->prepare($sql_detail);
            $stmt_detail->bind_param("issss", $ukm_id, $visi, $misi, $prestasi, $jadwal_latihan);

            if ($stmt_detail->execute()) {
                echo "<p>UKM berhasil ditambahkan!</p>";
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p>Gagal menambahkan detail UKM.</p>";
            }
        } else {
            echo "<p>Gagal menambahkan UKM.</p>";
        }
    } else {
        echo "<p>Gagal mengunggah gambar.</p>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Tambah UKM Baru</title>
    <link rel="stylesheet" href="styles/admin_dashboard.css">
</head>
<body>
    <h1>Tambah UKM Baru</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Nama UKM</label>
        <input type="text" id="name" name="name" required>
        
        <label for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="4" required></textarea>
        
        <label for="visi">Visi</label>
        <textarea id="visi" name="visi" rows="3" required></textarea>
        
        <label for="misi">Misi</label>
        <textarea id="misi" name="misi" rows="3" required></textarea>
        
        <label for="prestasi">Prestasi</label>
        <textarea id="prestasi" name="prestasi" rows="4" required></textarea>
        
        <label for="jadwal_latihan">Jadwal Latihan</label>
        <textarea id="jadwal_latihan" name="jadwal_latihan" rows="3" required></textarea>
        
        <label for="foto">Upload Foto</label>
        <input type="file" id="foto" name="foto" accept="image/*" required>
        
        <button type="submit">Tambah UKM</button>
    </form>
</body>
</html>
