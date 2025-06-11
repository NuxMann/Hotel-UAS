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
            <a href="laporan-kamar.php"   class="block px-3 py-1 rounded-lg hover:bg-slate-700 transition text-sm">Laporan Kamar</a>
          </div>
        </div>
      </nav>
    </aside>