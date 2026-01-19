<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Product Report | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/manager-head.php';
$fetch = new fetchClass();
$branch = $fetch->getBranchDetails($branch_id) ?>

<body>
    <section class="body">

        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/manager-header.php';
        ?>

        <div class="inner-wrapper">
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/manager-sidebar.php';
            ?>

            <section role="main" class="content-body content-body-modern mt-0">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">Generate Report</h2>
                </header>


                <!-- start: page -->
                <section class="card">
                    <div class="card-body">
                        <div class="invoice">
                            <header class="clearfix">
                                <div class="row">
                                    <div class="col-sm-6 mt-3">
                                        <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">Inventory Status Report</h2>
                                        <h4 class="h5 m-0 text-dark font-weight-bold">
                                            <?= htmlspecialchars($branch['branch_name']) ?>
                                        </h4>
                                    </div>
                                    <div class="col-sm-6 text-end mt-3 mb-3 d-flex flex-column align-items-end">
                                        <div class="mb-2">
                                            <img src="/HungryPaws/assets/img/hungrypaws.png" alt="Hungry Paws"
                                                class="invoice-logo" />
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

                            <div class="bill-info mb-4">
                                <form id="inventoryReportForm" class="row g-3 align-items-end" method="post">
                                    <div class="col-12 col-lg-3">
                                        <label for="startDate" class="form-label">Start Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <input type="text" data-plugin-datepicker
                                                class="form-control form-control-modern" name="startDate" id="startDate"
                                                placeholder="Set Start Date" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-3">
                                        <label for="endDate" class="form-label">End Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <input type="text" data-plugin-datepicker
                                                class="form-control form-control-modern" name="endDate" id="endDate"
                                                placeholder="Set End Date" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-3">
                                        <label for="filterType" class="form-label">Filter By</label>
                                        <select id="filterType" name="filterType"
                                            class="form-control form-control-modern">
                                            <option value="" disabled selected>Select Filter</option>
                                            <option value="last_update_date">Last Update Date</option>
                                            <option value="expiry_date">Expiry Date</option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="branchId" id="branchId"
                                        value="<?= htmlspecialchars($branch_id) ?>">

                                    <div class="col-12 col-lg-3"> <button type="submit"
                                            class="btn btn-success px-4 text-3">
                                            Generate Report
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
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
                                        <tr>
                                            <td colspan="7">Please Set Filters</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="invoice-summary">
                                <div class="row justify-content-end">
                                    <div class="col-sm-12 col-md-10 col-lg-6">
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
                        <div class="d-grid gap-3 d-md-flex justify-content-md-end me-2">
                            <button id="btn-print-report" target="_blank" class="btn btn-success ms-3"><i
                                    class="fas fa-print"></i> Print</button>
                            <a href="products" class="btn btn-primary ms-3"><i class="fas fa-arrow-left"></i> Back</a>

                        </div>
                    </div>


                </section>
                <!-- end: page -->
            </section>
        </div>
    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/product-report-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->

    <script src="/HungryPaws/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>
    <script src="/HungryPaws/assets/js/report/inventory-report.js"></script>
    <script src="/HungryPaws/assets/js/manager/notification.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>
    <script src="/HungryPaws/assets/js/examples/examples.ecommerce.datatables.list.js"></script>

</body>

</html>