<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Update Stock Request | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/manager-head.php';
$fetch = new fetchClass();
$products = $fetch->getCashierProducts($branch_id);
$branchList = $fetch->getBranches();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $requestID = $_GET['id'];
    $requestInfo = $fetch->getRequestInfo($requestID);
} else {
    header("Location: /hungrypaws/manager/transfers");
    exit;
}
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
                    <h2 class="font-weight-bold text-6">View Stock Transfer Request</h2>
                </header>


                <!-- start: page -->
                <div class="order-details action-buttons-fixed">
                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card card-modern">
                                <div class="card-header">
                                    <h2 class="card-title">Request Summary</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-auto me-xl-5 pe-xl-5 mb-4 mb-xl-0">
                                            <h3 class="text-color-dark font-weight-bold text-4 line-height-1 mt-0 mb-3">
                                                PRODUCT DETAILS</h3>
                                            <ul class="list list-unstyled list-item-bottom-space-0">
                                                <li><strong
                                                        id="productName"><?= htmlspecialchars($requestInfo['product_name']) ?></strong>
                                                </li>
                                                <li>
                                                    <strong>Product ID:&nbsp;</strong>
                                                    <span
                                                        id="productId"><?= htmlspecialchars($requestInfo['product_id']) ?></span>
                                                </li>
                                                <li>
                                                    <strong>Category:&nbsp;</strong>
                                                    <span
                                                        id="productCategory"><?= htmlspecialchars($requestInfo['category']) ?></span>
                                                </li>
                                                <li>
                                                    <strong>Supplier:&nbsp;</strong>
                                                    <span
                                                        id="productSupplier"><?= htmlspecialchars($requestInfo['supplier_name']) ?></span>
                                                </li>
                                                <li>
                                                    <strong>Stocks Left:&nbsp;</strong>
                                                    <span
                                                        id="productStock"><?= htmlspecialchars($requestInfo['stock_level']) ?></span>
                                                </li>
                                                <li>
                                                    <strong>Quantity Requested:&nbsp;</strong>
                                                    <span
                                                        id="quantityRequest"><?= htmlspecialchars($requestInfo['quantity']) ?></span>
                                                </li>
                                                <li>
                                                    <strong>Request Status:&nbsp;</strong>
                                                    <span id="requestStatus"
                                                        class="<?= getRequestStatusClass($requestInfo['status']) ?>"><?= htmlspecialchars($requestInfo['status']) ?></span>
                                                </li>
                                            </ul>
                                            <h3 class="text-color-dark font-weight-bold text-4 line-height-1 mt-0 mb-3">
                                                SENDING BRANCH</h3>
                                            <ul class="list list-unstyled list-item-bottom-space-0">
                                                <li><strong
                                                        id="sendingBranchName"><?= htmlspecialchars($requestInfo['branch_name']) ?></strong>
                                                </li>
                                                <li id="sendingBranchAddress">
                                                    <?= htmlspecialchars($requestInfo['address']) ?><br>
                                                </li>
                                                <li id="sendingBranchContact">
                                                    <?= htmlspecialchars($requestInfo['contact_number']) ?><br>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row action-buttons align-items-start align-items-md-center mt-4">
                        <div class="col-12 col-md-auto">
                            <a href="#"
                                class="submit-button btn btn-success btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                                data-loading-text="Loading..." id="approveRequestBtn"
                                data-id="<?= htmlspecialchars($requestID) ?>">
                                <i class="fa-solid fa-check text-4 me-2"></i> Approve Request
                            </a>
                        </div>
                        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                            <a href="#"
                                class="btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                                id="cancelRequestBtn" data-id="<?= htmlspecialchars($requestID) ?>">
                                <i class="fa-solid fa-ban text-4 me-2"></i> Cancel Request
                            </a>
                        </div>
                        <div class="col-12 col-md-auto ms-md-auto mt-3 mt-md-0 ms-auto">
                            <a href="transfers"
                                class="btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                                <i class="fa-solid fa-arrow-left text-4 me-2"></i> Back
                            </a>
                        </div>
                        <input type="hidden" name="requestId" value="<?= htmlspecialchars($requestID) ?>">
                        <input type="hidden" name="receivingBranch" value="<?= htmlspecialchars($branch_id) ?>">
                    </div>
                </div>
                <!-- end: page -->
            </section>
        </div>
    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/update-request-modal.php';
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

    <script src="/HungryPaws/assets/js/product/manage-stock-request.js"></script>
    <script src="/HungryPaws/assets/js/manager/notification.js"></script>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>
    <script src="/HungryPaws/assets/js/examples/examples.ecommerce.datatables.list.js"></script>

</body>

</html>