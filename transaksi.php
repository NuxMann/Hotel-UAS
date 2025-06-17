<?php
// transaksi-reservasi.php
include "database/connection-database.php";
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit;
}
$username = $_SESSION['username'];

// Ambil data master
$rooms = mysqli_query($connection, "
  SELECT r.room_id, r.room_number, t.type_name
  FROM tbl_rooms r
  JOIN tbl_room_types t ON r.room_type_id = t.room_type_id
  WHERE r.status = 'Tersedia'
  ORDER BY r.room_number
");
$customers = mysqli_query($connection, "
  SELECT customer_id, full_name
  FROM tbl_customers
  ORDER BY full_name
");
// Staff
$staffs = mysqli_query($connection, "
  SELECT staff_id, full_name FROM tbl_staff ORDER BY full_name
");

// Ambil data fasilitas
$facRes = mysqli_query($connection, "
  SELECT
    trf.room_facility_id AS rf_id,
    r.room_number         AS nomor_kamar,
    f.facility_name       AS nama_fasilitas,
    trf.total_price       AS total_harga
  FROM tbl_room_facilities trf
  JOIN tbl_rooms      r ON trf.room_id     = r.room_id
  JOIN tbl_facilities f ON trf.facility_id = f.facility_id
");
$allFacilities = [];
while ($f = mysqli_fetch_assoc($facRes)) {
  $allFacilities[] = $f;
}
?>
<!DOCTYPE html>
<html lang="en"
      x-data='reservationForm(<?php echo htmlspecialchars(json_encode($allFacilities), ENT_QUOTES, "UTF-8"); ?>)'>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Transaksi Reservasi</title>
 <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link sizes="64x64" href="img/logo/logo-web.png" rel="icon" />
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet" />
</head>
<body class="bg-slate-100 overflow-x-hidden font-sans">
  <div class="flex h-screen">
    <?php include 'sidebar.php'; ?>
    <div class="flex-1 flex flex-col ml-64">
      <?php include 'navbar.php'; ?>
      <main class="flex-1 p-6 bg-slate-200 overflow-y-auto">
        <a href="data-reservasi-page.php"
           class="mb-4 inline-block px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
          Lihat Reservasi
        </a>
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow p-6">
          <h2 class="text-2xl font-semibold text-slate-700 mb-6">Form Transaksi Reservasi</h2>
          <form action="database/Reservation/validation-tambah-reservation.php"
                method="POST" class="space-y-6">

            <!-- Pilih Customer -->
            <div>
              <label class="block text-gray-700 font-medium mb-1">Pilih Customer</label>
              <select name="customer_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Pilih Customer --</option>
                <?php while ($c = mysqli_fetch_assoc($customers)): ?>
                  <option value="<?= htmlspecialchars($c['customer_id']); ?>">
                    <?= htmlspecialchars("{$c['customer_id']} | {$c['full_name']}"); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <!-- Pilih Staff -->
            <div>
              <label class="block text-gray-700 font-medium mb-1">Pilih Staff</label>
              <select name="staff_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Pilih Staff --</option>
                <?php while ($s = mysqli_fetch_assoc($staffs)): ?>
                  <option value="<?= htmlspecialchars($s['staff_id']) ?>">
                    <?= htmlspecialchars($s['staff_id'] . ' | ' . $s['full_name']) ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>


            <!-- Pilih Kamar -->
            <div>
              <label class="block text-gray-700 font-medium mb-1">Pilih Kamar</label>
              <select x-model="selectedRoom" @change="onRoomChange"
                      name="room_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Pilih Kamar --</option>
                <?php while ($r = mysqli_fetch_assoc($rooms)): 
                  $val = $r['room_id'].'||'.$r['room_number'];
                ?>
                  <option value="<?= htmlspecialchars($val); ?>">
                    <?= htmlspecialchars("{$r['room_id']} | {$r['room_number']} | {$r['type_name']}"); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <!-- Pilih Fasilitas Kamar -->
            <div x-show="facilityOptions.length" class="mt-4">
              <label class="block text-gray-700 font-medium mb-1">Pilih Fasilitas Kamar</label>
              <select x-model="selectedFacility" @change="onFacilityChange"
                      name="facility_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Pilih Fasilitas --</option>
                <template x-for="opt in facilityOptions" :key="opt.rf_id">
                  <option :value="opt.rf_id+'||'+opt.total_harga">
                    <span x-text="opt.rf_id + ' | ' + opt.nomor_kamar + ' | ' + opt.nama_fasilitas"></span>
                  </option>
                </template>
              </select>
              <!-- Harga per malam -->
              <div x-show="pricePerNight !== null" class="mt-2 text-lg font-semibold text-slate-700">
                Harga/malam: Rp<span x-text="formatNumber(pricePerNight)"></span>
              </div>
            </div>

            <!-- Pilih Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-700 font-medium mb-1">Check-In</label>
                <input type="date" name="checkin" x-model="checkin" @change="updateTotals"
                       required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-2 focus:ring-indigo-500" />
              </div>
              <div>
                <label class="block text-gray-700 font-medium mb-1">Check-Out</label>
                <input type="date" name="checkout" x-model="checkout" @change="updateTotals"
                       required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-2 focus:ring-indigo-500" />
              </div>
            </div>

            <!-- Rincian & Kalkulasi -->
            <div x-show="nights > 0" class="text-lg font-semibold text-slate-700">
              Total kamar (<span x-text="nights"></span> malam): Rp<span x-text="formatNumber(subTotal)"></span>
            </div>
            <div x-show="grandTotal !== null" class="text-lg font-semibold text-slate-700 text-right">
              Grand Total: Rp<span x-text="formatNumber(grandTotal)"></span>
            </div>

            <!-- Hidden fields -->
            <input type="hidden" name="nights" :value="nights" />
            <input type="hidden" name="price_per_night" :value="pricePerNight" />
            <input type="hidden" name="total_price" :value="grandTotal" />

            <!-- Submit -->
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg shadow-md focus:ring-2 focus:ring-indigo-500">
              Simpan Reservasi
            </button>

          </form>
        </div>
      </main>
    </div>
  </div>
  <script>
    function reservationForm(allFacilities) {
      return {
        allFacilities,
        selectedRoom: '',
        facilityOptions: [],
        selectedFacility: '',
        pricePerNight: null,
        checkin: null,
        checkout: null,
        nights: 0,
        subTotal: 0,
        grandTotal: null,
        onRoomChange() {
          let [roomId, roomNum] = this.selectedRoom.split('||');
          this.facilityOptions = this.allFacilities.filter(f => f.nomor_kamar === roomNum);
          this.selectedFacility = '';
          this.pricePerNight   = null;
          this.nights          = 0;
          this.subTotal        = 0;
          this.grandTotal      = null;
        },
        onFacilityChange() {
          let [rfId, harga] = this.selectedFacility.split('||');
          this.pricePerNight = Number(harga);
          this.updateTotals();
        },
        updateTotals() {
          if (this.pricePerNight && this.checkin && this.checkout) {
            let diff = new Date(this.checkout) - new Date(this.checkin);
            this.nights    = diff > 0 ? diff/(1000*60*60*24) : 0;
            this.subTotal  = this.nights * this.pricePerNight;
            this.grandTotal = this.subTotal;
          } else {
            this.grandTotal = null;
          }
        },
        formatNumber(val) {
          return new Intl.NumberFormat('id-ID').format(val);
        }
      }
    }
  </script>
</body>
</html>
