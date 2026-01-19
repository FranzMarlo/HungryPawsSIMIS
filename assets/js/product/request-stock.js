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
    dropdownParent: $("#requestStockForm"),
    placeholder: "Select Product",
    allowClear: true,
    width: "100%",
  });

  handleProductSelect();
  handleBranchSelect();
});

document
  .getElementById("requestStockForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "requestStock");

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

  const form = document.getElementById("requestStockForm");

  if (form) {
    form.reset();
  }

  $("input[type='text'], input[type='number'], input[type='date']").val("");

  $("select").each(function () {
    this.selectedIndex = 0;
    if ($(this).data("select2")) {
      $(this).val($(this).find("option:first").val()).trigger("change.select2");
    } else {
      $(this).val($(this).find("option:first").val()).trigger("change");
    }
  });

  $("#sendingBranchName").text("No Branch Selected");
  $("#sendingBranchAddress").text("");
  $("#sendingBranchContact").text("");

  $("#productName").text("No Product Selected");
  $("#productId").text("N/A");
  $("#productCategory").text("N/A");
  $("#productSupplier").text("N/A");
  $("#productStock").text("N/A");
  $("#quantityRequest").text("N/A");
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
