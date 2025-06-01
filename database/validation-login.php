<?php
include "connection-database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM tbl_users WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['username'] = $username;

            // Tanpa role, arahkan ke satu dashboard umum
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "<script>alert('❌ Password salah!'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('❌ Username tidak ditemukan!'); window.history.back();</script>";
        exit();
    }

    $stmt->close();
    $connection->close();
}
?>
