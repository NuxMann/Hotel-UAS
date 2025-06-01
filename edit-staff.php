<?php
include "database/connection-database.php";

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM tbl_staff WHERE id = $id");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Staff</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Staff</h2>
    
    <form action="database/Staff/validation-edit-staff.php" method="POST" class="space-y-4">
      <input type="hidden" name="id" value="<?= $data['id'] ?>">

      <div>
        <label class="block text-gray-700">Staff ID</label>
        <input type="text" name="staff_id" value="<?= $data['staff_id'] ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="full_name" value="<?= $data['full_name'] ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Jenis Kelamin</label>
        <select name="gender" required class="w-full px-4 py-2 border rounded-md">
          <option value="L" <?= $data['gender'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
          <option value="P" <?= $data['gender'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
        </select>
      </div>

      <div>
        <label class="block text-gray-700">Jabatan</label>
        <input type="text" name="position" value="<?= $data['position'] ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">No HP</label>
        <input type="text" name="phone" value="<?= $data['phone'] ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" value="<?= $data['email'] ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Alamat</label>
        <textarea name="address" required class="w-full px-4 py-2 border rounded-md"><?= $data['address'] ?></textarea>
      </div>

      <div>
        <label class="block text-gray-700">Tempat Lahir</label>
        <input type="text" name="birth_place" value="<?= $data['birth_place'] ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Tanggal Lahir</label>
        <input type="date" name="birth_date" value="<?= $data['birth_date'] ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
        Update Staff
      </button>
    </form>
  </div>

</body>
</html>
