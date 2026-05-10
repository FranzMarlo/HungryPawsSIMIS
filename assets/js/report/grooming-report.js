const startDateInput = document.getElementById("startDate");

startDateInput.addEventListener("input", function (e) {
  this.value = this.value.replace(/[^0-9/-]/g, "");
});

const endDateInput = document.getElementById("endDate");

endDateInput.addEventListener("input", function (e) {
  this.value = this.value.replace(/[^0-9/-]/g, "");
});

document
  .getElementById("groomingReportForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append("submitType", "generateGroomingReport");

    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    const branchId = document.getElementById("branchId").value;

    formData.append("branch_id", branchId);
    formData.append("startDate", startDate);
    formData.append("endDate", endDate);

    try {
      const response = await fetch("/HungryPaws/backend/handle-fetch.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      const tbody = document.getElementById("groomingReportBody");
      tbody.innerHTML = "";

      if (result.status === "warning") {
        showWarning(result.title, result.message);
      } else if (result.status === "error") {
        showError(result.title, result.message);
      } else if (result.status === "info") {
        updateSummaryTable(result.total_pet, result.total_grooming);
        tbody.innerHTML = `
          <tr>
            <td colspan="6" class="text-center text-muted">No records found for the selected date range.</td>
          </tr>`;

        showInfo(result.title, result.message);
      } else {
        updateSummaryTable(result.total_pet, result.total_grooming);

        result.grooming_list.forEach((item) => {
          const row = document.createElement("tr");

          row.innerHTML = `
            <td>${item.service_id}</td>
            <td>${item.order_id}</td>
            <td>${item.pet_type}</td>
            <td>${item.pet_size}</td>
            <td>${item.first_name} ${item.last_name}</td>
            <td>${item.schedule_date}</td>
          `;

          tbody.appendChild(row);
        });
        showSuccess(
          "Report Generated",
          "Inventory report successfully loaded.",
        );
      }
    } catch (error) {
      console.error("Fetch Error:", error);
      showError(
        "Server Error",
        "Unable to load report. Please try again later.",
      );
    }
  });

document
  .getElementById("btn-print-report")
  .addEventListener("click", function (e) {
    e.preventDefault();

    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    const branchId = document.getElementById("branchId").value;

    if (!startDate || !endDate) {
      showWarning(
        "Missing Fields",
        "Please select date range before printing the report.",
      );
      return;
    }

    const form = document.getElementById("groomingReportForm");
    const formData = new FormData(form);
    formData.append("submitType", "generateGroomingReport");

    const tempForm = document.createElement("form");
    tempForm.method = "POST";
    tempForm.action = "print-grooming-report";
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

function updateSummaryTable(totalPet, totalGrooming) {
  if (totalPet === "" || totalGrooming === "") {
    document.getElementById("totalPet").textContent = "N/A";
    document.getElementById("totalGrooming").textContent = "N/A";
  } else {
    document.getElementById("totalPet").textContent = totalPet;
    document.getElementById("totalGrooming").textContent = totalGrooming;
  }
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
