<?php 

include 'core/init.php';


if (!empty($_POST)) {
	$required_fields = array("username", "email", "password", "password_again");

	foreach ($_POST as $key => $value) {
		if(empty($value) && in_array($key, $required_fields)){
			$errors[] = "The fields must filled, can\'t empty";
			break 1;
		}
	}

	if(empty($errors)){
		if( users_exist($_POST["username"]) ){
			$errors[] = "Username ". $_POST["username"] ." has already taken";
		}

		if(preg_match("/\\s/", $_POST["username"])){
			$errors[] = "Your username must not contain any space";
		}

		if(strlen($_POST['password']) < 6){
			$errors[] = "Your password must be at least 6 characters";
		}

		if($_POST['password'] !== $_POST['confirm_password']){
			$errors[] = "Your password do not match";
		}

		if( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ){
			$errors[] = "Email fields not valid, please enter valid email";
		}

		if(email_exist($_POST["email"])){
		    $errors[] = "You have signed that email. here <a href=login.php>login</a>";
		}
	}
}


if(empty($errors)){
	// register user
	$register_user = array(
		"username" => $_POST["username"],
		"email"    => $_POST["email"],
		"password" => $_POST["password"],
		"email_code" => md5($_POST["username"]+ microtime())
	);
	
	//unset session error
	// session_destroy();
	unset($_GET["register_error"]);
	// redirect
	if(register_user($register_user)){
		header("Location: index.php?success=".$register_user["username"]);
	}
}else{
	// $_GET["register_error"] = $errors;
	header("Location: index.php?register_error=".implode("|", $errors));
}
?>