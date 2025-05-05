<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile Kami</title>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Ganti warna background di sini */
            background-color: #e3f2fd;
            /* Misal: biru muda */
            position: relative;
            margin: 0;
            padding: 20px;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
        }

        .card {
            width: 18rem;
            margin: 10px;
        }
    </style>
</head>

<body>

    <!-- Tombol Kembali di pojok kiri atas -->
    <a href="../index.php" class="btn btn-primary back-button">← Kembali</a>

    <!-- Container untuk card-card -->
    <div class="d-flex flex-wrap justify-content-center">
        <!-- Card 1 -->
        <div class="card" style="width:400px">
            <img class="card-img-top" src="../assets/img/aim.jpeg" alt="Card image">
            <div class="card-body">
                <span class="card-title">
                    <h4>Efraim Raharangga</h4>
                    <h6>4.31.23.2.06</h6>
                </span>
                <p class="card-text">Berasal Dari SMK Negeri 7 Semarang Jurusan Sistem Informatika Jaringan dan Aplikasi</p>
                <button type="button" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary" id="aim">Lihat Foto</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card" style="width:400px">
            <img class="card-img-top" src="../assets/img/yogi.jpg" alt="Card image">
            <div class="card-body">
                <span class="card-title">
                    <h4>Yogi Makmur A</h4>
                    <h6>4.31.23.2.23</h6>
                </span>
                <p class="card-text">Berasal dari SMA Negeri 1 Lasem Jurusan Ilmu Pengetahuan Sosial</p>
                <button type="button" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary" id="yogi">Lihat Foto</button>
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Bootstrap JS (optional) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../js/jquery-3.7.1.js"></script>
        <script src="../js/profil.js"></script>
</body>

</html>