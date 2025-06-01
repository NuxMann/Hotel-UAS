<?php
$hostname = "localhost";
$user = "root";
$password = "root";
$db_name = "db_siakad";


// Membuat koneksi ke database

// Membuat koneksi ke database
$koneksi = mysqli_connect($hostname, $user, $password, $db_name);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

// echo "Koneksi Berhasil!";

// // Cek koneksi
// if (!$koneksi) {
//     die("Koneksi Gagal: " . mysqli_connect_error());
// }

// echo "Koneksi Berhasil!";
?>