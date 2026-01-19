document.addEventListener("DOMContentLoaded", function () {
  let scrollPosition = 0;

  $(".modal-trigger").magnificPopup({
    type: "inline",
    preloader: false,
    modal: true,
    callbacks: {
      open: function () {
        scrollPosition = window.scrollY;
        document.body.style.position = "fixed";
        document.body.style.top = `-${scrollPosition}px`;
        document.body.style.width = "100%";
      },
      close: function () {
        document.body.style.position = "";
        document.body.style.top = "";
        window.scrollTo(0, scrollPosition);
      },
    },
  });

  $(document).on("click", ".modal-dismiss", function (e) {
    e.preventDefault();
    $.magnificPopup.close();
  });

  $(document).on("click", "#logoutConfirm", function (e) {
    e.preventDefault();
    $.magnificPopup.close();
    window.location.href = "/HungryPaws/backend/staff/staff-logout.php";
  });

  setInterval(() => {
    checkUserStatus();
  }, 60000);

  checkUserStatus();
});

function checkUserStatus() {
  fetch("/HungryPaws/backend/check-user-status.php", {
    method: "POST",
  })
    .then((res) => res.json())
    .then((response) => {
      if (response.status === "success" && response.data.is_disabled == 1) {
        document.getElementById("disabledTitle").textContent =
          "Account Disabled";
        document.getElementById("disabledMessage").textContent =
          "Your account has been disabled by an admin. You will be logged out automatically.";

        $.magnificPopup.open({
          items: { src: "#modalDisabled" },
          type: "inline",
          modal: true,
        });
        setTimeout(() => {
          window.location.href = "/HungryPaws/backend/staff/staff-logout.php";
        }, 10000);
      }
    })
    .catch((err) => console.error("Error checking user status:", err));
}
