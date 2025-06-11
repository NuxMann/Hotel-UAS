<?php
// database/Room Facilities/validation-edit-room-facilities.php
include "../connection-database.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ../../data-room-facilities-page.php");
  exit();
}

$rf_id       = $_POST['room_facility_id'];
$room_id     = $_POST['room_id'];
$facility_id = $_POST['facility_id'];

$stmt = $connection->prepare("
  UPDATE tbl_room_facilities
  SET room_id = ?, facility_id = ?
  WHERE room_facility_id = ?
");
$stmt->bind_param('sss', $room_id, $facility_id, $rf_id);
if (!$stmt->execute()) {
  die("Error: " . htmlspecialchars($stmt->error));
}
$stmt->close();

header("Location: ../../data-room-facilities-page.php?success=1");
exit;
