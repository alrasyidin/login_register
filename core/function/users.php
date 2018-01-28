<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

function is_session($session){
	return (isset($_SESSION[$session])) ? true:false;
}

function activate($email, $email_code){
	global $link;

	escape_string($email);
	escape_string($email_code);

	if(mysqli_fetch_row(mysqli_query($link, "SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `email_code` = '$email_code' AND `active` = 0"))[0] == 1){
		// update active be 1
		mysqli_query($link, "UPDATE `users` SET active = 1 WHERE `email` = '$email'");
		return true;
	}else{
		return false;
	}
}

function sendEmail($subject, $data){
	global $mail;
	$mail = new PHPMailer(true);
	    // Sisi pengirim
	$mail->SMTPDebug = 2;
	$mail->isSMTP();
 	$mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               
    $mail->Username = 'hafidhpradiptaarrasyid@gmail.com';                 
    $mail->Password = 'irnanadya';                           
    $mail->SMTPSecure = 'tls';                            
    $mail->Port = 587;  

    // Sisi penerima
    $mail->setFrom('hafidhpradiptaarrasyid@gmail.com', 'hamstergeek');
    $mail->addAddress($data['email'], 'you as recipient'); // Add a recipient

    // set dalam format HTML
    $mail->isHTML(true);

    $bodyContent = '<h1>'.$subject.'</h1>';
    $bodyContent .= '<p>Activate your accoutn with click link below</p>';
    $bodyContent .= '<a href=http://localhost:8080/php/projectUAS/activate.php?email='.$data['email'].'&email_code='.$data['email_code'].'>Activate</a>';
    $bodyContent .= '<br><br> OR <br>';
    $bodyContent .= '<p> copy and paste this url to your tab browser if link not work.</p><br>';
    $bodyContent .= '<p>http://localhost:8080/php/projectUAS/activate.php?email='.$data['email'].'&email_code='.$data['email_code'].'</p><br>';
    $bodyContent .= '<p>if you ever feel fill in submission form on, please ignore this email.</p><br>';
    $bodyContent .= 'Best Regards,<br>Hamstergeek';

    $mail->Subject = $subject;
    $mail->Body = $bodyContent;

    return ( $mail->send() ) ? true:false;
}

function selectDataBaseId($id){
	global $link;
	escape_string($id);

	return mysqli_fetch_array(mysqli_query($link, "SELECT `username` FROM `users` WHERE `user_id`='$id'"))[0];
}

function kontak_kami($kontak_kami){
	global $link;
	escape_string($kontak_kami);

	$fields = implode_sql(array_keys($kontak_kami));
	$data   = implode_sql($kontak_kami, '\', \'', '\'');


	if(mysqli_query($link, "INSERT INTO `kontak` ($fields) VALUES ($data)")){
		return true;
	}else{
		return false;
	}

}

function register_user($register_user){
	global $link;
	escape_string($register_user);
	$register_user["password"] = md5($register_user["password"]);

	$fields = implode_sql(array_keys($register_user));
	$data   = implode_sql($register_user, '\', \'', '\'');
	$hasil = mysqli_query($link, "INSERT INTO `users` ($fields) VALUES ($data)");

	if($hasil){
		if(	sendEmail("Activate your account from localhost", $register_user) ){
			return true;
		}else{
			return false;
		}
	}
}

function user_data($user_id){
	global $link;
	$data = array();	
	$user_id = (int)$user_id;

	$func_get_args = func_get_args();

	if (func_num_args() > 0) {
		$func_get_args = array_splice($func_get_args, 1);
		$fields = implode_sql($func_get_args);

		return mysqli_fetch_assoc(mysqli_query($link, "SELECT $fields FROM `users` WHERE `user_id` = $user_id"));
	}
}

function logged_in(){
	return (isset($_SESSION["user_id"])) ? true:false;
}

function users_exist($username){
	global $link;

	escape_string($username);

	return (mysqli_fetch_row(mysqli_query($link, "SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'"))[0] == 1) ? true:false;
}

function email_exist($email){
	global $link;

	escape_string($email);

	return (mysqli_fetch_row(mysqli_query($link, "SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'"))[0] == 1) ? true:false;
}

function users_active($username){
	global $link; 
	escape_string($username);
	return (mysqli_fetch_row(mysqli_query($link, "SELECT `active` FROM `users` WHERE `username` = '$username' AND `active` = 1"))[0] == 1) ? true:false;
}

function user_id_from_username($link, $username){
	global $link;

	escape_string($username);
	return mysqli_fetch_row(mysqli_query($link, "SELECT `user_id` FROM `users` WHERE `username` = '$username'"))[0];
}

function login($username, $password){
	global $link;

	escape_string($username, $password);
	$password = md5($password);
	
	$user_id = user_id_from_username($link, $username);

	return (mysqli_fetch_row(mysqli_query($link, "SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'"))[0] == 1) ? $user_id : false;
}

function generate_user($data_pengguna){
	global $link;
	escape_string($data_pengguna);

	$fields = implode_sql(array_keys($data_pengguna));
	$data   = implode_sql($data_pengguna, '\', \'', '\'');

	return (mysqli_fetch_assoc(mysqli_query($link, "SELECT $fields FROM `users` WHERE `username` = '$data_pengguna[username]'")));
}

function update_user($data_pengguna){
	global $link;
	escape_string($data_pengguna);

	$fields = implode_sql(array_keys($data_pengguna));
	$data   = implode_sql($data_pengguna, '\', \'', '\'');

	$fieldArray = explode(",", $fields);
	$dataArray = explode(",", $data);

	$queryString = "";

	for ($i=0; $i < count($fieldArray); $i++) { 
		$queryString .= $fieldArray[$i] ." = ".$dataArray[$i];
		if($i == count($fieldArray) - 1){
			$queryString .= "";
		}else{
			$queryString .= ",";
		}
	}

	return (mysqli_query($link, "UPDATE `users` SET $queryString WHERE `username` = '$data_pengguna[username]'")) ? true:false;
}

function check_password($username, $password){
	global $link;
	escape_string($username, $password);	

	$password = md5($password);

	return (mysqli_query($link, "SELECT `password` FROM `users` WHERE `username` = '$username' && `password` = '$password'")) ? true:false;
}

function update_password($username, $new_password, $old_password){
	global $link;
	escape_string($username, $new_password, $old_password);		
	$old_password = md5($old_password);
	$new_password = md5($new_password);
	
	if(mysqli_fetch_row(mysqli_query($link, "SELECT `password` FROM `users` WHERE `username` = '$username'"))[0] == $old_password){
		if(mysqli_query($link, "UPDATE `users` SET `password` = '$new_password' WHERE username = '$username'")){
			return true;
		}else{
			return false;
		}
	}
}

function get_photo($user){
	global $link;

	return (mysqli_fetch_row(mysqli_query($link, "SELECT `photo` FROM `users` WHERE `username` = '$user'"))[0]);
}