<?php
// data-room-facilities-page.php
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
  <title>Data Fasilitas Kamar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link sizes="64x64" href="img/logo/logo-web.png" rel="icon" />
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet" />
</head>
<body class="bg-slate-100 overflow-x-hidden">
  <div x-data="{ sidebarOpen: window.innerWidth > 1024 }" class="flex h-screen">
    <?php include 'sidebar.php'; ?>
    <div class="flex flex-col flex-1 ml-64 overflow-x-hidden">
      <?php include 'navbar.php'; ?>
      <main class="flex-1 p-6 overflow-y-auto bg-slate-200">
        <div class="w-full px-4 lg:px-8 mx-auto">
          <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-slate-700">Data Fasilitas Kamar</h1>
            <a href="form-room-facilities.php"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
              <i class="fas fa-plus mr-2"></i>Tambah Fasilitas Kamar
            </a>
          </div>

          <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-slate-800">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">No</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">RF ID</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Nomor Kamar</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Nama Fasilitas</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Total Harga</th>
                  <th class="px-4 py-3 text-center text-xs font-medium text-slate-100 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no = 1;
                $sql = "
                  SELECT
                    rf.room_facility_id,
                    r.room_number,
                    f.facility_name,
                    rf.total_price
                  FROM tbl_room_facilities rf
                  JOIN tbl_rooms    r ON rf.room_id      = r.room_id
                  JOIN tbl_facilities f ON rf.facility_id = f.facility_id
                  ORDER BY rf.id ASC
                ";
                $result = mysqli_query($connection, $sql);
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                  <td class="px-4 py-2 whitespace-nowrap"><?= $no++ ?></td>
                  <td class="px-4 py-2 whitespace-nowrap font-mono"><?= htmlspecialchars($row['room_facility_id']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['room_number']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap"><?= htmlspecialchars($row['facility_name']) ?></td>
                  <td class="px-4 py-2 whitespace-nowrap font-semibold">Rp<?= number_format($row['total_price'],0,',','.') ?></td>
                  <td class="px-4 py-2 text-center flex justify-center space-x-2">
                    <a href="edit-room-facilities.php?rf_id=<?= urlencode($row['room_facility_id']) ?>"
                       class="p-2 text-yellow-600 bg-yellow-100 rounded-full hover:bg-yellow-200"
                       title="Edit">
                      <i class="fas fa-pen-to-square"></i>
                    </a>
                    <a href="database/Room Facilities/validation-delete-room-facilities.php?rf_id=<?= urlencode($row['room_facility_id']) ?>"
                       onclick="return confirm('Yakin hapus relasi fasilitas ini?')"
                       class="p-2 text-red-600 bg-red-100 rounded-full hover:bg-red-200"
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
      <footer class="p-4 text-center text-slate-600 bg-white border-t">
        <?php include 'footer.php'; ?>
      </footer>
    </div>
  </div>
</body>
</html>
