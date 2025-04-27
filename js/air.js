$(document).ready(function () {
  let url = window.location.href;
  url.split("=");
  $("#summary, #grafik, #tambahUser,#tabelUser").hide();
  switch (url.split("=")[1]) {
    case "managemen-user":
      $("#tabelUser").show();
      $(".datatable-dropdown").append(
        '<button type="button" class="btn btn-outline-success float-start me-2" id="new-user"><i class="fa-solid fa-user-plus"></i> User</button>'
      );

      $("#new-user").click(function (e) {
        $("#tambahUser").show();
        $("#tabelUser").hide();
      });

      $("#batalTambah").click(function (e) {
        $("#tambahUser").hide();
        $("#tabelUser").show();
      });
      break;
    case "ubah-datameter-warga":
      $("#grafik").show();
      break;
    case "pembayaran-warga":
      $("#sumary").show();
      break;
    default:
      $("#summary, #grafik, #tambahUser,#tabelUser").show();
  }
});
