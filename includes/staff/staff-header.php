<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<!-- start: header -->
<header class="header header-nav-menu header-nav-links">
    <div class="logo-container dynamic-role-theme">
        <a href="dashboard" class="logo">

            <img src="/HungryPaws/assets/img/logo-banner.png" class="logo-image" width="150" height="35"
                alt="Hungry Paws" /><img src="/HungryPaws/assets/img/logo-banner.png" class="logo-image-mobile"
                width="150" height="35" alt="Hungry Paws" />
        </a>
        <button class="btn header-btn-collapse-nav d-lg-none" data-bs-toggle="collapse" data-bs-target=".header-nav">
            <i class="fas fa-bars"></i>
        </button>

        <!-- start: header nav menu -->
        <div class="header-nav collapse">
            <div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 header-nav-main-square">
                <nav class="d-lg-none">
                    <ul class="nav nav-pills" id="mainNav">
                        <li class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
                            <a class="nav-link" href="dashboard">
                                Dashboard
                            </a>
                        </li>
                        <li
                            class="dropdown <?= ($current_page == 'products.php' || $current_page == 'add-inventory.php' || $current_page == 'update-inventory.php') ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#">
                                Product Inventory
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="products">
                                        Inventory List
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="add-inventory">
                                        Add Inventory
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="dropdown <?= ($current_page == 'stock-transfer.php' || $current_page == 'transfers.php' || $current_page == 'update-request.php') ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#">
                                Stock Transfer
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="transfers">
                                        Stock Transfer Requests
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="stock-transfer">
                                        Request Stock Transfer
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="nav-link modal-trigger" href="#modalLogoutConfirm">
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- end: header nav menu -->
    </div>

    <!-- start: search & user box -->
    <div class="header-right">

        <div id="userbox" class="userbox">
            <a href="#" data-bs-toggle="dropdown">

                <img src="/HungryPaws/uploads/image/profile/<?= htmlspecialchars($image) ?>" id="profile-header"
                    class="profile-picture profile-picture-as-text bg-body">
                <div class="profile-info profile-info-no-role" data-lock-name="<?= htmlspecialchars($username) ?>"
                    data-lock-email="<?= htmlspecialchars($email); ?>">
                    <span class="name"><strong
                            class="font-weight-semibold"><?= htmlspecialchars($username) ?></strong></span>
                </div>

                <i class="fas fa-chevron-down text-color-dark"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled">
                    <li>
                        <a role="menuitem" tabindex="-1" href="profile "><i class="bx bx-user"></i> My
                            Profile</a>
                    </li>
                    <li>
                        <a role="menuitem" class="modal-trigger" tabindex="-1" href="#modalLogoutConfirm"><i
                                class="bx bx-log-out"></i>
                            Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<!-- end: header -->