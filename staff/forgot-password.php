<!doctype html>
<html class="fixed">
<?php
$title = "Forgot Password | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/login-head.php';
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
                            class="bx bx-user-circle me-1 text-6 position-relative top-5"></i> Forgot Password</h2>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <h1 class="text-dark text-uppercase">Forgot Password</h1>
                    </div>
                    <div class="alert alert-info">
                        <p class="m-0">Enter your e-mail below and we will send you reset instructions!</p>
                    </div>

                    <form id="forgotPasswordForm" method="post">
                        <div class="form-group mb-0">
                            <div class="input-group">
                                <input name="email" type="text" placeholder="Enter Email"
                                    class="form-control form-control-md" />
                                <button class="btn btn-primary btn-lg d-flex align-items-center" type="submit"
                                    id="resetBtn">
                                    <span class="btn-text">Reset!</span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" id="resetSpinner"></span>
                                </button>
                            </div>
                        </div>

                        <p class="text-center mt-3">Remembered? <a href="login">Log In!</a></p>
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

    <script src="/HungryPaws/assets/js/forgot-password.js"></script>

</body>

</html>