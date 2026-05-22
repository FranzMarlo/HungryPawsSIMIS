<!doctype html>
<html class="fixed">
<?php
$title = "Forgot Password | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/login-head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';

$fetch = new fetchClass();
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];
    $checkToken = $fetch->checkToken($token);
    if (!$checkToken) {
        header("Location: /HungryPaws/utility/403");
        exit;
    }

} else {
    header("Location: /HungryPaws/utility/401");
    exit;
}

?>

<body>
    <!-- start: page -->
    <section class="body-sign">
        <div class="center-sign">
            <a href="/hungrypaws/" class="logo float-start">
                <img src="/HungryPaws/assets/img/hungrypaws.png" height="80" alt="Porto Admin" />
            </a>

            <div class="panel card-sign">
                <div class="card-title-sign mt-3 text-end">
                    <h2 class="title text-uppercase font-weight-bold m-0"><i
                            class="bx bx-user-circle me-1 text-6 position-relative top-5"></i> Reset Password</h2>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <h1 class="text-dark text-uppercase">Reset Password</h1>
                    </div>
                    <div class="alert alert-info">
                        <p class="m-0">Enter your new password and confirm it by re-entering it. Your new password must
                            be at least 6 characters.</p>
                    </div>

                    <form id="resetPasswordForm" method="post" class="mb-4">
                        <div class="form-group mb-3">
                            <label>New Password</label>
                            <div class="input-group">
                                <input name="newPassword" id="newPassword" type="password"
                                    class="form-control form-control-md " placeholder="Enter New Password" />
                                <span class="input-group-text">
                                    <i class="bx bx-lock text-4"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label>Confirm Password</label>
                            <div class="input-group">
                                <input name="confirmPassword" id="confirmPassword" type="password"
                                    class="form-control form-control-md " placeholder="Confirm Password" />
                                <span class="input-group-text">
                                    <i class="bx bx-lock text-4"></i>
                                </span>
                            </div>
                        </div>

                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="w-100 btn btn-primary mt-2">Change Password</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <p class="text-center text-muted mt-3 mb-3">&copy; Copyright 2025. All Rights Reserved.</p>
        </div>
    </section>
    <!-- end: page -->

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/forgot-password-modal.php';
    ?>
    <!-- Vendor -->
    <script src="/HungryPaws/assets/vendor/jquery/jquery.js"></script>
    <script src="/HungryPaws/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="/HungryPaws/assets/vendor/popper/umd/popper.min.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="/HungryPaws/assets/vendor/common/common.js"></script>
    <script src="/HungryPaws/assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="/HungryPaws/assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="/HungryPaws/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

    <!-- Specific Page Vendor -->
    <script src="/HungryPaws/assets/vendor/select2/js/select2.js"></script>
    <script src="/HungryPaws/assets/vendor/pnotify/pnotify.custom.js"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="/HungryPaws/assets/js/theme.js"></script>

    <!-- Theme Custom -->
    <script src="/HungryPaws/assets/js/custom.js"></script>

    <!-- Theme Initialization Files -->
    <script src="/HungryPaws/assets/js/theme.init.js"></script>

    <script src="/HungryPaws/assets/js/reset-password-main.js"></script>

</body>

</html>