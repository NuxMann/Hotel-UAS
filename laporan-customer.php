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
<html lang="en" x-data="{ sidebarOpen: window.innerWidth > 1024 }">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Data Laporan Customer</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet" />
</head>
<body class="bg-slate-100 overflow-x-hidden font-sans">
  <div class="flex h-screen">
    <?php include 'sidebar.php'; ?>
    <div class="flex flex-col flex-1 ml-64 overflow-x-hidden">
      <?php include 'navbar.php'; ?>
      <main class="flex-1 p-6 overflow-y-auto bg-slate-200">
        <div class="w-full px-4 lg:px-8 mx-auto">
          <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-slate-700">Data Laporan Customer</h1>
            <a href="export-laporan-customer.php" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
              <i class="fas fa-file-pdf mr-2"></i>Export PDF
            </a>
          </div>
          <div class="overflow-x-auto bg-white rounded-lg shadow">
            <?php
            // ambil data dari VIEW vw_laporan_customer
            $sql    = "SELECT * FROM vw_laporan_customer";
            $result = $connection->query($sql);
            ?>
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-slate-800">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">No</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Customer ID</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Nama Customer</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Email</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Phone</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Total Reservasi</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Total Pengeluaran</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Terakhir Reservasi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                  <td class="px-4 py-2 whitespace-nowrap"><?= $no++ ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['customer_id']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['customer_name']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['email']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['phone']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['total_reservations']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap font-semibold">Rp<?= number_format($row['total_spent'], 0, ',', '.') ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['last_reservation_date'] ?: '–') ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
