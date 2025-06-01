<?php
include "../connection-database.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID kamar tidak valid!'); window.location='../data-kamar-page.php';</script>";
    exit;
}

$id = intval($_GET['id']);

$query = "DELETE FROM tbl_rooms WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('🗑️ Data berhasil dihapus!'); window.location='../../data-kamar-page.php';</script>";
} else {
    echo "<script>alert('❌ Gagal menghapus kamar!'); window.history.back();</script>";
}

$stmt->close();
$connection->close();
?>
