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
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button class="btn btn-success modal-dismiss">OK</button>
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

<div id="modalError" class="modal-block modal-block-danger mfp-hide">
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

<div id="modalInfo" class="modal-block modal-block-info mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 id="infoTitle" class="card-title"></h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">Info</h4>
                    <p id="infoMessage">This is a information message.</p>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button class="btn btn-info modal-dismiss">OK</button>
                </div>
            </div>
        </footer>
    </section>
</div>

<div id="modalConfirm" class="modal-block modal-block-primary mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 id="confirmTitle" class="card-title">Are You Sure?</h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="modal-text">
                    <p id="confirmMessage"></p>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button class="btn btn-primary modal-confirm" id="confirmBtn">Yes</button>
                    <button class="btn btn-default modal-dismiss">No</button>
                </div>
            </div>
        </footer>
    </section>
</div>