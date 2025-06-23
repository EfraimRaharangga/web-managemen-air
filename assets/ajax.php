<?php

include 'funcions.php';
$air = new Air;
$koneksi = $air->koneksi();
// cek data post yang masuk 
if (isset($_POST['page'])) {
    $page = $_POST['page'];
    $username = $_POST['username'];
    $level = $_POST['level'];

    switch ($page) {
        // memilih halaman ringkasan 
        case 'summary':
            $bulan = $_POST['time'];
            $data = ['level' => $level];

            // memilih berdasarkan level 
            switch ($level) {

                // menampilkan data petugas / admin
                case 'petugas':
                case 'admin':

                    // ambil dari jumlah pelanggan 
                    $q1 = mysqli_query($koneksi, "SELECT COUNT(username) as jumlahPelanggan FROM user WHERE level='warga'");
                    $d1 = mysqli_fetch_assoc($q1);
                    $data['jumlahPelanggan'] = $d1['jumlahPelanggan'];

                    // ambil dari pemakaian 
                    $q2 = mysqli_query($koneksi, "SELECT SUM(pemakaian) as jumlahPemakaian FROM pemakaian WHERE tgl LIKE '$bulan%'");
                    $d2 = mysqli_fetch_assoc($q2);
                    $data['jumlahPemakaian'] = $d2['jumlahPemakaian'];

                    // ambil dari pelanggan sudah dicarat 
                    $q2 = mysqli_query($koneksi, "SELECT COUNT(username) as dataSudahDicatat FROM pemakaian WHERE tgl LIKE '$bulan%'");
                    $d2 = mysqli_fetch_assoc($q2);
                    $data['dataSudahDicatat'] = $d2['dataSudahDicatat'];

                    echo json_encode($data);
                    break;

                // menampilkan data bendahara
                case 'bendahara':

                    // ambil dari jumlah pelanggan 
                    $q1 = mysqli_query($koneksi, "SELECT COUNT(username) as jumlahPelanggan FROM user WHERE level='warga'");
                    $d1 = mysqli_fetch_assoc($q1);
                    $data['jumlahPelanggan'] = $d1['jumlahPelanggan'];

                    // ambil dari pemasukan
                    $q2 = mysqli_query($koneksi, "SELECT SUM(tagihan) as pemasukan FROM pemakaian WHERE tgl LIKE '$bulan%' AND status='1'");
                    $d2 = mysqli_fetch_assoc($q2);
                    $data['pemasukan'] = $d2['pemasukan'];

                    // ambil dari pelanggan sudah lunas 
                    $q3 = mysqli_query($koneksi, "SELECT COUNT(username) as pelangganLunas FROM pemakaian WHERE tgl LIKE '$bulan%' AND status='1'");
                    $d3 = mysqli_fetch_assoc($q3);
                    $data['pelangganLunas'] = $d3['pelangganLunas'];

                    echo json_encode($data);
                    break;
                case 'warga':
                    $username = $_POST['username'];

                    // ambil data 
                    $q1 = mysqli_query($koneksi, "SELECT tgl,pemakaian,tagihan,status,waktu FROM pemakaian WHERE tgl LIKE '$bulan%' AND username='$username'");
                    $d1 = mysqli_fetch_array($q1);
                    if (isset($d1)) {

                        $data['status'] = 'berhasil';
                        $data['tanggalPencatatan'] = $d1[0];
                        $data['waktuPencatatan'] = $d1[4];
                        $data['pemakaianWarga'] = $d1[1];
                        $data['tagihanWarga'] = $d1[2];
                        $data['statusTagihan'] = $d1[3];
                    } else {
                        $data['status'] = 'gagal';
                    }

                    echo json_encode($data);
                    break;
            }
            break;

        case 'grafik':
            $response = [];
            switch ($level) {
                case 'bendahara':
                case 'admin':
                    $response[] = panggilDatabase('totalPemakaian', $koneksi, $username);
                    $response[] = panggilDatabase('pie', $koneksi, $username);
                    $response[] = panggilDatabase('totalTagihan', $koneksi, $username);
                    $response[] = panggilDatabase('totalPemasukan', $koneksi, $username);
                    $response[] = panggilDatabase('totalWargaTercatat', $koneksi, $username);
                    $response[] = panggilDatabase('totalWargaBelumTercatat', $koneksi, $username);
                    $response[] = panggilDatabase('totalWargaLunas', $koneksi, $username);
                    $response[] = panggilDatabase('totalWargaBelumLunas', $koneksi, $username);

                    echo json_encode($response);
                    break;
                case 'warga':
                    $response[] = panggilDatabase('pemakaianWarga', $koneksi, $username);
                    $response[] = panggilDatabase('tagihanWarga', $koneksi, $username);
                    echo json_encode($response);
                    break;
                case 'petugas':
                    $response[] = panggilDatabase('totalPemakaian', $koneksi, $username);
                    $response[] = panggilDatabase('pie', $koneksi, $username);
                    $response[] = panggilDatabase('totalWargaTercatat', $koneksi, $username);
                    $response[] = panggilDatabase('totalWargaBelumTercatat', $koneksi, $username);
                    echo json_encode($response);

                default:
                    # code...
                    break;
            }
            break;

        default:
            echo json_encode('testing');
            break;
    }
}
