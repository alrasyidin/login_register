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
				$_SESSION["user_id"] = $login;

				if( isset($_POST["check_login"]) ){
					$data = generate_user([
							"user_id", 
							"username"
						 ]);

					setcookie("id", $data["user_id"], time() + 60 * 60 * 24 * 30);
					setcookie("key", hash("sha256", $data["username"] ), time() + 60 * 60 * 24 * 30);
				}

				header("Location: home.php");
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