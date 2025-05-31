import * as myFunc from "./function.js";

$(document).ready(function () {
  let level = $("#inputLevelDashboard").val();
  let username = $("#inputUsernameDashboard").val();
  let bulanSekarang = $("#selectorTanggal option:selected").val();

  // mangambil data untuk summary
  myFunc.fetchDatawithPost(bulanSekarang, level, username);

  // variabel get
  let url = window.location.href;
  let get = url.split("=");

  // menghilangkan semua isi
  $(
    "#summary, #pilihWaktu, #grafik, #tambahUser,#tabelUser, #tabelTarif, #tambahTarif, #tabelMeter, #tambahMeter,#tabelWarga,#tambahWarga"
  ).hide();

  // switch untuk menu sebelah kiri
  switch (get[1]) {
    case "user_edit&user":
    case "managemen-user":
      // tampilkan tabel user & tombol tambah user
      $("#tabelUser").show();
      $(".datatable-dropdown").append(
        '<button type="button" class="btn btn-outline-success float-start me-2" id="new-user"><i class="fa-solid fa-user-plus"></i> User</button>'
      );

      // ketika page berubah jadi user_edit tabel juga berubah
      if (get[1] == "user_edit&user") {
        $("#tambahUser").show();
        $("#tabelUser").hide();
        $("#tambahUser .card-header").html(
          '<i class="fas fa-users me-1"></i> Edit User'
        );
        $("#user_form button").val("user_edit");
        $("#user_form input[name='username']").attr("disabled", true);
        $("#user_form").append(
          `<input type="hidden" name="username" value=${get[2]} ></input>`
        );
      }

      // menampilkan tabel user baru
      $("#new-user").click(function (e) {
        $("#tambahUser").show();
        $("#tabelUser").hide();
        $("#user_form input, #user_form text_area").show();
        $("#tambahUser input,#tambahUser textarea").val("");
      });

      // mengaktifkan fungsi batal tambah
      $("#batalTambah").click(function (e) {
        $("#tambahUser").hide();
        $("#tabelUser").show();
      });

      // modal untuk konfirmasi hapus
      $(".tombolHapusUser").click(function (e) {
        let user = $(this).attr("data-user");
        $("#myModal .modal-body").text(
          `Yakin menghapus data dengan username ${user}`
        );
        $(".modal-footer form").append(
          `<input type="hidden" name="user" value="${user}"> `
        );
      });
      break;
    case "ubah-datameter-warga":
      $("#grafik").show();
      break;

    case "lihat-pemakaian-warga":
    case "pemakaian-warga":
    case "meter_edit&meter":
    case "catat-meter":
      // munculkan tabel dan tombol tambah
      $("#tabelMeter").show();
      if (get[1] !== "pemakaian-warga") {
        $("#tabelMeter .card-body a")
          .first()
          .append(
            '<button type="button" class="btn btn-outline-success float-start me-2" id="new-meter"><i class="fa-solid fa-otter"></i> Meter </button>'
          );
      }

      // tambahkan tabel
      const datatablesSimple3 = document.getElementById("datatablesSimple3");
      if (datatablesSimple3) {
        new simpleDatatables.DataTable(datatablesSimple3);
      }

      // ketika page berubah jadi meter_edit tabel juga berubah
      if (get[1] == "meter_edit&meter") {
        $("#tambahMeter").show();
        $("#tabelMeter").hide();
        $("#tambahMeter .card-header").html(
          '<i class="fa-solid fa-water"></i> Edit Meter'
        );
        $("#meter_form button").val("meter_edit");
        $("#wargaMeter").attr("disabled", true);
        $("#meter_form").append(
          `<input type="hidden" name="wargaMeter" value=${get[2]} ></input>`
        );
      }

      // merubah value tombol hapus
      $(".modal-footer form button").click(function () {
        $(this).attr("value", "meter_hapus");
      });

      // modal untuk konfirmasi hapus
      $(".tombolHapusMeter").click(function (e) {
        let nomorMeter = $(this).attr("no-meter");
        $("#myModal .modal-body").text(`Yakin menghapus Data ini ?`);
        $(".modal-footer form").append(
          `<input type="hidden" name="meter" value="${nomorMeter}"> `
        );
      });

      // menambahkan meter
      $("#new-meter").click(function (e) {
        $("#tambahMeter").show();
        $("#tabelMeter").hide();
        $('#tambahMeter input[type="text"]').val("");
      });

      // tahan di halaman utama ketika meter terlalu kecil
      if ($(".dataSama").hasClass(".dataSama")) {
        $("#tabelMeter").hide();
        $("#tambahMeter").show();
      }
      break;
    case "tarif_edit&kode":
    case "managemen-tarif":
      // menampilkan tabel tarif
      $("#tabelTarif").show();
      $("#tabelTarif .card-body a")
        .first()
        .append(
          '<button type="button" class="btn btn-outline-success float-start me-2" id="new-tarif"><i class="fa-solid fa-hippo"></i> Tarif </button>'
        );

      // tambahkan tabel
      const datatablesSimple2 = document.getElementById("datatablesSimple2");
      if (datatablesSimple2) {
        new simpleDatatables.DataTable(datatablesSimple2);
      }

      // if untuk edit tabel
      if (get[1] == "tarif_edit&kode") {
        $("#tambahTarif").show();
        $("#tabelTarif").hide();
        $("#tarif_form button").val("tarif_edit");
        $("#tarif_form input[name='kodeTarif']").attr("disabled", true);
        $("#tarif_form").append(
          `<input type="hidden" name="kodeTarif" value=${get[2]} ></input>`
        );
      }

      // menambahkan tarif
      $("#new-tarif").click(function (e) {
        $("#tambahTarif").show();
        $("#tabelTarif").hide();
        $("#user_form input, #user_form text_area").show();
        $("#tambahTarif input").val("");
      });

      // batal tambah
      $("#batalTambahTarif").click(function (e) {
        $("#tambahUser").hide();
        $("#tabelUser").show();
      });

      // merubah value tombol hapus
      $(".modal-footer form button").click(function () {
        // over
        $(this).attr("value", "tarif_hapus");
      });

      // modal untuk konfirmasi hapus
      $(".tombolHapusTarif").click(function (e) {
        let kodeTarif = $(this).attr("data-tarif");
        $("#myModal .modal-body").text(
          `Yakin menghapus Data dengan kode tarif ${kodeTarif}`
        );
        $(".modal-footer form").append(
          `<input type="hidden" name="tarif" value="${kodeTarif}"> `
        );
      });

      break;
    case "pemakaian-anda":
      // munculkan tabel dan tombol tambah
      $("#tabelWarga").show();

      // tambahkan tabel
      const datatablesSimple4 = document.getElementById("datatablesSimple4");
      if (datatablesSimple4) {
        new simpleDatatables.DataTable(datatablesSimple4);
      }
      $(".datatable-empty").html("Anda belum memiliki tagihan apapun");
      break;
    default:
      // tampilkan data summary
      $("#summary, #pilihWaktu,#grafik").show();

      // mengganti berdasarkan level
      switch (level) {
        case "bendahara":
          // ganti summary
          $(".tabKuningDashboard ~ div").text("Rp");
          $(".penjelasanKuning").text("Pemasukan");
          $(".penjelasanHijau").text("Sudah Lunas");
          $(".penjelasanMerah").text("Belum Lunas");

          // ganti tabel
          myFunc.fetchGrafikGaris(username, "totalPemakaian", "myChart");
          myFunc.fetchGrafikPie(username, "pie", "myChart2");
          myFunc.fetchGrafikGaris(username, "totalTagihan", "myChart3");
          myFunc.fetchGrafikGaris(username, "totalPemasukan", "myChart4");
          myFunc.fetchGrafikBar(username, "totalWargaTercatat", "myChart5");
          myFunc.fetchGrafikBar(
            username,
            "totalWargaBelumTercatat",
            "myChart6"
          );
          myFunc.fetchGrafikBar(username, "totalWargaLunas", "myChart7");
          myFunc.fetchGrafikBar(username, "totalWargaBelumLunas", "myChart8");
          break;

        case "warga":
          $(".tabMerahDashboard ~ div").hide();
          $(".tabBiruDashboard ~ div").text("-");
          $(".tabHijauDashboard ~ div").text("Rp");
          $(".penjelasanBiru").text("Waktu Pencatatan");
          $(".penjelasanKuning").text("Pemakaian Air");
          $(".penjelasanHijau").text("Tagihan");
          $(".penjelasanMerah").text("Status Tagihan");

          // ganti grafik
          myFunc.fetchGrafikBar(username, "pemakaianWarga", "myChart");
          myFunc.fetchGrafikGaris(username, "tagihanWarga", "myChart2");
          $(
            "#myChart3, #myChart4, #myChart5, #myChart6, #myChart7, #myChart8"
          ).hide();

          break;

        case "admin":
          myFunc.fetchGrafikGaris(username, "totalPemakaian", "myChart");
          myFunc.fetchGrafikPie(username, "pie", "myChart2");
          myFunc.fetchGrafikGaris(username, "totalTagihan", "myChart3");
          myFunc.fetchGrafikGaris(username, "totalPemasukan", "myChart4");
          myFunc.fetchGrafikBar(username, "totalWargaTercatat", "myChart5");
          myFunc.fetchGrafikBar(
            username,
            "totalWargaBelumTercatat",
            "myChart6"
          );
          myFunc.fetchGrafikBar(username, "totalWargaLunas", "myChart7");
          myFunc.fetchGrafikBar(username, "totalWargaBelumLunas", "myChart8");
          break;

        case "petugas":
          myFunc.fetchGrafikGaris(username, "totalPemakaian", "myChart");
          myFunc.fetchGrafikPie(username, "pie", "myChart2");
          myFunc.fetchGrafikBar(username, "totalWargaTercatat", "myChart3");
          myFunc.fetchGrafikBar(
            username,
            "totalWargaBelumTercatat",
            "myChart4"
          );
          $("#myChart5,#myChart6,#myChart7,#myChart8").hide();

        default:
          break;
      }

      // ketika selektor tanggal berubah
      $("#selectorTanggal").on("change", function () {
        // ambil nilai dari selektor
        let bulan = $(this).val();
        // minta data dengan post
        myFunc.fetchDatawithPost(bulan, level, username);
      });

      // tampilkan grafik
      break;
  }
});
