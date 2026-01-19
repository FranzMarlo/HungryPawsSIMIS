<div id="modalLogoutConfirm" class="modal-block modal-block-primary mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Do you want to log out?</h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="modal-text">
                    <p>You will be logged out of your account. Do you want to continue?</p>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button class="btn btn-primary modal-confirm" id="logoutConfirm">Yes</button>
                    <button class="btn btn-default modal-dismiss">No</button>
                </div>
            </div>
        </footer>
    </section>
</div>

<div id="modalDisabled" class="modal-block modal-block-danger mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 id="disabledTitle" class="card-title"></h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">Error!</h4>
                    <p id="disabledMessage"></p>
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

<script src="/HungryPaws/assets/js/manager-logout.js"></script>