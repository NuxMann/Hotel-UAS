<?php
include "database/connection-database.php";

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM tbl_rooms WHERE id = $id");
$data = mysqli_fetch_assoc($query);

// Ambil semua tipe kamar
$roomTypes = mysqli_query($connection, "SELECT * FROM tbl_room_types");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Kamar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Kamar</h2>
    
    <form action="database/Kamar/validation-edit-kamar.php" method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="hidden" name="id" value="<?= $data['id'] ?>">

      <div>
        <label class="block text-gray-700">Room Id</label>
        <input type="text" name="room_id" value="<?= $data['room_id'] ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Nomor Kamar</label>
        <input type="text" name="room_number" value="<?= $data['room_number'] ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Tipe Kamar</label>
        <select name="room_type_id" required class="w-full px-4 py-2 border rounded-md">
          <?php while ($type = mysqli_fetch_assoc($roomTypes)) : ?>
            <option value="<?= $type['room_type_id'] ?>" <?= $type['room_type_id'] === $data['room_type_id'] ? 'selected' : '' ?>>
              <?= $type['type_name'] ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div>
        <label class="block text-gray-700">Deskripsi</label>
        <textarea name="description" required class="w-full px-4 py-2 border rounded-md"><?= $data['description'] ?></textarea>
      </div>

      <div>
        <label class="block text-gray-700">Harga per Malam</label>
        <input type="number" name="price" value="<?= $data['price'] ?>" step="0.01" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Gambar Kamar (kosongkan jika tidak diganti)</label>
        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-md">
        <p class="text-sm mt-1">Gambar saat ini: <strong><?= $data['image'] ?></strong></p>
      </div>

      <div>
        <label class="block text-gray-700">Status</label>
        <select name="status" required class="w-full px-4 py-2 border rounded-md">
          <option value="Tersedia" <?= $data['status'] === 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
          <option value="Tidak Tersedia" <?= $data['status'] === 'Tidak Tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
          <option value="Maintenance" <?= $data['status'] === 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
        </select>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
        Update Kamar
      </button>
    </form>
  </div>

</body>
</html>
