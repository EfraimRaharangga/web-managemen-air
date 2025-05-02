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

// mysqli_query($koneksi, "INSERT INTO tarif(kodeTarif,tipe,tarif,status) VALUES ('T1','rt',5000,1)");


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

            // switch case merubah menu kiri 
            print navLink("Dashboard", "main");
            switch ($level) {
              case 'admin':
                print navLink("Management User", "managemen-user"); //done
                print navLink("Ubah Datameter Warga", "ubah-datameter-warga"); //done
                print navLink("Pembayaran Warga", "pembayaran-warga"); //done
                print navLink("Lihat Pemakaian Warga", "pemakaian-warga"); //done
                break;
              case 'bendahara':
                print navLink("Ubah Datameter Warga", "ubah-datameter-warga"); //done
                print navLink("Transaksi Pembayaran", "transaksi-pembayaran-warga"); //done
                print navLink("Managemen Tarif", "managemen-tarif"); //done
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

          // switch case merubah judul dan penjelasan 
          $e = explode('=', $_SERVER["REQUEST_URI"]);
          if (!empty($e[1])) {
            switch ($e[1]) {
              case 'user_edit&user':
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
              case 'managemen-tarif':
                $h1 = "Manajemen Tarif";
                $li = "Menu untuk mengelola data tarif";
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
          <?php
          // ketika tombol ditekan 
          if (isset($_POST['tombol'])) {
            $tombol = $_POST['tombol'];

            // switch case tergantung post dari tombol
            switch ($tombol) {
              // tombol ditambah 
              case 'user_add':

                // ambil data dari post 
                $user = $_POST['username'];
                $level = $_POST['level'];
                $tipe = $_POST['tipe'];
                $status = $_POST['status'];

                // upload data 
                $qc = mysqli_query($koneksi, "SELECT username FROM user WHERE username='$user'");

                // cek apakah user sudah ada 
                if (mysqli_num_rows($qc)) {
                  echo "<div class=\"alert alert-warning alert-dismissible\">
                      <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                      <strong>Username $user sudah ada!</strong> Coba gunakan user lainnya...
                      </div>";
                } else {
                  mysqli_query($koneksi, "INSERT INTO user (username,password,nama,alamat,kota,level,tipe,status,noTelp) VALUES ('$user','$pass','$nama','$alamat','$kota','$level','$tipe','$status','$noTelp')");

                  // cek apakah data berhasil terupload 
                  if (mysqli_affected_rows($koneksi) > 0) {
                    echo "<div class=\"alert alert-success alert-dismissible\">
                      <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                      <strong>Data Berhasil Masuk!</strong> User dengan role $level berhasil ditambahkan.
                      </div>";
                  } else {
                    echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      <strong>Data Gagal Masuk!</strong> Mohon maaf data yang anda gagal ditambahkan.
                      </div>';
                  }
                }
                break;
              case 'tarif_add':

                // ambil data dari post 
                $kodeTarif = $_POST['kodeTarif'];
                $tipeTarif = $_POST['tipeTarif'];
                $tarif = $_POST['tarif'];
                $statusTarif = $_POST['statusTarif'] ? 0 : 2;
                var_dump($statusTarif);
                break;

              // tombol diedit 
              case 'user_edit':

                // ambil data dari post 
                $user = $_POST['username'];
                $pass = $_POST['pass'];
                $pass2 = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                $nama = $_POST['nama'];
                $kota = $_POST['kota'];
                $alamat = $_POST['alamat'];
                $noTelp = $_POST['notelp'];
                $level = $_POST['level'];
                $tipe = $_POST['tipe'];
                $status = $_POST['status'];

                // ambil password dari database 
                $qcp = mysqli_query($koneksi, "SELECT password FROM user WHERE username='$user'");
                $dcp = mysqli_fetch_array($qcp);
                $pass_db = $dcp[0];

                // bandingkan password jika lalu upload data 
                if ($pass == $pass_db) {
                  mysqli_query($koneksi, "UPDATE user SET nama='$nama',alamat='$alamat',kota='$kota',noTelp='$noTelp', level='$level',tipe='$tipe',status='$status' WHERE username='$user'");
                } else {
                  mysqli_query($koneksi, "UPDATE user SET password='$pass2',nama='$nama',alamat='$alamat',kota='$kota',noTelp='$noTelp', level='$level',tipe='$tipe',status='$status' WHERE username='$user'");
                }

                // cek apakah data berhasil terupload 
                if (mysqli_affected_rows($koneksi) > 0) {
                  echo "<div class=\"alert alert-success alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Berhasil Diedit!</strong> User berhasil diedit.
                    </div>";
                } else {
                  echo '<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Data Tidak Diubah</strong> Mohon maaf anda tidak mengedit user.
                    </div>';
                }
                break;

              // tomol hapus 
              case 'user_hapus':

                // hapus user
                $user = $_POST['user'];
                mysqli_query($koneksi, "DELETE FROM user WHERE username='$user'");

                // cek apakah user berhasil dihapus 
                if (mysqli_affected_rows($koneksi) > 0) {
                  echo "<div class=\"alert alert-success alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Berhasil Dihapus!</strong> Data dengan username $user berhasil dihapus.
                    </div>";
                } else {
                  echo '<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Data Gagal Dihapus</strong> Data dengan username $user gagal dihapus.
                    </div>';
                }
                break;
              default:
                break;
            }
          } else if (isset($_GET['page'])) {
            $p = $_GET['page'];
            if ($p == 'user_edit') {
              $username = $_GET['user'];
              $q = mysqli_query($koneksi, "SELECT password,nama,alamat,kota,noTelp,tipe,status,level FROM user WHERE username='$username'");
              $d = mysqli_fetch_row($q);
              $password = $d[0];
              $nama = $d[1];
              $alamat = $d[2];
              $kota = $d[3];
              $noTelp = $d[4];
              $tipe = $d[5];
              $status = $d[6];
              $levl = $d[7];
            } else if ($p == 'managemen-tarif') {
              $statusTarif = '';
            }
          }
          ?>
          <div class="card mb-4" id="tambahUser">
            <div class="card-header">
              <i class="fas fa-users me-1"></i>
              Tambah User Baru
            </div>
            <div class="card-body">
              <form method="post" class="need-validation" id="user_form" action="dashboard.php?page=managemen-user">
                <div class=" mb-3 mt-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" value="<?php echo $username ?>" class="form-control" id="username" placeholder="Masukan username" name="username" required>
                </div>
                <div class="mb-3">
                  <label for="pwd" class="form-label">Password</label>
                  <input type="password" value="<?php echo $password ?>" class="form-control" id="pwd" placeholder="Masukan password" name="pass" required>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="nama" class="form-label">Nama Pengguna</label>
                  <input type="text" value="<?php echo $nama ?>" class="form-control" id="nama" placeholder="Masukan nama" name="nama" required>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="alamat" class="form-label">Alamat Rumah</label>
                  <textarea class="form-control" rows="5" id="alamat" name="alamat"><?php echo $alamat ?></textarea>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="kota" class="form-label">Kota</label>
                  <input type="text" value="<?php echo $kota ?>" class="form-control" id="kota" placeholder="Masukan kota" name="kota">
                </div>
                <div class=" mb-3 mt-3">
                  <label for="notelp" class="form-label">Nomor Telepon</label>
                  <input type="tel" class="form-control" pattern="[0-9]{10,13}"
                    maxlength="13" id="notelp" value="<?php echo $noTelp ?>" placeholder="Masukan Nomor Telepon" name="notelp">
                </div>
                <div class=" mb-3 mt-3">
                  <label for="level" class="form-label">Level</label>
                  <select class="form-control" name="level" id="level">
                    <option value="">Level</option>
                    <?php
                    $levelArray = ['admin', 'bendahara', 'petugas', 'warga'];
                    foreach ($levelArray as $lv) {
                      ($lv == $levl) ? $sel = "SELECTED" : $sel = "";
                      echo "<option value=\"$lv\" $sel>$lv</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="tipe" class="form-label">Tipe</label>
                  <select class="form-control" name="tipe" id="tipe">
                    <option value="">Tipe</option>
                    <?php
                    $tipeArray = ['rt', 'kos'];
                    foreach ($tipeArray as $ta) {
                      ($ta == $tipe) ? $sel = "SELECTED" : $sel = "";
                      echo "<option value=\"$ta\" $sel>$ta</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="aktif">Status</option>
                    <?php
                    $statusArray = ['aktif', 'tdk Aktif'];
                    foreach ($statusArray as $sa) {
                      ($sa == $status) ? $sel = "SELECTED" : $sel = "";
                      echo "<option value=\"$sa\" $sel>$sa</option>";
                    }
                    ?>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary" id="tombolAcc" name="tombol" value="user_add">Simpan Data</button>
                <a href="dashboard.php?page=managemen-user"><button type="button" class="btn btn-danger" id="batalTambah">Batal Tambah</button></a>
              </form>
            </div>
          </div>

          <div class="card mb-4" id="tambahTarif">
            <div class="card-header">
              <i class="fa-solid fa-hippo"></i>
              Tambah Tarif Baru
            </div>
            <div class="card-body">
              <form method="post" class="need-validation" id="user_form_tarif" action="dashboard.php?page=managemen-tarif">
                <div class=" mb-3 mt-3">
                  <label for="kodeTarif" class="form-label">Kode Tarif</label>
                  <input type="text" value="<?php echo $kodeTarif ?>" class="form-control" id="kodeTarif" placeholder="Masukan Kode Tarif" name="kodeTarif" required>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="tipeTarif" class="form-label">Tipe Tarif</label>
                  <select class="form-control" name="tipeTarif" id="tipeTarif">
                    <option value="">Pilih Tipe</option>
                    <?php
                    $tipeTarifArray = ['kos', 'rumah'];
                    foreach ($tipeTarifArray as $tp) {
                      ($tp == $tipeTarif) ? $sel = "SELECTED" : $sel = "";
                      echo "<option value=\"$tp\" $sel>$tp</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class=" mb-3 mt-3">
                  <label for="tarif" class="form-label">Tarif</label>
                  <input type="number" value="<?php echo $tarif ?>" class="form-control" id="tarif" placeholder="0" name="tarif">
                </div>
                <div class="form-check">
                  <input type="radio" class="form-check-input" value="halo" name="statusTarif"> $st
                  <label class="form-check-label" for="statusTarif"></label>
                </div>
                <?php
                // untuk radio button 
                $statusArray = ["Tdk Aktif", "Aktif"];
                foreach ($statusArray as $st) {
                  $st == $statusTarif ? $sel = "CHECKED" : '';
                  $bool = array_search($st, $statusArray);
                  echo "<div class=\"form-check\">
                  <input type=\"radio\" class=\"form-check-input\" value='$st' name=\"statusTarif\"> $st
                  <label class=\"form-check-label\" for=\"statusTarif\"></label>
                  </div>";
                }
                ?>
                <button type="submit" class="btn btn-primary mt-3" name="tombol" value="tarif_add">Simpan Data</button>
                <a href="dashboard.php?page=managemen-tarif"><button type="button" class="btn btn-danger mt-3" id="batalTambahTarif">Batal Tambah</button></a>
              </form>
            </div>
          </div>

          <div class="modal" id="myModal">
            <div class="modal-dialog">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <form method="post">
                    <button type="submit" name="tombol" value='user_hapus' class="btn btn-danger" data-bs-dismiss="modal">Konfirmasi</button>
                  </form>
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                </div>

              </div>
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
                <a>
                  <?php

                  // mengambil data tarif 
                  $q = mysqli_query($koneksi, "SELECT * FROM user ORDER BY level ASC");
                  while ($d = mysqli_fetch_row($q)) {
                    $user = $d[0];
                    $pass = $d[1];
                    $nama = $d[2];
                    $alamat = $d[3];
                    $kota = $d[4];
                    $tlp = $d[8]; //8
                    $level = $d[5];
                    $tipe = $d[6]; //5
                    $status = $d[7]; //7

                    // menampilkan data user 
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
                    <a href=\"dashboard.php?page=user_edit&user=$user\"><button type=\"button\" class=\"btn btn-outline-success\">Edit</button></a>
                    <button type=\"button\" class=\"btn btn-outline-danger\" data-bs-toggle=\"modal\" data-bs-target=\"#myModal\" data-user='$user'>Hapus</button>
                    </td>
                  </tr>";
                  }
                  ?>

                  </tbody>
              </table>
            </div>
          </div>

          <div class="card mb-4" id="tabelTarif">
            <div class="card-header">
<<<<<<< Updated upstream
              <i class="fas fa-charts-simple me-1"></i>
              Data Tarif
            </div>
            <div class="card-body">
              <table id="datatablesSimple">
                <thead>
                  <tr>
                    <th>Kode Tarif</th>
                    <th>Tipe Tarif</th>
                    <th>Tarif</th>
                    <th>Status</th>
=======
              <i class="fa-solid fa-address-book"></i>
              Data Baru Cah
            </div>
            <div class="card-body">
              <table id="datatablesSimple2">
                <thead>
                  <tr>
                    <th>Kode Tarif</th>
                    <th>Tipe</th>
                    <th>Tarif</th>
                    <th>Status</th>
                    <th>Modifikasi</th>
>>>>>>> Stashed changes
                  </tr>
                </thead>
                <a>
                  <?php
<<<<<<< Updated upstream

                  // mengambil data tarif 
                  $q = mysqli_query($koneksi, "SELECT * FROM tarif ORDER BY level ASC");
=======
                  $q = mysqli_query($koneksi, "SELECT * FROM tarif ORDER BY kodeTarif ASC");
>>>>>>> Stashed changes
                  while ($d = mysqli_fetch_row($q)) {
                    $kodeTarif = $d[0];
                    $tipeTarif = $d[1];
                    $tarif = $d[2];
                    $statusTarif = $d[3];

<<<<<<< Updated upstream
                    // menampilkan data user 
=======

>>>>>>> Stashed changes
                    echo "<tr>
                    <td>$kodeTarif</td>
                    <td>$tipeTarif</td>
                    <td>$tarif</td>
<<<<<<< Updated upstream
                    <td>$statusTarif</td>
=======
                    <td>$status</td>
>>>>>>> Stashed changes
                    <td>
                    <a href=\"dashboard.php?page=tarif_edit&kode=$kodeTarif\"><button type=\"button\" class=\"btn btn-outline-success\">Edit</button></a>
                    <button type=\"button\" class=\"btn btn-outline-danger\" data-bs-toggle=\"modal\" data-bs-target=\"#myModal\" data-tarif='$kodeTarif'>Hapus</button>
                    </td>
                  </tr>";
                  }
                  ?>

                  </tbody>
              </table>
            </div>
          </div>
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
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