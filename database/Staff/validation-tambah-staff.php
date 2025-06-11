<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan sanitasi data dari form
    $staff_id  = trim($_POST['staff_id']);
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $username  = trim($_POST['username']);
    $password  = trim($_POST['password']);
    $role      = trim($_POST['role']);

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid!'); window.history.back();</script>";
        exit;
    }

    // Validasi panjang password minimal 6 karakter
    if (strlen($password) < 3) {
        echo "<script>alert('Password minimal 6 karakter!'); window.history.back();</script>";
        exit;
    }

    // Hash password sebelum simpan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $stmt = $connection->prepare("INSERT INTO tbl_staff 
        (staff_id, full_name, email, username, password, role, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())");

    if (!$stmt) {
        echo "<script>alert('Gagal menyiapkan query!'); window.history.back();</script>";
        exit;
    }

    $stmt->bind_param("ssssss", 
        $staff_id, $full_name, $email, $username, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Data staff berhasil disimpan!'); window.location.href='../../data-staff-page.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menyimpan data staff: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../../form-staff.php");
    exit;
}
