<?php
// database/Fasilitas/validation-edit-fasilitas.php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../data-fasilitas-page.php");
    exit;
}

$id            = intval($_POST['id']);
$facility_id   = trim($_POST['facility_id']);
$facility_name = trim($_POST['facility_name']);
$description   = trim($_POST['description']);
$price         = floatval($_POST['price']);

$stmt = $connection->prepare("
    UPDATE tbl_facilities
       SET facility_id   = ?,
           facility_name = ?,
           description   = ?,
           price         = ?
     WHERE id = ?
");
$stmt->bind_param("sssdi",
    $facility_id,
    $facility_name,
    $description,
    $price,
    $id
);

if ($stmt->execute()) {
    echo "<script>
            alert('✅ Fasilitas berhasil diupdate!');
            window.location.href='../../data-fasilitas-page.php';
          </script>";
} else {
    $err = htmlspecialchars($stmt->error);
    echo "<script>
            alert('❌ Gagal update fasilitas: {$err}');
            history.back();
          </script>";
}

$stmt->close();
$connection->close();
