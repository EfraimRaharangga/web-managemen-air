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
