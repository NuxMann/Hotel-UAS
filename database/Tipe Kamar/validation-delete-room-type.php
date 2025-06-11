<?php
// validation-delete-room-type.php
include "../connection-database.php";
session_start();

if (!isset($_GET['id'])) {
    header('Location: ../../data-room-type-page.php');
    exit;
}

$id = intval($_GET['id']);

// Ambil kode tipe kamar (room_type_id) dari tbl_room_types
$stmt = $connection->prepare("SELECT room_type_id FROM tbl_room_types WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($room_type_code);
if (!$stmt->fetch()) {
    // Tidak ditemukan
    echo "<script>alert('Data tipe kamar tidak ditemukan.'); window.location='../../data-room-type-page.php';</script>";
    exit;
}
$stmt->close();

// Cek apakah ada kamar yang menggunakan tipe ini
$check = $connection->prepare("SELECT COUNT(*) FROM tbl_rooms WHERE room_type_id = ?");
$check->bind_param('s', $room_type_code);
$check->execute();
$check->bind_result($countRooms);
$check->fetch();
$check->close();

if ($countRooms > 0) {
    // Jika masih ada kamar, batalkan penghapusan
    echo "<script>alert('Tidak dapat menghapus tipe kamar. Masih ada $countRooms kamar yang menggunakan tipe ini.'); window.history.back();</script>";
    exit;
}

// Jika aman, hapus tipe kamar
$del = $connection->prepare("DELETE FROM tbl_room_types WHERE id = ?");
$del->bind_param('i', $id);
if ($del->execute()) {
    echo "<script>alert('Tipe kamar berhasil dihapus.'); window.location='../../data-tipe-kamar-page.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus tipe kamar: " . addslashes($del->error) . "'); window.history.back();</script>";
}
$del->close();
$connection->close();
?>
