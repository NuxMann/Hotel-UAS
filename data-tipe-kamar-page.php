<?php 
include "database/connection-database.php";
session_start();

if(!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/logo.png" rel="icon" />
  <title>Data Tipe Kamar</title>
  <!-- Tailwind, AlpineJS, Font Awesome, Google Fonts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet" />
</head>
<body class="bg-slate-100 overflow-x-hidden">
  <div x-data="{ sidebarOpen: window.innerWidth > 1024 }" class="flex h-screen">
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Content -->
    <div class="flex flex-col flex-1 ml-64 overflow-x-hidden">
      <!-- Navbar -->
      <?php include 'navbar.php'; ?>

      <!-- Main -->
      <main class="flex-1 p-6 overflow-y-auto overflow-x-hidden bg-slate-200">
        <div class="w-full px-4 lg:px-8 mx-auto">
          <!-- Header -->
          <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-slate-700">Data Tipe Kamar</h1>
            <a href="form-room-type.php" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
              <i class="fas fa-plus mr-2"></i>Tambah Tipe Kamar
            </a>
          </div>

          <!-- Table Container -->
          <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-slate-800">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">No</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">ID Tipe</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Nama Tipe</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Deskripsi</th>
                  <th class="px-4 py-3 text-center text-xs font-medium text-slate-100 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no = 1;
                $result = mysqli_query($connection, "SELECT * FROM tbl_room_types ORDER BY id ASC");
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                  <td class="px-4 py-2 whitespace-nowrap"><?= $no++ ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['room_type_id']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['type_name']) ?></td>
                  <td class="px-4 py-2 overflow-hidden text-ellipsis whitespace-nowrap text-sm text-slate-600"><?= htmlspecialchars($row['description']) ?></td>
                  <td class="px-4 py-2 text-center space-x-2 flex justify-center">
                    <a href="edit-room-type.php?id=<?= $row['id'] ?>" class="inline-flex items-center justify-center p-2 text-yellow-600 bg-yellow-100 rounded-full hover:bg-yellow-200" title="Edit">
                      <i class="fas fa-pen-to-square"></i>
                    </a>
                    <a href="database/Tipe Kamar/validation-delete-room-type.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Yakin hapus tipe kamar ini?')"
                       class="inline-flex items-center justify-center p-2 text-red-600 bg-red-100 rounded-full hover:bg-red-200" title="Hapus">
                      <i class="fas fa-trash-can"></i>
                    </a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </main>

      <!-- Footer -->
      <footer class="p-4 text-center text-slate-600 bg-white border-t">
        <?php include 'footer.php'; ?>
      </footer>
    </div>
  </div>
</body>
</html>
