<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Input Kamar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Form Tambah Kamar</h2>
    
    <form action="database/Kamar/validation-tambah-kamar.php" method="POST" enctype="multipart/form-data" class="space-y-4">

      <div>
        <label class="block text-gray-700">Tipe Kamar</label>
        <input type="text" name="room_type" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Deskripsi</label>
        <textarea name="description" required class="w-full px-4 py-2 border rounded-md"></textarea>
      </div>

      <div>
        <label class="block text-gray-700">Kapasitas (orang)</label>
        <input type="number" name="capacity" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Harga per Malam</label>
        <input type="number" name="price" step="0.01" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Gambar Kamar</label>
        <input type="file" name="image" accept="image/*" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Status</label>
        <select name="status" required class="w-full px-4 py-2 border rounded-md">
          <option value="active">Aktif</option>
          <option value="inactive">Tidak Aktif</option>
        </select>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
        Simpan Kamar
      </button>

    </form>
  </div>

</body>
</html>
