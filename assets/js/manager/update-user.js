document
  .getElementById("updateUserForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "updateMainUser");

    fetch("/HungryPaws/backend/handle-post.php", {
      method: "POST",
      body: formData,
    })
      .then(async (response) => {
        const data = await response.json();

        if (!response.ok) {
          showWarning(data.message || "Something went wrong.");
          throw new Error(data.message);
        }

        if (data.status === "warning") {
          showWarning(data.title, data.message);
        } else if (data.status === "error") {
          showError(data.title, data.message);
        } else if (data.status === "info") {
          showInfo(data.title, data.message);
        } else {
          showSuccess(data.title, data.message);
        }
      })
      .catch((error) => {
        showError(data.title, error);
      });
  });

$(document).on("click", "#confirmBtn", function (e) {
  e.preventDefault();

  if (confirmCallback) {
    confirmCallback();
  }
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

function showInfo(title, message) {
  document.getElementById("infoTitle").textContent = title;
  document.getElementById("infoMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalInfo" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}

let confirmCallback = null;

function showConfirm(title, message, callback) {
  document.getElementById("confirmTitle").textContent = title;
  document.getElementById("confirmMessage").innerHTML = message;

  confirmCallback = callback;

  $.magnificPopup.open({
    items: { src: "#modalConfirm" },
    type: "inline",
    preloader: false,
    modal: true,
  });
}
