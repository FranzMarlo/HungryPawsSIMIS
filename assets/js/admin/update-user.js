document
  .getElementById("updateUserForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "updateUser");

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

$(document).on("click", "#toggleAccountBtn", function (e) {
  e.preventDefault();
  const accountStatus = $("#toggleAccountBtn").data("status");
  if (accountStatus == 1) {
    showConfirm(
      "Are You Sure?",
      "Do you want to re-enable this user account? Enabling this account will allow the user to login to system again.",
      function () {
        enableAccount();
      }
    );
  } else { 
    showConfirm(
      "Are You Sure?",
      "Do you want to disable this user account? Disabling this account will block the user's access to login to system.",
      function () {
        disableAccount();
      }
    );
  }
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

function disableAccount() {
  $.magnificPopup.close();
  const userId = $("#toggleAccountBtn").data("id");

  const formData = new FormData();
  formData.append("submitType", "disableUser");
  formData.append("userId", userId);

  fetch("/HungryPaws/backend/handle-post.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.status === "info") {
        showInfo(response.title, response.message);
      } else if (response.status === "warning") {
        showWarning(response.title, response.message);
      } else {
        showError(response.title, response.message);
      }
    })
    .catch((error) => {
      console.error("Fetch Error:", error);
      showError("Error!", "Something went wrong. Please try again.");
    });
}

function enableAccount() {
  $.magnificPopup.close();
  const userId = $("#toggleAccountBtn").data("id");

  const formData = new FormData();
  formData.append("submitType", "enableUser");
  formData.append("userId", userId);

  fetch("/HungryPaws/backend/handle-post.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.status === "info") {
        showInfo(response.title, response.message);
      } else if (response.status === "warning") {
        showWarning(response.title, response.message);
      } else {
        showError(response.title, response.message);
      }
    })
    .catch((error) => {
      console.error("Fetch Error:", error);
      showError("Error!", "Something went wrong. Please try again.");
    });
}
