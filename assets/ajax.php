<?php

include 'funcions.php';
$air = new Air;
$koneksi = $air->koneksi();
// cek data post yang masuk 
if (isset($_POST['page'])) {
    $page = $_POST['page'];
    $username = $_POST['username'];

    switch ($page) {
        // memilih halaman ringkasan 
        case 'summary':
            $level = $_POST['level'];
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

        case 'pemakaianWarga':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, pemakaian FROM pemakaian WHERE username='$username'");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['pemakaian'];
            }

            echo json_encode($response);
            break;
        case 'totalTagihan':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, tagihan FROM pemakaian  ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['tagihan'];
            }
            echo json_encode($response);
            break;

        case 'totalWargaTercatat':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, COUNT(username) as dataSudahDicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['dataSudahDicatat'];
            }
            echo json_encode($response);
            break;

        case 'totalWargaBelumTercatat':
            $q1 = mysqli_query($koneksi, "SELECT COUNT(username) as jumlahPelanggan FROM user WHERE level='warga'");
            $d1 = mysqli_fetch_row($q1);

            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, COUNT(username) as dataSudahDicatat FROM pemakaian GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d1[0] - $d['dataSudahDicatat'];
            }
            echo json_encode($response);
            break;

        case 'totalWargaLunas':
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, COUNT(username) as dataSudahLunas FROM pemakaian WHERE status='1' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d['dataSudahLunas'];
            }
            echo json_encode($response);
            break;
        case 'totalWargaBelumLunas':
            $q1 = mysqli_query($koneksi, "SELECT COUNT(username) as jumlahPelanggan FROM user WHERE level='warga'");
            $d1 = mysqli_fetch_row($q1);

            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, COUNT(username) as dataSudahLunas FROM pemakaian WHERE status='1' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $response[] = $bulanIndonesia[$d['bulan'] - 1];
                $response[] = $d1[0] - $d['dataSudahLunas'];
            }
            echo json_encode($response);
            break;

        case 'totalPemakaian':
            $data = [];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, pemakaian FROM pemakaian ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $data[] = $bulanIndonesia[$d['bulan'] - 1];
                $data[] = $d['pemakaian'];
            }
            echo json_encode($data);
            break;
        case 'totalPemasukan':
            $data = [];
            $q = mysqli_query($koneksi, "SELECT MONTH(tgl) as bulan, SUM(tagihan) AS total_tagihan_lunas FROM pemakaian WHERE status='1' GROUP BY MONTH(tgl) ORDER BY MONTH(tgl) ASC");
            while ($d = mysqli_fetch_assoc($q)) {
                $data[] = $bulanIndonesia[$d['bulan'] - 1];
                $data[] = $d['total_tagihan_lunas'];
            }
            echo json_encode($data);
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
            echo json_encode($response);
            break;

        case 'pie':
            $q = mysqli_query($koneksi, "SELECT SUM(CASE WHEN tipe = 'kos' THEN 1 ELSE 0 END), SUM(CASE WHEN tipe = 'rumah' THEN 1 ELSE 0 END) FROM user");
            $d = mysqli_fetch_row($q);
            $data = $d;
            echo json_encode($data);
            break;

        default:
            echo json_encode('testing');
            break;
    }
}
