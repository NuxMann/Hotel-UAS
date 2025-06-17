<header class="flex items-center justify-between p-4 bg-white shadow-md">
  <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 lg:hidden">
    <i class="fas fa-bars w-6 h-6"></i>
  </button>
  <div class="flex-1"></div>

  <div class="relative mr-5" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 focus:outline-none">
      <span class="font-semibold text-slate-700 capitalize">
        Halo, <?= htmlspecialchars($username) ?>
      </span>
      <!-- <i class="fas fa-chevron-down w-3 h-3 text-slate-500"></i> -->
    </button>

    <div x-show="open" x-transition class="absolute right-0 w-48 mt-2 py-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">
      <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="profile-page.php">
        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
        Profile
      </a>
      <!-- <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="#">
        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
        Settings
      </a>
      <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="#">
        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
        Activity Log
      </a> -->
      <div class="border-t border-gray-100"></div>
      <!-- <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="database/validation-logout.php">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Logout
      </a> -->
    </div>
  </div>
  <a href="database/validation-logout.php"
     class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
    Logout
  </a>
  </header>