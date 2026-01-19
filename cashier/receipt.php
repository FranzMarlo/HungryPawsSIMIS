<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Order Receipt | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/cashier-head.php';
$fetch = new fetchClass();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $orderID = $_GET['id'];
    $orderInfo = $fetch->getOrderInfo($orderID);
    $orderDetails = $fetch->getOrderDetails($orderID);
    $groomingDetail = $fetch->getGroomingDetails($orderID);
    $bookingDetail = $fetch->getBookingDetails($orderID);
} else {
    header("Location: /hungrypaws/cashier/orders");
    exit;
}
?>

<body>
    <section class="body">

        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/cashier-header.php';
        ?>

        <div class="inner-wrapper">
            <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/cashier-sidebar.php';
            ?>

            <section role="main" class="content-body content-body-modern mt-0">
                <header class="page-header page-header-left-inline-breadcrumb">
                    <h2 class="font-weight-bold text-6">View Order Receipt</h2>
                </header>


                <!-- start: page -->
                <section class="card">
                    <div class="card-body">
                        <div class="invoice">
                            <header class="clearfix">
                                <div class="row">
                                    <div class="col-sm-6 mt-3">
                                        <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">ORDER RECEIPT</h2>
                                        <h4 class="h4 m-0 text-dark font-weight-bold">#<?= htmlspecialchars($orderID) ?>
                                        </h4>
                                    </div>
                                    <div class="col-sm-6 text-end mt-3 mb-3">
                                        <div class="ib mb-3">
                                            <img src="/HungryPaws/assets/img/hungrypaws.png" alt="Hungry Paws"
                                                class="invoice-logo" />
                                        </div>
                                    </div>
                                </div>
                            </header>
                            <div class="bill-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="bill-to">
                                            <p class="h5 mb-1 text-dark font-weight-semibold">Branch:</p>
                                            <address>
                                                <?= htmlspecialchars($orderInfo['branch_name']) ?>
                                                <br />
                                                <?= htmlspecialchars($orderInfo['address']) ?>
                                                <br />
                                                <?= htmlspecialchars($orderInfo['contact_number']) ?>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bill-to text-end">
                                            <p class="mb-0">
                                                <span class="text-dark">Order Date:</span>
                                                <span
                                                    class="value"><?= htmlspecialchars($orderInfo['order_date']) ?></span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="text-dark">Payment Method:</span>
                                                <span
                                                    class="value"><?= htmlspecialchars($orderInfo['payment_method']) ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bill-info">
                                <div class="row">
                                    <?php if (!empty($groomingDetail)): ?>
                                        <div class="col-md-6">
                                            <div class="bill-to">
                                                <p class="h6 mb-1 text-dark font-weight-semibold">Pet Grooming Service:</p>

                                                <span>
                                                    <strong>Pet Type & Size:
                                                    </strong><?= htmlspecialchars($groomingDetail['pet_type'] . ', ' . $groomingDetail['pet_size']) ?>
                                                    <br />
                                                    <strong>Scheduled Date:
                                                    </strong><?= htmlspecialchars(date("F d, Y", strtotime($groomingDetail['schedule_date']))) ?>
                                                    <br />
                                                    <strong>Groomer:
                                                    </strong><?= htmlspecialchars($groomingDetail['first_name'] . ' ' . $groomingDetail['last_name']) ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($bookingDetail)): ?>
                                        <div class="col-md-6">
                                            <div class="bill-to">
                                                <p class="h6 mb-1 text-dark font-weight-semibold">Pet Hotel Booking:</p>

                                                <span>
                                                    <strong>Pet Type:
                                                    </strong><?= htmlspecialchars($bookingDetail['pet_type']) ?>
                                                    <br />
                                                    <strong>Room Type:
                                                    </strong><?= htmlspecialchars($bookingDetail['room_type']) ?>
                                                    <br />
                                                    <strong>Date Booked:
                                                    </strong><?= htmlspecialchars(date("F d, Y", strtotime($bookingDetail['check_in_date'])) . ' to ' . date("F d, Y", strtotime($bookingDetail['check_out_date']))) ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle text-dark">
                                    <thead>
                                        <tr class="text-dark">
                                            <th id="cell-id" class="font-weight-semibold">#</th>
                                            <th id="cell-item" class="font-weight-semibold">Product</th>
                                            <th id="cell-price" class="text-center font-weight-semibold">Price</th>
                                            <th id="cell-qty" class="text-center font-weight-semibold">Quantity</th>
                                            <th id="cell-total" class="text-center font-weight-semibold">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $grandTotal = 0; ?>
                                        <?php if (!empty($orderDetails)): ?>
                                            <?php foreach ($orderDetails as $orderDetail): ?>
                                                <?php $grandTotal += $orderDetail['total_price']; ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($orderDetail['barcode']) ?>
                                                    </td>
                                                    <td class="font-weight-semibold text-dark">
                                                        <?= htmlspecialchars($orderDetail['product_name']) ?>
                                                    </td>
                                                    <td class="text-center">₱
                                                        <?= htmlspecialchars(number_format($orderDetail['unit_price_at_sale'], 2)) ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= htmlspecialchars($orderDetail['quantity_sold']) ?>
                                                    </td>
                                                    <td class="text-center">₱
                                                        <?= htmlspecialchars(number_format($orderDetail['total_price'], 2)) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>

                                        <?php endif; ?>
                                        <?php if (!empty($groomingDetail) && !empty($bookingDetail)): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($groomingDetail['service_id']) ?>
                                                </td>
                                                <td class="font-weight-semibold text-dark">
                                                    Pet Grooming Service For A Pet
                                                    <?= htmlspecialchars($groomingDetail['pet_type']) ?>
                                                </td>
                                                <td colspan="2"></td>
                                                <td rowspan="2" class="text-center">
                                                    ₱<?= htmlspecialchars($orderInfo['total_amount'] - $grandTotal, 2) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?= htmlspecialchars($bookingDetail['booking_id']) ?>
                                                </td>
                                                <td class="font-weight-semibold text-dark">
                                                    Pet Hotel Booking For A Pet
                                                    <?= htmlspecialchars($bookingDetail['pet_type']) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-center">--- Nothing Follows ---</td>
                                            </tr>
                                        <?php elseif (!empty($groomingDetail)): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($groomingDetail['service_id']) ?></td>
                                                <td class="font-weight-semibold text-dark">
                                                    Pet Grooming Service For A Pet
                                                    <?= htmlspecialchars($groomingDetail['pet_type']) ?>
                                                </td>
                                                <td colspan="2"></td>
                                                <td class="text-center">
                                                    ₱<?= htmlspecialchars(number_format($orderInfo['total_amount'] - $grandTotal, 2)) ?>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-center">--- Nothing Follows ---</td>
                                            </tr>
                                        <?php elseif (!empty($bookingDetail)): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($bookingDetail['booking_id']) ?></td>
                                                <td class="font-weight-semibold text-dark">
                                                    Pet Hotel Booking For A Pet
                                                    <?= htmlspecialchars($bookingDetail['pet_type']) ?>
                                                </td>
                                                <td colspan="2"></td>
                                                <td class="text-center">
                                                    ₱
                                                    <?= htmlspecialchars(number_format($orderInfo['total_amount'] - $grandTotal, 2)) ?>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <strong>--- Nothing Follows ---</strong>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <strong>No availed service</strong>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="invoice-summary">
                                <div class="row justify-content-end">
                                    <div class="col-12 col-sm-8 col-md-9 col-lg-5">
                                        <div class="table-responsive">
                                            <table class="table h6 text-dark mb-0">
                                                <tbody>
                                                    <tr class="b-top-0">
                                                        <td>Items Subtotal</td>
                                                        <td class="text-end">
                                                            ₱ <?= htmlspecialchars(number_format($grandTotal, 2)) ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Services</td>
                                                        <td class="text-end">
                                                            ₱
                                                            <?= htmlspecialchars(number_format($orderInfo['total_amount'] - $grandTotal, 2)) ?>
                                                        </td>
                                                    </tr>
                                                    <tr class="h5">
                                                        <td><strong>Grand Total</strong></td>
                                                        <td class="text-end">
                                                            <strong>₱
                                                                <?= htmlspecialchars(number_format($orderInfo['total_amount'], 2)) ?></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-3 d-md-flex justify-content-md-end me-2">
                            <a href="print-receipt?id=<?= urlencode($orderID) ?>" target="_blank"
                                class="btn btn-success ms-3"><i class="fas fa-print"></i> Print</a>
                            <a href="orders" class="btn btn-primary ms-3"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </section>
                <!-- end: page -->
            </section>
        </div>
    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->

    <script src="/HungryPaws/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>
    <script src="/HungryPaws/assets/js/examples/examples.ecommerce.datatables.list.js"></script>

</body>

</html>