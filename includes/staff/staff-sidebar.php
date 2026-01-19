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
                        class="nav-parent <?= ($current_page == 'products.php' || $current_page == 'add-inventory.php' || $current_page == 'update-inventory.php') ? 'nav-expanded' : '' ?>">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-scroll" aria-hidden="true"></i>
                            <span>Product Inventory</span>
                        </a>
                        <ul class="nav nav-children">
                            <li
                                class="<?= ($current_page == 'products.php' || $current_page == 'update-inventory.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="products">
                                    <i class="fa-solid fa-coins" aria-hidden="true"></i>
                                    <span>Inventory List</span>
                                </a>
                            </li>
                            <li class="<?= ($current_page == 'add-inventory.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="add-inventory">
                                    <i class="bx bx-plus" aria-hidden="true"></i>
                                    <span>Add Inventory</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-parent <?= ($current_page == 'stock-transfer.php' || $current_page == 'transfers.php' || $current_page == 'update-request.php') ? 'nav-expanded' : '' ?>">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-money-bill-transfer" aria-hidden="true"></i>
                            <span>Stock Transfer</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="<?= ($current_page == 'transfers.php' || $current_page == 'update-request.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="transfers">
                                    <i class="fa-solid fa-file-invoice" aria-hidden="true"></i>
                                    <span>Stock Transfer Requests</span>
                                </a>
                            </li>
                            <li class="<?= ($current_page == 'stock-transfer.php') ? 'nav-active' : '' ?>">
                                <a class="nav-link" href="stock-transfer">
                                    <i class="fa-solid fa-up-right-from-square" aria-hidden="true"></i>
                                    <span>Request Stock Transfer</span>
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