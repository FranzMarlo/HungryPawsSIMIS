<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Dashboard | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-head.php';

$fetch = new fetchClass();
$productCount = $fetch->getProductCount();
$productsOnStock = $fetch->getProductCountOnStock($branch_id);
$orderCount = $fetch->getOrderCount($branch_id);
$orderRecord = $fetch->getOrderTrend($branch_id);
$averagePrice = $fetch->getAveragePrice($branch_id);
$userCount = $fetch->getUserCount($branch_id);
$revenue = $fetch->getRevenue($branch_id);
$branchDetail = $fetch->getBranchDetails($branch_id);
$products = $fetch->getTop5Products($branch_id);
$expensives = $fetch->getMostExpensiveProducts($branch_id);

$orderTrend = getPrevOrderClass($orderRecord['recent'], $orderRecord['previous']);
?>

<body>
    <section class="body">

        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-header.php';
        ?>

        <div class="inner-wrapper">
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-sidebar.php';
            ?>

            <section role="main" class="content-body content-body-modern">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">Admin Dashboard</h2>
                </header>

                <!-- start: page -->
                <div class="row">
                    <div class="col-lg-12 col-xl-4">

                        <div class="row">
                            <div class="col-12">
                                <div class="card card-modern">
                                    <div class="card-body p-0">
                                        <div class="widget-user-info">
                                            <div class="widget-user-info-header">
                                                <h2 class="font-weight-bold text-color-dark text-5">
                                                    <?= htmlspecialchars($first_name), ' ', htmlspecialchars($last_name); ?>
                                                </h2>
                                                <p class="mb-0"><?= htmlspecialchars($branchDetail['branch_name']) ?>
                                                </p>
                                                <p class="mb-0">Administrator</p>

                                                <img src="/HungryPaws/uploads/image/profile/<?= htmlspecialchars($image) ?>"
                                                    class="widget-user-acrostic">

                                                </img>
                                            </div>
                                            <div class="widget-user-info-body">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <strong
                                                            class="text-color-dark text-5"><?= htmlspecialchars($productCount['product_count']) ?></strong>
                                                        <h3 class="text-4-1">Products</h3>
                                                    </div>
                                                    <div class="col-auto">
                                                        <strong
                                                            class="text-color-dark text-5"><?= htmlspecialchars($productsOnStock['product_count']) ?></strong>
                                                        <h3 class="text-4-1">Products On Stock</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="profile"
                                                            class="btn btn-light btn-xl border font-weight-semibold text-color-dark text-3 mt-4">View
                                                            Profile</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-xl-12 pb-2 pb-lg-0 mb-4 mb-lg-0">
                                <div class="card card-modern">
                                    <div class="card-body py-4">
                                        <div class="row align-items-center">
                                            <div class="col-6 col-md-4">
                                                <h3 class="text-4-1 my-0">Total Orders</h3>
                                                <strong
                                                    class="text-6 text-color-dark"><?= htmlspecialchars($orderCount['order_count']) ?></strong>
                                            </div>
                                            <div
                                                class="col-6 col-md-4 border border-top-0 border-end-0 border-bottom-0 border-color-light-grey py-3">
                                                <h3
                                                    class="text-4-1 <?= htmlspecialchars($orderTrend['class']) ?> line-height-2 my-0">
                                                    <strong><?= $orderTrend['text'] ?></strong>
                                                </h3>
                                                <span>30 days</span>
                                            </div>
                                            <div class="col-md-4 text-start text-md-right pe-md-4 mt-4 mt-md-0">
                                                <i
                                                    class="bx bx-cart-alt icon icon-inline icon-xl bg-primary rounded-circle text-color-light"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-12 pt-xl-2 mt-xl-4">
                                <div class="card card-modern">
                                    <div class="card-body py-4">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-8">
                                                <h3 class="text-4-1 my-0">Average Price</h3>
                                                <strong class="text-6 text-color-dark">
                                                    <?= htmlspecialchars('₱' . number_format($averagePrice['avg_price'], 2)) ?>
                                                </strong>
                                            </div>

                                            <div class="col-12 col-md-4 text-start text-md-right pe-md-4 mt-4 mt-md-0">
                                                <i
                                                    class="bx bx-purchase-tag-alt icon icon-inline icon-xl bg-primary rounded-circle text-color-light pe-0"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-8 pt-2 pt-xl-0 mt-4 mt-xl-0">

                        <div class="row">
                            <div class="col">
                                <div class="card card-modern">
                                    <div class="card-header">
                                        <div class="card-actions">
                                            <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                                        </div>
                                        <h2 class="card-title">Revenue</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <strong
                                                    class="text-color-dark text-6"><?= htmlspecialchars('₱' . number_format($revenue['currentMonth'], 2)) ?></strong>
                                                <h3 class="text-4 mt-0 mb-2">This Month</h3>
                                            </div>
                                            <div class="col-auto">
                                                <strong
                                                    class="text-color-dark text-6"><?= htmlspecialchars('₱' . number_format($revenue['lastMonth'], 2)) ?></strong>
                                                <h3 class="text-4 mt-0 mb-2">Last Month</h3>
                                            </div>
                                            <div class="col-auto">
                                                <strong
                                                    class="text-color-dark text-6"><?= htmlspecialchars('₱' . number_format($revenue['total'], 2)) ?></strong>
                                                <h3 class="text-4 mt-0 mb-2">Total Profit</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">

                                                <!-- Morris: Area -->
                                                <div class="chart chart-md chart-bar-stacked-sm my-3" id="revenueChart"
                                                    style="height: 420px;"></div>

                                                <div id="revenuePlaceholder"
                                                    style="height: 450px; display:none; text-align:center; padding:40px; color:#777; font-size:18px;">
                                                    No revenue data available.
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xl-4">
                        <div class="card card-modern">
                            <div class="card-body py-4">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-8">
                                        <h3 class="text-4-1 my-0">Total Branch Users</h3>
                                        <strong
                                            class="text-6 text-color-dark"><?= htmlspecialchars($userCount['user_count']) ?></strong>
                                    </div>
                                    <div class="col-md-4 text-start text-md-right pe-md-4 mt-4 mt-md-0">
                                        <i
                                            class="bx bx-user icon icon-inline icon-xl bg-primary rounded-circle text-color-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-modern">
                            <div class="card-header">
                                <div class="card-actions">
                                    <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                                </div>
                                <h2 class="card-title">Quick Actions</h2>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column gap-3">
                                    <a href="products"
                                        class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4"><i
                                            class="fa-solid fa-coins"></i>
                                        &nbsp;View Products</a>
                                    <a href="add-product"
                                        class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4"><i
                                            class="fa-solid fa-add"></i>
                                        &nbsp;Add Product</a>
                                    <a href="profile"
                                        class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4"><i
                                            class="fa-solid fa-user"></i>
                                        &nbsp;View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4 pt-2 pt-lg-0 mt-4 mt-lg-0">
                        <div class="card card-modern">
                            <div class="card-header">
                                <div class="card-actions">
                                    <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                                </div>
                                <h2 class="card-title">Top 5 Selling Products</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-ecommerce-simple table-borderless table-striped mb-1">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($products)): ?>
                                                <?php $productPos = 1 ?>
                                                <?php foreach ($products as $product): ?>
                                                    <tr>
                                                        <td width="72"><span
                                                                class="badge bg-primary rounded-circle d-inline-flex justify-content-center align-items-center text-4"
                                                                style="width: 40px; height: 40px;">
                                                                <?= intval($productPos++) ?>
                                                            </span>
                                                        </td>
                                                        <td><a href="update-product?id=<?= urlencode($product['product_id']) ?>"
                                                                class="font-weight-semibold"><?= $product['product_name'] ?></a>
                                                        </td>
                                                        <td width="90">₱<?= $product['selling_price'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        No products sold
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-4 pt-2 pt-xl-0 mt-4 mt-xl-0">
                        <div class="card card-modern">
                            <div class="card-header">
                                <div class="card-actions">
                                    <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                                </div>
                                <h2 class="card-title">Most Expensive Products</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-ecommerce-simple table-borderless table-striped mb-1">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($expensives)): ?>
                                                <?php $expensivePos = 1 ?>
                                                <?php foreach ($expensives as $expensive): ?>
                                                    <tr>
                                                        <td width="72"><span
                                                                class="badge bg-primary rounded-circle d-inline-flex justify-content-center align-items-center text-4"
                                                                style="width: 40px; height: 40px;">
                                                                <?= intval($expensivePos++) ?>
                                                            </span>
                                                        </td>
                                                        <td><a href="update-product?id=<?= urlencode($expensive['product_id']) ?>"
                                                                class="font-weight-semibold"><?= $expensive['product_name'] ?></a>
                                                        </td>
                                                        <td width="90">₱<?= $expensive['selling_price'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        No products found in inventory
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end: page -->
            </section>
        </div>

    </section>

    <script>
        const branchId = "<?= $_SESSION['branch_id'] ?>";
    </script>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->
    <script src="/HungryPaws/assets/vendor/raphael/raphael.js"></script>
    <script src="/HungryPaws/assets/vendor/morris/morris.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>
    <script src="/HungryPaws/assets/js/admin/dashboard-charts.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>
    <script src="/HungryPaws/assets/js/examples/examples.ecommerce.datatables.list.js"></script>

</body>

</html>