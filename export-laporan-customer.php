<?php
// export-customer.php
chdir(__DIR__);

// 1. Autoload Dompdf
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;

// 2. Ambil data customer report
include 'database/connection-database.php';
$sql    = "SELECT * FROM vw_laporan_customer";
$result = $connection->query($sql);

// 3. Siapkan logo embed Base64
$logoPath = __DIR__ . '/img/logo/logo-web.png';
if (!is_file($logoPath)) {
    die('Logo tidak ditemukan: ' . $logoPath);
}
$logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

// 4. Bangun HTML dengan header/footer fixed
$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>Laporan Customer</title>
  <style>
    @page { margin: 120px 50px 80px 50px; }
    body { font-family: sans-serif; font-size:12px; margin:0; }

    /* Header */
    header {
      position: fixed; top: -100px; left: 0; right: 0; height:100px;
      display:flex; justify-content: space-between; align-items: flex-start;
    }
    header .logo img { height:60px; }
    header .company-info { text-align:right; }
    header .company-info h2 { margin:0; font-size:16px; }
    header .company-info p  { margin:0; font-size:10px; }

    /* Footer */
    footer {
      position: fixed; bottom: -60px; left: 0; right: 0; height:50px;
      font-size:10px; text-align:center;
    }
    .page-number:after { content: counter(page) " / " counter(pages); }

    /* Content */
    main { margin-top:10px; }
    table { width:100%; border-collapse: collapse; margin-top:10px; }
    th, td { border:1px solid #444; padding:6px 8px; }
    th { background:#eee; font-weight:bold; }
  </style>
</head>
<body>
  <!-- HEADER -->
  <header>
    <div class="logo">
      <img src="$logoData" alt="NuRy HOTEL">
    </div>
    <div class="company-info">
      <h2>NuRy HOTEL</h2>
      <p>Jl. Rajeg No.06 • Telp. 085156714674</p>
    </div>
  </header>

  <!-- FOOTER -->
  <footer>
    <div>Dicetak: <?= date('d-m-Y') ?></div>
    <div class="page-number">Halaman </div>
  </footer>

  <!-- MAIN CONTENT -->
  <main>
    <h1 style="text-align:center; font-size:16px; margin-bottom:4px;">Laporan Customer</h1>
    <p style="text-align:center; font-size:10px; margin-top:0; margin-bottom:8px;">
      Ringkasan aktivitas dan pengeluaran per customer
    </p>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Customer ID</th>
          <th>Nama Customer</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Total Reservasi</th>
          <th>Total Pengeluaran</th>
          <th>Terakhir Reservasi</th>
        </tr>
      </thead>
      <tbody>
HTML;

$no = 1;
while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
      <td>{$no}</td>
      <td>" . htmlspecialchars($row['customer_id']) . "</td>
      <td>" . htmlspecialchars($row['customer_name']) . "</td>
      <td>" . htmlspecialchars($row['email']) . "</td>
      <td>" . htmlspecialchars($row['phone']) . "</td>
      <td>" . htmlspecialchars($row['total_reservations']) . "</td>
      <td style=\"font-weight:bold;\">Rp" . number_format($row['total_spent'],0,',','.') . "</td>
      <td>" . htmlspecialchars($row['last_reservation_date'] ?: '–') . "</td>
    </tr>";
    $no++;
}

$html .= '
      </tbody>
    </table>
  </main>
</body>
</html>';

// 5. Render PDF
$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->set_option('chroot', __DIR__);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// 6. Stream download
$dompdf->stream("laporan_customer_".date('Ymd_His').".pdf", ['Attachment'=>1]);
exit;
