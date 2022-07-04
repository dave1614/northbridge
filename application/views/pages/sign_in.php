<!DOCTYPE html>
<html>
<head>
	<title>Sign In</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/owl.carousel.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/owl.theme.default.css'); ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
	<script src="<?php echo base_url('assets/js/jquery-3.0.0.js') ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css') ?>">
	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/sweetalert2.min.css') ?>">

	<link rel="stylesheet" href="<?php  echo base_url('assets/css/app.v1.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login_styles.css'); ?>">
	<style>
		.error{
			color: red;
			font-style: italic;
			font-size: 15px;
		}
	</style>
</head>
<body>
	<div class="section m-t-lg wrapper-md animated fadeInUp banner" >
		<main class="container aside-xl" style="padding-top: 0;">
			<section class="m-b-lg">
					
					<h1 class="text-center">Login</h1>
					<?php echo form_open(); ?>
						<div class="list-group">
							<div class="form-group">
								<span id="username-error" class="error" style=""><?php echo form_error('user_name'); ?></span>
								<label for="username">Enter Username</label>
								<input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo set_value('user_name'); ?>" required>
							</div>
							<div class="form-group">
								<span id="password-error" class="error"  style=""><?php echo form_error('password'); ?></span>
								<label for="pass" style="">Enter Password</label>
								<input type="password" id="pass" placeholder="" name="password" class="form-control" value="<?php echo set_value('password'); ?>" required>
							</div>
							<input type="submit" class="btn btn-lg btn-primary btn-block" value="Login" name="submit" style="margin-top: 50px;">
						
							<div class="text-center m-t m-b" style="color: white;">
								
								<p>New ?</p>
								<a href="register.php" style="border: 1px solid grey; background: #fff;">Register Now</a>
							</div>
						</div>
					</form>
			</section>
		</main>
		<script>
			function validateForm(){
				var username = document.forms["myForm"]["username"].value;
				var password = document.forms["myForm"]["password"].value;
				if(username.length > 10){
					var username_error = document.getElementById("username-error");
					username_error.innerHTML = "username must be at most 10 characters";
					return false;
				} if(password.length > 10){
					var password_error = document.getElementById("password-error");
					password_error.innerHTML = "password must be at most 10 characters";
					return false;
				} 
			}	
			$(document).ready(function(){
				function perform(){
					var banner = $("#banner");
					var height = window.innerHeight
					|| document.documentElement.clientHeight
					|| document.body.clientHeight;
					banner.css("height",height);
					
				}
				setInterval(perform, 1000);
				<?php if($incorrect_password == true){ ?>
				swal({
				  type: 'error',
				  title: 'Oops.....',
				  text: 'Sorry, the user name password combination was incorrect. Please try again!'
				  // footer: '<a href>Why do I have this issue?</a>'
				})
				<?php } ?>

				<?php if($user_does_not_exist == true){ ?>
				swal({
				  type: 'error',
				  title: 'Oops.....',
				  text: 'Sorry, the user name provided does not exist. Please try again!'
				  // footer: '<a href>Why do I have this issue?</a>'
				})
				<?php } ?>

				<?php if($something_wrong == true){ ?>
				swal({
				  type: 'error',
				  title: 'Oops.....',
				  text: 'Sorry, went wrong when loading this page. You Will Be Redirected'
				  // footer: '<a href>Why do I have this issue?</a>'
				})
				<?php } ?>
			});
		</script>
	
</div>
</body>
<script src="<?php echo base_url('assets/js/jquery-3.0.0.js') ?>"></script>
<script src="<?php echo base_url('assets/js/owl.carousel.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2.all.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2.min.js') ?>"></script>
</html>