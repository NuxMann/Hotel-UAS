<?php
include "../connection-database.php";

// 1) Validasi parameter id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../../data-kamar-page.php");
    exit;
}

$id = intval($_GET['id']);

// 2) Update status dan updated_at
$stmt = $connection->prepare("
    UPDATE tbl_rooms 
    SET status = 'Tersedia', updated_at = NOW() 
    WHERE id = ?
");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // 3) Redirect kembali dengan notifikasi sukses
    header("Location: ../../data-kamar-page.php?refreshed=1");
} else {
    // Pada error, redirect tetap dengan pesan error (opsional)
    header("Location: ../../data-kamar-page.php?error=refresh_failed");
}

$stmt->close();
$connection->close();
