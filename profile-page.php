<?php
include "database/connection-database.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

// Ambil data user berdasarkan username
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
  <title>Profil Pengguna</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans">
  <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
    <div class="text-left">
        <a href="dashboard.php" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Profil Pengguna</h2>

    <?php if ($user): ?>
      <div class="space-y-4">
        <!-- Tampilkan gambar profil -->
        <?php
        $imgPath = !empty($user['image']) ? 'uploads/' . $user['image'] : 'assets/img/default-profile.png';
        ?>
        <div class="flex justify-center mb-6">
        <img src="<?= $imgPath ?>" alt="Foto Profil"
            class="w-32 h-32 rounded-full object-cover border-4 border-blue-500 shadow">
        </div>

        <div>
          <label class="block text-sm text-gray-500">Nama Lengkap</label>
          <p class="text-lg text-gray-800 font-medium"><?= htmlspecialchars($user['full_name']) ?></p>
        </div>
        <div>
          <label class="block text-sm text-gray-500">Username</label>
          <p class="text-lg text-gray-800 font-medium"><?= htmlspecialchars($user['username']) ?></p>
        </div>
        <div>
          <label class="block text-sm text-gray-500">Tempat Lahir</label>
          <p class="text-lg text-gray-800 font-medium"><?= htmlspecialchars($user['tempat_lahir'] ?? '-') ?></p>
        </div>
        <div>
          <label class="block text-sm text-gray-500">Tanggal Lahir</label>
          <p class="text-lg text-gray-800 font-medium">
            <?= $user['tanggal_lahir'] ? date('d M Y', strtotime($user['tanggal_lahir'])) : '-' ?>
          </p>
        </div>
        <div>
          <label class="block text-sm text-gray-500">Alamat</label>
          <p class="text-lg text-gray-800 font-medium"><?= htmlspecialchars($user['alamat'] ?? '-') ?></p>
        </div>
        <div>
          <label class="block text-sm text-gray-500">No. HP</label>
          <p class="text-lg text-gray-800 font-medium"><?= htmlspecialchars($user['no_hp'] ?? '-') ?></p>
        </div>
        <div class="text-right">
          <a href="edit-profil.php" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Ubah Data</a>
        </div>
      </div>
    <?php else: ?>
      <p class="text-red-500">Data pengguna tidak ditemukan.</p>
    <?php endif; ?>
  </div>
</body>
</html>
