<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="UniPro App">
		<meta name="author" content="ParkerThemes">
    <link rel="icon" href="img/icon_1.ico">
		<link rel="shortcut icon" href="img/fav.png" />

		<!-- Title -->
		<title>Register</title>


		<!-- *************
			************ Common Css Files *************
		************ -->
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		
		<!-- Main css -->
		<link rel="stylesheet" href="css/main.css">


		<!-- *************
			************ Vendor Css Files *************
		************ -->
    <style>
    body {
      background: url('img/background-image.jpg');
			background-size: cover;
			background-attachment: fixed;
    }
    .login-screen .login-logo {
      margin: 0 auto !important;
      display: block !important;
    }
    .login-screen .login-logo img {
    }
    </style>
		
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
			<div class="row no-gutters h-100">
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 d-lg-none">
					<div class="login-about">
						<div class="slogan">
							<span>Design</span>
							<span>Made</span>
							<span>Simple.</span>
						</div>
						<div class="about-desc">
							UniPro a data dashboard is an information management tool that visually tracks, analyzes and displays key performance indicators (KPI), metrics and key data points to monitor the health of a business, department or specific process.
						</div>
						<a href="reports.html" class="know-more">Know More <img src="img/right-arrow.svg" alt="Uni Pro Admin"></a>

					</div>
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="login-wrapper pt-4 pb-4">
						<form action="/register" method="POST" name="register_form">
							<div class="login-screen">
								<div class="login-body">
									<a href="reports.html" class="login-logo text-center">
										<img src="img/Greicio_ratas_pagrindinis_logo-01.png" alt="Uni Pro Admin">
									</a>
									<h6 class="text-center">Welcome to UniPro dashboard,<br>Create your account.</h6>
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
										<input type="text" autofocus name="name">
										<div class="field-placeholder">Name</div>
									</div>
									<div class="field-wrapper">
										<input type="text" name="surname">
										<div class="field-placeholder">Surname</div>
									</div>
									<div class="field-wrapper mb-3">
										<input type="text" name="mobile_number">
										<div class="field-placeholder">Mobile number</div>
									</div>
                  <div class="field-wrapper mb-3">
										<input type="text" name="email">
										<div class="field-placeholder">Email</div>
									</div>
                  <div class="field-wrapper mb-3">
										<input type="password" name="password">
										<div class="field-placeholder">Password</div>
									</div>
                  <div class="field-wrapper mb-3">
										<input type="password" name="confirm_password">
										<div class="field-placeholder">Confirm password</div>
									</div>
                  <div class="field-wrapper">
                    <select class="form-select" id="formSelect" name="account_type">
                      <option value="">Select</option>
                      <option value="organizer">Organizer</option>
                      <option value="participant">User</option>
                      <!-- <option value="">Select</option> -->
                    </select>
                    <div class="field-placeholder">Account type</div>
                  </div>
									<div class="actions">
										<button type="submit" name="signup" class="btn btn-primary ms-auto">Sign Up</button>
									</div>
								</div>
								<div class="login-footer">
									<span class="additional-link">Have an account? <a href="/login" class="btn btn-light">Login</a></span>
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
    $(document).ready(function(){
      $('form[name="register_form"]').submit(function(e) {
        $('.alert').remove();

        var name = ($('input[name="name"]').val()).trim();
        var surname = ($('input[name="surname"]').val()).trim();
        var email = ($('input[name="email"]').val()).trim();
        var mobile_number = ($('input[name="mobile_number"]').val()).trim();
        var password = ($('input[name="password"]').val()).trim();
        var confirm_password = ($('input[name="confirm_password"]').val()).trim();
        var account_type = ($('select[name="account_type"]').val()).trim();

        if (name == "" || surname == "" || email == "" || mobile_number == "" || password == "" || confirm_password == "" || account_type == "") {
          e.preventDefault();
          var error_alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
              All fields are required.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
          $("#alert-container").append(error_alert);
        } else if (password != confirm_password) {
          e.preventDefault();
          var error_alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Incorrect confirm password.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
          $("#alert-container").append(error_alert);
        }
      });
    });
    </script>
	</body>
</html>