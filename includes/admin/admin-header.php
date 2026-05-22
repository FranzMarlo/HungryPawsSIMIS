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
                            class="dropdown <?= ($current_page == 'users.php' || $current_page == 'add-user.php' || $current_page == 'update-user.php') ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#">
                                Users
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="users">
                                        User List
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="add-user">
                                        Add User
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown <?= ($current_page == 'branches.php' || $current_page == 'add-branch.php'
                            || $current_page == 'update-branch.php') ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#">
                                Branches
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="branches">
                                        Branch List
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="add-branch">
                                        Add Branch
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown <?= ($current_page == 'products.php' || $current_page == 'add-product.php'
                            || $current_page == 'update-product.php') ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#">
                                Products
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="products">
                                        Product List
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="add-product">
                                        Add Product
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="dropdown <?= ($current_page == 'suppliers.php' || $current_page == 'add-supplier.php' || $current_page == 'update-supplier.php') ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#">
                                Supplier
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="suppliers">
                                        Supplier List
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="add-supplier">
                                        Add Supplier
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="dropdown <?= ($current_page == 'category.php' || $current_page == 'add-category.php' || $current_page == 'update-category.php') ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#">
                                Product Category
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="nav-link" href="category">
                                        Category List
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="add-category">
                                        Add Category
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

                    <span class="name">
                        <strong class="font-weight-semibold">
                            <?= htmlspecialchars($username) ?>
                        </strong>
                    </span>

                    <div class="branch-role-badge">

                        <span class="badge-dot"></span>

                        <span class="badge-text">
                            <?= htmlspecialchars($branchName) ?>
                            •
                            <?= htmlspecialchars($role) ?>
                        </span>

                    </div>

                </div>

                <i class="fas fa-chevron-down text-color-dark"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled mt-2">
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