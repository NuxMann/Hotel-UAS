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
  <meta charset="UTF-8">
  <title>Data Transaksi Reservasi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md h-screen fixed">
    <div class="p-6 font-bold text-xl text-blue-600 border-b border-gray-200">Hotel Admin</div>
    <nav class="p-4 space-y-2 text-sm">
      <a href="dashboard.php" class="block px-3 py-2 rounded hover:bg-blue-100">Dashboard</a>
      <a href="data-transaksi-page.php" class="block px-3 py-2 rounded bg-blue-100 text-blue-700 font-semibold">Transaksi Reservasi</a>
      <a href="data-kamar-page.php" class="block px-3 py-2 rounded hover:bg-blue-100">Data Kamar</a>
      <a href="logout.php" class="block px-3 py-2 rounded hover:bg-red-100 text-red-500">Logout</a>
    </nav>
  </aside>

  <!-- Main content -->
  <div class="flex-1 ml-64">
    <!-- Navbar -->
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
      <h1 class="text-xl font-bold text-gray-800">Data Transaksi Reservasi</h1>
      <a href="form-reservasi.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
        Tambah Reservasi
      </a>
    </header>

    <!-- Content -->
    <main class="p-6">
      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-blue-600 mb-4">Tabel Reservasi</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-center border border-gray-200 rounded">
            <thead class="bg-blue-100 text-gray-700 uppercase text-xs">
              <tr>
                <th class="px-3 py-2 border">NO</th>
                <th class="px-3 py-2 border">ID RESERVASI</th>
                <th class="px-3 py-2 border">ID CUSTOMER</th>
                <th class="px-3 py-2 border">ID KAMAR</th>
                <th class="px-3 py-2 border">ID STAFF</th>
                <th class="px-3 py-2 border">CHECK-IN</th>
                <th class="px-3 py-2 border">CHECK-OUT</th>
                <th class="px-3 py-2 border">TGL PESAN</th>
                <th class="px-3 py-2 border">STATUS</th>
                <th class="px-3 py-2 border">CATATAN</th>
              </tr>
            </thead>
            <tbody class="bg-white text-gray-700">
              <?php
                $no = 1;
                $result = mysqli_query($connection, "SELECT * FROM tbl_reservations ORDER BY reservation_date DESC");
                while ($row = mysqli_fetch_assoc($result)) :
              ?>
              <tr class="hover:bg-gray-50">
                <td class="px-3 py-2 border"><?= $no++ ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($row['reservation_id']) ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($row['customer_id']) ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($row['room_id']) ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($row['staff_id']) ?></td>
                <td class="px-3 py-2 border"><?= $row['check_in_date'] ?></td>
                <td class="px-3 py-2 border"><?= $row['check_out_date'] ?></td>
                <td class="px-3 py-2 border"><?= $row['reservation_date'] ?></td>
                <td class="px-3 py-2 border"><?= $row['status'] ?></td>
                <td class="px-3 py-2 border"><?= $row['notes'] ?? '-' ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
