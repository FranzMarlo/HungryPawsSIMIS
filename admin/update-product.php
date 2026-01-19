<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Update Product | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-head.php';
$fetch = new fetchClass();
$suppliers = $fetch->getSupplierNames();
$categories = $fetch->getCategories();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $productID = $_GET['id'];
    $productDetails = $fetch->getProductDetails($productID);
}
else {
    header("Location: /HungryPaws/admin/products");
    exit;
}
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
                    <h2 class="font-weight-bold text-6">Update Product</h2>
                </header>

                <!-- start: page -->
                <form class="ecommerce-form action-buttons-fixed" method="post" id="updateProductForm" data-id="<?= htmlspecialchars($productDetails['product_id']) ?>">
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
                                                        name="productName" id="productName"
                                                        value="<?= htmlspecialchars($productDetails['product_name']) ?>"
                                                        placeholder="<?= htmlspecialchars($productDetails['product_name']) ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Barcode</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="barcode" id="barcode" value="<?= htmlspecialchars($productDetails['barcode']) ?>"
                                                        placeholder="<?= htmlspecialchars($productDetails['barcode']) ?>" />
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
                                                            <option value="" disabled>Select Supplier</option>
                                                            <?php foreach ($suppliers as $supplier): ?>
                                                                <option
                                                                    <?= $supplier['supplier_id'] === $productDetails['supplier_id'] ? 'selected' : '' ?>
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
                                                            <option value="" disabled>Select Category</option>
                                                            <?php foreach ($categories as $category): ?>
                                                                <option
                                                                    <?= $category['category'] === $productDetails['category'] ? 'selected' : '' ?>
                                                                    value="<?= htmlspecialchars($category['category']) ?>">
                                                                    <?= htmlspecialchars($category['category']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <option value="" selected disabled>No Category Found</option>
                                                        <?php endif; ?>
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
                                                                id="unitCost" value="<?= htmlspecialchars($productDetails['unit_cost']) ?>" placeholder="<?= htmlspecialchars($productDetails['unit_cost']) ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row align-items-center">
                                                        <label
                                                            class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Selling
                                                            Price (₱)</label>
                                                        <div class="col-lg-7 col-xl-6">
                                                            <input type="number" step="0.01" min="0"
                                                                class="form-control form-control-modern"
                                                                name="sellingPrice" id="sellingPrice" value="<?= htmlspecialchars($productDetails['selling_price']) ?>"
                                                                placeholder="<?= htmlspecialchars($productDetails['selling_price']) ?>" />
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
                                class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                                data-loading-text="Loading...">
                                <i class="bx bx-save text-4 me-2"></i> Update Product
                            </button>
                        </div>
                        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
							<a href="products"
								class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Cancel</a>
						</div>
                        <div class="col-12 col-md-auto ms-md-auto mt-3 mt-md-0 ms-auto">
                            <?php if ($productDetails['archived'] == 1): ?>
                                <a href="#"
                                    class="delete-button btn btn-success btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                                    id="toggleArchiveBtn" data-id="<?= htmlspecialchars($productID) ?>"
                                    data-archived="<?= htmlspecialchars($productDetails['archived']) ?>">
                                    <i class="fa fa-square-check text-4 me-2"></i> Unarchive Product
                                </a>
                            <?php else: ?>
                                <a href="#"
                                    class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                                    id="toggleArchiveBtn" data-id="<?= htmlspecialchars($productID) ?>"
                                    data-archived="<?= htmlspecialchars($productDetails['archived']) ?>">
                                    <i class="fa fa-box-archive text-4 me-2"></i> Archive Product
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
                <!-- end: page -->
            </section>
        </div>

    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/update-product-modal.php';
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

    <script src="/HungryPaws/assets/js/product/update-product.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

</body>

</html>