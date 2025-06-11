<?php 
// data-reservasi-page.php
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
  <title>Data Reservasi</title>
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
            <h1 class="text-2xl font-semibold text-slate-700">Data Reservasi</h1>
            <a href="transaksi.php"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
              <i class="fas fa-plus mr-2"></i>Tambah Reservasi
            </a>
          </div>
          <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-slate-800">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">No</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Reservation ID</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Customer ID</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Nama Customer</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Nomor Kamar</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Tipe</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Fasilitas</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Tanggal Reservasi</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Staff</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Check-In</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Check-Out</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Total Harga</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Status</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Updated At</th>
                  <th class="px-4 py-3 text-center text-xs font-medium text-slate-100 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no = 1;
                $sql = "
                  SELECT
                    r.id,
                    r.reservation_id,
                    r.customer_id,
                    c.full_name        AS customer_name,
                    ro.room_number,
                    rt.type_name       AS room_type_name,
                    f.facility_name    AS fasilitas,
                    r.reservation_date,
                    s.full_name        AS staff_name,
                    r.check_in_date,
                    r.check_out_date,
                    r.total_price,
                    r.status,
                    r.update_reservation_at
                  FROM tbl_reservations r
                  JOIN tbl_customers c ON r.customer_id = c.customer_id
                  JOIN tbl_rooms ro ON r.room_id = ro.room_id
                  JOIN tbl_room_types rt ON ro.room_type_id = rt.room_type_id
                  JOIN tbl_room_facilities rf ON r.room_facility_id = rf.room_facility_id
                  JOIN tbl_facilities f ON rf.facility_id = f.facility_id
                  JOIN tbl_staff s ON r.staff_id = s.staff_id
                  ORDER BY r.reservation_date ASC
                ";
                $result = $connection->query($sql);
                while ($row = $result->fetch_assoc()):
                  $upd = $row['update_reservation_at'];
                ?>
                <tr>
                  <td class="px-4 py-2 whitespace-nowrap"><?= $no++ ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['reservation_id']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['customer_id']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['customer_name']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['room_number']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['room_type_name']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['fasilitas']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['reservation_date']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['staff_name']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['check_in_date']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['check_out_date']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap font-semibold">
                    Rp<?= number_format($row['total_price'], 0, ',', '.') ?>
                  </td>
                  <td class="px-4 py-2 whitespace-nowrap uppercase">
                    <?php if (strtolower($row['status']) === 'cancelled'): ?>
                      <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800">Cancelled</span>
                    <?php else: ?>
                      <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800"><?= htmlspecialchars(ucfirst($row['status'])) ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="px-4 py-2 whitespace-nowrap">
                    <?php if ($upd): ?>
                      <?= htmlspecialchars($upd) ?>
                    <?php else: ?>
                      <span class="text-gray-400">–</span>
                    <?php endif; ?>
                  </td>
                  <td class="px-4 py-2 text-center space-x-2 flex justify-center">
                    <a href="edit-reservation.php?id=<?= $row['id'] ?>"
                       class="inline-flex items-center justify-center p-2 text-yellow-600 bg-yellow-100 rounded-full hover:bg-yellow-200"
                       title="Edit">
                      <i class="fas fa-pen-to-square"></i>
                    </a>
                    <a href="database/Reservation/validation-delete-reservation.php?id=<?= $row['id'] ?>"
                       onclick="return confirm('Yakin hapus reservasi ini?')"
                       class="inline-flex items-center justify-center p-2 text-red-600 bg-red-100 rounded-full hover:bg-red-200"
                       title="Hapus">
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
    </div>
  </div>
</body>
</html>
