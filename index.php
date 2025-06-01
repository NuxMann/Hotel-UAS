<?php 
include "database/connection-database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Hotel - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: url('img/bg-login.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      margin: 0;
    }
    .overlay {
      background-color: rgba(0, 0, 0, 0.5);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    .login-popup {
      background-color: #fff;
      padding: 30px 25px;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      position: relative;
    }
    .btn-close {
      position: absolute;
      right: 20px;
      top: 20px;
    }
  </style>
</head>

<body>

  <div class="overlay">
    <form action="database/validation-login.php" method="POST" class="login-popup">
      <a href="dashboard.php" class="btn-close" aria-label="Close"></a>
      <h4 class="text-center mb-4">Login ke Sistem</h4>

      <div class="mb-3">
        <input type="text" class="form-control" placeholder="Username" name="username" required>
      </div>

      <div class="mb-3">
        <input type="password" class="form-control" placeholder="Password" name="password" required>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="rememberMe">
        <label class="form-check-label" for="rememberMe">Remember Me</label>
      </div>

      <button class="btn btn-primary w-100 mb-2" type="submit">Login</button>

      <p class="text-center mt-3 mb-0">
        Belum punya akun? <a href="register-page.php">Buat Akun</a>
      </p>
    </form>
  </div>

</body>
</html>
