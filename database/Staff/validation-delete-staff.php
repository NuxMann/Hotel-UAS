<?php
include "../connection-database.php";

// Validasi parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID staff tidak valid!'); window.location='../../data-staff-page.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Hapus data staff
$query = "DELETE FROM tbl_staff WHERE id = ?";
$stmt = $connection->prepare($query);

if (!$stmt) {
    echo "<script>alert('Gagal menyiapkan query!'); window.location='../../data-staff-page.php';</script>";
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('🗑️ Data staff berhasil dihapus!'); window.location='../../data-staff-page.php';</script>";
} else {
    echo "<script>alert('❌ Gagal menghapus data staff: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$connection->close();
