$(document).ready(function () {
  let url = window.location.href;
  let get = url.split("=");
  $("#summary, #grafik, #tambahUser,#tabelUser").hide();
  switch (get[1]) {
    case "user_edit&user":
    case "managemen-user":
      $("#tabelUser").show();
      $(".datatable-dropdown").append(
        '<button type="button" class="btn btn-outline-success float-start me-2" id="new-user"><i class="fa-solid fa-user-plus"></i> User</button>'
      );
      if (get[1] == "user_edit&user") {
        $("#tambahUser").show();
        $("#tabelUser").hide();
        $("#user_form button").val("user_edit");
      }

      $("#new-user").click(function (e) {
        $("#tambahUser").show();
        $("#tabelUser").hide();
        $("#user_form input, #user_form text_area").show();
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
      $("#summary, #grafik").show();
  }
});
