<?php 
include "database/connection-database.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link href="img/logo/logo.png" rel="icon" />
  <title>Data Kamar - NuRy HOTEL</title>

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
            <h1 class="text-2xl font-semibold text-slate-700">Data Kamar</h1>
            <a href="form-kamar.php" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
              <i class="fas fa-plus mr-2"></i>Tambah Kamar
            </a>
          </div>

          <!-- Table Container -->
          <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-slate-800">
                <tr>
                  <th class="w-8 px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">No</th>
                  <th class="w-16 px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Room ID</th>
                  <th class="w-20 px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Nomor Kamar</th>
                  <th class="w-24 px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Room Type ID</th>
                  <th class="w-24 px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Tipe</th>
                  <th class="min-w-[200px] px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Deskripsi</th>
                  <th class="w-28 px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Harga</th>
                  <th class="w-20 px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Gambar</th>
                  <th class="w-28 px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Status</th>
                  <th class="w-36 px-4 py-3 hidden md:table-cell text-left text-xs font-medium text-slate-100 uppercase">Created At</th>
                  <th class="w-36 px-4 py-3 hidden lg:table-cell text-left text-xs font-medium text-slate-100 uppercase">Updated At</th>
                  <th class="w-24 px-4 py-3 text-center text-xs font-medium text-slate-100 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php
                  $no = 1;
                  $sql = "SELECT r.id, r.room_id, r.room_number, t.room_type_id, t.type_name, r.description, r.price, r.image, r.status, r.created_at, r.updated_at
                          FROM tbl_rooms r
                          JOIN tbl_room_types t ON r.room_type_id = t.room_type_id";
                  $result = $connection->query($sql);
                  while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                  <td class="px-4 py-2 whitespace-nowrap"><?= $no++ ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['room_id']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['room_number']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['room_type_id']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['type_name']) ?></td>
                  <td class="px-4 py-2 overflow-hidden text-ellipsis whitespace-nowrap text-sm text-slate-600"><?= htmlspecialchars($row['description']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap font-semibold">Rp<?= number_format($row['price'], 0, ',', '.') ?></td>
                  <td class="px-4 py-2 whitespace-nowrap">
                    <img src="img/<?= htmlspecialchars($row['image']) ?>" class="h-16 w-20 object-cover rounded-md" alt="Room Image">
                  </td>
                  <td class="px-4 py-2 whitespace-nowrap">
                    <?php if (strtolower($row['status']) === 'available'): ?>
                      <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">Available</span>
                    <?php else: ?>
                      <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800"><?= htmlspecialchars(ucfirst($row['status'])) ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="px-4 py-2 text-sm text-slate-500 hidden md:table-cell"><?= $row['created_at'] ?></td>
                  <td class="px-4 py-2 text-sm text-slate-500 hidden lg:table-cell"><?= $row['updated_at'] ?></td>
                  <td class="px-4 py-2 text-center space-x-2 flex justify-center">
                    <a href="edit-room.php?id=<?= $row['id'] ?>" class="inline-flex items-center justify-center p-2 text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200" title="Edit">
                      <i class="fas fa-pen-to-square"></i>
                    </a>
                    <a href="database/Kamar/validation-delete-kamar.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Yakin hapus?')"
                       class="inline-flex items-center justify-center p-2 text-red-600 bg-red-100 rounded-full hover:bg-red-200" title="Delete">
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
