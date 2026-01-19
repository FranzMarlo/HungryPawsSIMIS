<!doctype html>
<html class="fixed">
<?php
$title = "401 - Unauthorized";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/utility/head.php';
?>

<body>
    <!-- start: page -->
    <section class="body-error error-outside">
        <div class="center-error">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="main-error mb-3 text-center">

                        <h2 class="error-code text-dark font-weight-semibold m-0">
                            401 <i class="fas fa-lock"></i>
                        </h2>

                        <h3 class="text-xl text-dark font-weight-semibold mt-3">
                            Unauthorized Access
                        </h3>

                        <p class="error-explanation mt-0">
                            You must be logged in or have proper authorization to view this page.
                        </p>

                        <!-- Go Back Button -->
                        <button class="btn btn-primary mt-3" onclick="history.back()">
                            <i class="fas fa-arrow-left me-1"></i> Go Back
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- end: page -->
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/utility/footer.php';
    ?>


</body>

</html>