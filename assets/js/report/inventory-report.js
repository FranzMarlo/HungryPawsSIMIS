const startDateInput = document.getElementById("startDate");

startDateInput.addEventListener("input", function (e) {
  this.value = this.value.replace(/[^0-9/-]/g, "");
});

const endDateInput = document.getElementById("endDate");

endDateInput.addEventListener("input", function (e) {
  this.value = this.value.replace(/[^0-9/-]/g, "");
});

document
  .getElementById("inventoryReportForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append("submitType", "generateInventoryStatusReport");

    const filterType = document.getElementById("filterType").value;
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    const branchId = document.getElementById("branchId").value;

    formData.append("branch_id", branchId);
    formData.append("filterType", filterType);
    formData.append("startDate", startDate);
    formData.append("endDate", endDate);

    try {
      const response = await fetch("/HungryPaws/backend/handle-fetch.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      const tbody = document.getElementById("inventoryReportBody");
      tbody.innerHTML = "";

      if (result.status === "warning") {
        showWarning(result.title, result.message);
      } else if (result.status === "error") {
        showError(result.title, result.message);
      } else {
        if (result.status === "success" && result.data.length > 0) {
          updateSummaryTable(result.data);

          result.data.forEach((item) => {
            const row = document.createElement("tr");

            row.innerHTML = `
            <td>${item.product_name}</td>
            <td>${item.category}</td>
            <td class="text-center">${item.stock_level}</td>
            <td class="text-center">${item.reorder_point}</td>
            <td>
              <span class="badge ${
                item.stock_level === 0
                  ? "bg-danger"
                  : item.stock_level <= item.reorder_point
                  ? "bg-warning"
                  : "bg-success"
              }">${
              item.stock_level === 0 ? "No Stock" : item.stock_status
            }</span>
            </td>
            <td>${item.last_update_date}</td>
            <td>${item.expiry_date}</td>
          `;

            tbody.appendChild(row);
          });
          showSuccess(
            "Report Generated",
            "Inventory report successfully loaded."
          );
        } else {
          tbody.innerHTML = `
          <tr>
            <td colspan="7" class="text-center text-muted">No records found for the selected date range.</td>
          </tr>`;
          showWarning("No Data Found", "No records for this date range.");
        }
      }
    } catch (error) {
      console.error("Fetch Error:", error);
      showError(
        "Server Error",
        "Unable to load report. Please try again later."
      );
    }
  });

document
  .getElementById("btn-print-report")
  .addEventListener("click", function (e) {
    e.preventDefault();

    const filterType = document.getElementById("filterType").value;
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    const branchId = document.getElementById("branchId").value;

    // 🟡 Validate required inputs
    if (!branchId || !filterType || !startDate || !endDate) {
      showWarning(
        "Missing Fields",
        "Please select a branch, filter type, and date range before printing the report."
      );
      return;
    }

    const form = document.getElementById("inventoryReportForm");
    const formData = new FormData(form);
    formData.append("submitType", "generateInventoryStatusReport");

    const tempForm = document.createElement("form");
    tempForm.method = "POST";
    tempForm.action = "print-product-report";
    tempForm.target = "_blank";

    for (const [key, value] of formData.entries()) {
      const input = document.createElement("input");
      input.type = "hidden";
      input.name = key;
      input.value = value;
      tempForm.appendChild(input);
    }

    document.body.appendChild(tempForm);
    tempForm.submit();

    document.body.removeChild(tempForm);
  });

function updateSummaryTable(data) {
  let totalProducts = data.length;
  let lowStockCount = 0;
  let noStockCount = 0;
  let totalStock = 0;
  let totalValue = 0;
  let totalSales = 0;

  data.forEach((item) => {
    totalStock += parseInt(item.stock_level);
    if (parseInt(item.stock_level) == 0) {
      noStockCount++;
    } else if (parseInt(item.stock_level) <= parseInt(item.reorder_point)) {
      lowStockCount++;
    }
    totalValue += item.stock_level * item.unit_cost;
    totalSales += item.stock_level * item.selling_price;
  });

  document.getElementById("totalProducts").textContent = totalProducts;
  document.getElementById("lowStock").textContent = lowStockCount;
  document.getElementById("noStock").textContent = noStockCount;
  document.getElementById("totalStock").textContent = totalStock;
  document.getElementById("inventoryValue").textContent =
    "₱ " + totalValue.toLocaleString();
  document.getElementById("salesValue").textContent =
    "₱ " + totalSales.toLocaleString();
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
