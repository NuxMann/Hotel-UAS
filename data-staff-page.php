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
  <title>Data Staff</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link sizes="64x64" href="img/logo/logo-web.png" rel="icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet" />
</head>
<body class="bg-slate-100 overflow-x-hidden">
  <div class="flex h-screen">
    <?php include 'sidebar.php'; ?>

    <div class="flex flex-col flex-1 ml-64 overflow-x-hidden">
      <?php include 'navbar.php'; ?>

      <main class="flex-1 p-6 overflow-y-auto overflow-x-hidden bg-slate-200">
        <div class="w-full px-4 lg:px-8 mx-auto">
          <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-slate-700">Data Staff</h1>
            <a href="form-staff.php" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
              <i class="fas fa-plus mr-2"></i>Tambah Staff
            </a>
          </div>

          <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto divide-y divide-gray-200">
              <thead class="bg-slate-800">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">No</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Staff ID</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Nama</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Email</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Role</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Tempat Lahir</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Tanggal Lahir</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Alamat</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">No HP</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Created At</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-slate-100 uppercase">Updated At</th>
                  <th class="px-4 py-3 text-center text-xs font-medium text-slate-100 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $no = 1;
                $query = mysqli_query($connection, "SELECT * FROM tbl_staff ORDER BY created_at ASC");
                while ($row = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                  <td class="px-4 py-2"><?= $no++ ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($row['staff_id']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($row['full_name']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($row['email']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($row['role']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($row['birth_place']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($row['birth_date']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($row['address']) ?></td>
                  <td class="px-4 py-2"><?= htmlspecialchars($row['phone_number']) ?></td>
                  <td class="px-4 py-2"><?= $row['created_at'] ?></td>
                  <td class="px-4 py-2"><?= $row['updated_at'] ?? '-' ?></td>
                  <td class="px-4 py-2 text-center space-x-2 flex justify-center">
                    <a href="edit-staff.php?id=<?= $row['id'] ?>" class="inline-flex items-center justify-center p-2 text-yellow-600 bg-yellow-100 rounded-full hover:bg-yellow-200" title="Edit">
                      <i class="fas fa-pen-to-square"></i>
                    </a>
                    <a href="database/Staff/validation-delete-staff.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus data ini?')" class="inline-flex items-center justify-center p-2 text-red-600 bg-red-100 rounded-full hover:bg-red-200" title="Hapus">
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
