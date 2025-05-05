$(document).ready(function () {
  $("#yogi").click(function (e) {
    $(".modal-body").append(
      '<img class="w-100" src="../assets/img/yogi.jpg" alt="Card image">'
    );
    $(".modal-title").text("Yogi Makmur A");
  });
  $("#aim").click(function (e) {
    $(".modal-body").append(
      '<img class="w-100" src="../assets/img/aim.jpeg" alt="Card image">'
    );
    $(".modal-title").text("Efraim Raharangga");
  });
});
