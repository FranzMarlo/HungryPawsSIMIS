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

  $("#productSelect").select2({
    theme: "bootstrap",
    dropdownParent: $("#updateRequestStockForm"),
    placeholder: "Select Product",
    allowClear: true,
    width: "100%",
  });

  $(document).on("click", "#cancelRequestBtn", function (e) {
    e.preventDefault();
    showConfirm(
      "Are You Sure?",
      "Do you want to cancel this stock request? This action is <strong>irreversible</strong>.",
      function () {
        cancelRequest();
      },
    );
  });

  $(document).on("click", "#confirmBtn", function (e) {
    e.preventDefault();

    if (confirmCallback) {
      confirmCallback();
    }
  });

  handleProductSelect();
  handleBranchSelect();
  handleBranch1Select();
});

document
  .getElementById("updateRequestStockForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "updateRequestStock");

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

$(document).on("click", "#closeSuccessModal", function (e) {
  e.preventDefault();
  $.magnificPopup.close();
});

function updateOrderSummary() {
  let subtotal = 0;
  let itemCount = 0;

  $("#datatable-add-order tbody tr").each(function () {
    const priceText = $(this)
      .find("td:nth-child(3)")
      .text()
      .replace("₱", "")
      .trim();
    const quantity = parseFloat($(this).find("td:nth-child(4)").text());
    const price = parseFloat(priceText);
    if (!isNaN(price) && !isNaN(quantity)) {
      subtotal += price * quantity;
      itemCount += quantity;
    }
  });

  const serviceTotal = parseFloat($("#serviceTotal").text()) || 0;
  const orderTotal = subtotal + serviceTotal;

  $("#itemCount").text(`${itemCount} ${itemCount === 1 ? "Item" : "Items"}`);
  $("#subTotalAmount").text(subtotal.toFixed(2));
  $("#orderTotal").text(orderTotal.toFixed(2));

  $("#orderTotalVal").val(orderTotal.toFixed(2));
}

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

function handleBranchSelect() {
  $("#branchSelect").on("change", function () {
    const selectedOption = $(this).find("option:selected");
    const branchName = selectedOption.text();
    const branchAddress = selectedOption.data("address");
    const branchContact = selectedOption.data("contact");

    if (selectedOption.val()) {
      $("#sendingBranchName").text(branchName);
      $("#sendingBranchAddress").text(branchAddress);
      $("#sendingBranchContact").text(branchContact);
    } else {
      $("#sendingBranchName").text("No Branch Selected");
      $("#sendingBranchAddress").text("");
      $("#sendingBranchContact").text("");
    }
  });
}

function handleBranch1Select() {
  $("#branch1Select").on("change", function () {
    const selectedOption = $(this).find("option:selected");
    const branchName = selectedOption.text();
    const branchAddress = selectedOption.data("address");
    const branchContact = selectedOption.data("contact");

    if (selectedOption.val()) {
      $("#receivingBranchName").text(branchName);
      $("#receivingBranchAddress").text(branchAddress);
      $("#receivingBranchContact").text(branchContact);
    } else {
      $("#receivingBranchName").text("No Branch Selected");
      $("#receivingBranchAddress").text("");
      $("#receivingBranchContact").text("");
    }
  });
}

function handleProductSelect() {
  $("#productSelect").on("change", function () {
    const selectedOption = $(this).find("option:selected");
    const productName = selectedOption.text();
    const productCategory = selectedOption.data("category");
    const productSupplier = selectedOption.data("supplier");
    const productStock = selectedOption.data("stock");
    const productId = selectedOption.data("id");

    if (selectedOption.val()) {
      $("#productName").text(productName);
      $("#productId").text(productId);
      $("#productCategory").text(productCategory);
      $("#productSupplier").text(productSupplier);
      $("#productStock").text(productStock);
    } else {
      $("#productName").text("No Product Selected");
      $("#productId").text("N/A");
      $("#productCategory").text("N/A");
      $("#productSupplier").text("N/A");
      $("#productStock").text("N/A");
    }
  });

  $("#quantity").on("change", function () {
    const quantity = $(this).val();

    if (quantity) {
      $("#quantityRequest").text(quantity);
    } else {
      $("#quantityRequest").text("N/A");
    }
  });
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

$("#branchSelect").on("change", function () {
  let branchId = $(this).val();

  $.ajax({
    url: "/HungryPaws/backend/manager/get-branch-stock.php",
    method: "GET",
    data: { branch_id: branchId },
    dataType: "json",

    success: function (products) {
      let productSelect = $("#productSelect");

      // Clear old options
      productSelect.empty();

      // Add default option
      productSelect.append(
        '<option value="" disabled selected>Select Product</option>',
      );

      // Add fetched products
      products.forEach(function (product) {
        productSelect.append(`
                        <option 
                            value="${product.product_id}"
                            data-id="${product.product_id}"
                            data-stock="${product.total_stock}"
                            data-category="${product.category}"
                            data-name="${product.product_name}"
                            data-supplier="${product.supplier_name}">
                            ${product.product_name} (${product.total_stock})
                        </option>
                    `);
      });

      // Refresh Select2
      productSelect.trigger("change.select2");
    },
  });
});

$("#productSelect").select2({
  placeholder: "Select Product",
});
