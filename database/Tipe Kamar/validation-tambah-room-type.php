<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan bersihkan data input
    $room_type_id = trim($_POST['room_type_id']);
    $type_name    = trim($_POST['type_name']);
    $description  = trim($_POST['description']);

    // Validasi: semua field wajib diisi
    if (empty($room_type_id) || empty($type_name) || empty($description)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    // Cek duplikasi room_type_id
    $check = mysqli_query($connection, "SELECT * FROM tbl_room_types WHERE room_type_id = '$room_type_id'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('ID Tipe sudah digunakan!'); window.history.back();</script>";
        exit;
    }

    // Simpan ke database
    $stmt = $connection->prepare("INSERT INTO tbl_room_types (room_type_id, type_name, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $room_type_id, $type_name, $description);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Tipe kamar berhasil ditambahkan!'); window.location.href='../../data-tipe-kamar-page.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menambah tipe kamar: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../../form-room-type.php");
    exit;
}
?>
