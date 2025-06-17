<?php
include "../connection-database.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}

$username = $_SESSION['username'];

$full_name     = $_POST['full_name'] ?? '';
$tempat_lahir  = $_POST['tempat_lahir'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$alamat        = $_POST['alamat'] ?? '';
$no_hp         = $_POST['no_hp'] ?? '';

if (empty($full_name) || empty($tempat_lahir) || empty($tanggal_lahir)) {
    echo "<script>alert('Data wajib diisi lengkap!'); window.history.back();</script>";
    exit;
}

$stmt = $connection->prepare("SELECT id, image FROM tbl_users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "<script>alert('User tidak ditemukan.'); window.location='../../profile-page.php';</script>";
    exit;
}

$userId = $user['id'];
$oldImage = $user['image'] ?? null;

$imageName = $oldImage;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png'];
    $fileType     = $_FILES['image']['type'];
    $tmpName      = $_FILES['image']['tmp_name'];

    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>alert('Format gambar harus JPG atau PNG'); window.history.back();</script>";
        exit;
    }

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = 'user_' . time() . '.' . $ext;
    $uploadDir = '../../uploads/';
    move_uploaded_file($tmpName, $uploadDir . $imageName);

    if ($oldImage && file_exists($uploadDir . $oldImage)) {
        unlink($uploadDir . $oldImage);
    }
}

$updateStmt = $connection->prepare("UPDATE tbl_users SET full_name = ?, tempat_lahir = ?, tanggal_lahir = ?, alamat = ?, no_hp = ?, image = ?, updated_at = NOW() WHERE id = ?");
$updateStmt->bind_param("ssssssi", $full_name, $tempat_lahir, $tanggal_lahir, $alamat, $no_hp, $imageName, $userId);

if ($updateStmt->execute()) {
    echo "<script>alert('✅ Profil berhasil diperbarui!'); window.location='../../profile-page.php';</script>";
} else {
    echo "<script>alert('❌ Gagal memperbarui profil!'); window.history.back();</script>";
}

$updateStmt->close();
$connection->close();
?>
