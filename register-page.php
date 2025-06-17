<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register Hotel</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Form Registrasi Pengguna</h2>

    <form action="database/validation-register.php" method="POST" class="space-y-4">

      <div>
        <label class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="full_name" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700">Alamat</label>
        <textarea name="alamat" rows="2" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
      </div>

      <div>
        <label class="block text-gray-700">No HP</label>
        <input type="text" name="no_hp" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700">Ulangi Password</label>
        <input type="password" name="confirm_password" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200">
        Daftar
      </button>

      <p class="text-center text-sm text-gray-600 mt-4">
        Sudah punya akun? <a href="index.php" class="text-blue-500 hover:underline">Login di sini</a>
      </p>
    </form>
  </div>

</body>
</html>
