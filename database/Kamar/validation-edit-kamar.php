<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $room_type = $_POST['room_type'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Cek apakah ada file gambar baru
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $target_dir = "../img/";
        $file_ext = pathinfo($image, PATHINFO_EXTENSION);
        $new_filename = uniqid('room_') . '.' . $file_ext;

        move_uploaded_file($tmp_name, $target_dir . $new_filename);

        // Update dengan gambar
        $query = "UPDATE tbl_rooms SET room_type=?, description=?, capacity=?, price=?, image=?, status=?, updated_at=NOW() WHERE id=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssidsii", $room_type, $description, $capacity, $price, $new_filename, $status, $id);
    } else {
        // Update tanpa gambar
        $query = "UPDATE tbl_rooms SET room_type=?, description=?, capacity=?, price=?, status=?, updated_at=NOW() WHERE id=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssidsi", $room_type, $description, $capacity, $price, $status, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('✅ Kamar berhasil diupdate!'); window.location='../../data-kamar-page.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal update kamar!'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
}
