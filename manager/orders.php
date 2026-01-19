<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Orders | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/manager-head.php';

$fetch = new fetchClass();
$orders = $fetch->getCashierOrders($branch_id);
?>

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
                    <h2 class="font-weight-bold text-6">Orders</h2>
                </header>


                <!-- start: page -->
                <div class="row">
                    <div class="col">

                        <div class="card card-modern">
                            <div class="card-body">
                                <div class="datatables-header-footer-wrapper">
                                    <div class="datatable-header">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                                <a href="order-report"
                                                    class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4"><i
                                                        class="fa-solid fa-file-lines"></i>
                                                    &nbsp;Generate Report</a>
                                            </div>

                                            <div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
                                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                                    <label class="ws-nowrap me-3 mb-0">Filter By:</label>
                                                    <select class="form-control select-style-1 filter-by"
                                                        name="filter-by">
                                                        <option value="all" selected>All</option>
                                                        <option value="0">Order ID</option>
                                                        <option value="1">Total Amount (₱)</option>
                                                        <option value="2">Order Date</option>
                                                        <option value="3">Cashier</option>
                                                        <option value="4">Payment Method</option>
                                                        <option value="5">Availed Service</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4 col-lg-auto ps-lg-1 mb-3 mb-lg-0">
                                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                                    <label class="ws-nowrap me-3 mb-0">Show:</label>
                                                    <select class="form-control select-style-1 results-per-page"
                                                        name="results-per-page">
                                                        <option value="10" selected>10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-auto ps-lg-1">
                                                <div class="search search-style-1 search-style-1-lg mx-lg-auto">
                                                    <div class="input-group">
                                                        <input type="text" class="search-term form-control"
                                                            name="search-term" id="search-term"
                                                            placeholder="Search Order">
                                                        <button class="btn btn-default" type="submit"><i
                                                                class="bx bx-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-ecommerce-simple table-borderless table-striped mb-0"
                                        id="datatable-order-list" style="min-width: 640px;">

                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Total Amount (₱)</th>
                                                <th>Order Date</th>
                                                <th>Cashier</th>
                                                <th>Payment Method</th>
                                                <th>Availed Service</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($orders)): ?>
                                                <?php foreach ($orders as $order): ?>
                                                    <tr>
                                                        <td><strong><?= htmlspecialchars($order['order_id']) ?></strong>
                                                        </td>
                                                        <td><strong><?= htmlspecialchars($order['total_amount']) ?></strong>
                                                        </td>
                                                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                                                        <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?>
                                                        </td>
                                                        <td><?= htmlspecialchars($order['payment_method']) ?></td>
                                                        <td><span
                                                                class="<?= getServiceClass($order['is_service']) ?>"><?= getServiceText($order['is_service']) ?>
                                                            </span></td>
                                                        <td>
                                                            <a href="receipt?id=<?= urlencode($order['order_id']) ?>"
                                                                class="mb-1 mt-1 me-1 btn btn-xs btn-success"><i
                                                                    class="fa-solid fa-eye"></i></a>
                                                            <a href="print-receipt?id=<?= urlencode($order['order_id']) ?>"
                                                                target="_blank" class="mb-1 mt-1 me-1 btn btn-xs btn-primary"><i
                                                                    class="fa-solid fa-print"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        No orders found in branch
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <hr class="solid mt-5 opacity-4">
                                    <div class="datatable-footer">
                                        <div class="row align-items-center justify-content-between mt-3">
                                            <div class="col-lg-auto text-center order-3 order-lg-2">
                                                <div class="results-info-wrapper"></div>
                                            </div>
                                            <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                                <div class="pagination-wrapper"></div>
                                            </div>
                                        </div>
                                    </div>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end: page -->
            </section>
        </div>
    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->

    <script src="/HungryPaws/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>
    <script src="/HungryPaws/assets/js/manager/notification.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <script src="/HungryPaws/assets/js/order/datatable-order.js"></script>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>
    <script src="/HungryPaws/assets/js/examples/examples.ecommerce.datatables.list.js"></script>

</body>

</html>