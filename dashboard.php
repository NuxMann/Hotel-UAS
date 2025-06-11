<?php
include "database/connection-database.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION['username'];

// Ambil data dari database
$countRooms = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM tbl_rooms"))['total'];
$countRoomFacilities = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM tbl_room_facilities"))['total'];
$countCustomers = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM tbl_customers"))['total'];
$countReservations = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM tbl_reservations"))['total'];

// Ambil data sebelumnya dari session
$prevCounts = $_SESSION['prevCounts'] ?? [
  'rooms'        => $countRooms,
  'facilities'   => $countRoomFacilities,
  'customers'    => $countCustomers,
  'reservations' => $countReservations
];

// Fungsi deteksi perubahan
function detectChange($current, $previous) {
  return [
    'changed'     => $current !== $previous,
    'increased'   => $current > $previous,
    'decreased'   => $current < $previous,
    'difference'  => $current - $previous
  ];
}

// Hitung perubahan untuk masing-masing data
$roomChange        = detectChange($countRooms, $prevCounts['rooms']);
$facilityChange    = detectChange($countRoomFacilities, $prevCounts['facilities']);
$customerChange    = detectChange($countCustomers, $prevCounts['customers']);
$reservationChange = detectChange($countReservations, $prevCounts['reservations']);

// Simpan ulang ke session
$_SESSION['prevCounts'] = [
  'rooms'        => $countRooms,
  'facilities'   => $countRoomFacilities,
  'customers'    => $countCustomers,
  'reservations' => $countReservations
];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link href="img/logo/logo.png" rel="icon" />
  <title>Reservasi Hotel</title>

  <!-- Tailwind, AlpineJS, Font Awesome, Google Fonts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <style>
    body { font-family: 'Nunito', sans-serif; }
    [x-cloak] { display: none !important; }
    .marquee-container { overflow: hidden; white-space: nowrap; }
    .marquee-text { display: inline-block; animation: marquee 15s linear infinite; padding-left: 100%; }
    @keyframes marquee { 0% { transform: translateX(0%); } 100% { transform: translateX(-100%); } }
  </style>
</head>
<body class="bg-slate-100">
  <div x-data="{ sidebarOpen: window.innerWidth > 1024 }" class="flex h-screen">
    <aside
      class="fixed inset-y-0 left-0 z-30 w-64 px-4 py-6 overflow-y-auto bg-slate-900 text-slate-100"
    >
      <!-- Brand -->
      <a href="dashboard.php" class="flex items-center space-x-2 mb-8 px-3">
        <img src="img/logo/logo-web.png" alt="NuRy HOTEL" class="h-20 w-30">
        <span class="text-xl font-bold">
          <span class="text-slate-400 font-medium">Green</span>
        </span>
      </a>
      <!-- Nav items -->
      <nav class="space-y-2">
        <a href="dashboard.php"
           class="flex items-center px-3 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 transition">
          <i class="fas fa-clock w-5"></i><span class="ml-3">Dashboard</span>
        </a>
        <p class="mt-6 mb-1 px-3 text-xs text-slate-500 uppercase">Data Master</p>
        <div x-data="{ open: false }" class="px-2">
          <button @click="open = !open"
                  class="flex items-center justify-between w-full px-3 py-2 rounded-lg hover:bg-slate-700 transition">
            <div class="flex items-center">
              <i class="fas fa-hotel w-5"></i>
              <span class="ml-3">Data Master Hotel</span>
            </div>
            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open }"></i>
          </button>
          <div x-show="open" x-collapse class="mt-1 space-y-1 ml-6">
            <a href="data-kamar-page.php"       class="block px-3 py-1 rounded-lg hover:bg-slate-700 transition text-sm">Kamar</a>
            <a href="data-tipe-kamar-page.php"       class="block px-3 py-1 rounded-lg hover:bg-slate-700 transition text-sm">Tipe Kamar</a>
            <a href="data-fasilitas-page.php"   class="block px-3 py-1 rounded-lg hover:bg-slate-700 transition text-sm">Fasilitas</a>
            <a href="data-room-facilities-page.php"   class="block px-3 py-1 rounded-lg hover:bg-slate-700 transition text-sm">Fasilitas Kamar</a>
          </div>
        </div>
        <!-- Data Staff -->
         <a href="data-staff-page.php"
           class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-700 transition">
          <i class="fas fa-credit-card w-5"></i><span class="ml-3">Staff</span>
        </a>
        <!-- Staff -->
        <!-- Data Customer -->
         <a href="data-customer-page.php"
           class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-700 transition">
          <i class="fas fa-credit-card w-5"></i><span class="ml-3">Customer</span>
        </a>
        <!-- Customer -->
        <p class="mt-6 mb-1 px-3 text-xs text-slate-500 uppercase">Data Transaksi</p>
        <a href="transaksi.php"
           class="flex items-center px-3 py-2 rounded-lg hover:bg-slate-700 transition">
          <i class="fas fa-credit-card w-5"></i><span class="ml-3">Transaksi</span>
        </a>
        <p class="mt-6 mb-1 px-3 text-xs text-slate-500 uppercase">Data Laporan</p>
        <div x-data="{ open: false }" class="px-2">
          <button @click="open = !open"
                  class="flex items-center justify-between w-full px-3 py-2 rounded-lg hover:bg-slate-700 transition">
            <div class="flex items-center">
              <i class="fas fa-hotel w-5"></i>
              <span class="ml-3">Data Laporan</span>
            </div>
            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open }"></i>
          </button>
          <div x-show="open" x-collapse class="mt-1 space-y-1 ml-6">
            <a href="laporan-transaksi.php"       class="block px-3 py-1 rounded-lg hover:bg-slate-700 transition text-sm">Laporan Transaksi</a>
            <a href="laporan-customer.php"       class="block px-3 py-1 rounded-lg hover:bg-slate-700 transition text-sm">Laporan Customer</a>
            <ar href="laporan-kamar.php"   class="block px-3 py-1 rounded-lg hover:bg-slate-700 transition text-sm">Laporan Kamar</ar>
          </div>
        </div>
      </nav>
    </aside>


    <div class="flex flex-col flex-1 ml-64">
      <header class="flex items-center justify-between p-4 bg-white shadow-md">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 lg:hidden">
          <i class="fas fa-bars w-6 h-6"></i>
        </button>
        <div class="flex-1"></div>
        <div class="flex items-center space-x-4">
          <span class="font-semibold text-slate-700 capitalize">
            Halo, <?= htmlspecialchars($username) ?>
          </span>
          <a href="database/validation-logout.php"
             class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
            Logout
          </a>
        </div>
      </header>

      <!-- MAIN CONTENT-->
       
      <main class="flex-1 p-6 overflow-y-auto bg-slate-200">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

    <!-- Data Kamar -->
    <div class="relative overflow-hidden bg-white rounded-xl shadow-lg p-5">
      <div class="absolute top-0 left-0 w-2 h-full bg-blue-500"></div>
      <i class="fas fa-bed absolute bottom-4 right-4 text-7xl text-slate-100 -rotate-12"></i>
      <p class="mb-2 text-sm font-bold text-blue-500 uppercase">Data Kamar</p>
      <p class="text-4xl font-extrabold text-slate-800"><?= $countRooms ?></p>
      <?php if ($roomChange['changed']): ?>
        <div class="mt-2 text-xs px-2 py-1 rounded-md overflow-hidden marquee-container 
                    <?= $roomChange['increased'] ? 'bg-green-100 text-green-600' : ($roomChange['decreased'] ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') ?>">
          <span class="marquee-text">
            <?= $roomChange['increased'] ? "Ada {$roomChange['difference']} kamar baru ditambahkan!" :
                ($roomChange['decreased'] ? "Ada " . abs($roomChange['difference']) . " kamar dihapus!" : "Data kamar diperbarui!") ?>
          </span>
        </div>
      <?php endif; ?>
    </div>

    <!-- Data Fasilitas Kamar -->
    <div class="relative overflow-hidden bg-white rounded-xl shadow-lg p-5">
      <div class="absolute top-0 left-0 w-2 h-full bg-green-500"></div>
      <i class="fas fa-signal absolute bottom-4 right-4 text-7xl text-slate-100 -rotate-12"></i>
      <p class="mb-2 text-sm font-bold text-green-500 uppercase">Data Fasilitas Kamar</p>
      <p class="text-4xl font-extrabold text-slate-800"><?= $countRoomFacilities ?></p>
      <?php if ($facilityChange['changed']): ?>
        <div class="mt-2 text-xs px-2 py-1 rounded-md overflow-hidden marquee-container 
                    <?= $facilityChange['increased'] ? 'bg-green-100 text-green-600' : ($facilityChange['decreased'] ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') ?>">
          <span class="marquee-text">
            <?= $facilityChange['increased'] ? "Ada {$facilityChange['difference']} fasilitas baru!" :
                ($facilityChange['decreased'] ? "Ada " . abs($facilityChange['difference']) . " fasilitas dihapus!" : "Data fasilitas diperbarui!") ?>
          </span>
        </div>
      <?php endif; ?>
    </div>

    <!-- Data Customer -->
    <div class="relative overflow-hidden bg-white rounded-xl shadow-lg p-5">
      <div class="absolute top-0 left-0 w-2 h-full bg-teal-500"></div>
      <i class="fas fa-user-friends absolute bottom-4 right-4 text-7xl text-slate-100 -rotate-12"></i>
      <p class="mb-2 text-sm font-bold text-teal-500 uppercase">Data Customer</p>
      <p class="text-4xl font-extrabold text-slate-800"><?= $countCustomers ?></p>
      <?php if ($customerChange['changed']): ?>
        <div class="mt-2 text-xs px-2 py-1 rounded-md overflow-hidden marquee-container 
                    <?= $customerChange['increased'] ? 'bg-green-100 text-green-600' : ($customerChange['decreased'] ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') ?>">
          <span class="marquee-text">
            <?= $customerChange['increased'] ? "Ada {$customerChange['difference']} customer baru!" :
                ($customerChange['decreased'] ? "Ada " . abs($customerChange['difference']) . " customer dihapus!" : "Data customer diperbarui!") ?>
          </span>
        </div>
      <?php endif; ?>
    </div>

    <!-- Data Reservasi -->
    <div class="relative overflow-hidden bg-white rounded-xl shadow-lg p-5">
      <div class="absolute top-0 left-0 w-2 h-full bg-amber-500"></div>
      <i class="fas fa-calendar-check absolute bottom-4 right-4 text-7xl text-slate-100 -rotate-12"></i>
      <p class="mb-2 text-sm font-bold text-amber-500 uppercase">Reservasi</p>
      <p class="text-4xl font-extrabold text-slate-800"><?= $countReservations ?></p>
      <?php if ($reservationChange['changed']): ?>
        <div class="mt-2 text-xs px-2 py-1 rounded-md overflow-hidden marquee-container 
                    <?= $reservationChange['increased'] ? 'bg-green-100 text-green-600' : ($reservationChange['decreased'] ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') ?>">
          <span class="marquee-text">
            <?= $reservationChange['increased'] ? "Ada {$reservationChange['difference']} reservasi baru!" :
                ($reservationChange['decreased'] ? "Ada " . abs($reservationChange['difference']) . " reservasi dibatalkan!" : "Data reservasi diperbarui!") ?>
          </span>
        </div>
      <?php endif; ?>
    </div>

  
</main>



      <!-- FOOTER -->
      <footer class="p-4 mt-auto text-center text-slate-600 bg-white border-t">
        <?php include 'footer.php'; ?>
      </footer>
    </div>
  </div>
</body>
</html>
