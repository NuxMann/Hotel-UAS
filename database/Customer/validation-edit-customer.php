<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id           = $_POST['id'];
    $full_name    = trim($_POST['full_name']);
    $customer_id  = trim($_POST['customer_id']); // Sesuai field database
    $email        = trim($_POST['email']);
    $phone        = trim($_POST['phone']);
    $address      = trim($_POST['address']);

    $query = "UPDATE tbl_customers 
              SET full_name = ?, customer_id = ?, email = ?, phone = ?, address = ?, updated_at = NOW() 
              WHERE id = ?";

    $stmt = $connection->prepare($query);
    $stmt->bind_param("sssssi", 
        $full_name, $customer_id, $email, $phone, $address, $id
    );

    if ($stmt->execute()) {
        echo "<script>alert('✅ Data customer berhasil diupdate!'); window.location.href='../../data-customer-page.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal mengupdate data customer!'); window.history.back();</script>";
    }

    $stmt->close();
    $connection->close();
} else {
    header("Location: ../../data-customer-page.php");
    exit;
}
