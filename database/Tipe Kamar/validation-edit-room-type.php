<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id            = intval($_POST['id']);
    $room_type_id  = trim($_POST['room_type_id']);
    $type_name     = trim($_POST['type_name']);
    $description   = trim($_POST['description']);

    // Validasi wajib isi
    if (empty($room_type_id) || empty($type_name) || empty($description)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    // Update ke database
    $stmt = $connection->prepare("UPDATE tbl_room_types 
        SET room_type_id = ?, type_name = ?, description = ? 
        WHERE id = ?");
    $stmt->bind_param("sssi", $room_type_id, $type_name, $description, $id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Data tipe kamar berhasil diperbarui!'); window.location.href='../../data-tipe-kamar-page.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal memperbarui data: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../../data-tipe-kamar-page.php");
    exit;
}
?>
