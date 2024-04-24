
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
		<title>Create New Password</title>


		<!-- *************
			************ Common Css Files *************
		************ -->
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		
		<!-- Main css -->
		<link rel="stylesheet" href="css/main.css">
    <style>
    body {
      background: url('img/312720081_487379483455154_8183047599682928908_n.jpg') no-repeat !important;
    }
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
						<form action="/new_password" method="POST" name="new_password_form">
							<div class="login-screen">
								<div class="login-body">
									<a href="crm.html" class="login-logo text-center">
										<img src="img/Greicio_ratas_pagrindinis_logo-01.png" alt="iChat">
									</a>
									<h6 class="text-center">Create new password.</h6>
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
										<input type="password" name="new_password" autofocus>
										<div class="field-placeholder">New password</div>
									</div>
									<div class="field-wrapper mb-3">
										<input type="password" name="confirm_password">
										<div class="field-placeholder">Confirm password</div>
									</div>
									<div class="actions">
										
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Row end -->




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

      $("form[name='new_password_form']").submit(function(e){
        $('.alert').remove();

        var password = ($('input[name="new_password"]').val()).trim();
        var confirm_password = ($('input[name="confirm_password"]').val()).trim();

				if (password == '' || confirm_password == '') {
					e.preventDefault();
					var error_alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Both fields are required.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
          $("#alert-container").append(error_alert);
				} else if (password != confirm_password) {
          e.preventDefault();
					var error_alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Incorrect password.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
          $("#alert-container").append(error_alert);
        }

      });

		
    });
    </script>
	</body>
</html>