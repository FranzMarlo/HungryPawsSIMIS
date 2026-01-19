$(document).ready(function () {
  $(document).on("click", ".modal-dismiss", function (e) {
    e.preventDefault();
    $.magnificPopup.close();
  });

  $(document).on("click", "#approveRequestBtn", function (e) {
    e.preventDefault();
    showConfirm(
      "Are You Sure?",
      "Do you want to approve this stock request? This action is <strong>irreversible</strong>..",
      function () {
        approveRequest();
      }
    );
  });

  $(document).on("click", "#cancelRequestBtn", function (e) {
    e.preventDefault();
    showConfirm(
      "Are You Sure?",
      "Do you want to cancel this stock request? This action is <strong>irreversible</strong>..",
      function () {
        cancelRequest();
      }
    );
  });

  $(document).on("click", "#confirmBtn", function (e) {
    e.preventDefault();

    if (confirmCallback) {
      confirmCallback();
    }
  });

  $(document).on("click", "#closeSuccessModal", function (e) {
    e.preventDefault();
    $.magnificPopup.close();
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

function showError(title, message) {
  document.getElementById("errorTitle").textContent = title;
  document.getElementById("errorMessage").textContent = message;
  $.magnificPopup.open({
    items: { src: "#modalDanger" },
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

function updateStatus(textContent, spanClass) {
  const status = document.getElementById("requestStatus");

  status.textContent = textContent;
  status.className = "";
  spanClass.split(" ").forEach((cls) => status.classList.add(cls));
}

function cancelRequest() {
  $.magnificPopup.close();

  const transferId = $("#cancelRequestBtn").data("id");

  const formData = new FormData();
  formData.append("submitType", "cancelStockRequest");
  formData.append("transferId", transferId);

  fetch("/HungryPaws/backend/handle-post.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.status === "success") {
        updateStatus("Cancelled", "ecommerce-status cancelled");
        showSuccess(response.title, response.message);
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

function approveRequest() {
  $.magnificPopup.close();

  const transferId = $("#approveRequestBtn").data("id");

  const formData = new FormData();
  formData.append("submitType", "approveStockRequest");
  formData.append("transferId", transferId);

  fetch("/HungryPaws/backend/handle-post.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.status === "success") {
        updateStatus("Approved", "ecommerce-status processing");
        showSuccess(response.title, response.message);
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
