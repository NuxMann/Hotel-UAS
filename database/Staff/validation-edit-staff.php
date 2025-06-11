<?php
include "../connection-database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil dan bersihkan data
    $id        = intval($_POST['id']);
    $staff_id  = trim($_POST['staff_id']);
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $username  = trim($_POST['username']);
    $role      = trim($_POST['role']);

    // Update data ke database
    $query = "UPDATE tbl_staff 
              SET staff_id = ?, full_name = ?, email = ?, username = ?, role = ?, updated_at = NOW() 
              WHERE id = ?";

    $stmt = $connection->prepare($query);
    $stmt->bind_param("sssssi", $staff_id, $full_name, $email, $username, $role, $id);

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
?>
