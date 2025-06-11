<?php
// form-room-facilities.php
include "database/connection-database.php";
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

// ambil daftar kamar
$rooms = mysqli_query($connection, "
  SELECT room_id, room_number 
  FROM tbl_rooms 
  ORDER BY room_number
");

// ambil daftar fasilitas
$facilities = mysqli_query($connection, "
  SELECT facility_id, facility_name 
  FROM tbl_facilities 
  ORDER BY facility_name
");
?>
<!DOCTYPE html>
<html lang="en" x-data>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Tambah Fasilitas Kamar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-2xl shadow w-full max-w-md">
    <h2 class="text-2xl font-semibold mb-6 text-center">Tambah Fasilitas Kamar</h2>
    <form action="database/Room Facilities/validation-tambah-room-facilities.php" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700 mb-1">Pilih Kamar</label>
        <select name="room_id" required
                class="w-full px-4 py-2 border rounded-md bg-gray-50">
          <option value="">-- Pilih Kamar --</option>
          <?php while ($r = mysqli_fetch_assoc($rooms)): ?>
            <option value="<?= htmlspecialchars($r['room_id']) ?>">
              <?= htmlspecialchars($r['room_number']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div>
        <label class="block text-gray-700 mb-1">Pilih Fasilitas</label>
        <select name="facility_id" required
                class="w-full px-4 py-2 border rounded-md bg-gray-50">
          <option value="">-- Pilih Fasilitas --</option>
          <?php while ($f = mysqli_fetch_assoc($facilities)): ?>
            <option value="<?= htmlspecialchars($f['facility_id']) ?>">
              <?= htmlspecialchars($f['facility_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
        Simpan
      </button>
    </form>
  </div>
</body>
</html>
