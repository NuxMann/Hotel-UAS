<?php
include "database/connection-database.php";

// Ambil daftar tipe kamar
$roomTypes = mysqli_query($connection, "SELECT * FROM tbl_room_types");
?>

<!DOCTYPE html>
<html lang="en" x-data="formHandler()">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Tambah Kamar</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine.js -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Notification Toast -->
  <template x-if="show">
    <div
      x-text="message"
      :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
      class="fixed top-5 right-5 text-white px-6 py-3 rounded-lg shadow-lg"
    ></div>
  </template>

  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-xl">
    <h2 class="text-3xl font-semibold text-gray-800 text-center mb-6">Form Tambah Kamar</h2>
    
    <form
      action="database/Kamar/validation-tambah-kamar.php"
      method="POST"
      enctype="multipart/form-data"
      @submit="handleSubmit($event)"
      class="space-y-5"
    >
      <div>
        <label for="roomId" class="block text-gray-700 font-medium mb-1">Room ID</label>
        <input
          x-ref="roomId"
          id="roomId"
          name="room_id"
          type="text"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <div>
        <label for="roomNumber" class="block text-gray-700 font-medium mb-1">Nomor Kamar</label>
        <input
          id="roomNumber"
          name="room_number"
          type="text"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <div>
        <label for="roomType" class="block text-gray-700 font-medium mb-1">Tipe Kamar</label>
        <select
          id="roomType"
          name="room_type_id"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
          <option value="">-- Pilih Tipe Kamar --</option>
          <?php while ($type = mysqli_fetch_assoc($roomTypes)): ?>
            <option value="<?= $type['room_type_id'] ?>"><?= htmlspecialchars($type['type_name']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div>
        <label for="description" class="block text-gray-700 font-medium mb-1">Deskripsi</label>
        <textarea
          id="description"
          name="description"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
          rows="4"
        ></textarea>
      </div>

      <div>
        <label for="price" class="block text-gray-700 font-medium mb-1">Harga per Malam</label>
        <input
          x-ref="price"
          id="price"
          name="price"
          type="number"
          step="0.01"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <div>
        <label for="image" class="block text-gray-700 font-medium mb-1">Gambar Kamar</label>
        <input
          x-ref="image"
          id="image"
          name="image"
          type="file"
          accept="image/*"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <div>
        <label for="status" class="block text-gray-700 font-medium mb-1">Status</label>
        <select
          x-ref="status"
          id="status"
          name="status"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
          <option value="Tersedia">Tersedia</option>
          <option value="Tidak Tersedia">Tidak Tersedia</option>
          <option value="Maintenance">Maintenance</option>
        </select>
      </div>

      <button
        type="submit"
        class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
      >
        Simpan Kamar
      </button>
    </form>
  </div>

  <script>
    function formHandler() {
      return {
        show: false,
        message: '',
        type: 'success',
        showNotification(msg, type = 'success') {
          this.message = msg;
          this.type = type;
          this.show = true;
          clearTimeout(this.timer);
          this.timer = setTimeout(() => this.show = false, 3000);
        },
        handleSubmit(event) {
          // Contoh validasi tambahan
          if (!this.$refs.roomId.value.trim()) {
            event.preventDefault();
            return this.showNotification('Room ID tidak boleh kosong', 'error');
          }
          if (!this.
$refs.image.files.length) {
            event.preventDefault();
            return this.showNotification('Silakan pilih gambar kamar', 'error');
          }
          // Tampilkan notifikasi loading
          this.showNotification('Menyimpan data kamar...', 'success');
          // Form akan submit secara normal
        }
      };
    }
  </script>
</body>
</html>
