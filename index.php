<?php 

include "core/init.php";

check_cookie();
logged_in_redirect();

?>

<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8">
	<title>Project UAS - LOGIN</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="node_modules/font-awesome/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
		<h1>.:Login:.</h1>
		<div class="wrap">
			<div class="navigation">
				<span class="navigation-login current">
					<a href="#login" class="navigation-login">Login</a>
				</span>
				<span class="navigation-signup">
					<a href="#signup" class="navigation-signup">Sign Up</a>
				</span>
			</div>
			<div class="login tabbox" id="login">
				<form action="proses_login.php" method="post" novalidate> 
					<div class="input-field">
						<input type="text" name="username"  class="field">
						<label for="username" class="awesome-label">Username</label>
					</div>

					<div class="input-field">
						<input type="password" name="password"  class="field">
						<label for="password" class="awesome-label">Password</label>
						<i class="fa fa-eye-slash"></i>
					</div>

					<div class="check">
						<input type="checkbox" id="check" name="check_login">
						<label for="check">Remember Me</label>
					</div>	

					<label></label>
					<div class="input-field">
						<input type="submit" name="submit" value="Login">
					</div>
				</form>
				<?php  
					if( isset($_GET["login_error"]) ){
						$errorArray = explode("|", $_GET["login_error"]);
						echo output_error($errorArray);
					}
				?>
			</div>
			<div class="signup tabbox" id="signup">
				<p>Silahkan daftar setelah itu check email anda</p>
				<form action="proses_register.php" method="post">
					<div class="input-field">
						<input type="text" class="field" name="username" id="username">
						<label for="username" class="awesome-label">Username</label>
					</div>

					<div class="input-field">
						<input type="text" class="field" name="email" id="email">
						<label for="email" class="awesome-label">Email</label>
					</div>

					<div class="input-field">
						<input type="password" class="field" name="password" id="password">
						<label for="password" class="awesome-label">Password</label>
					</div>

					<div class="input-field">
						<input type="password" class="field" name="confirm_password" id="confirm_password" >
						<label for="confirm_password" class="awesome-label">Confirm Password</label>
					</div>

					<div class="input-field">
						<input type="submit" name="submit" value="Sign Up">
						<label></label>
					</div>
				</form>
				<?php  
					if( isset($_GET["register_error"]) ){
						$registerError = explode("|", $_GET["register_error"]);
						echo output_error($registerError);
					}

					if( isset($_GET["success"]) ){
						echo "You have registered and we have send email to your email to activate your account, you cannot login before activate your account";
					}
					
				?>
			</div>
			<small>This is simple login system with minimalist design but nice and beautiful. [] dengan <i class="fa fa-heart"></i> di Bandung, Indonesia<br> Created by Hamstergeek &copy; UAS 2018  </small>
		</div>
	</div>

	<script src="js/script.js"></script>
</body>
</html>