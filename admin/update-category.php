<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Add Category | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-head.php';
$fetch = new fetchClass();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $categoryID = $_GET['id'];
    $category = $fetch->getCategoryDetails($categoryID);
} else {
    header("Location: /HungryPaws/admin/category");
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
                    <h2 class="font-weight-bold text-6">Update Product Category</h2>
                </header>

                <!-- start: page -->
                <form class="ecommerce-form action-buttons-fixed" method="post" id="updateCategoryForm">
                    <div class="row">
                        <div class="col">
                            <section class="card card-modern card-big-info">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2-5 col-xl-1-5">
                                            <i class="card-big-info-icon bx bx-box text-primary"></i>
                                            <h2 class="card-big-info-title">Category Info</h2>
                                            <p class="card-big-info-desc">Add here the category details.</p>
                                        </div>
                                        <div class="col-lg-3-5 col-xl-4-5">
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Category
                                                    Number</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="number" class="form-control form-control-modern"
                                                        name="categoryId" id="categoryId"
                                                        placeholder="<?= htmlspecialchars($categoryID) ?>"
                                                        value="<?= htmlspecialchars($categoryID) ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Category
                                                    Name</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="categoryName" id="categoryName"
                                                        placeholder="<?= htmlspecialchars($category['category']) ?>"
                                                        value="<?= htmlspecialchars($category['category']) ?>" />
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
                                <i class="bx bx-save text-4 me-2"></i> Update Category
                            </button>
                        </div>
                        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                            <a href="category"
                                class="cancel-button btn btn-danger btn-px-4 py-3 border font-weight-semibold text-color-white text-3">Cancel</a>
                        </div>
                    </div>
                </form>
                <!-- end: page -->
            </section>
        </div>

    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/category-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->
    <script src="/HungryPaws/assets/vendor/jquery-validation/jquery.validate.js"></script>
    <script src="/HungryPaws/assets/vendor/select2/js/select2.js"></script>
    <script src="/HungryPaws/assets/vendor/dropzone/dropzone.js"></script>
    <script src="/HungryPaws/assets/vendor/pnotify/pnotify.custom.js"></script>

    <script src="/HungryPaws/assets/js/admin/update-category.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->

</body>

</html>