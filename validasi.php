<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    $cek_user = mysqli_query($koneksi,"SELECT * FROM tbl_user WHERE email='$email'");
    $cek_login = mysqli_num_rows($cek_user);

    if ($cek_login > 0) {
        echo "<script>
            alert('Username telah terdaftar');
            window.location = 'register.php';
        </script>";
        exit;
    }else {
        if($password != $repeat_password){
            echo "<script>
            alert('konfirmasi password tidak sesuai');
            window.location = 'register.php';
            </script>";
            exit;
        }else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO user (name, email, password, repeat_password) VALUES ('$name', '$email', '$hashed_password', '$repeat_password')";
            $insert = mysqli_query($koneksi, $query);

            if ($insert) {
                echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location = 'login.php';
                </script>";
            } else {
                echo "<script>
                alert('Registrasi gagal, silakan coba lagi.');
                window.location = 'register.php';
                </script>";
            }
        }
    }
}



if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Ambil data user dari database
    $query = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        // Verifikasi password yang diinput dengan password di database
        if (password_verify($password, $data['password'])) {
            $_SESSION['user'] = $data;

            // Jika "Remember Me" dicentang, buat cookie
            if (isset($_POST['remember'])) {
                setcookie("email", $email, time() + (86400 * 30), "/"); // Cookie berlaku 30 hari
                setcookie("password", $password, time() + (86400 * 30), "/");
            } else {
                setcookie("email", "", time() - 3600, "/");
                setcookie("password", "", time() - 3600, "/");
            }


            echo "<script>
                alert('Login berhasil!');
                window.location = 'index.html';
            </script>";
        } else {
            echo "<script>
                alert('Password salah!');
                window.location = 'login.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Email tidak terdaftar!');
            window.location = 'login.php';
        </script>";
    }
}
?>