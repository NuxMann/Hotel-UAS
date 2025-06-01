<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id          = $_POST['id'];
    $staff_id    = $_POST['staff_id'];
    $full_name   = $_POST['full_name'];
    $gender      = $_POST['gender'];
    $position    = $_POST['position'];
    $phone       = $_POST['phone'];
    $email       = $_POST['email'];
    $address     = $_POST['address'];
    $birth_place = $_POST['birth_place'];
    $birth_date  = $_POST['birth_date'];

    // Update data ke tbl_staff
    $query = "UPDATE tbl_staff 
              SET staff_id = ?, full_name = ?, gender = ?, position = ?, phone = ?, email = ?, address = ?, birth_place = ?, birth_date = ?, updated_at = NOW() 
              WHERE id = ?";

    $stmt = $connection->prepare($query);
    $stmt->bind_param("sssssssssi", 
        $staff_id, $full_name, $gender, $position, $phone, $email, $address, $birth_place, $birth_date, $id
    );

    if ($stmt->execute()) {
        echo "<script>alert('✅ Data staff berhasil diupdate!'); window.location.href='../../data-staff-page.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal mengupdate data staff!'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../../data-staff-page.php");
    exit;
}
?>
