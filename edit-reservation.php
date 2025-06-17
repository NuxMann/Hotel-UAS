<?php
// edit-reservation.php
include "database/connection-database.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// ==========================================
// POST handler: update semua field yg boleh
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id         = intval($_POST['id']);
    $roomRaw    = $_POST['room_id']      ?? '';
    $facRaw     = $_POST['facility_id']  ?? '';
    $staff_id   = $_POST['staff_id']     ?? '';
    $checkIn    = $_POST['checkin']      ?? '';
    $checkOut   = $_POST['checkout']     ?? '';
    $status     = $_POST['status']       ?? '';
    $totalPrice = floatval($_POST['total_price'] ?? 0);

    $roomId      = explode('||', $roomRaw)[0] ?? '';
    $facilityId  = explode('||', $facRaw)[0]  ?? '';

    $sql = "
      UPDATE tbl_reservations
      SET
        room_id              = ?,
        room_facility_id     = ?,
        staff_id             = ?,
        check_in_date        = ?,
        check_out_date       = ?,
        total_price          = ?,
        status               = ?,
        update_reservation_at = NOW()
      WHERE id = ?
    ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param(
      'sssssdsi',
      $roomId,
      $facilityId,
      $staff_id,
      $checkIn,
      $checkOut,
      $totalPrice,
      $status,
      $id
    );
    $stmt->execute();
    $stmt->close();

    header('Location: data-reservasi-page.php?msg=updated');
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$resQ = mysqli_query($connection,
  "SELECT r.*, ro.room_number, ro.room_type_id, rt.type_name,
          rf.room_facility_id, rf.total_price AS fac_price,
          c.customer_id, c.full_name AS customer_name
     FROM tbl_reservations r
     JOIN tbl_rooms ro ON r.room_id = ro.room_id
     JOIN tbl_room_types rt ON ro.room_type_id = rt.room_type_id
     JOIN tbl_room_facilities rf ON r.room_facility_id = rf.room_facility_id
     JOIN tbl_customers c ON r.customer_id = c.customer_id
     WHERE r.id = $id"
);
$resData = mysqli_fetch_assoc($resQ) ?: [];

$roomsQ = mysqli_query($connection,
  "SELECT r.room_id, r.room_number, rt.type_name
     FROM tbl_rooms r
     JOIN tbl_room_types rt ON r.room_type_id = rt.room_type_id
     ORDER BY r.room_number"
);
$roomsArr = [];
while ($r = mysqli_fetch_assoc($roomsQ)) {
  $roomsArr[] = $r;
}

$facQ = mysqli_query($connection,
  "SELECT rf.room_facility_id, r.room_number AS nomor_kamar,
          f.facility_name, rf.total_price
     FROM tbl_room_facilities rf
     JOIN tbl_rooms r ON rf.room_id = r.room_id
     JOIN tbl_facilities f ON rf.facility_id = f.facility_id"
);
$allFacilities = [];
while ($f = mysqli_fetch_assoc($facQ)) {
  $allFacilities[] = $f;
}

$staffQ = mysqli_query($connection, "SELECT staff_id, full_name FROM tbl_staff ORDER BY full_name");
$staffArr = [];
while ($s = mysqli_fetch_assoc($staffQ)) {
  $staffArr[] = $s;
}
?>
<!DOCTYPE html>
<html lang="en" x-data="reservationForm(
    <?php echo htmlspecialchars(json_encode($allFacilities),ENT_QUOTES); ?>,
    <?php echo htmlspecialchars(json_encode($roomsArr),ENT_QUOTES); ?>,
    <?php echo htmlspecialchars(json_encode($resData),ENT_QUOTES); ?>
)">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Reservasi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 py-10">
  <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6">
    <form action="" method="POST" class="space-y-6">
      <input type="hidden" name="id" value="<?= htmlspecialchars($resData['id']) ?>">
      <a href="data-reservasi-page.php" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">&larr; Kembali</a>
      <div>
        <label class="block text-gray-700 font-medium mb-1">Reservation ID</label>
        <input type="text" readonly value="<?= htmlspecialchars($resData['reservation_id']) ?>" class="w-full px-4 py-2 border rounded-md bg-gray-100" />
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-1">Customer</label>
        <input type="text" readonly value="<?= htmlspecialchars($resData['customer_id'] . ' | ' . $resData['customer_name']) ?>" class="w-full px-4 py-2 border rounded-md bg-gray-100" />
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-1">Pilih Kamar</label>
        <select x-model="selectedRoom" @change="onRoomChange" name="room_id" required class="w-full px-4 py-2 border rounded-md bg-white">
          <option value="">-- Pilih Kamar --</option>
          <template x-for="r in rooms" :key="r.room_id">
            <option :value="`${r.room_id}||${r.room_number}||${r.type_name}`" :selected="r.room_id === resData.room_id" x-text="`${r.room_id} | ${r.room_number} | ${r.type_name}`"></option>
          </template>
        </select>
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-1">Pilih Fasilitas Kamar</label>
        <select x-model="selectedFacility" @change="onFacilityChange" name="facility_id" x-bind:required="facilityOptions.length>0" x-bind:disabled="facilityOptions.length===0" class="w-full px-4 py-2 border rounded-md bg-white">
          <option value="">-- Pilih Fasilitas --</option>
          <template x-for="f in facilityOptions" :key="f.room_facility_id">
            <option :value="`${f.room_facility_id}||${f.total_price}`" x-text="`${f.room_facility_id} | ${f.nomor_kamar} | ${f.facility_name}`"></option>
          </template>
        </select>
        <div x-show="pricePerNight!==null" class="mt-2 text-lg font-semibold">Harga/malam: Rp<span x-text="formatNumber(pricePerNight)"></span></div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-700 font-medium mb-1">Check-In</label>
          <input type="date" name="checkin" x-model="checkin" @change="updateTotals" required class="w-full px-4 py-2 border rounded-md" />
        </div>
        <div>
          <label class="block text-gray-700 font-medium mb-1">Check-Out</label>
          <input type="date" name="checkout" x-model="checkout" @change="updateTotals" required class="w-full px-4 py-2 border rounded-md" />
        </div>
      </div>
      <div x-show="nights>0" class="text-lg font-semibold">Total kamar (<span x-text="nights"></span> malam): Rp<span x-text="formatNumber(subTotal)"></span></div>
      <div x-show="grandTotal!==null" class="text-lg font-semibold text-right">Grand Total: Rp<span x-text="formatNumber(grandTotal)"></span></div>
      <div>
        <label class="block text-gray-700 font-medium mb-1">Status</label>
        <select name="status" x-model="status" required class="w-full px-4 py-2 border rounded-md bg-white">
          <option value="Confirmed">Confirmed</option>
          <option value="Pending">Pending</option>
          <option value="Cancelled">Cancelled</option>
        </select>
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-1">Pilih Staff</label>
        <select name="staff_id" required class="w-full px-4 py-2 border rounded-md bg-white">
          <option value="">-- Pilih Staff --</option>
          <?php foreach ($staffArr as $s): ?>
            <option value="<?= $s['staff_id'] ?>" <?= ($resData['staff_id'] === $s['staff_id']) ? 'selected' : '' ?>>
              <?= $s['staff_id'] . ' | ' . $s['full_name'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <input type="hidden" name="total_price" :value="grandTotal">
      <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg">Update Reservasi</button>
    </form>
  </div>
  <script>
    function reservationForm(allFacilities, rooms, resData) {
      return {
        allFacilities,
        rooms,
        resData,
        selectedRoom: `${resData.room_id}||${resData.room_number}||${resData.type_name}`,
        facilityOptions: [],
        selectedFacility: `${resData.room_facility_id}||${resData.fac_price}`,
        pricePerNight: Number(resData.fac_price),
        checkin: resData.check_in_date,
        checkout: resData.check_out_date,
        nights: 0,
        subTotal: 0,
        grandTotal: Number(resData.fac_price),
        status: resData.status,
        onRoomChange() {
          const [,num] = this.selectedRoom.split('||');
          this.facilityOptions = this.allFacilities.filter(f => f.nomor_kamar === num);
          this.selectedFacility = '';
          this.pricePerNight = null;
          this.nights = 0;
          this.subTotal = 0;
          this.grandTotal = null;
        },
        onFacilityChange() {
          const [,price] = this.selectedFacility.split('||');
          this.pricePerNight = Number(price);
          this.updateTotals();
        },
        updateTotals() {
          if (!this.pricePerNight || !this.checkin || !this.checkout) return;
          const diff = new Date(this.checkout) - new Date(this.checkin);
          this.nights = diff > 0 ? diff / 864e5 : 0;
          this.subTotal = this.nights * this.pricePerNight;
          this.grandTotal = this.subTotal;
        },
        formatNumber(val) {
          return new Intl.NumberFormat('id-ID').format(val);
        }
      }
    }
  </script>
</body>
</html>
