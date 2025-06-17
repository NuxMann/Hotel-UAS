<?php
include "connection-database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dan sanitasi
    $full_name      = trim($_POST['full_name']);
    $tempat_lahir   = trim($_POST['tempat_lahir']);
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $alamat         = trim($_POST['alamat']);
    $no_hp          = trim($_POST['no_hp']);
    $username       = trim($_POST['username']);
    $password       = trim($_POST['password']);
    $confirm_pass   = trim($_POST['confirm_password']);

    // Validasi password
    if ($password !== $confirm_pass) {
        echo "<script>alert('Password tidak cocok!'); window.history.back();</script>";
        exit;
    }

    // Cek username duplikat
    $check = $connection->prepare("SELECT id FROM tbl_users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.history.back();</script>";
        $check->close();
        exit;
    }
    $check->close();

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert data
    $stmt = $connection->prepare("INSERT INTO tbl_users 
        (full_name, username, password, tempat_lahir, tanggal_lahir, alamat, no_hp, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param("sssssss", 
        $full_name, $username, $hashed, $tempat_lahir, $tanggal_lahir, $alamat, $no_hp);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Registrasi berhasil!'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menyimpan data: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../register-page.php");
    exit;
}
