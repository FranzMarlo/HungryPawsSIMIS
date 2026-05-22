<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Update User | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/manager-head.php';
$fetch = new fetchClass();
$branches = $fetch->getBranches();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userID = $_GET['id'];
    $userDetails = $fetch->getMainUserDetails($userID);
} else {
    header("Location: /HungryPaws/manager/main-user");
    exit;
}
?>
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

            <section role="main" class="content-body content-body-modernmt-0">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">Update User Details</h2>
                </header>

                <!-- start: page -->
                <form class="ecommerce-form action-buttons-fixed" method="post" id="updateUserForm">
                    <div class="row">
                        <div class="col">
                            <section class="card card-modern card-big-info">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2-5 col-xl-1-5">
                                            <i class="card-big-info-icon bx bx-user-circle text-primary"></i>
                                            <h2 class="card-big-info-title">User Profile</h2>
                                            <p class="card-big-info-desc">Update here the user's personal information
                                                such
                                                as names and email.</p>
                                        </div>
                                        <div class="col-lg-3-5 col-xl-4-5">
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">First
                                                    Name</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="firstName" id="firstName"
                                                        placeholder="<?= htmlspecialchars($userDetails['first_name']) ?>"
                                                        value="<?= htmlspecialchars($userDetails['first_name']) ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Last
                                                    Name</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="lastName" id="lastName"
                                                        placeholder="<?= htmlspecialchars($userDetails['last_name']) ?>"
                                                        value="<?= htmlspecialchars($userDetails['last_name']) ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Email</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="email" id="email"
                                                        placeholder="<?= htmlspecialchars($userDetails['email']) ?>"
                                                        value="<?= htmlspecialchars($userDetails['email']) ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center pb-3">
                                                <label
                                                    class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Username</label>
                                                <div class="col-lg-7 col-xl-6">
                                                    <input type="text" class="form-control form-control-modern"
                                                        name="username" id="username"
                                                        placeholder="<?= htmlspecialchars($userDetails['username']) ?>"
                                                        value="<?= htmlspecialchars($userDetails['username']) ?>" />
                                                </div>
                                            </div>
                                            <input type="hidden" name="userId"
                                                value="<?= htmlspecialchars($userDetails['user_id']) ?>">
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
                                <i class="bx bx-save text-4 me-2"></i> Update User Info
                            </button>
                        </div>
                        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                            <a href="users"
                                class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Cancel</a>
                        </div>
                    </div>
                </form>
            </section>
        </div>

    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/update-user-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->
    <script src="/HungryPaws/assets/vendor/jquery-validation/jquery.validate.js"></script>
    <script src="/HungryPaws/assets/vendor/select2/js/select2.js"></script>
    <script src="/HungryPaws/assets/vendor/dropzone/dropzone.js"></script>
    <script src="/HungryPaws/assets/vendor/pnotify/pnotify.custom.js"></script>

    <script src="/HungryPaws/assets/js/manager/update-user.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->

</body>

</html>