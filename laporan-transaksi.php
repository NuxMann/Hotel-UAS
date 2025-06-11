<?php 
// data-laporan-transaksi-page.php
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
  <title>Data Laporan Transaksi</title>
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
            <h1 class="text-2xl font-semibold text-slate-700">Data Laporan Transaksi</h1>
            <a href="export-laporan-transaksi.php" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
              <i class="fas fa-file-pdf mr-2"></i>Export PDF
            </a>
          </div>
          <div class="overflow-x-auto bg-white rounded-lg shadow">
            <?php
            // ambil data dari VIEW
            $sql    = "SELECT * FROM vw_laporan_transaksi";
            $result = $connection->query($sql);
            ?>
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-slate-800">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">No</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Reservation ID</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Customer</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Nomor Kamar</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Tipe Kamar</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Fasilitas</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Tanggal Reservasi</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Check-In</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Check-Out</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Total Harga</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Status</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Updated At</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()):
                  $status = strtolower($row['status']);
                ?>
                <tr>
                  <td class="px-4 py-2 whitespace-nowrap"><?= $no++ ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['reservation_id']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['customer_name']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['room_number']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['room_type']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['facility']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['reservation_date']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['check_in_date']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['check_out_date']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap font-semibold">Rp<?= number_format($row['total_price'], 0, ',', '.') ?></td>
                  <td class="px-4 py-2 whitespace-nowrap">
                    <?php if ($status === 'cancelled'): ?>
                      <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                    <?php else: ?>
                      <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800"><?= ucwords(htmlspecialchars($status)) ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['updated_at'] ?: '–') ?></td>
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
