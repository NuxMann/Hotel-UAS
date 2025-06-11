<?php
// edit-reservation.php
include "database/connection-database.php";
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}

// ======== HANDLER UPDATE SEMUA FIELD ========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // 1) Tangkap semua input
    $id          = intval($_POST['id']);
    $roomRaw     = $_POST['room_id']      ?? '';
    $facRaw      = $_POST['facility_id']  ?? '';
    $checkIn     = $_POST['checkin']      ?? '';
    $checkOut    = $_POST['checkout']     ?? '';
    $status      = $_POST['status']       ?? '';
    $totalPrice  = floatval($_POST['total_price'] ?? 0);

    // 2) Pecah ID untuk room & facility
    $roomId      = explode('||', $roomRaw)[0] ?? '';
    $facId       = explode('||', $facRaw)[0]  ?? '';

    // 3) Prepared statement untuk UPDATE
    $sql = "
      UPDATE tbl_reservations
      SET
        room_id           = ?,
        room_facility_id  = ?,
        check_in_date     = ?,
        check_out_date    = ?,
        total_price       = ?,
        status            = ?,
        update_reservation_at = NOW()
      WHERE id = ?
    ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param(
      'ssssdsi',
      $roomId,
      $facId,
      $checkIn,
      $checkOut,
      $totalPrice,
      $status,
      $id
    );
    $stmt->execute();
    $stmt->close();

    // 4) Redirect kembali ke list
    header('Location: data-reservasi-page.php?msg=updated');
    exit;
}
// ======== END HANDLER ========


// … sisanya tetap seperti biasa, ambil GET[id], render form, dll …


?>
