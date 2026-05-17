<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Add Branch | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-head.php';
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
                    <h2 class="font-weight-bold text-6">Add Branch</h2>
                </header>

                <!-- start: page -->
                <form class="ecommerce-form action-buttons-fixed" method="post" id="addBranchForm">
                    <div class="row">
                        <div class="col">
                            <section class="card card-modern card-big-info">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2-5 col-xl-1-5">
                                            <i class="card-big-info-icon bx bx-store text-primary"></i>
                                            <h2 class="card-big-info-title">Branch Info</h2>
                                            <p class="card-big-info-desc">Add here the branch details such as branch
                                                name, complete branch address and contact number.</p>
                                        </div>
                                        <div class="col-lg-3-5 col-xl-4-5">
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Branch
                                                    Name</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="branchName" id="branchName"
                                                        placeholder="Enter Branch Name" />
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Country</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        id="country" name="country" value="Philippines" readonly />
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Region</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <select id="region" name="region"
                                                        class="form-control form-control-modern">
                                                        <option value="">Select Region</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Province</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <select id="province" name="province"
                                                        class="form-control form-control-modern" disabled>
                                                        <option value="">Select Province</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">City /
                                                    Municipality</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <select id="city" name="city"
                                                        class="form-control form-control-modern" disabled>
                                                        <option value="">Select City / Municipality</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Barangay</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <select id="barangay" name="barangay"
                                                        class="form-control form-control-modern" disabled>
                                                        <option value="">Select Barangay</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Street/Building</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="street" id="street" placeholder="Enter Street/Building" />
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Contact
                                                    Number</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="contactNumber" id="contactNumber"
                                                        placeholder="09XX-XXX-XXXX" maxlength="13" />
                                                </div>
                                            </div>

                                            <input type="hidden" id="region_name" name="region_name">
                                            <input type="hidden" id="province_name" name="province_name">
                                            <input type="hidden" id="city_name" name="city_name">
                                            <input type="hidden" id="barangay_name" name="barangay_name">
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
                                <i class="bx bx-save text-4 me-2"></i> Add Branch
                            </button>
                        </div>
                        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                            <a href="branches"
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

    <script src="/HungryPaws/assets/js/admin/add-branch.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->

</body>

</html>