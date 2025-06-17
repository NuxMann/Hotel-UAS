<?php
include "database/connection-database.php";
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
  exit;
}

$username = $_SESSION['username'];

// Ambil data user
$stmt = $connection->prepare("SELECT * FROM tbl_users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
  <div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-6">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Edit Profil</h2>

    <form action="database/Profile/validation-edit-profil.php" method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($user['tempat_lahir']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($user['tanggal_lahir']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Alamat</label>
        <textarea name="alamat" rows="2" required class="w-full px-4 py-2 border rounded-md"><?= htmlspecialchars($user['alamat']) ?></textarea>
      </div>

      <div>
        <label class="block text-gray-700">No HP</label>
        <input type="text" name="no_hp" value="<?= htmlspecialchars($user['no_hp']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Foto Profil</label>
        <input type="file" name="image" class="block w-full text-sm text-gray-500">
        <?php if (!empty($user['image'])): ?>
          <img src="../uploads/<?= $user['image'] ?>" alt="Foto Profil" class="w-24 h-24 rounded-full mt-2 object-cover">
        <?php endif; ?>
      </div>

      <div class="text-right">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</body>
</html>
