<?php

chdir(__DIR__);

require_once 'vendor/autoload.php';
use Dompdf\Dompdf;


include 'database/connection-database.php';
$sql    = "SELECT * FROM vw_laporan_transaksi";
$result = $connection->query($sql);


$logoPath = __DIR__ . '/img/logo/logo-web.png';
if (!is_file($logoPath)) {
    die('Logo tidak ditemukan: ' . $logoPath);
}
$logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));


$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>Laporan Transaksi</title>
  <style>

    @page { margin: 120px 50px 80px 50px; }
    body { font-family: sans-serif; font-size: 12px; margin: 0; }


    header {
      position: fixed; top: -100px; left: 0; right: 0; height: 100px;
      display: flex; justify-content: space-between; align-items: flex-start;
    }
    header .logo img { height: 60px; }
    header .company-info { text-align: right; }
    header .company-info h2 { margin:0; font-size:16px; }
    header .company-info p  { margin:0; font-size:10px; }


    footer {
      position: fixed; bottom: -60px; left: 0; right: 0; height: 50px;
      font-size:10px; text-align:center;
    }
    .page-number:after { content: counter(page) " / " counter(pages); }

    /* Content */
    main { margin-top: 10px; }
    table { width:100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border:1px solid #444; padding:6px 8px; }
    th { background:#eee; font-weight: bold; }
    .badge-confirmed { background:#d1fae5; color:#064e3b; padding:2px 6px; border-radius:4px; font-size:10px; }
    .badge-cancelled { background:#fee2e2; color:#991b1b; padding:2px 6px; border-radius:4px; font-size:10px; }
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
  <!-- END FOOTER -->

  <!-- MAIN CONTENT -->
  <main>
    <h1 style="text-align:center; font-size:16px; margin-bottom:4px;">Laporan Transaksi</h1>
    <p style="text-align:center; font-size:10px; margin-top:0; margin-bottom:8px;">
      Ringkasan dan detail laporan transaksi
    </p>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Reservation ID</th>
          <th>Customer</th>
          <th>Nomor Kamar</th>
          <th>Tipe Kamar</th>
          <th>Fasilitas</th>
          <th>Tgl Reservasi</th>
          <th>Check-In</th>
          <th>Check-Out</th>
          <th>Total Harga</th>
          <th>Status</th>
          <th>Updated At</th>
        </tr>
      </thead>
      <tbody>
HTML;

$no = 1;
while ($row = $result->fetch_assoc()) {
    $st    = strtolower($row['status']);
    $badge = $st === 'cancelled'
      ? '<span class="badge-cancelled">Cancelled</span>'
      : '<span class="badge-confirmed">'.ucfirst($st).'</span>';

    $html .= "<tr>
      <td>{$no}</td>
      <td>".htmlspecialchars($row['reservation_id'])."</td>
      <td>".htmlspecialchars($row['customer_name'])."</td>
      <td>".htmlspecialchars($row['room_number'])."</td>
      <td>".htmlspecialchars($row['room_type'])."</td>
      <td>".htmlspecialchars($row['facility'])."</td>
      <td>".htmlspecialchars($row['reservation_date'])."</td>
      <td>".htmlspecialchars($row['check_in_date'])."</td>
      <td>".htmlspecialchars($row['check_out_date'])."</td>
      <td style=\"font-weight:bold;\">Rp".number_format($row['total_price'],0,',','.')."</td>
      <td style=\"text-align:center;\">{$badge}</td>
      <td>".htmlspecialchars($row['updated_at'] ?: '–')."</td>
    </tr>";
    $no++;
}

$html .= '
      </tbody>
    </table>
  </main>
</body>
</html>';


$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->set_option('chroot', __DIR__);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream("laporan_transaksi_".date('Ymd_His').".pdf", ['Attachment'=>1]);
exit;
