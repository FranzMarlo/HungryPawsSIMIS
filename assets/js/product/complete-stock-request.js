$(document).ready(function () {
  $(".modal-with-form").magnificPopup({
    type: "inline",
    preloader: false,
    modal: true,
  });

  $(document).on("click", ".modal-dismiss", function (e) {
    e.preventDefault();
    $.magnificPopup.close();
  });

  $(document).on("click", "#completeRequestBtn", function (e) {
    e.preventDefault();
    showConfirm(
      "Are You Sure?",
      "Do you want to mark this stock request as completed? Please only confirm if your branch have received the correct number of items. This action is <strong>irreversible</strong>.",
      function () {
        completeRequest();
      },
    );
  });

  $(document).on("click", "#confirmBtn", function (e) {
    e.preventDefault();

    if (confirmCallback) {
      confirmCallback();
    }
  });
});

$(document).on("click", "#closeSuccessModal", function (e) {
  e.preventDefault();
  $.magnificPopup.close();
});

function showAlert(type, message) {
  const alertContainer = document.getElementById("alert-container");
  const alert = document.createElement("div");

  alert.className = `alert alert-${type} alert-dismissible fade show`;
  alert.setAttribute("role", "alert");
  alert.innerHTML = `
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;

  alertContainer.appendChild(alert);

  setTimeout(() => {
    alert.classList.remove("show");
    setTimeout(() => alert.remove(), 150);
  }, 3000);
}

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

function completeRequest() {
  $.magnificPopup.close();
  const transferId = $("#completeRequestBtn").data("id");

  const formData = new FormData();
  formData.append("submitType", "completeStockRequest");
  formData.append("transferId", transferId);

  fetch("/HungryPaws/backend/handle-post.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.status === "success") {
        updateStatus("Completed", "ecommerce-status completed");
        showSuccess(response.title, response.message);
      } else {
        showError(response.title, response.message);
      }
    })
    .catch((error) => {
      console.error("Fetch Error:", error);
      showError("Error!", "Something went wrong. Please try again.");
    });
}
function updateStatus(textContent, spanClass) {
  const status = document.getElementById("requestStatus");

  status.textContent = textContent;
  status.className = "";
  spanClass.split(" ").forEach((cls) => status.classList.add(cls));
}
