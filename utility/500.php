<!doctype html>
<html class="fixed">
<?php
$title = "500 - Internal Server Error";

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
                            500 <i class="fas fa-exclamation-triangle"></i>
                        </h2>

                        <h3 class="text-xl text-dark font-weight-semibold mt-3">
                            Something Went Wrong
                        </h3>

                        <p class="error-explanation mt-0">
                            Oops! There was an internal server error. Please try again later.
                        </p>

                        <!-- Go Back Button -->
                        <button class="btn btn-primary mt-3" onclick="history.back()">
                            <i class="fas fa-arrow-left me-1"></i> Go Back
                        </button>

                        <!-- Retry Button -->
                        <button class="btn btn-secondary mt-3 ms-2" onclick="window.location.reload();">
                            <i class="fas fa-redo me-1"></i> Try Again
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