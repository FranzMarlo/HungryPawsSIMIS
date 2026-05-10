<html>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';
$fetch = new fetchClass();

$branchId = $_POST['branchId'] ?? '';
$filterType = $_POST['filterType'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';

$branch = $fetch->getBranchDetails($branchId);


?>


<head>
    <title>Inventory Report</title>
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
    @media print {

        .badge.bg-danger,
        .badge.bg-warning,
        .badge.bg-success {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color: white !important;
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: black !important;
        }

        .badge.bg-success {
            background-color: #198754 !important;
        }
    }
</style>


<body>
    <div class="invoice">
        <header class="clearfix">
            <div class="row">
                <div class="col-sm-6 mt-3">
                    <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">Inventory Status Report</h2>
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

        <table class="table table-ecommerce-simple table-striped mb-0 text-center align-middle">
            <thead>
                <tr class="text-dark">
                    <th class="font-weight-semibold">Product</th>
                    <th class="font-weight-semibold">Category</th>
                    <th class="font-weight-semibold">Stock Level</th>
                    <th class="font-weight-semibold">Reorder Point</th>
                    <th class="font-weight-semibold">Stock Status</th>
                    <th class="font-weight-semibold">Last Update</th>
                    <th class="font-weight-semibold">Expiry Date</th>
                </tr>
            </thead>
            <tbody id="inventoryReportBody">

            </tbody>
        </table>

        <div class="invoice-summary">
            <div class="row justify-content-end">
                <div class="col-sm-6">
                    <table class="table h6 text-dark">
                        <tbody>
                            <tr>
                                <td>Total Products</td>
                                <td id="totalProducts" class="text-end">N/A</td>
                            </tr>
                            <tr>
                                <td>Low Stock Items</td>
                                <td id="lowStock" class="text-end text-warning">N/A</td>
                            </tr>
                            <tr>
                                <td>Out Of Stock Items</td>
                                <td id="noStock" class="text-end text-danger">N/A</td>
                            </tr>
                            <tr>
                                <td>Total Stock Quantity</td>
                                <td id="totalStock" class="text-end">N/A</td>
                            </tr>
                            <tr>
                                <td>Inventory Value</td>
                                <td id="inventoryValue" class="text-end">N/A</td>
                            </tr>
                            <tr class="h5">
                                <td><strong>Potential Sales Value</strong></td>
                                <td id="salesValue" class="text-end"><strong>N/A</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const branchId = "<?= htmlspecialchars($_POST['branchId'] ?? '') ?>";
            const filterType = "<?= htmlspecialchars($_POST['filterType'] ?? '') ?>";
            const startDate = "<?= htmlspecialchars($_POST['startDate'] ?? '') ?>";
            const endDate = "<?= htmlspecialchars($_POST['endDate'] ?? '') ?>";

            const formData = new FormData();
            formData.append("submitType", "generateInventoryStatusReport");
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
                            <span class="badge ${item.stock_level === 0
                                ? "bg-danger"
                                : item.stock_level <= item.reorder_point
                                    ? "bg-warning"
                                    : "bg-success"
                            }">${item.stock_level === 0 ? "No Stock" : item.stock_status
                            }</span>
                        </td>
                        <td>${item.last_update_date}</td>
                        <td>${item.expiry_date}</td>
                        `;
                        tbody.appendChild(row);
                    });

                    window.print();

                } else {
                    tbody.innerHTML = `
            <tr>
              <td colspan="7" class="text-center text-muted">No records found for the selected date range.</td>
            </tr>`;
                }

            } catch (error) {
                console.error("Fetch Error:", error);
            }
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


    </script>

</body>

</html>