<?php

class Air
{
    function koneksi()
    {
        $koneksi = mysqli_connect("localhost", "userAir", "#Us3r_A1r_2025#", "air");
        return $koneksi;
    }

    function data_user($sesi_user)
    {
        $q = mysqli_query($this->koneksi(), "SELECT nama,kota,level FROM user WHERE username ='$sesi_user'");
        $d = mysqli_fetch_row($q);
        return $d;
    }
}

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
