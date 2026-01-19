<div id="modalForm" class="modal-block modal-block-primary mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Add Product</h2>
        </header>
        <div class="card-body">
            <div class="alert alert-danger alert-dismissible fade show d-none" id="modalFormValidator" role="alert">
                <strong>Warning!</strong> <span id="validatorMessage"></span>
                <button type="button" class="btn-close" onclick="hideWarningAlert()" aria-label="Close"></button>
            </div>
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label for="productSelect">Select
                            Product</label>
                        <select data-plugin-selectTwo class="form-control form-control-modern populate"
                            id="productSelect" name="productSelect">
                            <?php if (!empty($products)): ?>
                                <option value="" disabled selected>Select Product</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= htmlspecialchars($product['product_id']) ?>"
                                        data-stock="<?= htmlspecialchars($product['stock_level']) ?>"
                                        data-price="<?= htmlspecialchars($product['selling_price']) ?>"
                                        data-barcode="<?= htmlspecialchars($product['barcode']) ?>">
                                        <?= htmlspecialchars($product['product_name']) ?>
                                    </option>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled selected>No Products Available</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control form-control-modern" name="quantity" id="quantity"
                            placeholder="Enter Quantity">
                    </div>
                </div>
            </form>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button id="addProductBtn" type="button" class="btn btn-success modal-confirm">Add Product</button>
                    <button class="btn btn-default modal-dismiss">Cancel</button>
                </div>
            </div>
        </footer>
    </section>
</div>

<div id="confirmRemoveModal" class="modal-block modal-block-danger mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Confirm Removal</h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="modal-text">
                    <p>Are you sure you want to remove this product from the order?</p>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button id="confirmRemoveBtn" class="btn btn-danger">Yes</button>
                    <button class="btn btn-default modal-dismiss">Cancel</button>
                </div>
            </div>
        </footer>
    </section>
</div>

<div id="modalSuccess" class="modal-block modal-block-success mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 id="successTitle" class="card-title"></h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">Success</h4>
                    <p id="successMessage"></p>
                    <p>Would you like you to print the order receipt?</p>
                </div>
            </div>
        </div>
        <footer class="card-footer" id="successModalFooter">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="button" id="printReceiptBtn" class="btn btn-success">Yes</button>
                    <button class="btn btn-primary modal-dismiss" id="closeSuccessModal">No</button>
                </div>
            </div>
        </footer>
    </section>
</div>

<div id="modalWarning" class="modal-block modal-block-warning mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 id="warningTitle" class="card-title"></h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">Warning!</h4>
                    <p id="warningMessage"></p>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button class="btn btn-warning modal-dismiss">OK</button>
                </div>
            </div>
        </footer>
    </section>
</div>

<div id="modalDanger" class="modal-block modal-block-danger mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 id="errorTitle" class="card-title"></h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">Error!</h4>
                    <p id="errorMessage"></p>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button class="btn btn-danger modal-dismiss">OK</button>
                </div>
            </div>
        </footer>
    </section>
</div>