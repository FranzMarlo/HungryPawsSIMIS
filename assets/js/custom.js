$(document).on("mfpOpen", function () {
  $("html, body").css({
    overflow: "hidden",
    height: "100%",
  });
});

$(document).on("mfpClose", function () {
  $("html, body").css({
    overflow: "",
    height: "",
  });
});
