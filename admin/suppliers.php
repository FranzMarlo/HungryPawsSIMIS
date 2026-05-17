<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Suppliers | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-head.php';

$fetch = new fetchClass();
$suppliers = $fetch->getSuppliers();
?>

<body>
    <section class="body">

        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-header.php';
        ?>

        <div class="inner-wrapper">
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-sidebar.php';
            ?>

            <section role="main" class="content-body content-body-modern mt-0">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">Suppliers</h2>
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
                                                <a href="add-supplier"
                                                    class="btn dynamic-role-btn btn-md font-weight-semibold btn-py-2 px-4">+
                                                    Add Supplier</a>
                                            </div>
                                            <div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
                                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                                    <label class="ws-nowrap me-3 mb-0">Filter By:</label>
                                                    <select class="form-control select-style-1 filter-by"
                                                        name="filter-by">
                                                        <option value="all" selected>All</option>
                                                        <option value="0">Supplier ID</option>
                                                        <option value="1">Supplier Name</option>
                                                        <option value="2">Contact Person</option>
                                                        <option value="3">Email</option>
                                                        <option value="4">Phone</option>
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
                                                            placeholder="Search Supplier">
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
                                                <th>Supplier ID</th>
                                                <th>Supplier Name</th>
                                                <th>Contact Person</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($suppliers)): ?>
                                                <?php foreach ($suppliers as $supplier): ?>
                                                    <tr>
                                                        <td><strong><?= htmlspecialchars($supplier['supplier_id']) ?></strong>
                                                        </td>
                                                        <td><strong><?= htmlspecialchars($supplier['supplier_name']) ?></strong>
                                                        </td>
                                                        <td><?= htmlspecialchars($supplier['contact_person']) ?></td>
                                                        <td><?= htmlspecialchars($supplier['email']) ?></td>
                                                        <td><?= htmlspecialchars($supplier['phone']) ?></td>
                                                        <td class="text-center">
                                                            <a href="update-supplier?id=<?= urlencode($supplier['supplier_id']) ?>"
                                                                class="mb-1 mt-1 me-1 btn btn-xs dynamic-role-btn"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        No suppliers found
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
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->

    <script src="/HungryPaws/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <script src="/HungryPaws/assets/js/product/datatable-product.js"></script>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>

</body>

</html>