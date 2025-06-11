<?php
include "database/connection-database.php";

$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM tbl_customers WHERE id = $id");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Customer</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Customer</h2>

    <form action="database/Customer/validation-edit-customer.php" method="POST" class="space-y-4">
      <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">

      <div>
        <label class="block text-gray-700">Customer ID</label>
        <input type="text" name="customer_id" value="<?= htmlspecialchars($data['customer_id']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($data['full_name']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">No HP</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($data['phone']) ?>" required class="w-full px-4 py-2 border rounded-md">
      </div>

      <div>
        <label class="block text-gray-700">Alamat</label>
        <textarea name="address" required class="w-full px-4 py-2 border rounded-md"><?= htmlspecialchars($data['address']) ?></textarea>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
        Update Customer
      </button>
    </form>
  </div>

</body>
</html>
