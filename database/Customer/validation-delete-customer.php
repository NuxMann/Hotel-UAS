<?php
include "../connection-database.php";

// Validasi parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID customer tidak valid!'); window.location='../../data-customer-page.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Hapus data customer
$query = "DELETE FROM tbl_customers WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('🗑️ Data customer berhasil dihapus!'); window.location='../../data-customer-page.php';</script>";
} else {
    echo "<script>alert('❌ Gagal menghapus data customer!'); window.history.back();</script>";
}

$stmt->close();
$connection->close();
