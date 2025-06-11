<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Input Customer</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Form Tambah Customer</h2>

    <form action="database/Customer/validation-tambah-customer.php" method="POST" class="space-y-4">
      <!-- ID disembunyikan, biasanya untuk update. Di tambah tidak dibutuhkan -->
      <!-- Jika kamu ingin input manual ID customer, bisa aktifkan di bawah -->

      <div>
        <label class="block text-gray-700">Customer ID</label>
        <input type="text" name="customer_id" required class="w-full px-4 py-2 border rounded-md" 
               value="<?= $_GET['customer_id'] ?? '' ?>">
      </div>

      <div>
        <label class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="full_name" required class="w-full px-4 py-2 border rounded-md" 
               value="<?= $_GET['full_name'] ?? '' ?>">
      </div>

      <div>
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border rounded-md" 
               value="<?= $_GET['email'] ?? '' ?>">
      </div>

      <div>
        <label class="block text-gray-700">No HP</label>
        <input type="text" name="phone" required class="w-full px-4 py-2 border rounded-md" 
               value="<?= $_GET['phone'] ?? '' ?>">
      </div>

      <div>
        <label class="block text-gray-700">Alamat</label>
        <textarea name="address" required class="w-full px-4 py-2 border rounded-md"><?= $_GET['address'] ?? '' ?></textarea>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
        Simpan Customer
      </button>
    </form>
  </div>

</body>
</html>
