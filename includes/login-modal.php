<div id="modalWarning" class="modal-block modal-block-warning mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Warning!</h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">Warning</h4>
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
            <h2 class="card-title">Login Failed!</h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">Login Failed!</h4>
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