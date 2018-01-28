<?php session_start();

require_once 'core/database/koneksi.php';
require_once 'core/function/general.php';
require_once 'core/function/users.php';

if (logged_in()) {

	$user_data = user_data($_SESSION["user_id"], "user_id", "username", "email", "password");

	if(users_active($user_data["username"]) === false){
		session_destroy();
		header("Location: index.php");
		exit();
	}
}

$errors = array();
?>