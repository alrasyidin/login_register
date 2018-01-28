<?php  
	require_once "core/init.php";

	
	if(!empty($_POST)){
		$username = $_POST['username'];
		$password = $_POST['password'];

		if( empty($username) === true || empty($password) === true ){
			$errors[] = "You must entered username and password";
		}else if(!users_exist($username)){
			$errors[] = "Username <b>$username</b> not available in database. Have you registered?";
		}else if(!users_active($username)){
			$errors[] = "Username <b>$username</b> haven't activated";
		}
		else{
			if(strlen($password) > 32){
				$errors[] = "Password too long. 32 characters max";
			}

			$login = login($username, $password);
	
			if( $login === false ){
				$errors[] = "That username is correct but password is incorrect";
			}else{
				// if( isset($_GET["check_login"]) ){
					$_SESSION["user_id"] = $login;
					header("Location: home.php");
				// }else{
				// 	header("Location: home.php");
				// }
			}

			// session_destroy();
			unset($_GET["login_error"]);
		}
	}
	else{
		$errors[] = "No data received";
	}

	if(!empty($errors)){
		// $_GET["login_error"] = $errors;
		// die(implode(" ",$errors));
		header("Location: index.php?login_error=".implode("|",$errors));
	}
?>