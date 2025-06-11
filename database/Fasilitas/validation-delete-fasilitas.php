<?php
// database/Fasilitas/validation-delete-fasilitas.php
include "../connection-database.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>
            alert('ID fasilitas tidak valid!');
            window.location.href='../../data-fasilitas-page.php';
          </script>";
    exit;
}

$id = intval($_GET['id']);

// Hapus record dari tbl_facilities
$stmt = $connection->prepare("DELETE FROM tbl_facilities WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>
            alert('🗑️ Fasilitas berhasil dihapus!');
            window.location.href='../../data-fasilitas-page.php';
          </script>";
} else {
    $err = htmlspecialchars($stmt->error);
    echo "<script>
            alert('❌ Gagal menghapus fasilitas: {$err}');
            history.back();
          </script>";
}

$stmt->close();
$connection->close();
