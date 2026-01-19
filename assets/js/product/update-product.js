document
  .getElementById("updateProductForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "updateProduct");

    const productID = form.getAttribute("data-id");

    formData.append("submitType", "updateProduct");
    formData.append("product_id", productID);

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

        if (data.status === "info") {
          showInfo(data.title, data.message);
        } else if (data.status === "warning") {
          showWarning(data.title, data.message);
        } else if (data.status === "error") {
          showError(data.title, data.message);
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

$(document).on("click", "#toggleArchiveBtn", function (e) {
  e.preventDefault();
  const archiveStatus = $("#toggleArchiveBtn").data("archived");
  if (archiveStatus == 1) {
    showConfirm(
      "Are You Sure?",
      "Do you want to unarchive this product? Unarchiving this product will allow other users to view this product again.",
      function () {
        unarchiveProduct();
      }
    );
  } else {
    showConfirm(
      "Are You Sure?",
      "Do you want to archive this product? Archiving this product will hide this product from other users.",
      function () {
        archiveProduct();
      }
    );
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

function archiveProduct() {
  $.magnificPopup.close();
  const productId = $("#toggleArchiveBtn").data("id");

  const formData = new FormData();
  formData.append("submitType", "archiveProduct");
  formData.append("productId", productId);

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

function unarchiveProduct() {
  $.magnificPopup.close();
  const productId = $("#toggleArchiveBtn").data("id");

  const formData = new FormData();
  formData.append("submitType", "unarchiveProduct");
  formData.append("productId", productId);

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
