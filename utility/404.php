<!doctype html>
<html class="fixed">
<?php
$title = "404 -  Not Found";

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
                            404 <i class="fas fa-file"></i>
                        </h2>

                        <h3 class="text-xl text-dark font-weight-semibold mt-3">Page Not Found</h3>

                        <p class="error-explanation mt-0">
                            The page you're trying to access cannot be found or may have been moved.
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