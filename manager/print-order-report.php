<html>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';
$fetch = new fetchClass();

$branchId = $_POST['branchId'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';

$branch = $fetch->getBranchDetails($branchId);
?>


<head>
    <title>Sales Report</title>
    <link rel="shortcut icon" href="/HungryPaws/assets/img/hungrypaws.png" type="image/x-icon">
    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/bootstrap/css/bootstrap.css" />

    <!-- Invoice Print Style -->
    <link rel="stylesheet" href="/HungryPaws/assets/css/invoice-print.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/css/custom.css" />

</head>

<style>
    .chart-container {
        position: relative;
        width: 100%;
        height: 60vh;
        overflow: hidden;
    }

    .chart-container canvas {
        width: 100% !important;
        height: 100% !important;
    }

    #paymentMethod {
        height: 30vh;
    }

    @media print {

        .chart-container {
            width: 100% !important;
            height: auto !important;
            margin-bottom: 20px;
        }

        .chart-container canvas {
            max-width: 100% !important;
            height: auto !important;
            object-fit: contain;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ccc !important;
        }
    }
</style>

<body>
    <div class="invoice">
        <header class="clearfix">
            <div class="row">
                <div class="col-sm-6 mt-3">
                    <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">Sales Report</h2>
                    <h4 class="h5 m-0 text-dark font-weight-bold">
                        <?= htmlspecialchars($branch['branch_name']) ?>
                    </h4>
                </div>
                <div class="col-sm-6 text-end mt-3 mb-3 d-flex flex-column align-items-end">
                    <div class="mb-2">
                        <img src="/HungryPaws/assets/img/hungrypaws.png" alt="Hungry Paws" class="invoice-logo" />
                    </div>
                    <div>
                        <address class="text-end">
                            <?= htmlspecialchars($branch['branch_name']) ?><br />
                            <?= htmlspecialchars($branch['address']) ?><br />
                            <?= htmlspecialchars($branch['contact_number']) ?>
                        </address>
                    </div>
                </div>

            </div>
        </header>

        <div class="row">
            <div class="col-12">
                <section class="card shadow-sm mb-5 border">
                    <header class="card-header">
                        <h2 class="card-title">Daily Sales Performance</h2>
                    </header>
                    <div class="card-body">
                        <div class="chart chart-lg chart-container" id="salesLine">
                            <canvas id="salesLineCanvas"></canvas>
                            <div id="salesLinePlaceholder" style="text-align:center; padding:40px; color:#6c757d;">
                                Please Set Filter First
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <section class="card shadow-sm mb-5 border">
                    <header class="card-header">
                        <h2 class="card-title">Top Products Sold</h2>
                    </header>
                    <div class="card-body">
                        <div class="chart chart-lg chart-container" id="salesBar">
                            <div id="salesBarPlaceholder" style="text-align:center; padding:40px; color:#6c757d;">
                                Please Set Filter First
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <section class="card shadow-sm mb-5 border">
                    <header class="card-header">
                        <h2 class="card-title">Order Processed By Payment Method</h2>
                    </header>
                    <div class="card-body">
                        <div class="d-flex justify-content-center chart chart-md chart-container" id="paymentMethod">
                            <div id="paymentMethodPlaceholder" style="text-align:center; padding:40px; color:#6c757d;">
                                Please Set Filter First
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-lg-6">
                <section class="card shadow-sm mb-5 border">
                    <header class="card-header">
                        <h2 class="card-title">Product Sold By Category</h2>
                    </header>
                    <div class="card-body">
                        <div class="chart chart-md chart-container" id="category">
                            <div id="categoryPlaceholder" style="text-align:center; padding:40px; color:#6c757d;">
                                Please Set Filter First
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>

    <script src="/HungryPaws/assets/vendor/jquery/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        window.addEventListener("beforeprint", () => {
            for (const id of ["salesLineCanvas", "salesBarCanvas", "paymentMethodCanvas", "categoryCanvas"]) {
                const canvas = document.getElementById(id);
                if (canvas && canvas.chart) {
                    canvas.chart.resize();
                }
            }
        });
        document.addEventListener("DOMContentLoaded", async () => {
            const formData = {
                startDate: "<?= htmlspecialchars($_POST['startDate'] ?? '') ?>",
                endDate: "<?= htmlspecialchars($_POST['endDate'] ?? '') ?>",
                branchId: "<?= htmlspecialchars($_POST['branchId'] ?? '') ?>",
            };

            $.ajax({
                url: "/HungryPaws/backend/manager/sales-report.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    const salesData = response.sales_performance;
                    const topProductData = response.top_product;
                    const paymentMethodData = response.payment_method;
                    const categoryData = response.category;

                    loadSalesLineChart(salesData);
                    loadTopProducts(topProductData);
                    loadPaymentMethod(paymentMethodData);
                    loadCategoryBreakdown(categoryData);
                    window.print();
                },
            });
        });

        let salesLineChart;
        let salesBarChart;
        let paymentChart;
        let categoryChart;

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
                    maintainAspectRatio: false,
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


    </script>

</body>

</html>