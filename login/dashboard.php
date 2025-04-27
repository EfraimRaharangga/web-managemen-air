<?php
session_start();
if (empty($_SESSION['user']) && empty($_SESSION['pass'])) {
  echo "<script>window.location.replace('../index.php')</script>";
}

include '../assets/funcions.php';
$air = new Air;
$koneksi = $air->koneksi();

$data_user = $air->data_user($_SESSION['user']);
$level = $data_user[2];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Dashboard - SB Admin</title>
  <link
    href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
    rel="stylesheet" />
  <link href="../css/styles.css" rel="stylesheet" />
  <script
    src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
    crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="#">Web Air Efraim Yogi</a>
    <!-- Sidebar Toggle-->
    <button
      class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
      id="sidebarToggle"
      href="#!">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search-->
    <form
      class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        <input
          class="form-control"
          type="text"
          placeholder="Search for..."
          aria-label="Search for..."
          aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" id="btnNavbarSearch" type="button">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a
          class="nav-link dropdown-toggle"
          id="navbarDropdown"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul
          class="dropdown-menu dropdown-menu-end"
          aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#!">Settings</a></li>
          <li><a class="dropdown-item" href="#!">Activity Log</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <?php
            print navLink("Dashboard", "main");
            switch ($level) {
              case 'admin':
                print navLink("Management User", "managemen-user"); //done
              case 'bendahara':
                print navLink("Ubah Datameter Warga", "ubah-datameter-warga"); //done
                print navLink("Pembayaran Warga", "pembayaran-warga"); //done
                print navLink("Lihat Pemakaian Warga", "pemakaian-warga"); //done
                break;
              case 'warga':
                print navLink("Lihat Pemakaian Anda", "pemakaian-anda"); //done
                print navLink("Lihat Tagihan Anda", "tagihan-anda"); //done
                print navLink("Bayar Tagihan Anda", "bayar-tagihan-anda"); //done
                break;
              case 'petugas':
                print navLink("Lihat Pemakaian Warga", "pemakaian-warga"); //done
                print navLink("Catat Meteran", "catat-meter");
                print navLink("Ubah Datameter Warga Sebulan", "ubah-datameter-bulan");
                break;
            }
            ?>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small"><i class="fa-regular fa-circle-user"></i> Logged in as: <?php echo $data_user[2] ?></div>
          <i class="fa-regular fa-face-smile fa-spin text-warning"></i> <?php echo "$data_user[0] ($data_user[1])" ?>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <?php
          $e = explode('=', $_SERVER["REQUEST_URI"]);
          if (!empty($e[1])) {
            switch ($e[1]) {
              case 'managemen-user':
                $h1 = "Management User";
                $li = "Menu untuk CRUD user";
                break;
              case 'pemakaian-warga':
                $h1 = "Lihat Pemakaian Warga";
                $li = "Lihat data pemakaian warga";
                break;
              case 'pembayaran-warga':
                $h1 = "Pembayaran Warga";
                $li = "Lihat data pembayaran air wara";
                break;
              case 'ubah-datameter-warga':
                $h1 = "Ubah Datameter Warga";
                $li = "Ubah Datameter air Warga";
                break;
              case 'pemakaian-anda':
                $h1 = "Lihat Pemakaian Anda";
                $li = "Melihat Pemakaian Air Anda";
                break;
              case 'tagihan-anda':
                $h1 = "Lihat Tagihan Anda";
                $li = "Melihat Tagihan Air Anda";
                break;
              case 'bayar-tagihan-anda':
                $h1 = "Bayar Tagihan Anda";
                $li = "Membayar Tagihan Air Anda";
                break;
              case 'catat-meter':
                $h1 = "Catat Meteran";
                $li = "Mencatat Meteran Warga";
                break;
              case 'ubah-datameter-bulan':
                $h1 = "Ubah Datameter Warga Sebulan";
                $li = "Mengubah Datameter Warga Satu Bulan";
                break;
              default:
                $h1 = "Dashboard";
                $li = "Dashboard";
            }
          } else {
            $h1 = "Dashboard";
            $li = "Dashboard";
          }
          ?>
          <h1 class="mt-4"><?php echo $h1 ?></h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><?php echo $li ?></li>
          </ol>
          <div class="row" id="summary">
            <div class="col-xl-3 col-md-6">
              <div class="card bg-primary text-white mb-4">
                <div class="card-body">Primary Card</div>
                <div
                  class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="#">View Details</a>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card bg-warning text-white mb-4">
                <div class="card-body">Warning Card</div>
                <div
                  class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="#">View Details</a>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card bg-success text-white mb-4">
                <div class="card-body">Success Card</div>
                <div
                  class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="#">View Details</a>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card bg-danger text-white mb-4">
                <div class="card-body">Danger Card</div>
                <div
                  class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="#">View Details</a>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row" id="grafik">
            <div class="col-xl-6">
              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-chart-area me-1"></i>
                  Area Chart Example
                </div>
                <div class="card-body">
                  <canvas id="myAreaChart" width="100%" height="40"></canvas>
                </div>
              </div>
            </div>
            <div class="col-xl-6">
              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-chart-bar me-1"></i>
                  Bar Chart Example
                </div>
                <div class="card-body">
                  <canvas id="myBarChart" width="100%" height="40"></canvas>
                </div>
              </div>
            </div>
          </div>
          <?php if (isset($_POST['tombol'])) {
            $user = $_POST['username'];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $nama = $_POST['nama'];
            $kota = $_POST['kota'];
            $alamat = $_POST['alamat'];
            $noTelp = $_POST['notelp'];
            $level = $_POST['level'];
            $tipe = $_POST['tipe'];
            $status = $_POST['status'];

            $qc = mysqli_query($koneksi, "SELECT username FROM user WHERE username='$user'");
            if (mysqli_num_rows($qc)) {

              echo "<div class=\"alert alert-warning alert-dismissible\">
                      <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                      <strong>Username $user sudah ada!</strong> Coba gunakan user lainnya...
                      </div>";
            } else {
              mysqli_query($koneksi, "INSERT INTO user (username,password,nama,alamat,kota,level,tipe,status,noTelp) VALUES ('$user','$pass','$nama','$alamat','$kota','$level','$tipe','$status','$noTelp')");
              if (mysqli_affected_rows($koneksi) > 0) {
                echo "<div class=\"alert alert-success alert-dismissible\">
                      <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                      <strong>Data Berhasil Masuk!</strong> User $level berhasil ditambahkan.
                      </div>";
              } else {
                echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      <strong>Data Gagal Masuk!</strong> Mohon maaf data yang anda gagal ditambahkan.
                      </div>';
              }
            }
          } ?>
          <div class="card mb-4" id="tambahUser">
            <div class="card-header">
              <i class="fas fa-users me-1"></i>
              Tambah User Baru
            </div>
            <div class="card-body">
              <form method="post" class="need-validation" id="user_form">
                <div class=" mb-3 mt-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" placeholder="Masukan username" name="username" required>
                </div>
                <div class="mb-3">
                  <label for="pwd" class="form-label">Password</label>
                  <input type="password" class="form-control" id="pwd" placeholder="Masukan password" name="pass" required>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="nama" class="form-label">Nama Pengguna</label>
                  <input type="text" class="form-control" id="nama" placeholder="Masukan nama" name="nama" required>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="alamat" class="form-label">Alamat Rumah</label>
                  <textarea class="form-control" rows="5" id="alamat" name="alamat"></textarea>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="kota" class="form-label">Kota</label>
                  <input type="text" class="form-control" id="kota" placeholder="Masukan kota" name="kota">
                </div>
                <div class=" mb-3 mt-3">
                  <label for="notelp" class="form-label">Nomor Telepon</label>
                  <input type="tel" class="form-control" pattern="[0-9]{10,13}"
                    maxlength="13" id="notelp" placeholder="Masukan Nomor Telepon" name="notelp">
                </div>
                <div class=" mb-3 mt-3">
                  <label for="level" class="form-label">Level</label>
                  <select class="form-control" name="level" id="level">
                    <option value="">Level</option>
                    <option value="admin">Admin</option>
                    <option value="bendahara">Bendahara</option>
                    <option value="petugas">Petugas</option>
                    <option value="warga">Warga</option>
                  </select>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="tipe" class="form-label">Tipe</label>
                  <select class="form-control" name="tipe" id="tipe">
                    <option value="">Tipe</option>
                    <option value="rt">RT</option>
                    <option value="kost">Kost</option>
                  </select>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="aktif">Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="tidak aktif">Tidak Aktif</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary" name="tombol" value="user_add">Simpan Data</button>
                <button type="button" class="btn btn-danger" id="batalTambah">Batal Tambah</button>
              </form>
            </div>
          </div>
          <div class="card mb-4" id="tabelUser">
            <div class="card-header">
              <i class="fas fa-users me-1"></i>
              Data User
            </div>
            <div class="card-body">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>No Telepon</th>
                    <th>Level</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Modifikasi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $q = mysqli_query($koneksi, "SELECT * FROM user ORDER BY level ASC");
                  while ($d = mysqli_fetch_row($q)) {
                    $user = $d[0];
                    $pass = $d[1];
                    $nama = $d[2];
                    $alamat = $d[3];
                    $kota = $d[4];
                    $tlp = $d[8]; //8
                    $level = $d[6];
                    $tipe = $d[5]; //5
                    $status = $d[7]; //7

                    echo "<tr>
                    <td>$user</td>
                    <td>$nama</td>
                    <td>$alamat</td>
                    <td>$kota</td>
                    <td>$tlp</td>
                    <td>$level</td>
                    <td>$tipe</td>
                    <td>$status</td>
                    <td>
                    <button type=\"button\" class=\"btn btn-outline-success\">Edit</button>
                    <button type=\"button\" class=\"btn btn-outline-danger\">Hapus</button>
                    </td>
                  </tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div
            class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2023</div>
            <div>
              <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  <script src="../js/scripts.js"></script>

  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
    crossorigin="anonymous"></script>
  <script src="../assets/demo/chart-area-demo.js"></script>
  <script src="../assets/demo/chart-bar-demo.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
  <script src="../js/jquery-3.7.1.js"></script>
  <script src="../js/air.js"></script>
  <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>