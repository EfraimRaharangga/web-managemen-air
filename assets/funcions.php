<?php

class Air
{
    function koneksi()
    {
        $koneksi = mysqli_connect("localhost", "root", "", "air");
        return $koneksi;
    }

    function data_user($sesi_user)
    {
        $q = mysqli_query($this->koneksi(), "SELECT nama,kota,level,username FROM user WHERE username ='$sesi_user'");
        $d = mysqli_fetch_row($q);
        return $d;
    }

    function ambilTipedariKodeTarif($kodeTarif)
    {
        $q = mysqli_query($this->koneksi(), "SELECT tipe FROM tarif WHERE kodeTarif ='$kodeTarif' AND status = 1");
        $d = mysqli_fetch_row($q);
        return $d[0];
    }

    function ambilKodeTarifDariUsername($username)
    {
        $q = mysqli_query($this->koneksi(), "SELECT tipe FROM user WHERE username ='$username'");
        $d = mysqli_fetch_row($q);

        return $this->ambiKodeTarifTipe($d[0]);
    }
    function ambiKodeTarifTipe($tipe)
    {
        $q = mysqli_query($this->koneksi(), "SELECT kodeTarif FROM tarif WHERE tipe ='$tipe' AND status = 1");
        $d = mysqli_fetch_row($q);
        return $d[0];
    }

    function ambilTarif($kodeTarif)
    {
        $q = mysqli_query($this->koneksi(), "SELECT tarif FROM tarif WHERE kodeTarif ='$kodeTarif' AND status = 1");
        $d = mysqli_fetch_row($q);
        return $d[0];
    }

    function nomorPemakainkeUsername($nomorMeter)
    {
        $q = mysqli_query($this->koneksi(), "SELECT username FROM pemakaian WHERE no='$nomorMeter'");
        $d = mysqli_fetch_row($q);
        return $d[0];
    }
}

$bulanIndonesia = [
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];

function navLink($title, $get)
{
    $link = "dashboard.php?page=$get";
    $isGreen  = (isset($_GET['page']) && $_GET['page'] == $get) ? 'text-success' : '';
    $isBounce = (isset($_GET['page']) && $_GET['page'] == $get) ? 'fa-bounce' : '';
    if ($get == 'main') {
        $isGreen  = (!isset($_GET['page'])) ? 'text-success' : '';
        $isBounce = (!isset($_GET['page'])) ? 'fa-bounce' : '';
        $link = "dashboard.php";
    }
    return "<a class=\"nav-link $isGreen\" href=\"$link\">
                <div class=\"sb-nav-link-icon\">
                  <i class=\"fas fa-tachometer-alt $isGreen $isBounce\"></i>
                </div>
                $title
              </a>";
}

function formatTanggalIndo($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $tgl = date('j', strtotime($tanggal));
    $bln = date('n', strtotime($tanggal));
    $thn = date('Y', strtotime($tanggal));
    return $tgl . ' ' . $bulan[$bln] . ' ' . $thn;
}

function panggilDatabase($page, $koneksi, $username)
{
    $bulanIndonesia = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $response = [];

    switch ($page) {
        case 'pemakaianWarga':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, pemakaian FROM pemakaian WHERE username='$username'");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['pemakaian'];
            }

            break;
        case 'totalTagihan':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, tagihan FROM pemakaian  ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['tagihan'];
            }
            break;

        case 'totalWargaTercatat':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, COUNT(username) as dataSudahDicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['dataSudahDicatat'];
            }
            break;

        case 'totalWargaBelumTercatat':
            $q1 = mysqli_query($koneksi, "SELECT COUNT(username) as jumlahPelanggan FROM user WHERE level='warga'");
            $d1 = mysqli_fetch_row($q1);

            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, COUNT(username) as dataSudahDicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d1[0] - $d['dataSudahDicatat'];
            }
            break;

        case 'totalWargaLunas':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, COUNT(username) as dataSudahLunas FROM pemakaian WHERE status='1' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['dataSudahLunas'];
            }
            break;
        case 'totalWargaBelumLunas':
            $q1 = mysqli_query($koneksi, "SELECT COUNT(username) as jumlahPelanggan FROM user WHERE level='warga'");
            $d1 = mysqli_fetch_row($q1);

            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, COUNT(username) as dataSudahLunas FROM pemakaian WHERE status='1' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d1[0] - $d['dataSudahLunas'];
            }
            break;

        case 'totalPemakaian':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, pemakaian FROM pemakaian ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['pemakaian'];
            }
            break;
        case 'totalPemasukan':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, SUM(tagihan) AS total_tagihan_lunas FROM pemakaian WHERE status='1' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['total_tagihan_lunas'];
            }
            break;
        case 'tagihanWarga':
            $q2 = mysqli_query($koneksi, "SELECT SUM(tagihan) as pemasukan FROM pemakaian WHERE username='$username' AND status='0'");
            $d2 = mysqli_fetch_row($q2);
            $response[] = $d2[0];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, tagihan FROM pemakaian WHERE username='$username'");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['tagihan'];
            }
            break;

        case 'pie':
            $q = mysqli_query($koneksi, "SELECT SUM(CASE WHEN tipe = 'kos' THEN 1 ELSE 0 END), SUM(CASE WHEN tipe = 'rumah' THEN 1 ELSE 0 END) FROM user");
            $d = mysqli_fetch_row($q);
            $response[] = $d;
            break;
        default:
            # code...
            break;
    }
    return $response;
}
