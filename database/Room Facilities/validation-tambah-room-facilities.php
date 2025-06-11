<?php
// database/Room Facilities/validation-tambah-room-facilities.php
include "../connection-database.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ../../form-room-facilities.php");
  exit();
}

// ambil input
$room_id     = $_POST['room_id'];
$facility_id = $_POST['facility_id'];

// generate room_facility_id otomatis (RF001, RF002, …)
$res = mysqli_query($connection,
  "SELECT room_facility_id
     FROM tbl_room_facilities
     ORDER BY id DESC
     LIMIT 1"
);
$row = mysqli_fetch_assoc($res);
$lastNum = $row
  ? (int)substr($row['room_facility_id'], 2)
  : 0;
$newNum  = $lastNum + 1;
$rf_id   = 'RF' . str_pad($newNum, 3, '0', STR_PAD_LEFT);

// insert — total_price akan diisi oleh trigger
$stmt = $connection->prepare("
  INSERT INTO tbl_room_facilities
    (room_facility_id, room_id, facility_id)
  VALUES (?, ?, ?)
");
$stmt->bind_param('sss', $rf_id, $room_id, $facility_id);
if (!$stmt->execute()) {
  die("Error: " . htmlspecialchars($stmt->error));
}
$stmt->close();
header("Location: ../../data-room-facilities-page.php?success=1");
exit;
