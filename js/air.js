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

  $(".datatable-dropdown").append(
    '<button type="button" class="btn btn-outline-success float-start me-2" id="new-user"><i class="fa-solid fa-user-plus"></i>User</button>'
  );
  $("#new-user").click(function (e) {
    console.log("halo");
  });
});
