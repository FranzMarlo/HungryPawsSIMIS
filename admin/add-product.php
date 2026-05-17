<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Add Product | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-head.php';
$fetch = new fetchClass();
$suppliers = $fetch->getSupplierNames();
$categories = $fetch->getCategories();
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

            <section role="main" class="content-body content-body-modernmt-0">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">Add Product</h2>
                </header>

                <!-- start: page -->
                <form class="ecommerce-form action-buttons-fixed" method="post" id="addProductForm">
                    <div class="row mt-2">
                        <div class="col">
                            <section class="card card-modern card-big-info">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2-5 col-xl-1-5">
                                            <i class="card-big-info-icon bx bx-box text-primary"></i>
                                            <h2 class="card-big-info-title">General Info</h2>
                                            <p class="card-big-info-desc">Add here all of the product
                                                details and necessary information.</p>
                                        </div>
                                        <div class="col-lg-3-5 col-xl-4-5">
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Product
                                                    Name</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="productName" id="productName" value=""
                                                        placeholder="Enter Product Name" />
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Barcode</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="barcode" id="barcode" value=""
                                                        placeholder="Enter Product Barcode" />
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end pt-2 mt-1 mb-0">Select
                                                    Supplier</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <select data-plugin-selectTwo
                                                        class="form-control form-control-modern populate"
                                                        id="supplierSelect" name="supplierSelect">
                                                        <?php if (!empty($suppliers)): ?>
                                                            <option value="" selected disabled>Select Supplier</option>
                                                            <?php foreach ($suppliers as $supplier): ?>
                                                                <option
                                                                    value="<?= htmlspecialchars($supplier['supplier_id']) ?>">
                                                                    <?= htmlspecialchars($supplier['supplier_name']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <option value="" selected disabled>No Supplier Found</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Select
                                                    Category</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <select data-plugin-selectTwo
                                                        class="form-control form-control-modern populate"
                                                        id="categorySelect" name="categorySelect">
                                                        <?php if (!empty($categories)): ?>
                                                            <option value="" selected disabled>Select Category</option>
                                                            <?php foreach ($categories as $category): ?>
                                                                <option value="<?= htmlspecialchars($category['category']) ?>">
                                                                    <?= htmlspecialchars($category['category']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <option value="" selected disabled>No Category Found</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Select
                                                    Product Type</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <select data-plugin-selectTwo
                                                        class="form-control form-control-modern populate"
                                                        id="perishSelect" name="perishSelect">
                                                        <option value="" selected disabled>Select Product Type</option>
                                                        <option value="1">
                                                            Perishable
                                                        </option>
                                                        <option value="0">
                                                            Non-Perishable
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <section class="card card-modern card-big-info">
                                <div class="card-body">
                                    <div class="tabs-modern row" style="min-height: 490px;">
                                        <div class="col-lg-2-5 col-xl-1-5">
                                            <div class="nav flex-column tabs" id="tab" role="tablist"
                                                aria-orientation="vertical">
                                                <a class="nav-link cur-pointer active" id="price-tab"
                                                    data-bs-toggle="pill" data-bs-target="#price" role="tab"
                                                    aria-controls="price" aria-selected="true">Price</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3-5 col-xl-4-5">
                                            <div class="tab-content" id="tabContent">
                                                <div class="tab-pane fade show active" id="price" role="tabpanel"
                                                    aria-labelledby="price-tab">
                                                    <div class="form-group row align-items-center pb-3">
                                                        <label
                                                            class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Regular
                                                            Unit Cost (₱)</label>
                                                        <div class="col-lg-7 col-xl-6">
                                                            <input type="number" step="0.01" min="0"
                                                                class="form-control form-control-modern" name="unitCost"
                                                                id="unitCost" value="" placeholder="Enter Unit Cost" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Selling
                                                            Price (₱)</label>
                                                        <div class="col-lg-7 col-xl-6">
                                                            <input type="number" step="0.01" min="0"
                                                                class="form-control form-control-modern"
                                                                name="sellingPrice" id="sellingPrice" value=""
                                                                placeholder="Enter Selling Price" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row action-buttons">
                        <div class="col-12 col-md-auto">
                            <button type="submit"
                                class="submit-button btn btn-success btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                                data-loading-text="Loading...">
                                <i class="bx bx-save text-4 me-2"></i> Add Product
                            </button>
                        </div>
                        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                            <a href="products"
                                class="cancel-button btn btn-danger btn-px-4 py-3 border font-weight-semibold text-color-white text-3">Cancel</a>
                        </div>
                    </div>
                </form>
                <!-- end: page -->
            </section>
        </div>

    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/add-product-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/logout-modal.php';
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

    <script src="/HungryPaws/assets/js/product/add-product.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

</body>

</html>