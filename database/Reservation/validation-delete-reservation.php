<?php
// database/Reservation/validation-delete-reservation.php

// 1. Load koneksi database
// __DIR__ mengacu ke folder database/Reservation, jadi ../connection-database.php
require_once __DIR__ . '/../connection-database.php';

session_start();

// 2. Validasi input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Kalau tidak ada atau bukan angka, redirect dengan error
    header('Location: ../../data-reservasi-page.php?error=invalid_id');
    exit;
}

$id = (int) $_GET['id'];

// 3. Eksekusi delete dengan prepared statement
if ($stmt = $connection->prepare('DELETE FROM tbl_reservations WHERE id = ?')) {
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        // Berhasil dihapus
        $stmt->close();
        header('Location: ../../data-reservasi-page.php?msg=deleted');
        exit;
    } else {
        // Gagal eksekusi
        $stmt->close();
        header('Location: ../../data-reservasi-page.php?error=delete_failed');
        exit;
    }
} else {
    // Gagal prepare statement
    header('Location: ../../data-reservasi-page.php?error=stmt_failed');
    exit;
}
