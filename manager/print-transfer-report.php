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
    <title>Transfer Report</title>
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
                    <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">Stock Tranfer Report</h2>
                    <h4 class="h5 m-0 text-dark font-weight-bold">
                        <?php if ($branch != ''): ?>
                            <?= htmlspecialchars($branch['branch_name']) ?>
                        <?php else: ?>
                            The Hungry Paws
                        <?php endif; ?>
                    </h4>
                </div>
                <div class="col-sm-6 text-end mt-3 mb-3 d-flex flex-column align-items-end">
                    <div class="mb-2">
                        <img src="/HungryPaws/assets/img/hungrypaws.png" alt="Hungry Paws" class="invoice-logo" />
                    </div>
                    <?php if ($branchId): ?>
                        <div>
                            <address class="text-end">
                                <?= htmlspecialchars($branch['branch_name']) ?><br />
                                <?= htmlspecialchars($branch['address']) ?><br />
                                <?= htmlspecialchars($branch['contact_number']) ?>
                            </address>
                        </div>
                    <?php else: ?>
                    <?php endif; ?>
                </div>

            </div>
        </header>

        <div class="row">
            <div class="col-12">
                <section class="card shadow-sm mb-5 border">
                    <header class="card-header">
                        <h2 class="card-title">Most Transferred Products</h2>
                    </header>
                    <div class="card-body">
                        <div class="chart chart-lg chart-container" id="mostTransferredChart">
                            <canvas id="mostTransferredCanvas"></canvas>
                            <div id="mostTransferredPlaceholder"
                                style="text-align:center; padding:40px; color:#6c757d;">
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
                        <h2 class="card-title">Transfers Cost Value</h2>
                    </header>
                    <div class="card-body">
                        <div class="chart chart-lg chart-container" id="transferCostChart">
                            <canvas id="transferCostCanvas"></canvas>
                            <div id="transferCostPlaceholder" style="text-align:center; padding:40px; color:#6c757d;">
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
                        <h2 class="card-title">Transfers By Status</h2>
                    </header>
                    <div class="card-body">
                        <div class="chart chart-md chart-container" id="transferStatusChart">
                            <canvas id="transferStatusCanvas"></canvas>
                            <div id="transferStatusPlaceholder" style="text-align:center; padding:40px; color:#6c757d;">
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
                        <h2 class="card-title">Stock Transfer Trend</h2>
                    </header>
                    <div class="card-body">
                        <div class="chart chart-lg chart-container" id="transferTrendChart">
                            <canvas id="transferTrendCanvas"></canvas>
                            <div id="transferTrendPlaceholder" style="text-align:center; padding:40px; color:#6c757d;">
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
            for (const id of ["mostTransferredCanvas", "transferCostCanvas", "transferStatusCanvas", "transferTrendCanvas"]) {
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
                url: "/HungryPaws/backend/manager/transfer-report.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    const topProductData = response.top_product;
                    const transferCostData = response.transfer_cost;
                    const transferStatusData = response.transfer_status;
                    const transferTrendData = response.transfer_trend;

                    loadMostTransferredProductsChart(topProductData);
                    loadTransferCostValueChart(transferCostData);
                    loadTransferStatusChart(transferStatusData);
                    loadTransferTrendChart(transferTrendData);
                    window.print();
                },
            });
        });

        let mostTransferredChart;
        let transferCostChart;
        let transferStatusChart;
        let transferTrendChart;

        function loadMostTransferredProductsChart(data) {
            $("#mostTransferredPlaceholder").remove();
            $("#mostTransferredCanvas").remove();
            $("#mostTransferredChart").append(
                `<canvas id="mostTransferredCanvas"></canvas>`
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
                `<canvas id="transferStatusCanvas"></canvas>`
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


    </script>

</body>

</html>