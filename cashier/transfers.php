<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Stock Requests | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/cashier-head.php';

$fetch = new fetchClass();
$requests = $fetch->getBranchStockTransfer($branch_id);
?>

<body>
    <section class="body">

        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/cashier-header.php';
        ?>

        <div class="inner-wrapper">
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/cashier-sidebar.php';
            ?>

            <section role="main" class="content-body content-body-modern mt-0">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">Incoming Stock Transfers</h2>
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
                                                <a href="add-order"
                                                    class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4">+
                                                    Add Order</a>
                                            </div>
                                            <div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
                                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                                    <label class="ws-nowrap me-3 mb-0">Filter By:</label>
                                                    <select class="form-control select-style-1 filter-by"
                                                        name="filter-by">
                                                        <option value="all" selected>All</option>
                                                        <option value="0">Request ID</option>
                                                        <option value="1">Product Name</option>
                                                        <option value="2">Quantity</option>
                                                        <option value="3">Sending Branch</option>
                                                        <option value="4">Receiving Branch</option>
                                                        <option value="5">Transfer Date</option>
                                                        <option value="6">Status</option>
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
                                                            placeholder="Search Request">
                                                        <button class="btn btn-default" type="submit"><i
                                                                class="bx bx-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-ecommerce-simple table-striped mb-0"
                                        id="datatable-product-list" style="min-width: 750px;">

                                        <thead>
                                            <tr>
                                                <th>Request ID</th>
                                                <th>Requested Product</th>
                                                <th>Quantity</th>
                                                <th>Sending Branch</th>
                                                <th>Receiving Branch</th>
                                                <th>Transfer Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($requests)): ?>
                                                <?php foreach ($requests as $request): ?>
                                                    <tr>
                                                        <td><strong><?= htmlspecialchars($request['transfer_id']) ?></strong></a>
                                                        </td>
                                                        <td><strong><?= htmlspecialchars($request['product_name']) ?></strong></a>
                                                        </td>
                                                        <td class="text-center"><?= htmlspecialchars($request['quantity']) ?>
                                                        </td>
                                                        <td><?= htmlspecialchars($request['sending_branch']) ?></td>
                                                        <td><?= htmlspecialchars($request['receiving_branch']) ?>
                                                        </td>
                                                        <td width="15%"><?= htmlspecialchars($request['transfer_date']) ?></td>
                                                        <td><span
                                                                class="<?= getRequestStatusClass($request['status']) ?>"><?= htmlspecialchars($request['status']) ?>
                                                            </span></td>
                                                        <td>
                                                            <a href="update-request?id=<?= urlencode($request['transfer_id']) ?>"
                                                                class="mb-1 mt-1 me-1 btn btn-xs btn-success"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        No incoming stock
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
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->

    <script src="/HungryPaws/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>

    <script src="/HungryPaws/assets/js/cashier/notification.js"></script>
    <script src="/HungryPaws/assets/js/cashier/notification.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>
    <script src="/HungryPaws/assets/js/examples/examples.ecommerce.datatables.list.js"></script>

</body>

</html>