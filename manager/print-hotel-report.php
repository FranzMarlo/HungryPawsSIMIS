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
    <title>Pet Hotel Report</title>
    <link rel="shortcut icon" href="/HungryPaws/assets/img/hungrypaws.png" type="image/x-icon">
    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/bootstrap/css/bootstrap.css" />

    <!-- Invoice Print Style -->
    <link rel="stylesheet" href="/HungryPaws/assets/css/invoice-print.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/css/custom.css" />
</head>

<body>
    <div class="invoice">
        <header class="clearfix">
            <div class="row">
                <div class="col-sm-6 mt-3">
                    <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">Pet Hotel Report</h2>
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

        <div class="table-responsive">
            <table class="table table-ecommerce-simple table-striped mb-0 text-center align-middle">
                <thead>
                    <tr class="text-dark">
                        <th class="font-weight-semibold">Booking ID</th>
                        <th class="font-weight-semibold">Order ID</th>
                        <th class="font-weight-semibold">Pet Type</th>
                        <th class="font-weight-semibold">Room Type</th>
                        <th class="font-weight-semibold">Check In Date</th>
                        <th class="font-weight-semibold">Check Out Date</th>
                    </tr>
                </thead>
                <tbody id="bookingReportBody">
                    <tr>
                        <td colspan="6">Please Set Filters</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="invoice-summary">
            <div class="row justify-content-end">
                <div class="col-sm-6">
                    <table class="table h6 text-dark">
                        <tbody>
                            <tr>
                                <td>Total Pet Types Booked</td>
                                <td id="totalPet" class="text-end">N/A</td>
                            </tr>
                            <tr class="h5">
                                <td><strong>Total Booking Services</strong></td>
                                <td id="totalBooking" class="text-end"><strong>N/A</strong></td>
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
            const startDate = "<?= htmlspecialchars($_POST['startDate'] ?? '') ?>";
            const endDate = "<?= htmlspecialchars($_POST['endDate'] ?? '') ?>";

            const formData = new FormData();
            formData.append("submitType", "generateBookingReport");
            formData.append("branch_id", branchId);
            formData.append("startDate", startDate);
            formData.append("endDate", endDate);

            try {
                const response = await fetch("/HungryPaws/backend/handle-fetch.php", {
                    method: "POST",
                    body: formData,
                });

                const result = await response.json();
                const tbody = document.getElementById("bookingReportBody");
                tbody.innerHTML = "";

                if (result.status === "success" && result.booking_list.length > 0) {
                    updateSummaryTable(result.total_pet, result.total_booking);

                    result.booking_list.forEach((item) => {
                        const row = document.createElement("tr");

                        row.innerHTML = `
                        <td>${item.booking_id}</td>
                        <td>${item.order_id}</td>
                        <td>${item.pet_type}</td>
                        <td>${item.room_type}</td>
                        <td>${item.check_in_date}</td>
                        <td>${item.check_out_date}</td>
                    `;

                        tbody.appendChild(row);
                    });

                    window.print();

                } else {
                    tbody.innerHTML = `
            <tr>
              <td colspan="6" class="text-center text-muted">No records found for the selected date range.</td>
            </tr>`;
                }

            } catch (error) {
                console.error("Fetch Error:", error);
            }
        });

        function updateSummaryTable(totalPet, totalBooking) {
            if (totalPet === "" || totalBooking === "") {
                document.getElementById("totalPet").textContent = "N/A";
                document.getElementById("totalBooking").textContent = "N/A";
            } else {
                document.getElementById("totalPet").textContent = totalPet;
                document.getElementById("totalBooking").textContent = totalBooking;
            }
        }

    </script>

</body>

</html>