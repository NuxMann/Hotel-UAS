<?php 

include "database/connection-database.php";

session_start();

if(!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>Data Kamar</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php 
      include 'sidebar.php';
    ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php 
        include 'navbar.php';
        ?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Kamar</h1>
            <ol class="breadcrumb">
              <a href="form-kamar.php">
                <button class="btn btn-primary">Tambah Kamar</button>
              </a>
              
              
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Data Kamar</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush" id="dataTable">
                    <thead class="thead-light" style="white-space: nowrap; text-align: center; vertical-align: middle;">
                      <tr>
                        <th>No</th>
                        <th>Tipe Kamar</th>
                        <th>Deskripsi</th>
                        <th>Kapasitas</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                    
                    <?php
                      include "database/connection-database.php";

                      $no = 1;
                      $result = mysqli_query($connection, "SELECT * FROM tbl_rooms");

                      $rooms = [];
                      while ($row = mysqli_fetch_assoc($result)) {
                          $rooms[] = $row;
                      }

                      foreach ($rooms as $row) {
                      ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['room_type']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= $row['capacity'] ?></td>
                        <td>Rp<?= number_format($row['price'], 0, ',', '.') ?></td>
                        <td><img src="img/<?= htmlspecialchars($row['image']) ?>" width="80"></td>
                        <td><?= ucfirst($row['status']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><?= $row['updated_at'] ?></td>
                        <td class="">
                          <a href="edit-room.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                          <a href="database/Kamar/validation-delete-kamar.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger mt-2">Hapus</a>
                        </td>
                      </tr>
                    <?php } ?>


                    <!-- Php versi 2 Tampil data -->
                    <!-- // include "database/connection-database.php";
                    // $no = 1;
                    // $query = mysqli_query($connection, "SELECT * FROM tbl_rooms");
                    // while ($row = mysqli_fetch_assoc($query)) {
                    //   echo "<tr>";
                    //   echo "<td>" . $no++ . "</td>";
                    //   echo "<td>" . htmlspecialchars($row['room_type']) . "</td>";
                    //   echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    //   echo "<td>" . $row['capacity'] . "</td>";
                    //   echo "<td>Rp" . number_format($row['price'], 0, ',', '.') . "</td>";
                    //   echo "<td> <img src='img/" . htmlspecialchars($row['image']) . "' width='80'></td>";
                    //   echo "<td>" . ucfirst($row['status']) . "</td>";
                    //   echo "<td>" . $row['created_at'] . "</td>";
                    //   echo "<td>" . $row['updated_at'] . "</td>";
                    //   echo "<td>
                    //           <a href='edit-room.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Edit</a>
                    //           <a href='delete-room.php?id=" . $row['id'] . "' onclick=\"return confirm('Yakin hapus?')\" class='btn btn-sm btn-danger'>Hapus</a>
                    //         </td>";
                    //   echo "</tr>";
                    // } -->
                    
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
            
          </div>
          <!--Row-->

          
          

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="login.html" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
      </div>

      <!-- Footer -->
      <?php 
      include 'footer.php';
      ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

</body>

</html>