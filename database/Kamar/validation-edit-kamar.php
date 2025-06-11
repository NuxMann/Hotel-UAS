<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $room_id = $_POST['room_id'];
    $room_number = $_POST['room_number'];
    $room_type_id = $_POST['room_type_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Validasi status ENUM agar tidak inject sembarang
    $allowed_status = ['Tersedia', 'Tidak Tersedia', 'Maintenance'];
    if (!in_array($status, $allowed_status)) {
        echo "<script>alert('❌ Status tidak valid!'); window.history.back();</script>";
        exit;
    }

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $target_dir = "../../img/";
        $file_ext = pathinfo($image, PATHINFO_EXTENSION);
        $new_filename = uniqid('room_') . '.' . $file_ext;

        move_uploaded_file($tmp_name, $target_dir . $new_filename);

        $query = "UPDATE tbl_rooms 
                  SET room_id=?, room_number=?, room_type_id=?, description=?, price=?, image=?, status=?, updated_at=NOW() 
                  WHERE id=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssssdssi", $room_id, $room_number, $room_type_id, $description, $price, $new_filename, $status, $id);
    } else {
        $query = "UPDATE tbl_rooms 
                  SET room_id=?, room_number=?, room_type_id=?, description=?, price=?, status=?, updated_at=NOW() 
                  WHERE id=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssssdsi", $room_id, $room_number, $room_type_id, $description, $price, $status, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('✅ Kamar berhasil diupdate!'); window.location='../../data-kamar-page.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal update kamar!'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
}
?>
