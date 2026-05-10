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
                    <li class="<?= ($current_page == 'products.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="products">
                            <i class="fa-solid fa-coins" aria-hidden="true"></i>
                            <span>Product List</span>
                        </a>
                    </li>
                    <li class="<?= ($current_page == 'add-order.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="add-order">
                            <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                            <span>Add Order</span>
                        </a>
                    </li>

                    <li
                        class="<?= ($current_page == 'transfers.php' || $current_page == 'update-request.php') ? 'nav-active' : '' ?>">
                        <a class="nav-link" href="transfers">
                            <i class="fa-solid fa-file-invoice" aria-hidden="true"></i>
                            <span>Incoming Stock Transfers</span>
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