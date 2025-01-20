<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'ukm');
$id = intval($_GET['id']);
$sql = "DELETE FROM ukm WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: admin_dashboard.php");
?>
