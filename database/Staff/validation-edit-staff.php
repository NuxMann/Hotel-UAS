<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil dan bersihkan data
    $id           = intval($_POST['id']);
    $staff_id     = trim($_POST['staff_id']);
    $full_name    = trim($_POST['full_name']);
    $email        = trim($_POST['email']);
    $role         = trim($_POST['role']);
    $birth_place  = trim($_POST['birth_place']);
    $birth_date   = trim($_POST['birth_date']);
    $address      = trim($_POST['address']);
    $phone_number = trim($_POST['phone_number']);

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid!'); window.history.back();</script>";
        exit;
    }

    // Validasi tanggal lahir
    if (empty($birth_date)) {
        echo "<script>alert('Tanggal lahir tidak boleh kosong!'); window.history.back();</script>";
        exit;
    }

    // Query update
    $query = "UPDATE tbl_staff 
              SET staff_id = ?, 
                  full_name = ?, 
                  email = ?, 
                  role = ?, 
                  birth_place = ?, 
                  birth_date = ?, 
                  address = ?, 
                  phone_number = ?, 
                  updated_at = NOW()
              WHERE id = ?";

    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssssssi", 
        $staff_id, $full_name, $email, $role, 
        $birth_place, $birth_date, $address, $phone_number, $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('✅ Data staff berhasil diupdate!');
                window.location.href='../../data-staff-page.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Gagal mengupdate data staff: " . $stmt->error . "');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../../data-staff-page.php");
    exit;
}
