<?php 
include "connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $connection->prepare("INSERT INTO tbl_users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Gagal registrasi: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}
?>
