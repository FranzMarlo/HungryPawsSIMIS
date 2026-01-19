<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "View Order | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/cashier-head.php';
$fetch = new fetchClass();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $orderID = $_GET['id'];
    $orderInfo = $fetch->getOrderInfo($orderID);
    $orderDetails = $fetch->getOrderDetails($orderID);
    $groomingDetail = $fetch->getGroomingDetails($orderID);
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
                    <h2 class="font-weight-bold text-6">View Order</h2>
                </header>


                <!-- start: page -->
                <form class="order-details action-buttons-fixed" method="post" id="addOrderForm">
                    <div class="row">
                        <div class="col-xl-8">

                            <div class="card card-modern">
                                <div class="card-header">
                                    <h2 class="card-title">Order Details</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-auto me-xl-5 pe-xl-5 mb-4 mb-xl-0">
                                            <h3 class="text-color-dark font-weight-bold text-4 line-height-1 mt-0 mb-3">
                                                BRANCH</h3>
                                            <ul class="list list-unstyled list-item-bottom-space-0">
                                                <li><strong><?= htmlspecialchars($orderInfo['branch_name']) ?></strong>
                                                </li>
                                                <li><?= htmlspecialchars($orderInfo['address']) ?></li>
                                            </ul>
                                            <strong class="d-block text-color-dark mt-3">Contact Number:</strong>
                                            <p class="text-color-dark">
                                                <?= htmlspecialchars($orderInfo['contact_number']) ?>
                                            </p>
                                            <strong class="d-block text-color-dark mt-3">Cashier:</strong>
                                            <p class="text-color-dark">
                                                <?= htmlspecialchars($first_name . ' ' . $last_name) ?>
                                            </p>
                                            <strong class="d-block text-color-dark mt-3">Services Availed:</strong>
                                            <p class="text-color-dark" id="serviceAvailed">
                                                None
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card card-modern">
                                <div class="card-header">
                                    <h2 class="card-title">Pet Grooming Details</h2>
                                </div>
                                <div class="card-body" id="groomingCardBody">
                                    <div class="form-group">
                                        <label>Select Groomer</label>
                                        <select class="form-control form-control-modern" name="groomerSelect"
                                            id="groomerSelect" data-plugin-selectTwo>
                                            <?php if (!empty($groomers)): ?>
                                                <option value="" disabled selected>Select Groomer</option>
                                                <?php foreach ($groomers as $groomer): ?>
                                                    <option value="<?= htmlspecialchars($groomer['user_id']) ?>">
                                                        <?= htmlspecialchars($groomer['first_name'] . ' ' . $groomer['last_name']) ?>
                                                    </option>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="" disabled selected>No Groomers Available</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="groomingPetType">Pet Type</label>
                                        <input type="text" class="form-control form-control-modern"
                                            name="groomingPetType" id="groomingPetType" placeholder="Enter Pet Type">
                                    </div>

                                    <div class="form-group">
                                        <label for="petSize">Pet Size</label>
                                        <input type="text" class="form-control form-control-modern" name="petSize"
                                            id="petSize" placeholder="Enter Pet Size">
                                    </div>

                                    <div class="form-group">
                                        <label for="scheduledDate">Schedule Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <input type="text" data-plugin-datepicker name="scheduledDate"
                                                id="scheduledDate" class="form-control form-control-modern"
                                                placeholder="Set Scheduled Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card card-modern">
                                <div class="card-header">
                                    <h2 class="card-title">Pet Hotel Booking Details</h2>
                                </div>
                                <div class="card-body" id="petHotelCardBody">
                                    <div class="form-group">
                                        <label for="bookingPetType">Pet Type</label>
                                        <input type="text" class="form-control form-control-modern"
                                            name="bookingPetType" id="bookingPetType" placeholder="Enter Pet Type">
                                    </div>

                                    <div class="form-group">
                                        <label for="roomType">Room Type</label>
                                        <input type="text" class="form-control form-control-modern" name="roomType"
                                            id="roomType" placeholder="Enter Room Type">
                                    </div>

                                    <div class="form-group">
                                        <label for="checkinDate">Check In Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <input type="text" data-plugin-datepicker
                                                class="form-control form-control-modern" name="checkinDate"
                                                id="checkinDate" placeholder="Set Check In Date">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="checkoutDate">Check Out Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                            <input type="text" data-plugin-datepicker
                                                class="form-control form-control-modern" name="checkoutDate"
                                                id="checkoutDate" placeholder="Set Check Out Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card card-modern">
                                <div class="card-header">
                                    <h2 class="card-title">Products</h2>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-ecommerce-simple table-ecommerce-simple-border-bottom table-borderless table-striped mb-0"
                                            style="min-width: 380px;" id="datatable-add-order">
                                            <thead>
                                                <tr>
                                                    <th width="12%" class="ps-4">Product ID</th>
                                                    <th width="60%">Product Name</th>
                                                    <th width="5%" class="text-end">Cost</th>
                                                    <th width="7%" class="text-end">Qty</th>
                                                    <th width="5%" class="text-end">Total</th>
                                                    <th width="5%" class="text-end">Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row justify-content-end flex-column flex-lg-row my-3">
                                        <div class="col-auto me-5">
                                            <h3 class="font-weight-bold text-color-dark text-4 mb-3">Items Subtotal</h3>
                                            <span class="d-flex align-items-center">
                                                <span id="itemCount">0 Items</span>
                                                <i class="fas fa-chevron-right text-color-primary px-3"></i>
                                                <b class="text-color-dark text-xxs">₱<span
                                                        id="subTotalAmount">0.00</span></b>
                                            </span>
                                        </div>

                                        <div class="col-auto me-5">
                                            <h3 class="font-weight-bold text-color-dark text-4 mb-3">Services</h3>
                                            <span class="d-flex align-items-center">
                                                Services Cost
                                                <i class="fas fa-chevron-right text-color-primary px-3"></i>
                                                <b class="text-color-dark text-xxs">₱<span
                                                        id="serviceTotal">0.00</span></b>
                                            </span>
                                        </div>

                                        <div class="col-auto">
                                            <h3 class="font-weight-bold text-color-dark text-4 mb-3">Order Total</h3>
                                            <span class="d-flex align-items-center justify-content-lg-end">
                                                <strong class="text-color-dark text-5">₱<span
                                                        id="orderTotal">0.00</span></strong>
                                            </span>
                                            <input type="hidden" name="orderTotalVal" id="orderTotalVal">

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row action-buttons align-items-start align-items-md-center">
                        <div class="col-12 col-md-auto">
                            <a href="#modalForm"
                                class="modal-with-form btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                                <i class="bx bx-plus text-4 me-2"></i> Add Product
                            </a>
                        </div>

                        <div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
                            <button type="submit"
                                class="submit-button btn btn-success btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
                                data-loading-text="Loading...">
                                <i class="bx bx-save text-4 me-2"></i> Save Order
                            </button>
                        </div>

                        <div class="col-12 col-md-auto mt-3 mt-md-0 ms-md-auto text-start text-md-end">
                            <a href="orders" class="btn btn-danger btn-px-4 py-3 border font-weight-semibold text-3">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
                <!-- end: page -->
            </section>
        </div>
    </section>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/cashier/logout-modal.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
    ?>

    <!-- Specific Page Vendor -->
    <script src="/HungryPaws/assets/vendor/jquery-validation/jquery.validate.js"></script>
    <script src="/HungryPaws/assets/vendor/select2/js/select2.js"></script>
    <script src="/HungryPaws/assets/vendor/dropzone/dropzone.js"></script>
    <script src="/HungryPaws/assets/vendor/pnotify/pnotify.custom.js"></script>
    <script src="/HungryPaws/assets/vendor/jquery-ui/jquery-ui.js"></script>
    <script src="/HungryPaws/assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
    <script src="/HungryPaws/assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script src="/HungryPaws/assets/vendor/fuelux/js/spinner.js"></script>
    <script src="/HungryPaws/assets/vendor/dropzone/dropzone.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-markdown/js/markdown.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-markdown/js/to-markdown.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script src="/HungryPaws/assets/vendor/summernote/summernote-bs4.js"></script>
    <script src="/HungryPaws/assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="/HungryPaws/assets/vendor/ios7-switch/ios7-switch.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/HungryPaws/assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js"></script>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
    ?>
    <script src="/HungryPaws/assets/js/order/add-order.js"></script>

    <!-- Examples -->
    <script src="/HungryPaws/assets/js/examples/examples.header.menu.js"></script>
    <script src="/HungryPaws/assets/js/examples/examples.ecommerce.datatables.list.js"></script>

</body>

</html>