export function fetchDatawithPost(bulan, level, username) {
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
          console.log(done);
          // data pelanggan belum lunas
          let dataBelumLunas = done["jumlahPelanggan"] - done["pelangganLunas"];

          // ubah data di tab summary
          $(".tabBiruDashboard").text(done["jumlahPelanggan"]);
          $(".tabKuningDashboard").text(
            formatNumberWithDots(done["pemasukan"])
          );
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

            // tentukan bulan ini
            const tanggalSekarang = new Date();
            const bulanIni = tanggalSekarang.getMonth() + 1;
            const newBulan = bulanIni.length == 1 ? `0${bulanIni}` : bulanIni;

            if (bulan.slice(5) == newBulan) {
              $(".tabBiruDashboard").text(
                ubahFormatTanggal(done["tanggalPencatatan"])
              );
              $(".penjelasanBiru").text(
                `Pencatatan terakhir : ${done["waktuPencatatan"]}`
              );
              $(".tabBiruDashboard ~ div").hide();
            } else {
              $(".tabBiruDashboard ~ div").show();
              $(".tabBiruDashboard ~ div").text(done["waktuPencatatan"]);
              $(".tabBiruDashboard").text(done["tanggalPencatatan"].slice(-2));
              $(".penjelasanBiru").text("Waktu Pencatatan");
            }

            $(".tabKuningDashboard").text(
              formatNumberWithDots(done["pemakaianWarga"])
            );
            $(".tabHijauDashboard").text(
              formatNumberWithDots(done["tagihanWarga"])
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
}

export function fetchGrafikBar(data, type, id) {
  let label = labelType(type);
  let sumbuX = data.filter((Number, index) => index % 2 == 0);
  let sumbuY = data.filter((Number, index) => index % 2 !== 0);
  let maxChart = Math.max(...sumbuY) + Math.max(...sumbuY) * 0.15;
  let total = sumbuY.reduce((a, c) => parseInt(a) + parseInt(c), 0);

  // Chart grafik balok
  Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = "#292b2c";

  // Bar Chart Example
  let ctx = document.querySelector(`#${id} .card-body canvas`);
  var myLineChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: sumbuX,
      datasets: [
        {
          label: label,
          backgroundColor: "#36A2EB",
          borderColor: "#36A2EB",
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
              max: maxChart,
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

  // menentukan header
  $(`#${id} .card-header`).html(headerKita(type, total));
}

export function fetchGrafikGaris(data, type, id) {
  // ganti isi pemakaian
  let label = labelType(type);
  let other;
  let sumbuX = data.filter((Number, index) => index % 2 == 0);
  let sumbuY = data.filter((Number, index) => index % 2 !== 0);
  let maxChart = Math.max(...sumbuY) + Math.max(...sumbuY) * 0.15;
  let total = sumbuY.reduce((a, c) => parseInt(a) + parseInt(c), 0);

  if (type == "tagihanWarga") {
    let [firstElement, ...restOfElement] = data;
    sumbuX = restOfElement.filter((Number, index) => index % 2 == 0);
    sumbuY = restOfElement.filter((Number, index) => index % 2 !== 0);
    other = firstElement;
  } else {
    sumbuX = data.filter((Number, index) => index % 2 == 0);
    sumbuY = data.filter((Number, index) => index % 2 !== 0);
  }

  // menentukan header
  $(`#${id} .card-header`).html(headerKita(type, total, other));

  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = "#292b2c";

  // Area Chart Example
  let ctx = document.querySelector(`#${id} .card-body canvas`);
  var myLineChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: sumbuX,
      datasets: [
        {
          label: label,
          lineTension: 0.3,
          backgroundColor: "rgba(2,117,216,0.2)",
          borderColor: "#36A2EB",
          pointRadius: 5,
          pointBackgroundColor: "#36A2EB",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "#36A2EB",
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
              max: maxChart,
              maxTicksLimit: 5,
            },
            gridLines: {
              color: "#36A2EB",
            },
          },
        ],
      },
      legend: {
        display: false,
      },
    },
  });
}

export function fetchGrafikPie(dataObjek, type, id) {
  // menentukan header
  $(`#${id} .card-header`).html(headerKita(type));

  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = "#292b2c";

  // selector id
  let ctx = document.querySelector(`#${id} .card-body canvas`);
  // Data untuk grafik pie
  const data = {
    labels: ["Kost", "Rumah"],
    datasets: [
      {
        data: dataObjek[0], // Nilai untuk setiap bagian pie
        borderWidth: "10rem",
        backgroundColor: [
          // Warna latar belakang untuk setiap bagian
          "#FF6384", // Merah muda
          "#36A2EB", // Biru
        ],
        hoverBackgroundColor: [
          // Warna saat di-hover (opsional)
          "#FF6384",
          "#36A2EB",
        ],
      },
    ],
  };

  // Buat objek grafik pie
  const myPieChart = new Chart(ctx, {
    type: "pie", // Tipe grafik
    data: data,
  });
}

function labelType(type) {
  switch (type) {
    case "totalPemakaian":
    case "pemakaianWarga":
      return "pemakaian";
      break;
    case "totalPemasukan":
      return "pemasukan";
      break;
    case "totalTagihan":
      return "tagihan";
      break;

    default:
      return "warga";
      break;
  }
}

function headerKita(type, total, other) {
  // menentukan header
  let headerKita = "isi fungsi header";
  let newTotal = formatNumberWithDots(total);
  let newOther = formatNumberWithDots(other);
  switch (type) {
    case "totalPemakaian":
    case "pemakaianWarga":
      headerKita = `<i class="fas fa-chart-area me-1"></i>Total Pemakaian Air <b>${total} m<sup>3</sup></b>`;
      break;
    case "pie":
      headerKita =
        '<i class="fas fa-chart-area me-1"></i> Jumlah Rumah Kos dan Rumah Tinggal';
      break;
    case "totalTagihan":
      headerKita = `<i class="fas fa-chart-area me-1"></i> Total Tagihan Air <b>Rp ${newTotal}</b>`;
      break;
    case "tagihanWarga":
      headerKita = `<i class="fas fa-chart-area me-1"></i> Total Pembayaran Air <b>Rp ${newTotal} | <span class='text-danger'>Belum Lunas <b>Rp ${newOther}</b></span></b>`;
      break;
    case "totalWargaTercatat":
      headerKita = `<i class="fas fa-chart-area me-1"></i> Jumlah Warga Tercatat`;
      break;
    case "totalWargaBelumTercatat":
      headerKita = `<i class="fas fa-chart-area me-1"></i> <span class='text-danger'>Jumlah Warga Belum Tercatat</span>`;
      break;
    case "totalWargaLunas":
      headerKita = `<i class="fas fa-chart-area me-1"></i> Jumlah Warga Sudah Lunas`;
      break;
    case "totalWargaBelumLunas":
      headerKita = `<i class="fas fa-chart-area me-1"></i> <span class='text-danger'>Jumlah Warga Belum Lunas</span>`;
      break;
    case "totalPemasukan":
      headerKita = `<i class="fas fa-chart-area me-1"></i> Total Pemasukan Air <b>Rp ${newTotal}</b>`;
      break;

    default:
      break;
  }
  return headerKita;
}

function formatNumberWithDots(numberString) {
  // Pastikan input adalah string angka atau bisa dikonversi menjadi angka
  const number = parseFloat(numberString);

  // Periksa jika konversi gagal (misal input bukan angka)
  if (isNaN(number)) {
    return "Input bukan angka valid";
  }

  // Gunakan Intl.NumberFormat untuk format lokal Indonesia (id-ID)
  // useGrouping: true untuk mengaktifkan pemisah ribuan
  return new Intl.NumberFormat("id-ID", { useGrouping: true }).format(number);
}

function ubahFormatTanggal(tanggalString) {
  // Pastikan input adalah string dan memiliki format YYYY-MM-DD yang diharapkan
  if (
    typeof tanggalString !== "string" ||
    !/^\d{4}-\d{2}-\d{2}$/.test(tanggalString)
  ) {
    console.error(
      "Input tidak valid. Harap berikan string dengan format 'YYYY-MM-DD'."
    );
    return null; // Mengembalikan null atau melempar error
  }

  // Pisahkan string berdasarkan tanda strip
  const parts = tanggalString.split("-"); // Hasilnya: ['2025', '01', '05']

  const year = parts[0]; // '2025'
  const month = parts[1]; // '01'
  const day = parts[2]; // '05'

  // Gabungkan kembali dalam format DD-MM-YYYY
  return `${day}-${month}-${year}`; // Menggunakan template literals
}
