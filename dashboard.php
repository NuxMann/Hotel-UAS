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
  <link href="img/logo/logo.png" rel="icon">
  <title>Reservasi Hotel</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
    .custom-dashboard-card {
      background: linear-gradient(135deg, #f8f9fc, #e9ecef);
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
      transition: 0.3s ease;
    }
    .custom-dashboard-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .custom-card-title {
      font-size: 0.75rem;
      font-weight: 700;
      color: #6c757d;
      text-transform: uppercase;
      margin-bottom: 1rem;
    }
    .custom-label {
      font-size: 1.1rem;
      font-weight: 600;
      color: #343a40;
    }
    .custom-value {
      font-size: 1.5rem;
      font-weight: bold;
      color: #495057;
      margin-top: 4px;
    }
    .custom-icon {
      font-size: 2.3rem;
      color: #6c63ff;
    }
    .carousel-inner {
      height: 100vh;
    }
    .carousel-item {
      height: 100vh;
      background-size: cover;
      background-position: center;
      position: relative;
    }
    .carousel-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include 'sidebar.php'; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include 'navbar.php'; ?>

        <!-- Carousel with Dashboard -->
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
          <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('img/img-banner.jpg');">
              <h1 class="h3 mb-0 text-white text-center mt-5" style="position: relative; z-index: 10;">Dashboard</h1>
              <div class="carousel-overlay">
                <div class="container-fluid" id="container-wrapper">
                  <div class="row mb-1 w-100">

                    
                    <!-- Data Kamar Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card h-100 custom-dashboard-card">
                        <div class="card-body text-center">
                          <div class="custom-card-title">Data Kamar</div>
                          <div class="d-flex justify-content-around">
                            <div>
                              <div class="custom-label">Booked</div>
                              <div class="custom-value">2</div>
                            </div>
                            <div>
                              <div class="custom-label">Available</div>
                              <div class="custom-value">4</div>
                            </div>
                          </div>
                          <div class="custom-icon mt-3 text-primary">
                            <i class="fas fa-bed"></i>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Data Customer Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card h-100 custom-dashboard-card">
                        <div class="card-body text-center">
                          <div class="custom-card-title">Data Customer</div>
                          <div class="custom-value">20</div>
                          <div class="custom-icon mt-3 text-info">
                            <i class="fas fa-user-friends"></i>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Data User Online Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card h-100 custom-dashboard-card">
                        <div class="card-body text-center">
                          <div class="custom-card-title">Data User Online</div>
                          <div class="custom-value">366</div>
                          <div class="custom-icon mt-3 text-success">
                            <i class="fas fa-signal"></i>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Bookings Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card h-100 custom-dashboard-card">
                        <div class="card-body text-center">
                          <div class="custom-card-title">Bookings</div>
                          <div class="custom-value">12</div>
                          <div class="custom-icon mt-3 text-danger">
                            <i class="fas fa-calendar-check"></i>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item" style="background-image: url('img/img-banner2.jpg');">
              <div class="carousel-overlay"><h1 class="text-white">Selamat Datang di Dashboard Hotel</h1></div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item" style="background-image: url('img/img-banner3.jpg');">
              <div class="carousel-overlay"><h1 class="text-white">Kelola Reservasi Anda dengan Mudah</h1></div>
            </div>

          </div>
        </div>

      </div>
      <?php include 'footer.php'; ?>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
</body>

</html>
