<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Tambah Tipe Kamar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Form Tambah Tipe Kamar</h2>

    <form action="database/Tipe Kamar/validation-tambah-room-type.php" method="POST" class="space-y-4">

      <div>
        <label class="block text-gray-700 mb-1">Room Type ID</label>
        <input type="text" name="room_type_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-400" placeholder="Contoh: RT001">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Nama Tipe Kamar</label>
        <input type="text" name="type_name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-400" placeholder="Contoh: Deluxe">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Deskripsi</label>
        <textarea name="description" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-400" rows="3" placeholder="Kamar luas dengan pemandangan..."></textarea>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
        Simpan Tipe Kamar
      </button>

    </form>
  </div>

</body>
</html>
