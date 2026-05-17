<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Add Inventory | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/staff/staff-head.php';
$fetch = new fetchClass();
$products = $fetch->staffGetProducts();
$branches = $fetch->getBranches();
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

            <section role="main" class="content-body content-body-modernmt-0">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">Add Product Inventory</h2>
                </header>

                <!-- start: page -->
                <form class="ecommerce-form action-buttons-fixed" method="post" id="addInventoryForm">
                    <div class="row mt-2">
                        <div class="col">
                            <section class="card card-modern card-big-info">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2-5 col-xl-1-5">
                                            <i class="card-big-info-icon bx bx-box"></i>
                                            <h2 class="card-big-info-title">Product Info</h2>
                                            <p class="card-big-info-desc">Add here the product's
                                                inventory details and necessary information.</p>
                                        </div>
                                        <div class="col-lg-3-5 col-xl-4-5">
                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end pt-2 mt-1 mb-0">Select
                                                    Product</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <select data-plugin-selectTwo
                                                        class="form-control form-control-modern populate"
                                                        id="productSelect" name="productSelect">
                                                        <?php if (!empty($products)): ?>
                                                            <option value="" selected disabled>Select Product</option>
                                                            <?php foreach ($products as $product): ?>
                                                                <option value="<?= htmlspecialchars($product['product_id']) ?>"
                                                                    data-perish="<?= htmlspecialchars($product['is_perishable']) ?>">
                                                                    <?= htmlspecialchars($product['product_name']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <option value="" selected disabled>No Product Found</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end pt-2 mt-1 mb-0">Select
                                                    Branch</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <select data-plugin-selectTwo
                                                        class="form-control form-control-modern populate"
                                                        id="inventoryBranch" name="inventoryBranch">
                                                        <?php if (!empty($branches)): ?>
                                                            <option value="" selected disabled>Select Branch</option>
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
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Quantity
                                                    On Hand</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="number" class="form-control form-control-modern"
                                                        name="productQuantity" id="productQuantity" value=""
                                                        placeholder="Enter Quantity On Hand" />
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Set
                                                    Reorder Point</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="number" class="form-control form-control-modern"
                                                        name="productPoint" id="productPoint" value=""
                                                        placeholder="Enter Reorder Point" />
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">
                                                    Manufactured Date</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </span>
                                                        <input type="text" data-plugin-datepicker
                                                            name="manufacturedDate" id="manufacturedDate"
                                                            class="form-control form-control-modern"
                                                            placeholder="Set Manufactured Date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Expiry
                                                    Date</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </span>
                                                        <input type="text" data-plugin-datepicker name="expiryDate"
                                                            id="expiryDate" class="form-control form-control-modern"
                                                            placeholder="Set Expiry Date" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="isPerish" id="isPerish">
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row action-buttons mt-3">
                        <div class="col-12 col-md-auto">
                            <button type="submit"
                                class="submit-button btn dynamic-role-btn btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                                data-loading-text="Loading...">
                                <i class="bx bx-save text-4 me-2"></i> Add Inventory
                            </button>
                        </div>
                        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                            <a href="products" class="btn btn-danger btn-px-4 py-3 border font-weight-semibold text-3">
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
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/staff/add-inventory-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/staff/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->
    <script src="/HungryPaws/assets/vendor/jquery-validation/jquery.validate.js"></script>
    <script src="/HungryPaws/assets/vendor/select2/js/select2.js"></script>
    <script src="/HungryPaws/assets/vendor/dropzone/dropzone.js"></script>
    <script src="/HungryPaws/assets/vendor/pnotify/pnotify.custom.js"></script>
    <script src="/HungryPaws/assets/vendor/jquery-ui/jquery-ui.js"></script>
    <script src="/HungryPaws/assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
    <script src="/HungryPaws/assets/vendor/select2/js/select2.js"></script>
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

    <script src="/HungryPaws/assets/js/staff/notification.js"></script>
    <script src="/HungryPaws/assets/js/product/add-inventory.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

</body>

</html>