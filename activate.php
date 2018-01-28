<?php 

include 'core/init.php';

if( isset($_GET["success"]) && empty($_GET["success"]) ){
	?>
	
	<h2>Thanks, we have activated your account</h2>
	<p>Now, you can login to your account here <a href="index.php">Login</a></p>

	<?php
} else if( isset($_GET["email"]) && isset($_GET["email_code"]) ){
	
	$email      = trim($_GET["email"]);
	$email_code = trim($_GET["email_code"]);

	if(!email_exist($email)){
		$errors[] = "We can\'t find that email";
	}else if(!activate($email, $email_code)){
		$errors[] = "we have problem to activate your account, please click link again in your email";
	}

	if( !empty($errors) ){
		?>
			<h2>Oooppss....</h2>
			<p>we can't process your request</p>
		<?php

		echo output_error($errors);
	}else{
		header("Location: activate.php?success");
		exit;
	}
}else{
	header("Location: index.php");
	exit;
}

