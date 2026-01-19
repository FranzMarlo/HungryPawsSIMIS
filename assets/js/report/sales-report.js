$("#salesReportForm").on("submit", function (e) {
  e.preventDefault();

  const formData = {
    startDate: $("#startDate").val(),
    endDate: $("#endDate").val(),
    branchId: $("#branchId").val(),
  };

  $.ajax({
    url: "/HungryPaws/backend/manager/sales-report.php",
    type: "POST",
    data: formData,
    dataType: "json",
    success: function (response) {
      const salesData = response.sales_performance ?? [];
      const topProductData = response.top_product ?? [];
      const paymentMethodData = response.payment_method ?? [];
      const categoryData = response.category ?? [];

      if (response.status === "success") {
        loadSalesLineChart(salesData);
        loadTopProducts(topProductData);
        loadPaymentMethod(paymentMethodData);
        loadCategoryBreakdown(categoryData);
        showSuccess(response.title, response.message);
      } else if (response.status === "warning") {
        showWarning(response.title, response.message);
      } else if (response.status === "info") {
        loadSalesLineChart(salesData);
        loadTopProducts(topProductData);
        loadPaymentMethod(paymentMethodData);
        loadCategoryBreakdown(categoryData);
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

    if (!branchId || !startDate || !endDate) {
      showWarning(
        "Missing Fields",
        "Please select a branch and date range before printing the report."
      );
      return;
    }

    const form = document.getElementById("salesReportForm");
    const formData = new FormData(form);

    const tempForm = document.createElement("form");
    tempForm.method = "POST";
    tempForm.action = "print-order-report";
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

let salesLineChart;
let salesBarChart;
let paymentChart;
let categoryChart;

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

function loadSalesLineChart(data) {
  $("#salesLinePlaceholder").remove();
  $("#salesLineCanvas").remove();
  $("#salesLine").append(`<canvas id="salesLineCanvas"></canvas>`);

  if (!Array.isArray(data) || data.length === 0) {
    $("#salesLine").html(`
      <div class="text-center text-muted py-5" id="salesLinePlaceholder">
        <h5>No Sales Records Found</h5>
        <h5>Select a different date range.</h5>
      </div>
    `);
    return;
  }

  const labels = data.map((row) => row.date);
  const totalSales = data.map((row) => Number(row.total_sales));
  const totalOrders = data.map((row) => Number(row.total_orders));
  const avgOrderValue = data.map((row) => Number(row.avg_order_value));

  const ctx = document.getElementById("salesLineCanvas").getContext("2d");

  if (salesLineChart) {
    salesLineChart.destroy();
  }

  salesLineChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Total Sales (₱)",
          data: totalSales,
          borderColor: "#1f77b4", // Deep blue
          backgroundColor: "#1f77b4",
          borderWidth: 4,
          pointRadius: 5,
          tension: 0.4,
        },
        {
          label: "Total Orders",
          data: totalOrders,
          borderColor: "#2ca02c", // Olive green
          backgroundColor: "#2ca02c",
          borderWidth: 4,
          pointRadius: 5,
          tension: 0.4,
        },
        {
          label: "Avg Order Value (₱)",
          data: avgOrderValue,
          borderColor: "#ff7f0e", // Burnt orange
          backgroundColor: "#ff7f0e",
          borderWidth: 4,
          pointRadius: 5,
          tension: 0.4,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          position: "top",
          labels: { font: { size: 14 } },
        },
        tooltip: {
          callbacks: {
            label: function (context) {
              const label = context.dataset.label + ": ";
              let value = context.parsed.y;

              if (context.dataset.label.includes("₱")) {
                return label + "₱" + Number(value).toLocaleString();
              }
              return label + value;
            },
          },
        },
      },
      scales: {
        x: { ticks: { maxRotation: 45, minRotation: 45 } },
        y: { beginAtZero: true },
      },
    },
  });
}

function loadTopProducts(data) {
  $("#salesBarPlaceholder").remove();
  $("#salesBar").empty();
  $("#salesBar").append(`<canvas id="salesBarCanvas"></canvas>`);

  if (!Array.isArray(data) || data.length === 0) {
    $("#salesBar").html(`
      <div class="text-center text-muted py-5" id="salesBarPlaceholder">
        <h5>No Sales Records Found</h5>
        <h5>Select a different date range.</h5>
      </div>
    `);
    return;
  }

  const shortenLabel = (name, max = 12) =>
    name.length > max ? name.substring(0, max) + "…" : name;

  const chartData = data.map((row) => ({
    product: shortenLabel(row.product_name),
    full_product: row.product_name,
    total_sold: Number(row.total_sold),
  }));

  const naturalColors = [
    "#4e79a7", // blue
    "#59a14f", // green
    "#f28e2c", // orange
    "#e15759", // red
    "#76b7b2", // teal
    "#edc948", // yellow-gold
    "#b07aa1", // purple
    "#ff9da7", // soft pink
    "#9c755f", // brown
    "#bab0ac", // warm gray
  ];

  const ctx = document.getElementById("salesBarCanvas").getContext("2d");

  if (salesBarChart) {
    salesBarChart.destroy();
  }

  const datasets = chartData.map((row, index) => ({
    label: row.product,
    data: [row.total_sold],
    backgroundColor: naturalColors[index % naturalColors.length],
    borderColor: naturalColors[index % naturalColors.length],
    borderWidth: 1,
  }));

  salesBarChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [""],
      datasets: datasets,
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,

      plugins: {
        legend: {
          display: true,
          position: "bottom",
          labels: {
            font: { size: 13 },
            boxWidth: 18,
            padding: 12,
          },
        },
        tooltip: {
          callbacks: {
            title: function () {
              return "";
            },
            label: function (context) {
              const fullName = chartData[context.datasetIndex].full_product;
              const sold = context.raw.toLocaleString();
              return `${fullName}: ${sold} sold`;
            },
          },
        },
      },

      scales: {
        x: {
          display: false,
        },
        y: {
          beginAtZero: true,
          ticks: { font: { size: 12 } },
        },
      },
    },
  });
}

function loadPaymentMethod(data) {
  $("#paymentMethodPlaceholder").remove();
  $("#paymentMethod").html(`<canvas id="paymentPieChart"></canvas>`);

  if (!Array.isArray(data) || data.length === 0) {
    $("#paymentMethod").html(`
      <div class="text-center text-muted py-5" id="paymentMethodPlaceholder">
        <h5>No Sales Records Found</h5>
        <h5>Select a different date range.</h5>
      </div>
    `);
    return;
  }

  const labels = data.map((item) => item.payment_method);
  const values = data.map((item) => Number(item.total_orders));

  if (paymentChart) paymentChart.destroy();

  const ctx = document.getElementById("paymentPieChart").getContext("2d");

  paymentChart = new Chart(ctx, {
    type: "pie",
    data: {
      labels: labels,
      datasets: [
        {
          data: values,
          backgroundColor: [
            "#007bff",
            "#28a745",
            "#ffc107",
            "#dc3545",
            "#6f42c1",
            "#17a2b8",
          ],
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            padding: 20,
            font: { size: 14 },

            // ⭐ MODIFY LEGEND LABEL TEXT
            generateLabels(chart) {
              const original =
                Chart.overrides.pie.plugins.legend.labels.generateLabels(chart);
              return original.map((item, index) => {
                const method = labels[index];
                const total = values[index];
                return {
                  ...item,
                  text: `${method}: ${total} orders`, // 👈 added value
                };
              });
            },
          },
        },

        tooltip: {
          callbacks: {
            label: (context) => {
              const orders = context.raw;
              const label = context.label;
              const total = values.reduce((a, b) => a + b, 0);
              const percent = ((orders / total) * 100).toFixed(1);
              return `${label}: ${orders} orders (${percent}%)`;
            },
          },
        },
      },
    },
  });
}

function loadCategoryBreakdown(data) {
  $("#categoryPlaceholder").remove();
  $("#category").empty();
  $("#category").append(`<canvas id="categoryCanvas"></canvas>`);

  if (!Array.isArray(data) || data.length === 0) {
    $("#category").html(`
      <div class="text-center text-muted py-5" id="categoryPlaceholder">
        <h5>No Sales Records Found</h5>
        <h5>Select a different date range.</h5>
      </div>
    `);
    return;
  }

  const shortenLabel = (name, max = 12) =>
    name.length > max ? name.substring(0, max) + "…" : name;

  const chartData = data.map((row) => ({
    category: shortenLabel(row.category),
    full_category: row.category,
    total_sold: Number(row.total_sold),
  }));

  const naturalColors = [
    "#4e79a7", // blue
    "#59a14f", // green
    "#f28e2c", // orange
    "#e15759", // red
    "#76b7b2", // teal
    "#edc948", // yellow-gold
    "#b07aa1", // purple
    "#ff9da7", // soft pink
    "#9c755f", // brown
    "#bab0ac", // warm gray
  ];

  const ctx = document.getElementById("categoryCanvas").getContext("2d");

  if (categoryChart) {
    categoryChart.destroy();
  }

  // Each bar is its own dataset (so legend shows one color per category)
  const datasets = chartData.map((row, i) => ({
    label: row.category,
    data: [row.total_sold],
    backgroundColor: naturalColors[i % naturalColors.length],
    borderColor: naturalColors[i % naturalColors.length],
    borderWidth: 1,
  }));

  categoryChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [""], // dummy x-axis
      datasets: datasets,
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,

      plugins: {
        legend: {
          display: true,
          position: "bottom", // ⬅ legend moved to bottom
          labels: {
            font: { size: 13 },
            boxWidth: 18,
            padding: 10,
          },
        },
        tooltip: {
          callbacks: {
            title: () => "",
            label: (context) => {
              const full = chartData[context.datasetIndex].full_category;
              const value = context.raw.toLocaleString();
              return `${full}: ${value} sold`;
            },
          },
        },
      },

      scales: {
        x: { display: false }, // legend replaces x-axis labels
        y: {
          beginAtZero: true,
          ticks: { font: { size: 12 } },
        },
      },
    },
  });
}
