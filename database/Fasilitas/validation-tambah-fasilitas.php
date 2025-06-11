<?php
// database/Fasilitas/validation-tambah-fasilitas.php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../form-fasilitas.php");
    exit;
}

// Ambil & bersihkan input
$facility_id   = trim($_POST['facility_id']);
$facility_name = trim($_POST['facility_name']);
$description   = trim($_POST['description']);
$price         = isset($_POST['price']) 
                   ? floatval(str_replace(',', '', $_POST['price'])) 
                   : 0.0;

// (Optional) validasi sederhana
$errors = [];
if ($facility_id === "")   $errors[] = "Facility ID wajib diisi.";
if ($facility_name === "") $errors[] = "Nama fasilitas wajib diisi.";
if ($price <= 0)           $errors[] = "Harga harus lebih dari 0.";

if (!empty($errors)) {
    $msg = implode("\\n", $errors);
    echo "<script>alert('❌ {$msg}'); window.history.back();</script>";
    exit;
}

// Simpan ke database
$stmt = $connection->prepare("
    INSERT INTO tbl_facilities
      (facility_id, facility_name, description, price)
    VALUES (?, ?, ?, ?)
");
$stmt->bind_param("sssd", 
    $facility_id, 
    $facility_name, 
    $description, 
    $price
);

if ($stmt->execute()) {
    echo "<script>
            alert('✅ Data fasilitas berhasil ditambahkan!');
            window.location.href='../../data-fasilitas-page.php';
          </script>";
} else {
    $error = $stmt->error;
    echo "<script>
            alert('❌ Gagal menyimpan fasilitas: {$error}');
            window.history.back();
          </script>";
}

$stmt->close();
$connection->close();
?>
