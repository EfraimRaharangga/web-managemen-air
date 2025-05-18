<?php

use function PHPUnit\Framework\isEmpty;

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
                print navLink("Lihat Pemakaian Warga", "lihat-pemakaian-warga"); //done
                print navLink("Managemen Tarif", "managemen-tarif"); //done
                break;
              case 'bendahara':
                print navLink("Managemen Tarif", "managemen-tarif"); //done
                print navLink("Lihat Pemakaian Warga", "pemakaian-warga"); //done
                break;
              case 'warga':
                print navLink("Lihat Pemakaian & Tagihan", "pemakaian-anda"); //done
                break;
              case 'petugas':
                print navLink("Catat Meteran", "catat-meter");
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
                $h1 = "Lihat Pemakaian & Tagihan Anda";
                $li = "Melihat Pemakaian & Tagihan Air Anda";
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
                $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                $nama = $_POST['nama'];
                $kota = $_POST['kota'];
                $alamat = $_POST['alamat'];
                $noTelp = $_POST['notelp'];
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
                $statusTarif = isset($_POST['statusTarif']) ? 1 : 0;

                // upload data 
                $qc = mysqli_query($koneksi, "SELECT kodeTarif FROM tarif WHERE kodeTarif='$kodeTarif'");

                // cek apakah user sudah ada 
                if (mysqli_num_rows($qc)) {
                  echo "<div class=\"alert alert-warning alert-dismissible\">
                      <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                      <strong>Kode Tarif $kodeTarif sudah ada!</strong> Coba gunakan kode tarif lainnya...
                      </div>";
                } else {
                  mysqli_query($koneksi, "INSERT INTO tarif (kodeTarif,tipe,tarif,status) VALUES ('$kodeTarif','$tipeTarif','$tarif','$statusTarif')");

                  // cek apakah data berhasil terupload 
                  if (mysqli_affected_rows($koneksi) > 0) {
                    echo "<div class=\"alert alert-success alert-dismissible\">
                      <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                      <strong>Data Berhasil Masuk!</strong> Tarif dengan tipe $tipeTarif berhasil ditambahkan.
                      </div>";
                  } else {
                    echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      <strong>Data Gagal Masuk!</strong> Mohon maaf data yang anda gagal ditambahkan.
                      </div>';
                  }
                }
                break;

              // tombol meter ditambahkan 
              case 'meter_add':

                // ambil nilai dari post 
                $userWarga = $_POST['wargaMeter'];
                $meterAwal = $_POST['meterAwal'];
                $meterAkhir = $_POST['meterAkhir'];
                $pemakaian = $meterAkhir - $meterAwal;


                // cek apakah nilai meter akhir lebih besar atau tidak 
                if ($pemakaian < 0) {
                  echo '<div class="alert alert-danger alert-dismissible dataSama">
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  <strong>Data Masukan Salah!</strong> Mohon maaf data meter awal lebih besar daripada meter akhir.
                  </div>';
                } else {

                  $kodeTarif = $air->ambilKodeTarifDariUsername($userWarga);
                  $tarif = $air->ambilTarif($kodeTarif);
                  $tagihan = $tarif * $pemakaian;

                  if ($data_user[2] == 'admin') {
                    $statusMeter = $_POST['status'];
                    mysqli_query($koneksi, "INSERT INTO pemakaian (username,meterAwal,meterAkhir,pemakaian,tgl,waktu,kodeTarif,tagihan,status) VALUES ('$userWarga','$meterAwal','$meterAkhir','$pemakaian',CURRENT_DATE(),CURRENT_TIME(),'$kodeTarif','$tagihan','$statusMeter')");
                  } else mysqli_query($koneksi, "INSERT INTO pemakaian (username,meterAwal,meterAkhir,pemakaian,tgl,waktu,kodeTarif,tagihan,status) VALUES ('$userWarga','$meterAwal','$meterAkhir','$pemakaian',CURRENT_DATE(),CURRENT_TIME(),'$kodeTarif','$tagihan','0')");

                  // cek apakah data berhasil terupload 
                  if (mysqli_affected_rows($koneksi) > 0) {
                    echo "<div class=\"alert alert-success alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Berhasil Masuk!</strong> Meter Air dengan berhasil ditambahkan.
                    </div>";
                  } else {
                    echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Data Gagal Masuk!</strong> Mohon maaf data yang anda gagal ditambahkan.
                    </div>';
                  }
                }
                break;

              // tombol user diedit 
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

              // tarif diedit 
              case 'tarif_edit':
                $kodeTarif = $_POST['kodeTarif'];
                $tarif = $_POST['tarif'];
                $statusTarif = isset($_POST['statusTarif']) ? '1' : 0;
                $tipeTarif = $_POST['tipeTarif'];

                // upload data 
                mysqli_query($koneksi, "UPDATE tarif SET kodeTarif='$kodeTarif',tarif='$tarif',status='$statusTarif',tipe='$tipeTarif' WHERE kodeTarif='$kodeTarif'");

                if (mysqli_affected_rows($koneksi) > 0) {
                  echo "<div class=\"alert alert-success alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Berhasil Diedit!</strong> Tarih telah berubah.
                    </div>";
                } else {
                  echo '<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Data Tidak Dirubah</strong> Mohon maaf anda tidak mengedit user.
                    </div>';
                }
                break;

              // meter diedit 
              case 'meter_edit':
                // ambil data 
                $nomorMeter = $_POST['wargaMeter'];
                $meterAwal = $_POST['meterAwal'];
                $meterAkhir = $_POST['meterAkhir'];
                $statusMeter = isset($_POST['status']) ? $_POST['status'] : 'null';
                $userWarga = $air->nomorPemakainkeUsername($nomorMeter);
                $kodeTarif = $air->ambilKodeTarifDarIUsername($userWarga);
                $tarif = $air->ambilTarif($kodeTarif);
                $pemakaian = $meterAkhir - $meterAwal;
                $tagihan = $tarif * $pemakaian;


                // cek apakah nilai meter akhir lebih besar atau tidak 
                if ($pemakaian < 0) {
                  echo '<div class="alert alert-danger alert-dismissible dataSama">
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  <strong>Data Masukan Salah!</strong> Mohon maaf data meter awal lebih besar daripada meter akhir.
                  </div>';
                } else {

                  // cek apakah bendahara atau admin
                  if ($data_user[2] !== 'petugas') {

                    // update data 
                    mysqli_query($koneksi, "UPDATE pemakaian SET meterAwal='$meterAwal',meterAkhir='$meterAkhir',pemakaian='$pemakaian',tagihan=$tagihan,status='$statusMeter' WHERE no='$nomorMeter'");

                    // cek apakah data berhasil terupload 
                    if (mysqli_affected_rows($koneksi) > 0) {
                      echo "<div class=\"alert alert-success alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Berhasil Masuk!</strong> Meter Air dengan berhasil ditambahkan.
                    </div>";
                    } else {
                      echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Data Gagal Masuk!</strong> Mohon maaf data yang anda gagal ditambahkan.
                    </div>';
                    }
                  } else {

                    // update data 
                    mysqli_query($koneksi, "UPDATE pemakaian SET meterAwal='$meterAwal',meterAkhir='$meterAkhir',pemakaian='$pemakaian',tgl=CURRENT_DATE(),waktu=CURRENT_TIME(),tagihan=$tagihan WHERE no='$nomorMeter'");

                    // cek apakah data berhasil terupload 
                    if (mysqli_affected_rows($koneksi) > 0) {
                      echo "<div class=\"alert alert-success alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Berhasil Masuk!</strong> Meter Air dengan berhasil ditambahkan.
                    </div>";
                    } else {
                      echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Data Gagal Masuk!</strong> Mohon maaf data yang anda gagal ditambahkan.
                    </div>';
                    }
                  }
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
              case 'tarif_hapus':
                // hapus user
                $kode = $_POST['tarif'];
                mysqli_query($koneksi, "DELETE FROM tarif WHERE kodeTarif='$kode'");

                // cek apakah user berhasil dihapus 
                if (mysqli_affected_rows($koneksi) > 0) {
                  echo "<div class=\"alert alert-success alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Berhasil Dihapus!</strong> Data dengan kode tarif $kode berhasil dihapus.
                    </div>";
                } else {
                  echo "<div class=\"alert alert-warning alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Gagal Dihapus</strong> Data dengan kode tarif $kode gagal dihapus.
                    </div>";
                }
                break;
              case 'meter_hapus':
                // hapus user
                $kode = $_POST['meter'];
                mysqli_query($koneksi, "DELETE FROM pemakaian WHERE no='$kode'");

                // cek apakah user berhasil dihapus 
                if (mysqli_affected_rows($koneksi) > 0) {
                  echo "<div class=\"alert alert-success alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Berhasil Dihapus!</strong> Data meter anda berhasil dihapus.
                    </div>";
                } else {
                  echo "<div class=\"alert alert-warning alert-dismissible\">
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    <strong>Data Gagal Dihapus</strong> Data meter anda gagal dihapus.
                    </div>";
                }
                break;
              default:
                break;
            }
          } else if (isset($_GET['page'])) {

            // memberikan variabel sesuai halaman 
            $p = $_GET['page'];
            switch ($p) {
              case 'user_edit':
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
                break;
              case 'tarif_edit':
                // ambil data ke database 
                $kode = $_GET['kode'];
                $q = mysqli_query($koneksi, "SELECT * FROM tarif WHERE kodeTarif='$kode'");
                $d = mysqli_fetch_row($q);

                // jadikan variabel 
                $kodeTarif = $d[0];
                $tipeTarif = $d[1];
                $tarif = $d[2];
                $statusTarif = $d[3];
                break;
              case 'meter_edit':
                $nomorMeter = $_GET['meter'];
                $q = mysqli_query($koneksi, "SELECT username,meterAwal,meterAkhir,status FROM pemakaian WHERE no='$nomorMeter'");
                $d = mysqli_fetch_row($q);
                $namaWarga = $d[0];
                $meterAwal = $d[1];
                $meterAkhir = $d[2];
                $statusMeter = $d[3];
                break;
              case 'managemen-tarif':
                $statusTarif = '';
                break;
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
                    $tipeArray = ['rumah', 'kos'];
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
              <form method="post" class="need-validation" id="tarif_form" action="dashboard.php?page=managemen-tarif">
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
                  <input type="number" value="<?php echo isset($tarif) ? $tarif : ''; ?>" class="form-control" id="tarif" placeholder="0" name="tarif">
                </div>

                <div class="form-check form-switch">
                  <input class="form-check-input" value="aktif" type="checkbox" id="mySwitch" name="statusTarif" <?php if ($statusTarif == 1) echo 'checked' ?>>
                  <label class="form-check-label" for="mySwitch">Aktif</label>
                </div>

                <button type="submit" class="btn btn-primary mt-3" name="tombol" value="tarif_add">Simpan Data</button>
                <a href="dashboard.php?page=managemen-tarif"><button type="button" class="btn btn-danger mt-3" id="batalTambahTarif">Batal Tambah</button></a>
              </form>
            </div>
          </div>

          <div class="card mb-4" id="tambahMeter">
            <div class="card-header">
              <i class="fa-solid fa-otter"></i>
              Tambah Meter Baru
            </div>
            <div class="card-body">
              <form method="post" class="need-validation" id="meter_form" action="dashboard.php?page=catat-meter">
                <div class=" mb-3 mt-3">
                  <label for="wargaMeter" class="form-label">Tipe Tarif</label>
                  <select class="form-control" name="wargaMeter" id="wargaMeter">
                    <option value="">Pilih Warga</option>
                    <?php
                    $qw = mysqli_query($koneksi, "SELECT username,nama FROM user WHERE level='warga'");
                    while ($dw = mysqli_fetch_row($qw)) {
                      $sel = ($namaWarga == $dw[0]) ? 'SELECTED' : '';
                      echo "<option value=\"$dw[0]\" $sel>$dw[1]</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class=" mb-3 mt-3">
                  <label for="meterAwal" class="form-label">Meter Awal (m<sup>3</sup>)</label>
                  <input type="text" value="<?php echo $meterAwal ?>" class="form-control" id="meterAwal" placeholder="Masukan Meter Awal" name="meterAwal">
                </div>

                <div class=" mb-3 mt-3">
                  <label for="meterAkhir" class="form-label">Meter Akhir (m<sup>3</sup>)</label>
                  <input type="text" value="<?php echo $meterAkhir ?>" class="form-control" id="meterAkhir" placeholder="Masukan Meter Akhir" name="meterAkhir">
                </div>
                <?php

                // penambahan lunas jika user bendahara atau admin 
                if ($data_user[2] !== 'petugas') {
                  $meterArray = ['1', '0',];
                  foreach ($meterArray as $mt) {

                    if (isset($statusMeter)) $sel = ($mt == $statusMeter) ? "checked" : "";
                    else $sel = '';

                    $status = ($mt == '1') ? 'Lunas' : 'Belum Lunas';
                    echo "<div class=\"form-check\">
                        <input type=\"radio\" class=\"form-check-input\" id=\"radioMeter$mt\" name=\"status\" value=\"$mt\" $sel>$status
                        <label class=\"form-check-label\" for=\"radioMeter$mt\"></label>
                        </div>";
                  }
                }
                ?>

                <button type="submit" class="btn btn-primary mt-3" name="tombol" value="meter_add">Simpan Data</button>
                <a href="dashboard.php?page=catat-meter"><button type="button" class="btn btn-danger mt-3" id="batalTambahMeter">Batal Tambah</button></a>
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
                    <button type=\"button\" class=\"btn btn-outline-danger tombolHapusUser\" data-bs-toggle=\"modal\" data-bs-target=\"#myModal\" data-user='$user'>Hapus</button>
                    </td>
                  </tr>";
                  }
                  ?>

                  </tbody>
              </table>
            </div>
          </div>

          <!-- tabel tarif  -->
          <div class="card mb-4" id="tabelTarif">
            <div class="card-header">
              <i class="fa-solid fa-address-book"></i>
              Tabel Tarif
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
                  </tr>
                </thead>
                <a>
                  <?php
                  $q = mysqli_query($koneksi, "SELECT * FROM tarif ORDER BY kodeTarif ASC");
                  while ($d = mysqli_fetch_row($q)) {
                    $kodeTarif = $d[0];
                    $tipeTarif = $d[1];
                    $tarif = $d[2];
                    $statusTarif = $d[3] == 1 ? 'aktif' : 'tidak aktif';

                    echo "<tr>
                    <td>$kodeTarif</td>
                    <td>$tipeTarif</td>
                    <td>$tarif</td>
                    <td>$statusTarif</td>
                    <td>
                    <a href=\"dashboard.php?page=tarif_edit&kode=$kodeTarif\"><button type=\"button\" class=\"btn btn-outline-success\">Edit</button></a>
                    <button type=\"button\" class=\"btn btn-outline-danger tombolHapusTarif\" data-bs-toggle=\"modal\" data-bs-target=\"#myModal\" data-tarif='$kodeTarif'>Hapus</button>
                    </td>
                  </tr>";
                  }
                  ?>

                  </tbody>
              </table>
            </div>
          </div>

          <!-- tabel meter  -->
          <div class="card mb-4" id="tabelMeter">
            <div class="card-header">
              <i class="fa-solid fa-industry"></i>
              Tabel Meter
            </div>
            <div class="card-body">
              <table id="datatablesSimple3">
                <thead>
                  <tr>
                    <th>Nama Warga</th>
                    <th>Tipe</th>
                    <th>Tanggal & Waktu</th>
                    <th>Meter Awal</th>
                    <th>Meter Akhir</th>
                    <th>Pemakaian</th>
                    <?php
                    // menambahkan tagihan dan modifikasi jika bendahara 
                    if ($data_user[2] !== 'petugas') {
                      echo "<th>Tagihan</th>
                            <th>Status</th>";
                    }
                    ?>
                    <th>Modifikasi</th>
                  </tr>
                </thead>
                <a>
                  <?php
                  $q = mysqli_query($koneksi, "SELECT * FROM pemakaian ORDER BY tgl ASC, username ASC");
                  while ($d = mysqli_fetch_row($q)) {
                    $nomorMeter = $d[0];
                    $tipeMeter = $air->ambilTipedariKodeTarif($d[7]);
                    $userMeter = $air->data_user($d[1]);
                    $namaWarga = $userMeter[0];
                    $meterAwal = $d[2];
                    $meterAkhir = $d[3];
                    $pemakaianMeter = $d[4];
                    $tanggalMeter = formatTanggalIndo($d[5]);
                    $tanggalSekarang = formatTanggalIndo(date('Y-m-d'));
                    $waktuMeter = $d[6];
                    $tagihanMeter = $d[8];
                    $statusMeter = $d[9] == 0 ? 'Belum Lunas' : 'Lunas';
                    $diff = date_diff(date_create($d[5]), date_create())->days;
                    $selisih = ($diff == 0) ? '(Hari ini)' : "$diff hari";
                    $rupiah = "Rp " . number_format($tagihanMeter, 0, ',', '.');

                    echo "<tr>
                    <td>$namaWarga --> $selisih</td>
                    <td>$tipeMeter</td>
                    <td>$tanggalMeter $waktuMeter | $tanggalSekarang $selisih </td>
                    <td>$meterAwal</td>
                    <td>$meterAkhir</td>
                    <td>$pemakaianMeter</td>";

                    // menambahkan pemakaian dan status pada bendahara 
                    if ($data_user[2] !== 'petugas') {
                      echo "<td>$rupiah</td>";
                      echo  $d[9] == '0' ? "<td><span class='text-danger'>$statusMeter</span></td>" : "<td><span class='text-success'>$statusMeter</span></td>";
                    }

                    // menentukan tombol modifikasi ada atau tidak 
                    switch ($data_user[2]) {
                      case 'petugas':
                        if ($diff > 30) {
                          echo "<td></td>";
                        } else {
                          echo "<td>
                      <a href=\"dashboard.php?page=meter_edit&meter=$nomorMeter\"><button type=\"button\" class=\"btn btn-outline-success mb-2\">Edit</button></a>
                      <button type=\"button\" class=\"btn btn-outline-danger tombolHapusMeter mb-2\" data-bs-toggle=\"modal\" data-bs-target=\"#myModal\" no-meter='$nomorMeter'>Hapus</button>
                      </td>
                      </tr>";
                        }
                        break;
                      default:
                        echo "<td>
                      <a href=\"dashboard.php?page=meter_edit&meter=$nomorMeter\"><button type=\"button\" class=\"btn btn-outline-success mb-2\">Edit</button></a>
                      <button type=\"button\" class=\"btn btn-outline-danger tombolHapusMeter mb-2\" data-bs-toggle=\"modal\" data-bs-target=\"#myModal\" no-meter='$nomorMeter'>Hapus</button>
                      </td>
                      </tr>";;
                    }
                  }
                  ?>

                  </tbody>
              </table>
            </div>
          </div>

          <!-- tabel warga -->
          <div class="card mb-4" id="tabelWarga">
            <div class="card-header">
              <i class="fa-solid fa-industry"></i>
              Tabel Meter
            </div>
            <div class="card-body">
              <table id="datatablesSimple4">
                <thead>
                  <tr>
                    <th>Waktu Pencatatan Meter</th>
                    <th>Kode Tarif</th>
                    <th>Meter Awal (m<sup>3</sup>)</th>
                    <th>Meter Akhir (m<sup>3</sup>)</th>
                    <th>Pemakaian</th>
                    <th>Tagihan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <a>
                  <?php
                  $userWarga = $_SESSION['user'];
                  $q = mysqli_query($koneksi, "SELECT * FROM pemakaian WHERE username = '$userWarga' ORDER BY tgl DESC;");
                  while ($d = mysqli_fetch_row($q)) {
                    $tanggalMeter = formatTanggalIndo($d[5]);
                    $waktuMeter = $d[6];
                    $kodeTarif = $d[7];
                    $meterAwal = $d[2];
                    $meterAkhir = $d[3];
                    $pemakaianMeter = $d[4];
                    $tagihanMeter = $d[8];
                    $rupiah = "Rp " . number_format($tagihanMeter, 0, ',', '.') . ",-";
                    $statusMeter = $d[9] == 0 ? 'Belum Lunas' : 'Lunas';

                    echo "<tr>
                    <td>$tanggalMeter $waktuMeter </td>
                    <td>$kodeTarif</td>
                    <td>$meterAwal</td>
                    <td>$meterAkhir</td>
                    <td>$pemakaianMeter</td>
                    <td>$tagihanMeter</td>";
                    echo  $d[9] == '0' ? "<td><span class='text-danger'>$statusMeter</span></td>" : "<td><span class='text-success'>$statusMeter</span></td>";
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
  <script src="../js/jquery-3.7.1.js"></script>
  <script src="../js/air.js"></script>

  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
    crossorigin="anonymous"></script>
  <script src="../assets/demo/chart-area-demo.js"></script>
  <script src="../assets/demo/chart-bar-demo.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
  <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>