<style>
    :root {
        --branch-color:
            <?= $_SESSION['branch_color'] ?? '#5B8DEF' ?>
        ;
        --role-color:
            <?= $_SESSION['role_color'] ?? '#6B7280' ?>
        ;
    }

    .pagination .page-item .page-link {
        color: var(--role-color) !important;
        border-color: rgba(0, 0, 0, 0.08) !important;

        transition: 0.2s ease;
    }

    /* Hover */
    .pagination .page-item .page-link:hover {
        background-color: var(--role-color) !important;
        border-color: var(--role-color) !important;
        color: #fff !important;
    }

    /* Active Page */
    .pagination .page-item.active .page-link,
    .pagination .active>.page-link {
        background-color: var(--role-color) !important;
        border-color: var(--role-color) !important;
        color: #fff !important;
    }

    /* Focus */
    .pagination .page-link:focus {
        box-shadow: 0 0 0 0.15rem rgba(0, 0, 0, 0.08) !important;
    }

    /* Active sidebar text */
    #sidebar-left .nav-active>.nav-link span {
        color: var(--role-color) !important;
    }

    /* Active sidebar icon */
    #sidebar-left .nav-active>.nav-link i {
        color: var(--role-color) !important;
    }

    /* Optional active indicator */
    #sidebar-left .nav-active>.nav-link {
        border-left: 3px solid var(--role-color) !important;
    }

    /* SIDEBAR HOVER */
    #sidebar-left .nav-link:hover,
    #sidebar-left .nav-link:focus,
    #sidebar-left .nav-link:active {

        background:
            color-mix(in srgb, var(--role-color) 10%, white) !important;

        border-left: 3px solid var(--role-color) !important;

        box-shadow: none !important;
    }

    html #sidebar-left .nav-link:hover {
        color: var(--role-color) !important;
    }

    /* TEXT + ICON */
    #sidebar-left .nav-link:hover span,
    #sidebar-left .nav-link:hover i,
    #sidebar-left .nav-link:focus span,
    #sidebar-left .nav-link:focus i,
    #sidebar-left .nav-link:active span,
    #sidebar-left .nav-link:active i {

        color: var(--role-color) !important;
    }

    /* REMOVE PORTO BLUE AFTER-EFFECT */
    #sidebar-left .nav-link::before,
    #sidebar-left .nav-link::after {
        background: transparent !important;
        box-shadow: none !important;
    }

    /* Active mobile nav item */
    #mainNav li.active .nav-link {
        background: var(--role-color) !important;
        color: #fff !important;

        border-radius: 10px;

        transition: 0.2s ease;
    }

    /* Hover */
    #mainNav .nav-link {
        color: var(--role-color) !important;
    }


    /* Default */
    .header-btn-collapse-nav {
        border: 1px solid var(--role-color) !important;
        background: transparent !important;

        border-radius: 10px;

        transition: 0.2s ease;
    }

    /* Icon */
    .header-btn-collapse-nav i {
        color: #fff !important;
    }

    /* Hover */
    .header-btn-collapse-nav:hover {
        background: var(--role-color) !important;
    }

    .header-btn-collapse-nav:hover i {
        color: #fff !important;
    }

    /* Focus / Click */
    .header-btn-collapse-nav:focus,
    .header-btn-collapse-nav:active,
    .header-btn-collapse-nav.show {
        background: var(--role-color) !important;
        border-color: var(--role-color) !important;

        box-shadow: none !important;
    }

    /* Icon during click */
    .header-btn-collapse-nav:focus i,
    .header-btn-collapse-nav:active i,
    .header-btn-collapse-nav.show i {
        color: #fff !important;
    }

    /* Dropdown hover */
    .dropdown-menu a:hover,
    .dropdown-menu a:focus {

        background:
            color-mix(in srgb, var(--role-color) 10%, white) !important;

        color: var(--role-color) !important;

        transition: 0.2s ease;
    }

    /* Icons inside dropdown */
    .dropdown-menu a:hover i,
    .dropdown-menu a:focus i {

        color: var(--role-color) !important;
    }

    /* Normal tab */
    .tabs .nav-tabs .nav-link {
        color: #64748b !important;

        transition: 0.2s ease;
    }

    /* Hover */
    .tabs .nav-tabs .nav-link:hover {
        color: var(--role-color) !important;
    }

    /* Active tab */
    .tabs .nav-tabs .nav-link.active {
        color: var(--role-color) !important;

        border-top-color: var(--role-color) !important;
    }

    /* Optional active underline */
    .tabs .nav-tabs .nav-link.active::after {
        background: var(--role-color) !important;
    }

    /* Hover tab border fix */
    .tabs .nav-tabs .nav-link:hover {
        border-top-color: var(--role-color) !important;
    }
</style>