$(document).ready(function () {
  let url = window.location.href;
  switch (url.split("=")[1]) {
    case "managemen-user":
      $("#summary, #grafik").hide();
      break;
    case "ubah-datameter-warga":
      $("#summary, #tabelUser").hide();
      break;
    case "pembayaran-warga":
      $("#grafik, #tabelUser").hide();
      break;
  }
});
