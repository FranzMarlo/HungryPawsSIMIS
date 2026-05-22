<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
if (!isset($_SESSION['user_id'])) {
    header("Location: /HungryPaws/utility/401");
    exit();
}

if ($_SESSION['role'] !== "Cashier") {
    header("Location: /HungryPaws/utility/403");
    exit();
}

$user_id = $_SESSION['user_id'];
$branch_id = $_SESSION['branch_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];
$image = $_SESSION['image'];
$branch_color = $_SESSION['branch_color'];
$roleColor = $_SESSION['role_color'] ?? '#6B7280';

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/fetch-class.php';
include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/backend/css-helper.php';

$fetch = new fetchClass();
$branchDetail = $fetch->getBranchDetails($branch_id);
$branchName = $branchDetail['branch_name'] ?? 'Hungry Paws';
?>

<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title><?= $title ?></title>

    <meta name="description" content="The Hungry Paws">

    <link rel="shortcut icon" href="/HungryPaws/assets/img/hungrypaws.png" type="image/x-icon">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,300,400,600,700,800,900" rel="stylesheet"
        type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/animate/animate.compat.css">
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/font-awesome/css/all.min.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/boxicons/css/boxicons.min.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/morris/morris.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/datatables/media/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/pnotify/pnotify.custom.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/jquery-ui/jquery-ui.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/jquery-ui/jquery-ui.theme.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/select2/css/select2.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/dropzone/basic.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/dropzone/dropzone.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
    <link rel="stylesheet" href="/HungryPaws/assets/vendor/summernote/summernote-bs4.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <!-- Theme CSS -->
    <link rel="stylesheet" href="/HungryPaws/assets/css/theme.css" />

    <!-- Theme Layout -->
    <link rel="stylesheet" href="/HungryPaws/assets/css/layouts/modern.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="/HungryPaws/assets/css/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="/HungryPaws/assets/css/custom.css">

    <!-- Head Libs -->
    <script src="/HungryPaws/assets/vendor/modernizr/modernizr.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/style.php';
    ?>

</head>