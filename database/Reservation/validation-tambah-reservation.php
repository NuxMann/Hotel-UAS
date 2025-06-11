<?php
// database/Reservation/validation-tambah-reservation.php
include "../connection-database.php";
session_start();

// 1) Pastikan method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../transaksi.php');
    exit;
}

// 2) Ambil data dari form
// Customer
$customer_id = $_POST['customer_id'];

// Room ID bisa saja dikirim dalam format "ROOM003||003"
if (isset($_POST['room_id']) && strpos($_POST['room_id'], '||') !== false) {
    list($room_id, $dummyRoom) = explode('||', $_POST['room_id']);
} else {
    $room_id = $_POST['room_id'];
}

// Facility ID dalam format "RF001||harga"
if (isset($_POST['facility_id']) && strpos($_POST['facility_id'], '||') !== false) {
    list($facility_id, $dummyPrice) = explode('||', $_POST['facility_id']);
} else {
    $facility_id = $_POST['facility_id'] ?? '';
}

// Tanggal checkin/checkout & total price
$check_in    = $_POST['checkin'];
$check_out   = $_POST['checkout'];
$total_price = (float) $_POST['total_price'];

// 3) Ambil staff_id berdasar username session
$stmt = $connection->prepare("SELECT staff_id FROM tbl_staff WHERE username = ?");
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($staff_id);
$stmt->fetch();
$stmt->close();

// 4) Generate reservation_id unik per bulan
date_default_timezone_set('Asia/Jakarta');
$month = date('m');
$year2 = date('y');
$sqlCount = "
  SELECT COUNT(*)
  FROM tbl_reservations
  WHERE MONTH(reservation_date) = MONTH(CURDATE())
    AND YEAR(reservation_date) = YEAR(CURDATE())
";
$count = $connection->query($sqlCount)->fetch_row()[0];
$seq = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
$reservation_id = "RSV{$month}{$year2}{$seq}";

// 5) Status default
$status = 'Confirmed';

// 6) Simpan ke tbl_reservations
$insertSql = "
  INSERT INTO tbl_reservations
    (reservation_id,
     customer_id,
     room_id,
     room_facility_id,
     staff_id,
     check_in_date,
     check_out_date,
     reservation_date,
     status,
     total_price
    )
  VALUES
    (?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)
";

$stmt = $connection->prepare($insertSql);
if (!$stmt) {
    die("Prepare statement failed: " . $connection->error);
}

// 7×s + 1×d (double)
$stmt->bind_param(
    'ssssssssd',
    $reservation_id,
    $customer_id,
    $room_id,
    $facility_id,
    $staff_id,
    $check_in,
    $check_out,
    $status,
    $total_price
);

if (!$stmt->execute()) {
    die("Gagal simpan reservasi: " . $stmt->error);
}
$stmt->close();

// 7) Redirect kembali ke list reservasi
header('Location: ../../data-reservasi-page.php?success=1');
exit;
