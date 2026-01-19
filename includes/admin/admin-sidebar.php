<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
        <div class="sidebar-toggle d-none d-md-flex" data-toggle-class="sidebar-left-collapsed" data-target="html"
            data-fire-event="sidebar-left-toggle">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">

                <ul class="nav nav-main">
                    <li class="<?= ($current_page == 'dashboard.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="dashboard">
                            <i class="fa-solid fa-square-poll-vertical" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li
                        class="nav-parent <?= ($current_page == 'users.php' || $current_page == 'add-user.php' || $current_page == 'update-user.php') ? 'nav-expanded' : '' ?>">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-user" aria-hidden="true"></i>
                            <span>Users</span>
                        </a>
                        <ul class="nav nav-children">
                            <li
                                class="<?= ($current_page == 'users.php' || $current_page == 'update-user.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="users">
                                    <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                    <span>User List</span>
                                </a>
                            </li>
                            <li class="<?= ($current_page == 'add-user.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="add-user">
                                    <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                                    <span>Add User</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-parent <?= ($current_page == 'branches.php' || $current_page == 'add-branch.php'
                        || $current_page == 'update-branch.php') ? 'nav-expanded' : '' ?>">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-shop" aria-hidden="true"></i>
                            <span>Branches</span>
                        </a>
                        <ul class="nav nav-children">
                            <li
                                class="<?= ($current_page == 'branches.php' || $current_page == 'update-branch.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="branches">
                                    <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                    <span>Branch List</span>
                                </a>
                            </li>
                            <li class="<?= ($current_page == 'add-branch.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="add-branch">
                                    <i class="bx bx-plus" aria-hidden="true"></i>
                                    <span>Add Branch</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-parent <?= ($current_page == 'products.php' || $current_page == 'add-product.php'
                        || $current_page == 'update-product.php') ? 'nav-expanded' : '' ?>">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-coins" aria-hidden="true"></i>
                            <span>Products</span>
                        </a>
                        <ul class="nav nav-children">
                            <li
                                class="<?= ($current_page == 'products.php' || $current_page == 'update-product.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="products">
                                    <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                    <span>Product List</span>
                                </a>
                            </li>
                            <li class="<?= ($current_page == 'add-product.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="add-product">
                                    <i class="bx bx-plus" aria-hidden="true"></i>
                                    <span>Add Product</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-parent <?= ($current_page == 'suppliers.php' || $current_page == 'add-supplier.php' || $current_page == 'update-supplier.php') ? 'nav-expanded' : '' ?>">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-truck-field" aria-hidden="true"></i>
                            <span>Supplier</span>
                        </a>
                        <ul class="nav nav-children">
                            <li
                                class="<?= ($current_page == 'suppliers.php' || $current_page == 'update-supplier.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="suppliers">
                                    <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                    <span>Supplier List</span>
                                </a>
                            </li>
                            <li class="<?= ($current_page == 'add-supplier.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="add-supplier">
                                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                    <span>Add Supplier</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-parent <?= ($current_page == 'category.php' || $current_page == 'add-category.php' || $current_page == 'update-category.php') ? 'nav-expanded' : '' ?>">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                            <span>Product Category</span>
                        </a>
                        <ul class="nav nav-children">
                            <li
                                class="<?= ($current_page == 'category.php' || $current_page == 'update-category.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="category">
                                    <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                    <span>Category List</span>
                                </a>
                            </li>
                            <li class="<?= ($current_page == 'add-category.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="add-category">
                                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                    <span>Add Category</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link modal-trigger" href="#modalLogoutConfirm">
                            <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                            <span>Log Out</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <script>
            if (typeof localStorage !== 'undefined') {
                if (localStorage.getItem('sidebar-left-position') !== null) {
                    var initialPosition = localStorage.getItem('sidebar-left-position'),
                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');

                    sidebarLeft.scrollTop = initialPosition;
                }
            }
        </script>

    </div>

</aside>
<!-- end: sidebar -->