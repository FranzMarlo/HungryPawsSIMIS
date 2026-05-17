<!doctype html>
<html class="modern fixed has-top-menu has-left-sidebar-half">

<?php
$title = "Add User | Hungry Paws";

include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/admin-head.php';
$fetch = new fetchClass();
$branches = $fetch->getBranches();
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

			<section role="main" class="content-body content-body-modernmt-0">
				<header class="page-header page-header-left-inline-breadcrumb">
					<h2 class="font-weight-bold text-6">Add User</h2>
				</header>

				<!-- start: page -->
				<form class="ecommerce-form action-buttons-fixed" method="post" id="addUserForm">
					<div class="row">
						<div class="col">
							<section class="card card-modern card-big-info">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-2-5 col-xl-1-5">
											<i class="card-big-info-icon bx bx-user-circle text-primary"></i>
											<h2 class="card-big-info-title">User Profile</h2>
											<p class="card-big-info-desc">Add here the user's personal information such
												as names and email.</p>
										</div>
										<div class="col-lg-3-5 col-xl-4-5">
											<div class="form-group row align-items-center pb-3">
												<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">First
													Name</label>
												<div class="col-lg-7 col-xl-6">
													<input type="text" class="form-control form-control-modern"
														name="firstName" id="firstName"
														placeholder="Enter First Name" />
												</div>
											</div>
											<div class="form-group row align-items-center pb-3">
												<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Last
													Name</label>
												<div class="col-lg-7 col-xl-6">
													<input type="text" class="form-control form-control-modern"
														name="lastName" id="lastName" placeholder="Enter Last Name" />
												</div>
											</div>
											<div class="form-group row align-items-center pb-3">
												<label
													class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Email</label>
												<div class="col-lg-7 col-xl-6">
													<input type="text" class="form-control form-control-modern"
														name="email" id="email" placeholder="Enter Email" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<section class="card card-modern card-big-info">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-2-5 col-xl-1-5">
											<i class="card-big-info-icon bx bx-building text-primary"></i>
											<h2 class="card-big-info-title">Company Details</h2>
											<p class="card-big-info-desc">Add here the user's company details in
												<strong>Hungry Paws</strong> such as role and branch to be assigned.
											</p>
										</div>
										<div class="col-lg-3-5 col-xl-4-5">
											<div class="form-group row align-items-center pb-3">
												<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Select
													User's Role</label>
												<div class="col-lg-7 col-xl-6">
													<select data-plugin-selectTwo
														class="form-control form-control-modern populate"
														id="roleSelect" name="roleSelect">
														<option value="" selected disabled>Select Role</option>
														<option value="Admin">Admin</option>
														<option value="Cashier">Cashier</option>
													</select>
												</div>
											</div>
											<div class="form-group row align-items-center pb-3">
												<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Select
													User's Branch</label>
												<div class="col-lg-7 col-xl-6">
													<select data-plugin-selectTwo
														class="form-control form-control-modern populate"
														id="branchSelect" name="branchSelect">
														<?php if (!empty($branches)): ?>
															<option value="" selected disabled>Select branch</option>
															<?php foreach ($branches as $branch): ?>
																<option value="<?= htmlspecialchars($branch['branch_id']) ?>">
																	<?= htmlspecialchars($branch['branch_name']) ?>
																</option>
															<?php endforeach; ?>
														<?php else: ?>
															<option value="" selected disabled>No Branch Found</option>
														<?php endif; ?>
													</select>
												</div>
											</div>
										</div>
									</div>
							</section>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<section class="card card-modern card-big-info">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-2-5 col-xl-1-5">
											<i class="card-big-info-icon bx bx-lock text-primary"></i>
											<h2 class="card-big-info-title">User Credentials</h2>
											<p class="card-big-info-desc">Add here the user's account credentials such
												as username and password.</p>
										</div>
										<div class="col-lg-3-5 col-xl-4-5">
											<div class="form-group row align-items-center pb-3">
												<label
													class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Username</label>
												<div class="col-lg-7 col-xl-6">
													<input type="text" class="form-control form-control-modern"
														name="username" id="username" placeholder="Enter Username" />
												</div>
											</div>
											<div class="form-group row align-items-center pb-3">
												<label
													class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Password</label>
												<div class="col-lg-7 col-xl-6">
													<input type="password" class="form-control form-control-modern"
														name="password" id="password" placeholder="Enter Password" />
												</div>
											</div>
											<div class="form-group row align-items-center">
												<label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Confirm
													Password</label>
												<div class="col-lg-7 col-xl-6">
													<input type="password" class="form-control form-control-modern"
														name="confirmPassword" id="confirmPassword"
														placeholder="Re-enter Password" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
					<div class="row action-buttons">
						<div class="col-12 col-md-auto">
							<button type="submit"
								class="submit-button btn btn-success btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1"
								data-loading-text="Loading...">
								<i class="bx bx-save text-4 me-2"></i> Add User
							</button>
						</div>
						<div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
							<a href="users"
								class="cancel-button btn btn-danger btn-px-4 py-3 border font-weight-semibold text-color-white text-3">Cancel</a>
						</div>
					</div>
				</form>
				<!-- end: page -->
			</section>
		</div>

	</section>


	<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/logout-modal.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/admin/add-user-modal.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/vendor.php';
	?>

	<!-- Specific Page Vendor -->
	<script src="/HungryPaws/assets/vendor/jquery-validation/jquery.validate.js"></script>
	<script src="/HungryPaws/assets/vendor/select2/js/select2.js"></script>
	<script src="/HungryPaws/assets/vendor/dropzone/dropzone.js"></script>
	<script src="/HungryPaws/assets/vendor/pnotify/pnotify.custom.js"></script>

	<script src="/HungryPaws/assets/js/admin/add-user.js"></script>

	<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/HungryPaws/includes/theme.php';
	?>

	<!-- Examples -->

</body>

</html>