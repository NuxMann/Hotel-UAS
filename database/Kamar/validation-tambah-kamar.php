<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $room_type   = trim($_POST['room_type']);
    $description = trim($_POST['description']);
    $capacity    = intval($_POST['capacity']);
    $price       = floatval($_POST['price']);
    $status      = $_POST['status'];

    // Validasi file gambar
    $image       = $_FILES['image']['name'];
    $tmp_name    = $_FILES['image']['tmp_name'];
    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    $target_dir  = "../../img/";
    $file_ext    = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $new_filename = uniqid('room_') . '.' . $file_ext;

    if (!in_array($file_ext, $allowed_ext)) {
        echo "<script>alert('Format gambar tidak valid! (jpg/jpeg/png/webp)'); window.history.back();</script>";
        exit;
    }

    if (!move_uploaded_file($tmp_name, $target_dir . $new_filename)) {
        echo "<script>alert('Gagal mengunggah gambar!'); window.history.back();</script>";
        exit;
    }

    // Simpan ke database
    $stmt = $connection->prepare("INSERT INTO tbl_rooms (room_type, description, capacity, price, image, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdss", $room_type, $description, $capacity, $price, $new_filename, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Data kamar berhasil disimpan!'); window.location.href='../../data-kamar-page.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data kamar: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: form-kamar.php");
    exit;
}
?>
