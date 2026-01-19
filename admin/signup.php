<!doctype html>
<html class="fixed">

<?php
$title = "Sign Up | Hungry Paws";

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
                            class="bx bx-user-circle me-1 text-6 position-relative top-5"></i> Sign Up</h2>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group mb-3">
                            <h1 class="text-dark text-uppercase">Admin Sign Up</h1>
                        </div>
                        <div class="form-group mb-3">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control form-control-md"
                                placeholder="Enter Name" />
                        </div>

                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control form-control-md"
                                placeholder="Enter Email" />
                        </div>

                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input name="pwd" type="password" class="form-control form-control-md"
                                placeholder="Enter Password" />
                        </div>

                        <div class="form-group mb-3">
                            <label>Confirm Password</label>
                            <input name="pwd_confirm" type="password" class="form-control form-control-md"
                                placeholder="Confirm Password" />
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="checkbox-custom checkbox-default">
                                    <input id="showPassword" name="showPassword" type="checkbox" />
                                    <label for="showPassword">Show Password</label>
                                </div>
                            </div>
                            <div class="col-sm-4 text-end">
                                <button type="submit" class="btn btn-primary mt-2">Sign Up</button>
                            </div>
                        </div>

                        <span class="mt-3 mb-3 line-thru text-center text-uppercase">
                            <span>or</span>
                        </span>


                        <p class="text-center">Already have an account? <a href="login">Log In!</a></p>

                    </form>
                </div>
            </div>

            <p class="text-center text-muted mt-3 mb-3">&copy;2025 - All Rights Reserved.</p>
        </div>
    </section>
    <!-- end: page -->

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/login-scripts.php';
    ?>

</body>

</html>