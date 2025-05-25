$(document).ready(function () {
  // variabel get
  let url = window.location.href;
  let get = url.split("=");

  // fungsi menambahkan titik setiap 3 angka
  function formatAngka(n) {
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

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
      let level = $("#inputLevelDashboard").val();
      let username = level == "warga" ? $("#inputUsernameDashboard").val() : "";

      // mengganti selektor kecil kecil
      switch (level) {
        case "bendahara":
          $(".tabKuningDashboard ~ div").text("Rp");
          $(".penjelasanKuning").text("Pemasukan");
          $(".penjelasanHijau").text("Sudah Lunas");
          $(".penjelasanMerah").text("Belum Lunas");
          break;

        case "warga":
          $(".tabMerahDashboard ~ div").hide();
          $(".tabBiruDashboard ~ div").text("-");
          $(".tabHijauDashboard ~ div").text("Rp");
          $(".penjelasanBiru").text("Waktu Pencatatan");
          $(".penjelasanKuning").text("Pemakaian Air");
          $(".penjelasanHijau").text("Tagihan");
          $(".penjelasanMerah").text("Status Tagihan");
          break;

        default:
          break;
      }

      // ketika selektor tanggal berubah
      $("#selectorTanggal").on("change", function () {
        // ambil nilai dari selektor
        let bulan = $(this).val();
        // minta data dengan post
        $.ajax({
          type: "post",
          url: "../assets/ajax.php",
          data: {
            page: "summary",
            time: bulan,
            level: level,
            username: username,
          },
          dataType: "json",
        })

          // jika berhasi
          .done(function (done) {
            // merubah null menjadi 0
            for (const key in done) {
              if (!done[key]) {
                done[key] = 0;
              }
            }

            switch (done["level"]) {
              // menampilkan data admin atau petugas
              case "admin":
              case "petugas":
                // data pelanggan belum dicatat
                let dataBelumDicatat =
                  done["jumlahPelanggan"] - done["dataSudahDicatat"];

                // ubah data di tab summary
                $(".tabBiruDashboard").text(done["jumlahPelanggan"]);
                $(".tabKuningDashboard").text(done["jumlahPemakaian"]);
                $(".tabHijauDashboard").text(done["dataSudahDicatat"]);
                $(".tabMerahDashboard").text(dataBelumDicatat);
                break;

              // menampilkan data bendahara
              case "bendahara":
                // data pelanggan belum lunas
                let dataBelumLunas =
                  done["jumlahPelanggan"] - done["pelangganLunas"];

                // ubah data di tab summary
                $(".tabBiruDashboard").text(done["jumlahPelanggan"]);
                $(".tabKuningDashboard").text(formatAngka(done["pemasukan"]));
                $(".tabHijauDashboard").text(done["pelangganLunas"]);
                $(".tabMerahDashboard").text(dataBelumLunas);
                break;

              // menampilkan data bendahara
              case "warga":
                // jika data ada
                if (done["status"] == "berhasil") {
                  // data pelanggan belum lunas
                  let statusTagihan =
                    done["statusTagihan"] == 1 ? "LUNAS" : "BLM LUNAS";

                  // ubah data di tab summary
                  $(".tabBiruDashboard").text(
                    done["tanggalPencatatan"].slice(-2)
                  );
                  $(".tabBiruDashboard ~ div").text(done["waktuPencatatan"]);
                  $(".tabKuningDashboard").text(
                    formatAngka(done["pemakaianWarga"])
                  );
                  $(".tabHijauDashboard").text(
                    formatAngka(done["tagihanWarga"])
                  );
                  $(".tabMerahDashboard").text(statusTagihan);
                } else {
                  $(".tabBiruDashboard").text("-");
                  $(".tabBiruDashboard ~ div").text("-");
                  $(".tabKuningDashboard").text("-");
                  $(".tabHijauDashboard").text("-");
                  $(".tabMerahDashboard").text("-");
                }
                break;

              default:
                break;
            }
          })

          // jika gagal
          .fail(function () {
            console.log("ada eror");
          });
      });

      // untuk grafik
      $.ajax({
        type: "POST",
        url: "../assets/ajax.php",
        data: { page: "chart", username: username },
        dataType: "json",
      })
        // ketika data berhasil didapatkan
        .done(function (done) {
          let sumbuX = done.filter((Number, index) => index % 2 == 0);
          let sumbuY = done.filter((Number, index) => index % 2 !== 0);

          // Chart grafik balok
          Chart.defaults.global.defaultFontFamily =
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
          Chart.defaults.global.defaultFontColor = "#292b2c";

          // Bar Chart Example
          var ctx = document.getElementById("myBarChart");
          var myLineChart = new Chart(ctx, {
            type: "bar",
            data: {
              labels: sumbuX,
              datasets: [
                {
                  label: "Pemakaian",
                  backgroundColor: "rgba(2,117,216,1)",
                  borderColor: "rgba(2,117,216,1)",
                  data: sumbuY,
                },
              ],
            },
            options: {
              scales: {
                xAxes: [
                  {
                    time: {
                      unit: "month",
                    },
                    gridLines: {
                      display: false,
                    },
                    ticks: {
                      maxTicksLimit: 6,
                    },
                  },
                ],
                yAxes: [
                  {
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 5,
                    },
                    gridLines: {
                      display: true,
                    },
                  },
                ],
              },
              legend: {
                display: false,
              },
            },
          });
        });

      $.ajax({
        type: "post",
        url: "../assets/ajax.php",
        data: { page: "chartLine", username: username },
        dataType: "json",
      })
        // jika data berhasil dikirim
        .done(function (done) {
          let sumbuX = done.filter((Number, index) => index % 2 == 0);
          let sumbuY = done.filter((Number, index) => index % 2 !== 0);

          // Set new default font family and font color to mimic Bootstrap's default styling
          Chart.defaults.global.defaultFontFamily =
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
          Chart.defaults.global.defaultFontColor = "#292b2c";

          // Area Chart Example
          var ctx = document.getElementById("myAreaChart");
          var myLineChart = new Chart(ctx, {
            type: "line",
            data: {
              labels: sumbuX,
              datasets: [
                {
                  label: "Tagihan",
                  lineTension: 0.3,
                  backgroundColor: "rgba(2,117,216,0.2)",
                  borderColor: "rgba(2,117,216,1)",
                  pointRadius: 5,
                  pointBackgroundColor: "rgba(2,117,216,1)",
                  pointBorderColor: "rgba(255,255,255,0.8)",
                  pointHoverRadius: 5,
                  pointHoverBackgroundColor: "rgba(2,117,216,1)",
                  pointHitRadius: 50,
                  pointBorderWidth: 2,
                  data: sumbuY,
                },
              ],
            },
            options: {
              scales: {
                xAxes: [
                  {
                    time: {
                      unit: "date",
                    },
                    gridLines: {
                      display: false,
                    },
                    ticks: {
                      maxTicksLimit: 7,
                    },
                  },
                ],
                yAxes: [
                  {
                    ticks: {
                      min: 0,
                      max: 500000,
                      maxTicksLimit: 5,
                    },
                    gridLines: {
                      color: "rgba(0, 0, 0, .125)",
                    },
                  },
                ],
              },
              legend: {
                display: false,
              },
            },
          });
        });
      break;
  }
});
