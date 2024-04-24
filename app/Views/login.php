
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="UniPro App">
		<meta name="author" content="ParkerThemes">
		<link rel="shortcut icon" href="img/fav.png" />

		<!-- Title -->
		<title>Login</title>


		<!-- *************
			************ Common Css Files *************
		************ -->
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		
		<!-- Main css -->
		<link rel="stylesheet" href="css/main.css">
    <style>
    
    .login-screen .login-logo {
      margin: 0 auto !important;
      display: block !important;
    }
    .login-screen .login-logo img {
    }
    </style>

		<!-- *************
			************ Vendor Css Files *************
		************ -->

	</head>
	<body class="authentication">

		<!-- Loading wrapper start -->
		<div id="loading-wrapper">
			<div class="spinner-border"></div>
			Loading...
		</div>
		<!-- Loading wrapper end -->

		<!-- *************
			************ Login container start *************
		************* -->
		<div class="login-container">

			<div class="container-fluid h-100">

			<!-- Row start -->
			<div class="row g-0 h-100">
				<div class="d-none col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
					<div class="login-about">
						<div class="slogan">
							<span>Design</span>
							<span>Made</span>
							<span>Simple.</span>
						</div>
						<div class="about-desc">
							UniPro a data dashboard is an information management tool that visually tracks, analyzes and displays key performance indicators (KPI), metrics and key data points to monitor the health of a business, department or specific process.
						</div>
						<a href="crm.html" class="know-more">Know More <img src="img/right-arrow.svg" alt="Uni Pro Admin"></a>

					</div>
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="login-wrapper">
						<form action="/login" method="POST" name="login_form">
							<div class="login-screen">
								<div class="login-body">
									<a href="crm.html" class="login-logo text-center">
										<img src="img/Greicio_ratas_pagrindinis_logo-01.png" alt="iChat">
									</a>
									<h6 class="text-center">Welcome back,<br>Please login to your account.</h6>
									<div id="alert-container">
										<?php if (session()->has('success')) { ?>
											<div class="alert alert-success alert-dismissible fade show" role="alert">
												<?php echo session()->getFlashdata('success'); ?>
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										<?php } ?>
										<?php if (session()->has('error')) { ?>
											<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<?php echo session()->getFlashdata('error'); ?>
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										<?php } ?>
									</div>
									<div class="field-wrapper mt-4">
										<input type="email" name="email" autofocus>
										<div class="field-placeholder">Email ID</div>
									</div>
									<div class="field-wrapper mb-3">
										<input type="password" name="password">
										<div class="field-placeholder">Password</div>
									</div>
									<div class="actions">
										<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Forgot password?</a>
										<button type="submit" class="btn btn-primary">Login</button>
									</div>
								</div>
								<div class="login-footer">
									<span class="additional-link">No Account? <a href="/register" class="btn btn-light">Sign Up</a></span>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Row end -->

			<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Forgot password</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 95%;"><div class="modal-body" style="overflow: hidden; width: auto; height: 95%;">
					<div id="forgot_password_alert"></div>
					<form action="/forgot_password" method="POST" name="forgot_password">

						<div class="field-wrapper mt-4">
							<input class="form-control" type="email" name="forgot_password_email" required>
							<div class="field-placeholder">Email <span class="text-danger">*</span></div>
						</div>

						<button type="submit" class="btn btn-primary">Submit</button>
					</form>

					</div><div class="slimScrollBar" style="background: rgb(214, 219, 230); width: 5px; position: absolute; top: 0px; opacity: 0.8; display: block; border-radius: 0px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; background: rgb(214, 219, 230); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<!-- <button type="button" class="btn btn-primary">Understood</button> -->
					</div>
					</div>
				</div>
			</div>


			</div>
		</div>
		<!-- *************
			************ Login container end *************
		************* -->

		<!-- *************
			************ Required JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/modernizr.js"></script>
		<script src="js/moment.js"></script>
		
		<!-- *************
			************ Vendor Js Files *************
		************* -->

		<!-- Main Js Required -->
		<script src="js/main.js"></script>
    <script>
    $(document).ready(function(e){
			var validateEmail = (email) => {
				return String(email)
					.toLowerCase()
					.match(
						/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
					);
			};

      $("form[name='login_form']").submit(function(e){
        $('.alert').remove();

        var email = ($('input[name="email"]').val()).trim();
        var password = ($('input[name="password"]').val()).trim();

				if (email == '' || password == '') {
					e.preventDefault();
					var error_alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Enter email and password.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
          $("#alert-container").append(error_alert);
				}

      });

			$('form[name="forgot_password"]').submit(function(e) {
				$('.alert').remove();
				var email = ($('input[name="forgot_password_email"').val()).trim();
				if (!validateEmail(email)) {
					e.preventDefault();
					var message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Enter proper email.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
					$('#forgot_password_alert').append(message);
				} else {
					e.preventDefault();
					$.ajax({
						url: '<?php echo base_url('forgot_password'); ?>',
						method: 'POST',
						data: {
							'forgot_password': true,
							email: email
						},
						success: function(data) {
							if (data['not_found'] != undefined) {
								$('input[name="forgot_password_email"').val('');
								var message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
									Email not found.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
								$('#forgot_password_alert').append(message);
							} else if (data['email_sent'] != undefined) {
								$('input[name="forgot_password_email"').val('');
								var message = $(`<div class="alert alert-success alert-dismissible fade show" role="alert">
									Check email to set new password.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
								$('#forgot_password_alert').append(message);
							}
						},
						error: function(error) {
							console.log(error);
						}
					});
				}
			});
    });
    </script>
	</body>
</html>