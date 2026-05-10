$("#transferReportForm").on("submit", function (e) {
  e.preventDefault();

  const formData = {
    startDate: $("#startDate").val(),
    endDate: $("#endDate").val(),
    branchId: $("#branchId").val(),
  };

  $.ajax({
    url: "/HungryPaws/backend/manager/transfer-report.php",
    type: "POST",
    data: formData,
    dataType: "json",
    success: function (response) {
      const topProductData = response.top_product ?? [];
      const transferCostData = response.transfer_cost ?? [];
      const transferStatusData = response.transfer_status ?? [];
      const transferTrendData = response.transfer_trend ?? [];

      if (response.status === "success") {
        loadMostTransferredProductsChart(topProductData);
        loadTransferCostValueChart(transferCostData);
        loadTransferStatusChart(transferStatusData);
        loadTransferTrendChart(transferTrendData);
        showSuccess(response.title, response.message);
      } else if (response.status === "warning") {
        showWarning(response.title, response.message);
      } else if (response.status === "info") {
        loadMostTransferredProductsChart(topProductData);
        loadTransferCostValueChart(transferCostData);
        loadTransferStatusChart(transferStatusData);
        loadTransferTrendChart(transferTrendData);
        showInfo(response.title, response.message);
      } else {
        showError(response.title, response.message);
      }
    },
  });
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
        "Please select a branch and date range before printing the report.",
      );
      return;
    }

    const form = document.getElementById("transferReportForm");
    const formData = new FormData(form);

    const tempForm = document.createElement("form");
    tempForm.method = "POST";
    tempForm.action = "print-transfer-report";
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

let mostTransferredChart;
let transferCostChart;
let transferStatusChart;
let transferTrendChart;

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

function shortenLabel(label) {
  return label.length > 8 ? label.substring(0, 8) + "..." : label;
}

function loadMostTransferredProductsChart(data) {
  $("#mostTransferredPlaceholder").remove();
  $("#mostTransferredCanvas").remove();
  $("#mostTransferredChart").append(
    `<canvas id="mostTransferredCanvas"></canvas>`,
  );

  if (!Array.isArray(data) || data.length === 0) {
    $("#mostTransferredChart").html(`
      <div class="text-center text-muted py-5" id="mostTransferredPlaceholder">
        <h5>No Transfer Records Found</h5>
        <h5>Select a different date range.</h5>
      </div>
    `);
    return;
  }

  const labels = data.map((row) => row.product_name);
  const quantities = data.map((row) => Number(row.total_transferred));

  const ctx = document.getElementById("mostTransferredCanvas").getContext("2d");

  if (mostTransferredChart) {
    mostTransferredChart.destroy();
  }

  mostTransferredChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Total Quantity Transferred",
          data: quantities,
          backgroundColor: "#1f77b4",
          borderColor: "#1f77b4",
          borderWidth: 1,
        },
      ],
    },
    options: {
      indexAxis: "y", // Horizontal Bar Chart
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function (context) {
              return "Total Transferred: " + context.parsed.x.toLocaleString();
            },
          },
        },
      },
      scales: {
        x: { beginAtZero: true },
        y: {
          ticks: {
            autoSkip: false, // Show all product names
            font: { size: 12 },
          },
        },
      },
    },
  });
}

function loadTransferCostValueChart(data) {
  $("#transferCostPlaceholder").remove();
  $("#transferCostCanvas").remove();
  $("#transferCostChart").append(`<canvas id="transferCostCanvas"></canvas>`);

  if (!Array.isArray(data) || data.length === 0) {
    $("#transferCostChart").html(`
      <div class="text-center text-muted py-5" id="transferCostPlaceholder">
        <h5>No Transfer Records Found</h5>
        <h5>Select a different date range.</h5>
      </div>
    `);
    return;
  }

  const labels = data.map((row) => row.product_name);
  const totalQuantity = data.map((row) => Number(row.total_quantity));
  const totalCost = data.map((row) => Number(row.total_cost_value));
  const totalSales = data.map((row) => Number(row.total_sales_value));
  const totalProfit = data.map((row) => Number(row.total_potential_profit));

  const ctx = document.getElementById("transferCostCanvas").getContext("2d");

  // Destroy previous instance
  if (transferCostChart) {
    transferCostChart.destroy();
  }

  transferCostChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Quantity Transferred",
          data: totalQuantity,
          backgroundColor: "#1f77b4",
        },
        {
          label: "Total Cost Value (₱)",
          data: totalCost,
          backgroundColor: "#ff7f0e",
        },
        {
          label: "Total Sales Value (₱)",
          data: totalSales,
          backgroundColor: "#2ca02c",
        },
        {
          label: "Potential Profit (₱)",
          data: totalProfit,
          backgroundColor: "#d62728",
        },
      ],
    },
    options: {
      indexAxis: "y", // HORIZONTAL BAR CHART
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          position: "top",
        },
        tooltip: {
          callbacks: {
            label: function (context) {
              let label = context.dataset.label + ": ";
              let value = Number(context.parsed.x);

              if (label.includes("₱")) {
                return label + "₱" + value.toLocaleString();
              }
              return label + value.toLocaleString();
            },
          },
        },
      },
      scales: {
        x: { beginAtZero: true },
        y: {
          ticks: {
            autoSkip: false,
            font: { size: 12 },
          },
        },
      },
    },
  });
}

function loadTransferStatusChart(data) {
  $("#transferStatusPlaceholder").remove();
  $("#transferStatusCanvas").remove();

  $("#transferStatusChart").append(
    `<canvas id="transferStatusCanvas"></canvas>`,
  );

  if (!Array.isArray(data) || data.length === 0) {
    $("#transferStatusChart").html(`
      <div class="text-center text-muted py-5" id="transferStatusPlaceholder">
        <h5>No Transfer Records Found</h5>
        <h5>Select a different date range.</h5>
      </div>
    `);
    return;
  }

  const rawLabels = data.map((row) => row.status);
  const totals = data.map((row) => Number(row.total_transfers));

  const colorMap = {
    Completed: "#28a745",
    Approved: "#8fd19e",
    Requested: "#ffc107",
    Cancelled: "#dc3545",
  };
  const bgColors = data.map((row) => colorMap[row.status] || "#6c757d");

  const ctx = document.getElementById("transferStatusCanvas").getContext("2d");

  if (transferStatusChart) transferStatusChart.destroy();

  transferStatusChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: rawLabels,
      datasets: [
        {
          data: totals,
          backgroundColor: bgColors,
          borderWidth: 2,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            font: {
              size: 13,
              weight: "bold",
            },
            padding: 16,
            generateLabels: function (chart) {
              const data = chart.data;
              if (!data.labels.length) return [];
              return data.labels.map((label, i) => {
                const value = data.datasets[0].data[i];
                const bgColor = data.datasets[0].backgroundColor[i];
                return {
                  text: `${label} (${value})`,
                  fillStyle: bgColor,
                  strokeStyle: bgColor,
                  lineWidth: 1,
                  hidden: false,
                  index: i,
                };
              });
            },
          },
        },
        tooltip: {
          callbacks: {
            label: function (context) {
              const status = rawLabels[context.dataIndex]; // Only status
              const value = context.raw;
              return `${status}: ${value} transfers`;
            },
          },
        },
      },
    },
  });
}

function loadTransferTrendChart(data) {
  $("#transferTrendPlaceholder").remove();
  $("#transferTrendCanvas").remove();

  $("#transferTrendChart").append(`
    <canvas id="transferTrendCanvas"></canvas>
  `);

  if (!Array.isArray(data) || data.length === 0) {
    $("#transferTrendChart").html(`
      <div class="text-center text-muted py-5" id="transferTrendPlaceholder">
        <h5>No Transfer Trend Data Found</h5>
      </div>
    `);
    return;
  }

  const labels = data.map((row) => row.period_label);
  const totals = data.map((row) => Number(row.total_transfers));

  const ctx = document.getElementById("transferTrendCanvas").getContext("2d");

  if (transferTrendChart) transferTrendChart.destroy();

  transferTrendTrendChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Total Transfers",
          data: totals,
          borderWidth: 3,
          tension: 0.4,
          pointRadius: 5,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: { beginAtZero: true },
      },
    },
  });
}
