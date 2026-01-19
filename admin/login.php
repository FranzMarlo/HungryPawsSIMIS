<!doctype html>
<html class="fixed">

<?php
$title = "Login | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/login-head.php';
?>

<body>
    <!-- start: page -->
    <section class="body-sign">
        <div class="center-sign">
            <a href="/hungrypaws/" class="logo float-start">
                <img src="/HungryPaws/assets/img/hungrypaws.png" height="80" alt="Hungry Paws" />
            </a>

            <div class="panel card-sign">
                <div class="card-title-sign mt-3 text-end">
                    <h2 class="title text-uppercase font-weight-bold m-0"><i
                            class="bx bx-user-circle me-1 text-6 position-relative top-5"></i> Log In</h2>
                </div>
                <div class="card-body">
                    <form id="loginForm" data-role="Admin" method="post" class="mb-4">
                        <div class="form-group mb-3">
                            <h1 class="text-dark text-uppercase">Admin Login</h1>
                        </div>
                        <div class="form-group mb-3">
                            <label>Username</label>
                            <div class="input-group">
                                <input name="username" id="username" type="text" class="form-control form-control-md "
                                    placeholder="Enter Username" />
                                <span class="input-group-text">
                                    <i class="bx bx-user text-4"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="clearfix">
                                <label class="float-start">Password</label>
                                <a href="forgot-password" class="float-end">Forgot Password?</a>
                            </div>
                            <div class="input-group">
                                <input name="password" id="password" type="password"
                                    class="form-control form-control-md " placeholder="Enter Password" />
                                <span class="input-group-text">
                                    <i class="bx bx-lock text-4"></i>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="checkbox-custom checkbox-default">
                                    <input id="showPassword" name="showPassword" type="checkbox" />
                                    <label for="showPassword">Show Password</label>
                                </div>
                            </div>
                            <div class="col-sm-4 text-end">
                                <button type="submit" class="btn btn-primary mt-2">Log In</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <p class="text-center text-muted mt-3 mb-3">&copy;2025 - All Rights Reserved.</p>
        </div>
    </section>
    <!-- end: page -->
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/login-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/login-scripts.php';
    ?>


</body>

</html>