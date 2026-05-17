<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Profile | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/manager-head.php';

$fetch = new fetchClass();
$globalStats = $fetch->getGlobalBranchStats();
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

            <section role="main" class="content-body content-body-modern">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">My Profile</h2>
                </header>

                <!-- start: page -->
                <div class="row">
                    <div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">

                        <section class="card">
                            <div class="card-body">
                                <div class="thumb-info mb-3">
                                    <img src="/HungryPaws/uploads/image/profile/<?= htmlspecialchars($image) ?>"
                                        id="profile-icon" class="rounded img-fluid"
                                        alt="<?= htmlspecialchars($first_name), ' ', htmlspecialchars($last_name); ?>">
                                    <div class="thumb-info-title">
                                        <span
                                            class="thumb-info-inner"><?= htmlspecialchars($first_name), ' ', htmlspecialchars($last_name); ?></span>
                                        <span
                                            class="thumb-info-type dynamic-role-theme text-uppercase"><?= htmlspecialchars($role); ?></span>
                                    </div>
                                </div>

                                <h5 class="mb-2 mt-3 font-weight-bold text-dark">Personal Information</h5>

                                <ul class="list-group">

                                    <li class="list-group-item">
                                        <p class="dynamic-role-text font-weight-bold mb-1">First Name</p>
                                        <p class="text-dark mb-0"><?= htmlspecialchars($first_name); ?></p>
                                    </li>

                                    <li class="list-group-item">
                                        <p class="dynamic-role-text font-weight-bold mb-1">Last Name</p>
                                        <p class="text-dark mb-0"><?= htmlspecialchars($last_name); ?></p>
                                    </li>

                                    <li class="list-group-item">
                                        <p class="dynamic-role-text font-weight-bold mb-1">Role</p>
                                        <p class="text-dark mb-0"><?= htmlspecialchars($role); ?></p>
                                    </li>

                                    <li class="list-group-item">
                                        <p class="dynamic-role-text font-weight-bold mb-1">User ID</p>
                                        <p class="text-dark mb-0"><?= htmlspecialchars($user_id); ?></p>
                                    </li>

                                    <li class="list-group-item">
                                        <p class="dynamic-role-text font-weight-bold mb-1">Username</p>
                                        <p class="text-dark mb-0"><?= htmlspecialchars($username); ?></p>
                                    </li>

                                    <li class="list-group-item">
                                        <p class="dynamic-role-text font-weight-bold mb-1">Email</p>
                                        <p class="text-dark mb-0"><?= htmlspecialchars($email); ?></p>
                                    </li>



                                </ul>

                            </div>
                        </section>
                    </div>

                    <div class="col-lg-8 col-xl-6">

                        <div class="tabs">
                            <ul class="nav nav-tabs tabs-primary">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-target="#overview" data-bs-toggle="tab">
                                        Overview
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-target="#edit" data-bs-toggle="tab">
                                        Edit Profile
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="overview" class="tab-pane active">
                                    <div class="p-3">
                                        <h3 class="mb-2">Orders Processed By Month</h3>
                                        <div class="chart chart-md" id="orderLine"></div>
                                        <div id="orderLegend" class="text-center mt-2"></div>
                                    </div>
                                </div>
                                <div id="edit" class="tab-pane">

                                    <div class="card mb-4">
                                        <h4 class="mb-3 font-weight-semibold text-dark">Update Photo</h4>
                                        <div class="card-body text-center">

                                            <!-- FILE DROPZONE -->
                                            <div id="dropzone" class="border rounded-circle mx-auto position-relative"
                                                style="width: 160px; height: 160px; overflow: hidden; cursor: pointer;">

                                                <!-- Profile Image -->
                                                <img id="profilePreview"
                                                    src="/HungryPaws/uploads/image/profile/<?= htmlspecialchars($image) ?>"
                                                    class="w-100 h-100" style="object-fit: cover;">

                                                <!-- Overlay Icon -->
                                                <div
                                                    class="edit-overlay d-flex justify-content-center align-items-center">
                                                    <i class="fas fa-pencil-alt text-white fs-4"></i>
                                                </div>
                                            </div>

                                            <!-- Hidden input -->
                                            <input type="file" id="profileInput" accept="image/*" hidden>
                                            <p class="text-muted mt-2">Click or Drop Image to Edit</p>

                                        </div>
                                    </div>


                                    <form class="p-3" id="updatePasswordForm">
                                        <h4 class="mb-3 font-weight-semibold text-dark">Change Password</h4>
                                        <div class="row gap-2">
                                            <div class="form-group">
                                                <label for="currentPassword">Current Password</label>
                                                <input type="password" class="form-control form-control-modern"
                                                    id="currentPassword" name="currentPassword"
                                                    placeholder="Enter Current Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="newPassword">New Password</label>
                                                <input type="password" class="form-control form-control-modern"
                                                    id="newPassword" name="newPassword"
                                                    placeholder="Enter New Password">
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmPassword">Confirm New Password</label>
                                                <input type="password" class="form-control form-control-modern"
                                                    id="confirmPassword" name="confirmPassword"
                                                    placeholder="Re-enter New Password">
                                            </div>
                                        </div>

                                        <input type="hidden" name="userId" id="userId"
                                            value="<?= htmlspecialchars($user_id) ?>">
                                        <div class="row">
                                            <div class="col-md-12 text-end mt-3">
                                                <button class="btn btn-primary modal-confirm">Save</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">

                        <h4 class="mb-3 mt-0 font-weight-semibold text-dark">All Branch Stats</h4>
                        <ul class="simple-card-list mb-3">
                            <li class="primary dynamic-role-theme">
                                <h3><?= htmlspecialchars($globalStats['total_orders']) ?></h3>
                                <p class="text-light">Total Orders Processed</p>
                            </li>
                            <li class="primary dynamic-role-theme">
                                <h3><?= htmlspecialchars('₱' . number_format($globalStats['total_amount'], 2)) ?></h3>
                                <p class="text-light">Total Sales Amount</p>
                            </li>
                            <li class="primary dynamic-role-theme">
                                <h3><?= htmlspecialchars($globalStats['total_requested']) ?></h3>
                                <p class="text-light">Total Requested Transfers</p>
                            </li>
                            <li class="primary dynamic-role-theme">
                                <h3><?= htmlspecialchars($globalStats['total_approved']) ?>
                                </h3>
                                <p class="text-light">Total Approved Transfers</p>
                            </li>
                            <li class="primary dynamic-role-theme">
                                <h3><?= htmlspecialchars($globalStats['total_completed']) ?>
                                </h3>
                                <p class="text-light">Total Completed Transfers</p>
                            </li>
                        </ul>

                    </div>

                </div>

                <!-- end: page -->
            </section>
        </div>

    </section>

    <div class="modal fade" id="cropModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Crop Image</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body d-flex justify-content-center align-items-center">
                    <div class="crop-container">
                        <img id="cropImage" class="crop-image">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="cropBtn" class="btn btn-primary">Crop & Save</button>
                </div>
            </div>
        </div>
    </div>



    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/manager/update-profile-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->
    <script src="/HungryPaws/assets/vendor/autosize/autosize.js"></script>
    <script src="/HungryPaws/assets/vendor/flot/jquery.flot.js"></script>
    <script src="/HungryPaws/assets/vendor/flot/jquery.flot.resize.js"></script>
    <script src="/HungryPaws/assets/vendor/flot.tooltip/jquery.flot.tooltip.js"></script>

    <script src="/HungryPaws/assets/js/global-profile.js"></script>
    <script src="/HungryPaws/assets/js/manager/notification.js"></script>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <style>
        .edit-overlay {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .25s ease;
            pointer-events: none;
        }

        #dropzone:hover .edit-overlay {
            opacity: 1;
        }

        .edit-overlay i {
            font-size: 18px;
            color: white;
        }

        .crop-container {
            width: 100%;
            max-width: 800px;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .crop-image {
            width: 100% !important;
            height: auto !important;
            max-height: 100% !important;
        }
    </style>



</body>

</html>