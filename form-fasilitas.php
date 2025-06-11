<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Tambah Fasilitas</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Form Tambah Fasilitas</h2>
    
    <form action="database/Fasilitas/validation-tambah-fasilitas.php"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-4">

      <!-- Facility ID -->
      <div>
        <label class="block text-gray-700">Facility ID</label>
        <input type="text"
               name="facility_id"
               required
               class="w-full px-4 py-2 border rounded-md"
               placeholder="Contoh: FAC005">
      </div>

      <!-- Nama Fasilitas -->
      <div>
        <label class="block text-gray-700">Nama Fasilitas</label>
        <input type="text"
               name="facility_name"
               required
               class="w-full px-4 py-2 border rounded-md"
               placeholder="Contoh: Wifi Gratis">
      </div>

      <!-- Harga -->
      <div>
        <label class="block text-gray-700">Harga (per unit)</label>
        <div class="flex">
          <span class="inline-flex items-center px-3 bg-gray-200 border border-r-0 rounded-l-md text-gray-600">Rp</span>
          <input type="number"
                 name="price"
                 required
                 min="0"
                 step="0.01"
                 class="w-full px-4 py-2 border rounded-r-md focus:outline-none"
                 placeholder="100000.00">
        </div>
      </div>

      <!-- Deskripsi -->
      <div>
        <label class="block text-gray-700">Deskripsi</label>
        <textarea name="description"
                  required
                  class="w-full px-4 py-2 border rounded-md"
                  placeholder="Keterangan singkat"></textarea>
      </div>

      <!-- Submit -->
      <button type="submit"
              class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700">
        Simpan Fasilitas
      </button>

    </form>
  </div>

</body>
</html>
