<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
	<title>SIMBADA DPC PPP SITUBONDO</title>
	<meta content="Admin Dashboard" name="Halaman Dashboard Admin Simbada DPC PPP Situbondo">
	<meta content="DPC PPP Situbondo" name="hosterweb">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="<?= base_url('assets/login/') ?>images/favicon1.ico">
	<link href="<?= base_url('assets/login/') ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/login/') ?>css/icons.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/login/') ?>css/style.css" rel="stylesheet" type="text/css">
</head>

<body class="fixed-left">
	<!-- Loader -->
	<div id="preloader">
		<div id="status">
			<div class="spinner">
			</div>
		</div>
	</div><!-- Begin page -->
	<div class="accountbg">
		<div class="content-center">
			<div class="content-desc-center">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-5 col-md-8">
							<div class="card">
								<div class="card-body">
									<h3 class="text-center mt-0 m-b-15">
										<a href="index.html" class="logo logo-admin">
											<img src="<?= base_url('assets/login/') ?>images/logo-dark.png" height="30" alt="logo"></a>
									</h3>
									<h4 class="text-muted text-center font-18">
										<b>Reset Password</b>
									</h4>
									<div class="p-2">
										<form class="form-horizontal m-t-20" action="<?= base_url('auth/update_password') ?>" method="post">
											<div class="form-group row">
												<div class="col-12">
													<input class="form-control" type="hidden" placeholder="Masukkan Email Anda" name="id" value="<?= $user->id ?>">
													<input class="form-control" type="text" placeholder="Masukkan Email Anda" name="email" value="<?= $user->email ?>">
													<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
													<?php echo '<span class="text-danger">' . form_error('email') . '</span>'; ?>
													<?php if ($this->session->flashdata('success')) { ?>
														<span class="text-danger">Email telah dikirim</span> 
													<?php } ?>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-12">
													<input class="form-control" type="password" required="" placeholder="Password" name="password">
													<span class="glyphicon glyphicon-lock form-control-feedback"></span>
													<?php echo '<span class="text-danger">' . form_error('password') . '</span>'; ?>
												</div>
											</div>
				
											<div class="form-group text-center row m-t-20">
												<div class="col-12">
													<button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Reset Password</button>
												</div>
											</div>
											
										</form>
									</div>
								</div>
							</div>
						</div>
					</div><!-- end row -->
				</div>
			</div>
		</div>
	</div><!-- jQuery  -->
	<script src="<?= base_url('assets/login/') ?>js/jquery.min.js">
	</script>
	<script src="<?= base_url('assets/login/') ?>js/bootstrap.bundle.min.js">
	</script>
	<script src="<?= base_url('assets/login/') ?>js/modernizr.min.js"></script>
	<script src="<?= base_url('assets/login/') ?>js/detect.js"></script>
	<script src="<?= base_url('assets/login/') ?>js/fastclick.js"></script>
	<script src="<?= base_url('assets/login/') ?>js/jquery.slimscroll.js">
	</script>
	<script src="<?= base_url('assets/login/') ?>js/jquery.blockUI.js">
	</script>
	<script src="<?= base_url('assets/login/') ?>js/waves.js">
	</script>
	<script src="<?= base_url('assets/login/') ?>js/jquery.nicescroll.js"></script>
	<script src="<?= base_url('assets/login/') ?>js/jquery.scrollTo.min.js"></script><!-- App js -->
	<script src="<?= base_url('assets/login/') ?>js/app.js">
	</script>
</body>

</html>