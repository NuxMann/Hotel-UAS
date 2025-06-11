<?php
// edit-fasilitas.php
include "database/connection-database.php";

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    die("ID fasilitas tidak valid.");
}

$query = $connection->prepare("SELECT * FROM tbl_facilities WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$data = $query->get_result()->fetch_assoc();
$query->close();

if (!$data) {
    die("Data fasilitas tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Fasilitas</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Fasilitas</h2>

    <form action="database/Fasilitas/validation-edit-fasilitas.php" method="POST" class="space-y-4">
      <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">

      <div>
        <label class="block text-gray-700">Facility ID</label>
        <input
          type="text"
          name="facility_id"
          value="<?= htmlspecialchars($data['facility_id']) ?>"
          required
          class="w-full px-4 py-2 border rounded-md"
        >
      </div>

      <div>
        <label class="block text-gray-700">Nama Fasilitas</label>
        <input
          type="text"
          name="facility_name"
          value="<?= htmlspecialchars($data['facility_name']) ?>"
          required
          class="w-full px-4 py-2 border rounded-md"
        >
      </div>

      <div>
        <label class="block text-gray-700">Deskripsi</label>
        <textarea
          name="description"
          required
          class="w-full px-4 py-2 border rounded-md"
          rows="3"
        ><?= htmlspecialchars($data['description']) ?></textarea>
      </div>

      <div>
        <label class="block text-gray-700">Harga (per unit)</label>
        <input
          type="number"
          name="price"
          value="<?= htmlspecialchars($data['price']) ?>"
          min="0"
          step="0.01"
          required
          class="w-full px-4 py-2 border rounded-md"
        >
      </div>

      <button
        type="submit"
        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700"
      >
        Update Fasilitas
      </button>
    </form>
  </div>

</body>
</html>
