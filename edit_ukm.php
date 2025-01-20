<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'ukm');
$id = intval($_GET['id']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $visi = $_POST['visi'];
    $misi = $_POST['misi'];
    $prestasi = $_POST['prestasi'];
    $jadwal_latihan = $_POST['jadwal_latihan'];

    // Proses upload foto baru jika ada
    if (!empty($_FILES["foto"]["name"])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $sql = "UPDATE products SET name = ?, description = ?, foto = ?, visi = ?, misi = ?, prestasi = ?, jadwal_latihan = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $name, $description, $target_file, $visi, $misi, $prestasi, $jadwal_latihan, $id);
        }
    } else {
        $sql = "UPDATE products SET name = ?, description = ?, visi = ?, misi = ?, prestasi = ?, jadwal_latihan = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $name, $description, $visi, $misi, $prestasi, $jadwal_latihan, $id);
    }

    if ($stmt->execute()) {
        echo "<p>Data UKM berhasil diperbarui!</p>";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<p>Gagal memperbarui data.</p>";
    }
} else {
    $result = $conn->query("SELECT * FROM ukm WHERE id = $id");
    $ukm = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit UKM</title>
    <link rel="stylesheet" href="styles/admin_dashboard.css">
</head>
<body>
    <h1>Edit Data UKM</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Nama UKM</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($ukm['name'] ?? ''); ?>" required>
        
        <label for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($ukm['description'] ?? ''); ?></textarea>
        
        <label for="visi">Visi</label>
        <textarea id="visi" name="visi" rows="3" required><?php echo htmlspecialchars($ukm['visi'] ?? ''); ?></textarea>
        
        <label for="misi">Misi</label>
        <textarea id="misi" name="misi" rows="3" required><?php echo htmlspecialchars($ukm['misi'] ?? ''); ?></textarea>
        
        <label for="prestasi">Prestasi</label>
        <textarea id="prestasi" name="prestasi" rows="4" required><?php echo htmlspecialchars($ukm['prestasi'] ?? ''); ?></textarea>
        
        <label for="jadwal_latihan">Jadwal Latihan</label>
        <textarea id="jadwal_latihan" name="jadwal_latihan" rows="3" required><?php echo htmlspecialchars($ukm['jadwal_latihan'] ?? ''); ?></textarea>
        
        <label for="foto">Ganti Foto (Opsional)</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        
        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
