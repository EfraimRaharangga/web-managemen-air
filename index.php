<?php
session_start();
if (!empty($_SESSION['user']) && !empty($_SESSION['pass'])) {
  echo "<script>window.location.replace('./login/dashboard.php')</script>";
}

include './assets/funcions.php';
$air = new Air;
$koneksi = $air->koneksi();

// $pass = password_hash('warga123', PASSWORD_DEFAULT);
// mysqli_query($koneksi, "INSERT INTO user(username,password,nama,alamat,kota,level,tipe,status,noTelp) VALUES ('petugas','$pass','Petugas Kita','Jl. Gondomono no 9','Selat Malaka','petugas','kos','online','08994592581')");
// mysqli_query($koneksi, "INSERT INTO user(username,password,nama,alamat,kota,level,tipe,status,noTelp) VALUES ('warga','$pass','warga Kita','Jl. Gondomono no 9','Selat Malaka','warga','kos','online','08994592581')");


?>
<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta
  name="viewport"
  content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<title>Login - Sistem Air</title>
<link href="css/styles.css" rel="stylesheet" />
<script
  src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
  crossorigin="anonymous"></script>
<style>
  body {
    background-image: url('assets/img/wave.png');
  }

  .grayscale {
    filter: grayscale(100%) brightness(70%);
    /* Ubah nilai untuk intensitas */
    transition: filter 0.3s ease;
  }
</style>
</head>

<body>
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Login</h3>
                </div>
                <div class="card-body">
                  <?php
                  if (isset($_POST['tombol'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    // echo "username $username password $password ";
                    $qc = mysqli_query($koneksi, "SELECT username,password FROM user WHERE  username='$username'");
                    $dc = mysqli_fetch_row($qc);
                    if (!empty($dc)) {
                      $user_check = $dc[0];
                      $pass_check = $dc[1];

                      if (password_verify($password, $pass_check)) {
                        $_SESSION['user'] = $username;
                        $_SESSION['pass'] = $password;

                        echo "<script>window.location.replace('./login/dashboard.php')</script>";
                      } else {
                        echo '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Login Gagal!</strong> login salah...
                            </div>';
                      }
                    } else {
                      echo '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Login Gagal!</strong> Username tidak ditemukan
                            </div>';
                    }
                  }
                  ?>
                  <form method="post" class="needs-validation">
                    <div class="form-floating mb-3">
                      <input
                        class="form-control "
                        id="inputUser"
                        type="text"
                        placeholder="username..."
                        name="username" required />
                      <label for="inputUser">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input
                        class="form-control"
                        id="inputPassword"
                        type="password"
                        placeholder="Password" name="password" required />
                      <label for="inputPassword">Password</label>
                    </div>
                    <div class="form-check mb-3">
                      <input
                        class="form-check-input"
                        id="inputRememberPassword"
                        type="checkbox"
                        value="" />
                      <label
                        class="form-check-label"
                        for="inputRememberPassword">Remember Password</label>
                    </div>
                    <div class="d-flex justify-content-between">
                      <button type="submit" name="tombol" class="btn btn-primary flex-fill btn-block me-1">Login</button>
                      <a href="login/profile.php" class="flex-fill"><button type="button" name="profile" class="btn btn-warning btn-block w-100">Profile</button></a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </main>

  </div>
  <div id="layoutAuthentication_footer">
    <footer class="py-4 bg-light mt-auto">
      <div class="container-fluid px-4">
        <div
          class="d-flex align-items-center justify-content-between small">
          <div class="text-muted">Copyright &copy; TE-2C 2025</div>
          <div>
            <a href="#">Privacy Policy</a>
            &middot;
            <a href="#">Terms &amp; Conditions</a>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
</body>

</html>