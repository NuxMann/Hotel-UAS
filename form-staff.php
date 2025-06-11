<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Tambah Staff</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Form Tambah Staff</h2>

    <form action="database/Staff/validation-tambah-staff.php" method="POST" class="space-y-4">

      <div>
        <label class="block text-gray-700">Staff ID</label>
        <input type="text" name="staff_id" required class="w-full px-4 py-2 border rounded-md" placeholder="STF001">
      </div>

      <div>
        <label class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="full_name" required class="w-full px-4 py-2 border rounded-md" placeholder="Nama Lengkap">
      </div>

      <div>
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border rounded-md" placeholder="email@domain.com">
      </div>

      <div>
        <label class="block text-gray-700">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-2 border rounded-md" placeholder="username login">
      </div>

      <div>
        <label class="block text-gray-700">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border rounded-md" placeholder="Password">
      </div>

      <div>
        <label class="block text-gray-700">Role</label>
        <select name="role" required class="w-full px-4 py-2 border rounded-md">
          <option value="">-- Pilih Role --</option>
          <option value="Admin">Admin</option>
          <option value="Receptionist">Receptionist</option>
        </select>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
        Simpan Staff
      </button>

    </form>
  </div>

</body>
</html>
