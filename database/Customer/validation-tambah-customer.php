<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $full_name   = trim($_POST['full_name']);
    $identity_no = trim($_POST['identity_no']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $address     = trim($_POST['address']);

    // Simpan ke database
    $stmt = $connection->prepare("INSERT INTO tbl_customers 
        (full_name, identity_no, email, phone, address, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param("sssss", $full_name, $identity_no, $email, $phone, $address);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Data customer berhasil disimpan!'); window.location.href='../../data-customer-page.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menyimpan data customer: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../../form-customer.php");
    exit;
}
?>
