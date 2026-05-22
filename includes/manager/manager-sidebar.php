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
                        class="<?= ($current_page == 'products.php' || $current_page == 'product-report.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="products">
                            <i class="fa-solid fa-coins" aria-hidden="true"></i>
                            <span>Products</span>
                        </a>
                    </li>
                    <li
                        class="<?= ($current_page == 'orders.php' || $current_page == 'receipt.php' || $current_page == 'order-report.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="orders">
                            <i class="fa-solid fa-scroll" aria-hidden="true"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li
                        class="<?= ($current_page == 'transfers.php' || $current_page == 'update-request.php' || $current_page == 'transfer-report.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="transfers">
                            <i class="fa-solid fa-money-bill-transfer" aria-hidden="true"></i>
                            <span>Stock Transfer Requests</span>
                        </a>
                    </li>
                    <li
                        class="<?= ($current_page == 'pet-grooming.php' || $current_page == 'grooming-report.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="pet-grooming">
                            <i class="fa-solid fa-shower" aria-hidden="true"></i>
                            <span>Pet Grooming Records</span>
                        </a>
                    </li>
                    <li
                        class="<?= ($current_page == 'pet-hotel.php' || $current_page == 'hotel-report.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="pet-hotel">
                            <i class="fa-solid fa-suitcase" aria-hidden="true"></i>
                            <span>Pet Hotel Records</span>
                        </a>
                    </li>
                    <li
                        class="<?= ($current_page == 'main-user.php' || $current_page == 'update-user.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="main-user">
                            <i class="fa-solid fa-user" aria-hidden="true"></i>
                            <span>Main Users</span>
                        </a>
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
            // Maintain Scroll Position
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