<?php
include "database/connection-database.php";

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='data-room-type-page.php';</script>";
    exit;
}

// Ambil data berdasarkan ID
$query = mysqli_query($connection, "SELECT * FROM tbl_room_types WHERE id = $id");
$data = mysqli_fetch_assoc($query);
if (!$data) {
    echo "<script>alert('Data tidak ditemukan di database!'); window.location.href='data-room-type-page.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Tipe Kamar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Tipe Kamar</h2>

    <form action="database/Tipe Kamar/validation-edit-room-type.php" method="POST" class="space-y-4">
      <input type="hidden" name="id" value="<?= $data['id'] ?>">

      <div>
        <label class="block text-gray-700 mb-1">ID Tipe (Kode)</label>
        <input type="text" name="room_type_id" value="<?= htmlspecialchars($data['room_type_id']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Nama Tipe</label>
        <input type="text" name="type_name" value="<?= htmlspecialchars($data['type_name']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Deskripsi</label>
        <textarea name="description" rows="3" required class="w-full px-4 py-2 border rounded-md"><?= htmlspecialchars($data['description']) ?></textarea>
      </div>

      <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700">
        Update Tipe Kamar
      </button>
    </form>
  </div>
</body>
</html>
