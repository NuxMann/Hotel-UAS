<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $room_id      = trim($_POST['room_id']);
    $room_number  = trim($_POST['room_number']);
    $room_type_id = trim($_POST['room_type_id']);
    $description  = trim($_POST['description']);
    $price        = floatval($_POST['price']);
    $status       = $_POST['status'];

    // Validasi status
    $allowed_status = ['Tersedia', 'Tidak Tersedia', 'Maintenance'];
    if (!in_array($status, $allowed_status)) {
        echo "<script>alert('Status tidak valid!'); window.history.back();</script>";
        exit;
    }

    // Validasi dan proses file gambar
    $image        = $_FILES['image']['name'];
    $tmp_name     = $_FILES['image']['tmp_name'];
    $allowed_ext  = ['jpg', 'jpeg', 'png', 'webp'];
    $target_dir   = "../../img/";
    $file_ext     = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $new_filename = uniqid('room_') . '.' . $file_ext;

    if (!in_array($file_ext, $allowed_ext)) {
        echo "<script>alert('Format gambar tidak valid! (jpg/jpeg/png/webp)'); window.history.back();</script>";
        exit;
    }

    if (!move_uploaded_file($tmp_name, $target_dir . $new_filename)) {
        echo "<script>alert('❌ Gagal mengunggah gambar!'); window.history.back();</script>";
        exit;
    }

    // Simpan ke database
    $stmt = $connection->prepare("INSERT INTO tbl_rooms 
        (room_id, room_number, room_type_id, description, price, image, status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param("ssssdss", $room_id, $room_number, $room_type_id, $description, $price, $new_filename, $status);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Data kamar berhasil disimpan!'); window.location.href='../../data-kamar-page.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menyimpan data kamar: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../../form-kamar.php");
    exit;
}
?>
