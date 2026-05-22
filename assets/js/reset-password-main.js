document
  .getElementById("resetPasswordForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "resetPasswordMain");

    fetch("/HungryPaws/backend/handle-post.php", {
      method: "POST",
      body: formData,
    })
      .then(async (response) => {
        const data = await response.json();

        if (!response.ok) {
          showWarning("Warning", data.message || "Something went wrong.");
          throw new Error(data.message);
        }

        if (data.status === "warning") {
          showWarning(data.title, data.message);
        } else if (data.status === "error") {
          showError(data.title, data.message);
        } else {
          showSuccess(data.title, data.message);
          form.reset();

          setTimeout(() => {
            window.location.href = "/HungryPaws/";
          }, 2000);
        }
      })
      .catch((error) => {
        showError("Error", error.message || "Request failed");
      });
  });

function showSuccess(title, message) {
  document.getElementById("successTitle").textContent = title;
  document.getElementById("successMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalSuccess" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}

function showWarning(title, message) {
  document.getElementById("warningTitle").textContent = title;
  document.getElementById("warningMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalWarning" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}

function showError(title, message) {
  document.getElementById("errorTitle").textContent = title;
  document.getElementById("errorMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalError" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}

$(document).on("click", ".modal-dismiss", function (e) {
  e.preventDefault();
  $.magnificPopup.close();
});
