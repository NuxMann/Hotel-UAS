<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Tambah Staff</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Form Tambah Staff</h2>

    <form action="database/Staff/validation-tambah-staff.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">

      <div class="col-span-1 md:col-span-2">
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
        <label class="block text-gray-700">Role</label>
        <select name="role" required class="w-full px-4 py-2 border rounded-md">
          <option value="">-- Pilih Role --</option>
          <option value="Admin">Admin</option>
          <option value="Receptionist">Receptionist</option>
        </select>
      </div>

      <div>
        <label class="block text-gray-700">Tempat Lahir</label>
        <input type="text" name="birth_place" required class="w-full px-4 py-2 border rounded-md" placeholder="Contoh: Bandung">
      </div>

      <div>
        <label class="block text-gray-700">Tanggal Lahir</label>
        <input type="date" name="birth_date" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div class="col-span-1 md:col-span-2">
        <label class="block text-gray-700">Alamat</label>
        <textarea name="address" required class="w-full px-4 py-2 border rounded-md" rows="3" placeholder="Alamat lengkap..."></textarea>
      </div>

      <div class="col-span-1 md:col-span-2">
        <label class="block text-gray-700">No HP</label>
        <input type="text" name="phone_number" required class="w-full px-4 py-2 border rounded-md" placeholder="Contoh: 081234567890">
      </div>

      <div class="col-span-1 md:col-span-2">
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
          Simpan Staff
        </button>
      </div>

    </form>
  </div>

</body>
</html>
