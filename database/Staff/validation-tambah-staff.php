<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $staff_id    = trim($_POST['staff_id']);
    $full_name   = trim($_POST['full_name']);
    $gender      = $_POST['gender'];
    $position    = trim($_POST['position']);
    $phone       = trim($_POST['phone']);
    $email       = trim($_POST['email']);
    $address     = trim($_POST['address']);
    $birth_place = trim($_POST['birth_place']);
    $birth_date  = $_POST['birth_date'];

    // Simpan ke database
    $stmt = $connection->prepare("INSERT INTO tbl_staff 
        (staff_id, full_name, gender, position, phone, email, address, birth_place, birth_date, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

    $stmt->bind_param("sssssssss", 
        $staff_id, $full_name, $gender, $position, $phone, $email, $address, $birth_place, $birth_date);

    if ($stmt->execute()) {
        echo "<script>alert('Data staff berhasil disimpan!'); window.location.href='../../data-staff-page.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data staff: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../../form-staff.php");
    exit;
}
?>
