<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Sales Report | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/manager-head.php';
$fetch = new fetchClass();
$branches = $fetch->getBranches(); ?>

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
                                        <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">Sales Report</h2>
                                    </div>
                                    <div class="col-sm-6 text-end mt-3 mb-3 d-flex flex-column align-items-end">
                                        <div class="mb-2">
                                            <img src="/HungryPaws/assets/img/hungrypaws.png" alt="Hungry Paws"
                                                class="invoice-logo" />
                                        </div>
                                    </div>

                                </div>
                            </header>

                            <div class="bill-info mb-4">
                                <form id="salesReportForm" class="row g-3 align-items-end" method="post">
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
                                        <label for="endDate" class="form-label">Select Branch</label>
                                        <select data-plugin-selectTwo class="form-control form-control-modern populate"
                                            id="branchId" name="branchId">
                                            <?php if (!empty($branches)): ?>
                                                <option value="" selected>All Branches</option>
                                                <?php foreach ($branches as $branch): ?>
                                                    <option value="<?= htmlspecialchars($branch['branch_id']) ?>">
                                                        <?= htmlspecialchars($branch['branch_name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="" selected disabled>No Branch Found</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-3"> <button type="submit"
                                            class="btn dynamic-role-btn px-4 text-3">
                                            Generate Report
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <section class="card shadow-sm mb-5 border">
                                        <header class="card-header">
                                            <h2 class="card-title">Daily Sales Performance</h2>
                                        </header>
                                        <div class="card-body">
                                            <div class="chart chart-lg" id="salesLine">
                                                <canvas id="salesLineCanvas"></canvas>
                                                <div id="salesLinePlaceholder"
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
                                            <h2 class="card-title">Top Products Sold</h2>
                                        </header>
                                        <div class="card-body">
                                            <div class="chart chart-lg" id="salesBar">
                                                <div id="salesBarPlaceholder"
                                                    style="text-align:center; padding:40px; color:#6c757d;">
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
                                            <div class="d-flex justify-content-center chart chart-md"
                                                id="paymentMethod">
                                                <div id="paymentMethodPlaceholder"
                                                    style="text-align:center; padding:40px; color:#6c757d;">
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
                                            <div class="chart chart-md" id="category">
                                                <div id="categoryPlaceholder"
                                                    style="text-align:center; padding:40px; color:#6c757d;">
                                                    Please Set Filter First
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>

                        </div>
                        <div class="d-grid gap-3 d-md-flex justify-content-md-end me-2">
                            <button id="btn-print-report" target="_blank" class="btn dynamic-role-btn ms-3"><i
                                    class="fas fa-print"></i> Print</button>
                            <a href="orders" class="btn dynamic-role-btn ms-3"><i class="fas fa-arrow-left"></i>
                                Back</a>

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
    <script src="/HungryPaws/assets/vendor/raphael/raphael.js"></script>
    <script src="/HungryPaws/assets/vendor/morris/morris.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script src="/HungryPaws/assets/js/report/sales-report.js"></script>
    <script src="/HungryPaws/assets/js/manager/notification.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>
    <script src="/HungryPaws/assets/js/examples/examples.ecommerce.datatables.list.js"></script>
</body>

</html>