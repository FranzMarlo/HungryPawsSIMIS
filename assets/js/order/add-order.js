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
    dropdownParent: $("#modalForm"),
    placeholder: "Select Product",
    allowClear: true,
    width: "100%",
  });

  handleServiceSelect();
  handleServiceCost();
});
$("#barcodeInput").focus();

function updateScanner(statusText, colorClass, iconClass) {
  $("#scannerStatus")
    .text(statusText)
    .removeClass("text-success text-dark text-warning text-danger text-primary")
    .addClass(colorClass);

  $("#scannerIcon i")
    .removeClass(
      "bi-upc-scan bi-dot bi-check-circle bi-x-circle bi-hourglass-split"
    )
    .addClass(iconClass);
}

$("#barcodeInput").on("focus", function () {
  updateScanner("Ready", "text-success", "bi-dot");
});

$("#barcodeInput").on("blur", function () {
  updateScanner("Idle", "text-dark", "bi-upc-scan");
});

$("#barcodeInput").on("keypress", function (e) {
  if (e.which === 13) {
    e.preventDefault();
    const barcode = $(this).val().trim();
    if (!barcode) return;

    updateScanner("Scanning...", "text-warning", "bi-hourglass-split");

    $.ajax({
      url: "/HungryPaws/backend/cashier/search-product.php",
      type: "POST",
      dataType: "json",
      data: { barcode: barcode },
      success: function (res) {
        if (res.status === "success") {
          updateScanner("Product found", "text-primary", "bi-check-circle");

          const product = res.data;
          $("#productSelect").val(product.id).trigger("change");
          $("#quantity").val(1);

          $.magnificPopup.open({
            items: { src: "#modalForm" },
            type: "inline",
          });

          setTimeout(() => $("#quantity").focus(), 200);
        } else {
          updateScanner("Not found", "text-danger", "bi-x-circle");
        }

        $("#barcodeInput").val("");

        setTimeout(() => {
          updateScanner("Ready", "text-success", "bi-dot");
        }, 1000);
      },
    });
  }
});

$(document).on("click", function () {
  const active = document.activeElement;
  if (active.tagName !== "INPUT" && active.tagName !== "SELECT") {
    $("#barcodeInput").focus();
  }
});

$(document).on("keydown", function (e) {
  if (e.key === "F2") {
    $("#barcodeInput").focus();
  }
});

$("#productSelect").on("change", function () {
  const price = $(this).find(":selected").data("price");
  const stock = $(this).find(":selected").data("stock");
  $("#price").val(price);
  $("#quantity").attr("max", stock);
});

$("#modalForm").on("keydown", function (e) {
  if (e.key === "Enter") {
    e.preventDefault();
    document.getElementById("addProductBtn").click();
  }
});

$("#addProductBtn").click(function (e) {
  e.preventDefault();

  const productId = $("#productSelect").val();
  const selectedOption = $("#productSelect option:selected");
  const productName = selectedOption.text();
  const quantity = $("#quantity").val();
  const price = selectedOption.data("price");
  const barcode = selectedOption.data("barcode");
  const stock = parseInt(selectedOption.data("stock"), 10);
  const total = (quantity * price).toFixed(2);

  if (!productId) {
    showWarningAlert("Please Select A Product");
    return;
  }
  if (!quantity || quantity == 0) {
    showWarningAlert("Please Enter Quantity Of Ordered Product");
    return;
  }

  if (stock && quantity > stock) {
    showWarningAlert(
      `Only ${stock} units available in stock for ${productName}.`
    );
    return;
  }

  if (stock === 0) {
    showWarningAlert(`No stock available for ${productName}.`);
    return;
  }

  const existingRow = $(
    `#datatable-add-order tbody tr[data-id="${productId}"]`
  );
  if (existingRow.length > 0) {
    showWarningAlert(
      "This product has already been added to the order. Kindly remove it first if you want to modify its quantity."
    );
    return;
  }

  $("#datatable-add-order tbody").append(`
  <tr data-id="${productId}">
    <td class="ps-4">
      <strong>${barcode}</strong>
      <input type="hidden" name="products[${productId}][id]" value="${productId}">
    </td>
    <td class="ps-4">
      <strong>${productName}</strong>
      <input type="hidden" name="products[${productId}][name]" value="${productName}">
    </td>
    <td class="text-end">
      ₱${price}
      <input type="hidden" name="products[${productId}][price]" value="${price}">
    </td>
    <td class="text-end">
      ${quantity}
      <input type="hidden" name="products[${productId}][quantity]" value="${quantity}">
    </td>
    <td class="text-end">
      ₱${total}
      <input type="hidden" name="products[${productId}][total]" value="${total}">
    </td>
    <td class="text-end">
      <button type="button" class="btn btn-sm btn-danger remove-product text-center">
        <i class="bx bx-trash text-4 me-2"></i>
      </button>
    </td>
  </tr>
`);

  updateOrderSummary();

  const orderTotal = parseFloat($("#orderTotal").text()) || 0;

  $("#orderTotalVal").val(orderTotal.toFixed(2));

  $.magnificPopup.close();

  $("#productSelect").val("").trigger("change");
  $("#quantity").val("");
});

let rowToRemove = null;

$(document).on("click", ".remove-product", function (e) {
  e.preventDefault();
  rowToRemove = $(this).closest("tr");

  $.magnificPopup.open({
    items: { src: "#confirmRemoveModal" },
    type: "inline",
    preloader: false,
    modal: true,
  });
});

$(document).on("click", "#confirmRemoveBtn", function () {
  if (rowToRemove) {
    rowToRemove.remove();
    updateOrderSummary();
    rowToRemove = null;
  }

  $.magnificPopup.close();
});

document
  .getElementById("addOrderForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const serviceType = document.getElementById("service").value;

    const rows = $("#datatable-add-order tbody tr");
    if (rows.length === 0 && (serviceType === "" || serviceType === "none")) {
      showWarning("Warning!", "Please add at least one service or product.");
      return;
    }

    const form = this;
    const formData = new FormData(form);
    formData.append("submitType", "addOrder");

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
          latestOrderId = data.orderId;

          showSuccess(data.title, data.message);
        }
      })
      .catch((error) => {
        showError(data.title, error);
      });
  });

$(document).on("click", "#printReceiptBtn", function (e) {
  e.preventDefault();
  $.magnificPopup.close();

  if (!latestOrderId) {
    showWarning(
      "Missing Order ID",
      "Unable to print receipt. Please refresh and try again."
    );
    return;
  }

  const form = document.getElementById("addProductForm");

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

  const tableBody = $("#datatable-add-order tbody");
  tableBody.empty();

  updateOrderSummary();
  $("#orderTotal").text("0.00");
  $("#serviceTotal").text("0.00");
  $("#orderTotalVal").val("0.00");
  $("#subTotalAmount").text("0.00");
  $("#itemCount").text("0 Items");

  handleServiceSelect();

  $("#serviceAvailed").text("None");
  refreshProductOptions();

  setTimeout(() => {
    const printURL = `/HungryPaws/cashier/print-receipt?id=${encodeURIComponent(
      latestOrderId
    )}`;
    window.open(printURL, "_blank");
  }, 300);
});

$(document).on("click", "#closeSuccessModal", function (e) {
  e.preventDefault();
  $.magnificPopup.close();

  const form = document.getElementById("addProductForm");

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

  const tableBody = $("#datatable-add-order tbody");
  tableBody.empty();

  updateOrderSummary();
  $("#orderTotal").text("0.00");
  $("#serviceTotal").text("0.00");
  $("#orderTotalVal").val("0.00");
  $("#subTotalAmount").text("0.00");
  $("#itemCount").text("0 Items");

  handleServiceSelect();

  $("#serviceAvailed").text("None");
  refreshProductOptions();
});

function showWarningAlert(message) {
  document.getElementById("validatorMessage").textContent = message;
  document.getElementById("modalFormValidator").classList.remove("d-none");
}

function hideWarningAlert() {
  document.getElementById("modalFormValidator").classList.add("d-none");
}

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

function handleServiceSelect() {
  const serviceSelect = document.getElementById("service");
  const serviceCost = document.getElementById("serviceCost");
  const serviceAvailed = document.getElementById("serviceAvailed");
  const groomingCardBody = document.getElementById("groomingCardBody");
  const petHotelCardBody = document.getElementById("petHotelCardBody");

  serviceCost.disabled = true;

  groomingCardBody
    .querySelectorAll("input, select")
    .forEach((el) => (el.disabled = true));

  petHotelCardBody
    .querySelectorAll("input, select")
    .forEach((el) => (el.disabled = true));

  serviceSelect.addEventListener("change", function () {
    const selected = this.value;

    const enableGrooming = selected === "grooming" || selected === "both";
    const enablePetHotel = selected === "pet_hotel" || selected === "both";
    const groomingInputs = groomingCardBody.querySelectorAll("input, select");

    groomingInputs.forEach((el) => {
      el.disabled = !enableGrooming;
    });

    if (!enableGrooming) {
      groomingInputs.forEach((el) => {
        if (el.tagName.toLowerCase() === "select") {
          $(el).val("").trigger("change");
        } else {
          el.value = "";
        }
      });
    }

    const petHotelInputs = petHotelCardBody.querySelectorAll("input, select");

    petHotelInputs.forEach((el) => {
      el.disabled = !enablePetHotel;
    });

    if (!enablePetHotel) {
      petHotelInputs.forEach((el) => {
        if (el.tagName.toLowerCase() === "select") {
          $(el).val("").trigger("change");
        } else {
          el.value = "";
        }
      });
    }

    if (selected && selected !== "none") {
      serviceCost.disabled = false;

      if (selected === "grooming") {
        serviceAvailed.textContent = "Pet Grooming Service";
      } else if (selected === "pet_hotel") {
        serviceAvailed.textContent = "Pet Hotel Service";
      } else {
        serviceAvailed.textContent =
          "Pet Grooming Service and Pet Hotel Service";
      }
    } else {
      serviceCost.disabled = true;
      serviceCost.value = "";
      serviceAvailed.textContent = "None";
    }
  });
}

function handleServiceCost() {
  const serviceCost = document.getElementById("serviceCost");
  const serviceTotal = document.getElementById("serviceTotal");

  serviceCost.addEventListener("change", function () {
    const serviceRate = parseFloat(this.value) || 0;
    serviceTotal.textContent = serviceRate.toFixed(2);

    updateOrderSummary();
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

function refreshProductOptions() {
  const orderBranch = document.getElementById("orderBranch").value;

  $.ajax({
    url: "/HungryPaws/backend/handle-fetch.php",
    method: "POST",
    data: { submitType: "getCashierProducts", branchId: orderBranch },
    dataType: "json",
    success: function (response) {
      const productSelect = $("#productSelect");
      productSelect.empty();

      if (response.length > 0) {
        productSelect.append(
          '<option value="" disabled selected>Select Product</option>'
        );

        response.forEach((product) => {
          productSelect.append(`
            <option value="${product.product_id}" 
                    data-stock="${product.stock_level}" 
                    data-price="${product.selling_price}">
              ${product.product_name}
            </option>
          `);
        });
      } else {
        productSelect.append(
          '<option value="" disabled selected>No Products Available</option>'
        );
      }

      productSelect.trigger("change.select2");
    },
    error: function (xhr, status, error) {
      console.error("Error fetching products:", error);
    },
  });
}
