<?php
// edit-room-facilities.php
include "database/connection-database.php";
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

$rf_id = $_GET['rf_id'] ?? '';
if (!$rf_id) {
  die("RF ID tidak ditemukan.");
}

// ambil data relasi
$stmt = $connection->prepare("
  SELECT room_facility_id, room_id, facility_id
  FROM tbl_room_facilities
  WHERE room_facility_id = ?
");
$stmt->bind_param('s', $rf_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$data) {
  die("Relasi fasilitas–kamar tidak ditemukan.");
}

// ambil daftar kamar & fasilitas
$rooms = mysqli_query($connection, "SELECT room_id, room_number FROM tbl_rooms ORDER BY room_number");
$facilities = mysqli_query($connection, "SELECT facility_id, facility_name FROM tbl_facilities ORDER BY facility_name");
?>
<!DOCTYPE html>
<html lang="en" x-data>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Edit Fasilitas Kamar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-2xl shadow w-full max-w-md">
    <h2 class="text-2xl font-semibold mb-6 text-center">Edit Fasilitas Kamar</h2>
    <form action="database/Room Facilities/validation-edit-room-facilities.php" method="POST" class="space-y-4">
      <input type="hidden" name="room_facility_id" value="<?= htmlspecialchars($data['room_facility_id']) ?>">
      <div>
        <label class="block text-gray-700 mb-1">Pilih Kamar</label>
        <select name="room_id" required class="w-full px-4 py-2 border rounded-md bg-gray-50">
          <?php while ($r = mysqli_fetch_assoc($rooms)): ?>
            <option value="<?= htmlspecialchars($r['room_id']) ?>"
              <?= $r['room_id'] === $data['room_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($r['room_number']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div>
        <label class="block text-gray-700 mb-1">Pilih Fasilitas</label>
        <select name="facility_id" required class="w-full px-4 py-2 border rounded-md bg-gray-50">
          <?php while ($f = mysqli_fetch_assoc($facilities)): ?>
            <option value="<?= htmlspecialchars($f['facility_id']) ?>"
              <?= $f['facility_id'] === $data['facility_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($f['facility_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <button type="submit"
              class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
        Update
      </button>
    </form>
  </div>
</body>
</html>
