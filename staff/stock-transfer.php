<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Request Stock | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/staff/staff-head.php';
$fetch = new fetchClass();
$branchList = $fetch->getBranches();
?>

<body>
    <section class="body">

        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/staff/staff-header.php';
        ?>

        <div class="inner-wrapper">
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/staff/staff-sidebar.php';
            ?>

            <section role="main" class="content-body content-body-modern mt-0">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">Request Stock Transfer</h2>
                </header>


                <!-- start: page -->
                <form class="order-details action-buttons-fixed" method="post" id="requestStockForm">
                    <div class="row">
                        <div class="col-xl-4 mb-4 mb-xl-0">

                            <div class="card card-modern">
                                <div class="card-header">
                                    <h2 class="card-title">General</h2>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col mb-3">
                                            <label for="branchSelect">Select
                                                Sending Branch</label>
                                            <select data-plugin-selectTwo
                                                class="form-control form-control-modern populate" id="branchSelect"
                                                name="branchSelect">
                                                <?php if (!empty($branchList)): ?>
                                                    <option value="" disabled selected>Select Branch</option>
                                                    <?php foreach ($branchList as $item): ?>
                                                        <option value="<?= htmlspecialchars($item['branch_id']) ?>"
                                                            data-address="<?= htmlspecialchars($item['address']) ?>"
                                                            data-contact="<?= htmlspecialchars($item['contact_number']) ?>">
                                                            <?= htmlspecialchars($item['branch_name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <option value="" disabled selected>No Branches Found</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col mb-3">
                                            <label for="productSelect">Select
                                                Product</label>
                                            <select data-plugin-selectTwo
                                                class="form-control form-control-modern populate" id="productSelect"
                                                name="productSelect">
                                                <option value="" disabled selected>No Products Available
                                                <option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col mb-3">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" min="0" class="form-control form-control-modern"
                                                name="quantity" id="quantity" placeholder="Enter Quantity" />
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col mb-3">
                                            <label for="branchSelect">Select
                                                Receiving Branch</label>
                                            <select data-plugin-selectTwo
                                                class="form-control form-control-modern populate" id="branch1Select"
                                                name="branch1Select">
                                                <?php if (!empty($branchList)): ?>
                                                    <option value="" disabled selected>Select Branch</option>
                                                    <?php foreach ($branchList as $item): ?>
                                                        <option value="<?= htmlspecialchars($item['branch_id']) ?>"
                                                            data-address="<?= htmlspecialchars($item['address']) ?>"
                                                            data-contact="<?= htmlspecialchars($item['contact_number']) ?>">
                                                            <?= htmlspecialchars($item['branch_name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <option value="" disabled selected>No Branches Found</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-8">

                            <div class="card card-modern">
                                <div class="card-header">
                                    <h2 class="card-title">Request Summary</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-auto me-xl-5 pe-xl-5 mb-4 mb-xl-0">
                                            <h3 class="text-color-dark font-weight-bold text-4 line-height-1 mt-0 mb-3">
                                                SENDING BRANCH</h3>
                                            <ul class="list list-unstyled list-item-bottom-space-0">
                                                <li><strong id="sendingBranchName">No Branch Selected</strong>
                                                </li>
                                                <li id="sendingBranchAddress"><br></li>
                                                <li id="sendingBranchContact"><br></li>
                                            </ul>
                                            <h3 class="text-color-dark font-weight-bold text-4 line-height-1 mt-0 mb-3">
                                                PRODUCT DETAILS</h3>
                                            <ul class="list list-unstyled list-item-bottom-space-0">
                                                <li><strong id="productName">No Product Selected</strong>
                                                </li>
                                                <li>
                                                    <strong>Product ID:&nbsp;</strong>
                                                    <span id="productId">N/A</span>
                                                </li>
                                                <li>
                                                    <strong>Category:&nbsp;</strong>
                                                    <span id="productCategory">N/A</span>
                                                </li>
                                                <li>
                                                    <strong>Supplier:&nbsp;</strong>
                                                    <span id="productSupplier">N/A</span>
                                                </li>
                                                <li>
                                                    <strong>Stocks Left:&nbsp;</strong>
                                                    <span id="productStock">N/A</span>
                                                </li>
                                                <li>
                                                    <strong>Quantity Requested:&nbsp;</strong>
                                                    <span id="quantityRequest">N/A</span>
                                                </li>
                                            </ul>

                                            <h3 class="text-color-dark font-weight-bold text-4 line-height-1 mt-0 mb-3">
                                                RECEIVING BRANCH</h3>
                                            <ul class="list list-unstyled list-item-bottom-space-0">
                                                <li><strong id="receivingBranchName">No Branch Selected</strong>
                                                </li>
                                                <li id="receivingBranchAddress"><br></li>
                                                <li id="receivingBranchContact"><br></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row action-buttons align-items-start align-items-md-center">
                        <div class="col-12 col-md-auto">
                            <button type="submit"
                                class="submit-button btn btn-success btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                                data-loading-text="Loading...">
                                <i class="fa-solid fa-arrow-trend-up text-4 me-2"></i> Request Stock
                            </button>
                        </div>
                        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                            <a href="transfers" class="btn btn-danger btn-px-4 py-3 border font-weight-semibold text-3">
                                Cancel
                            </a>
                        </div>
                    </div>

                </form>
                <!-- end: page -->
            </section>
        </div>
    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/staff/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/staff/request-stock-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->
    <script src="/HungryPaws/assets/vendor/jquery-validation/jquery.validate.js"></script>
    <script src="/HungryPaws/assets/vendor/select2/js/select2.js"></script>
    <script src="/HungryPaws/assets/vendor/dropzone/dropzone.js"></script>
    <script src="/HungryPaws/assets/vendor/pnotify/pnotify.custom.js"></script>
    <script src="/HungryPaws/assets/vendor/jquery-ui/jquery-ui.js"></script>
    <script src="/HungryPaws/assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
    <script src="/HungryPaws/assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script src="/HungryPaws/assets/vendor/fuelux/js/spinner.js"></script>
    <script src="/HungryPaws/assets/vendor/dropzone/dropzone.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-markdown/js/markdown.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-markdown/js/to-markdown.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script src="/HungryPaws/assets/vendor/summernote/summernote-bs4.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="/HungryPaws/assets/vendor/ios7-switch/ios7-switch.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>

    <script src="/HungryPaws/assets/js/staff/notification.js"></script>
    <script src="/HungryPaws/assets/js/product/request-stock.js"></script>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>
    <script src="/HungryPaws/assets/js/examples/examples.ecommerce.datatables.list.js"></script>

</body>

</html>