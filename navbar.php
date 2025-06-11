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
