<?php
// database/Room Facilities/validation-delete-room-facilities.php
include "../connection-database.php";
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit();
}

// Cek parameter rf_id (karena kita sekarang menyimpan room_facility_id, bukan numeric id)
if (!isset($_GET['rf_id']) || trim($_GET['rf_id']) === '') {
    echo "<script>
            alert('ID relasi fasilitas–kamar tidak valid!');
            window.location.href='../../data-room-facilities-page.php';
          </script>";
    exit();
}

$rf_id = $_GET['rf_id'];

// Hapus record berdasarkan room_facility_id
$stmt = $connection->prepare("DELETE FROM tbl_room_facilities WHERE room_facility_id = ?");
$stmt->bind_param("s", $rf_id);

if ($stmt->execute()) {
    // Berhasil
    echo "<script>
            alert('🗑️ Relasi fasilitas–kamar (ID: {$rf_id}) berhasil dihapus!');
            window.location.href='../../data-room-facilities-page.php?success=1';
          </script>";
} else {
    // Gagal
    $err = htmlspecialchars($stmt->error, ENT_QUOTES);
    echo "<script>
            alert('❌ Gagal menghapus relasi: {$err}');
            window.history.back();
          </script>";
}

$stmt->close();
$connection->close();
?>
