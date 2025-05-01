$(document).ready(function () {
  // variabel get
  let url = window.location.href;
  let get = url.split("=");

  // menghilangkan semua isi
  $("#summary, #grafik, #tambahUser,#tabelUser").hide();

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
      $("button[data-bs-toggle='modal']").click(function (e) {
        let user = $(this).attr("data-user");
        $("#myModal .modal-body").text(
          `Yakin menghapus Data dengan username ${user}`
        );
        $(".modal-footer form").append(
          `<input type="hidden" name="user" value="${user}"> `
        );
      });
      break;
    case "ubah-datameter-warga":
      $("#grafik").show();
      break;
    case "pembayaran-warga":
      $("#sumary").show();
      break;
    case "managemen-tarif&kodeTarif":
    case "managemen-tarif":
      $("#tabelTarif").show();
      $(".datatable-dropdown").append(
        '<button type="button" class="btn btn-outline-success float-start me-2" id="new-tarif"><i class="fa-solid fa-user-plus"></i> User</button>'
      );
      if (get[1] == "tarif_edit&tarif") {
        $("#tambahTarif").show();
        $("#tabelTarif").hide();
        $("#tarif_form button").val("user_edit");
        $("#tarif_form input[name='kodeTarif']").attr("disabled", true);
        $("#tarif_form").append(
          `<input type="hidden" name="kodeTarif" value=${get[2]} ></input>`
        );
      }
      break;
    default:
      $("#summary, #grafik").show();
      console.log("uy");
  }
});
