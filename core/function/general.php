<?php

function protected_page(){
	if(!logged_in()){
		header("Location: index.php");
		exit;
	}
}

function logged_in_redirect(){
	if(logged_in()){
		header("Location: home.php");
		exit;
	}
}

function check_cookie($cn = "login"){
	if( isset($_COOKIE[$cn]) ){
		if( $_COOKIE[$cn] === "true" ){
			$id = $_COOKIE["id"];
			$key = $_COOKIE["key"];

			$hasil = generate_user([$username], "WHERE id = $id");


			if( hash("sha256", $hasil["username"] )  === $key ){
				header("Location: home.php");
				exit;
			}
		}
	}
}

function implode_sql($array, $pemisah = "`, `", $awal_akhir= '`'){
	return $awal_akhir .implode($pemisah, $array ) . $awal_akhir;
}

function escape_string(&$data){
	global $link;

	if(gettype($data) === "array"){
		foreach ($data as $key => $value) {
			$value = mysqli_escape_string($link, $value);
		}
	}else{
		$data = mysqli_escape_string($link, $data);
	}
}

function output_error($errors){
	return "<ul id=error><li>".implode("</li><li>", $errors)."</li></ul>";
}

function thumbnailImage($nama_file){
	$D         = "img/";
	
	$Image     = $D . $nama_file;
	$Image     = imagecreatefromjpeg($Image);
	$lebar     = imagesx($Image);
	$tinggi    = imagesy($Image);
	
	
	$TmbLebar  = 300;
	$TmbTinggi = 250;
	
	$TmbImage  = imagecreatetruecolor($TmbLebar, $TmbTinggi);
	imagecopyresampled($TmbImage, $Image, 0, 0, 0, 0, $TmbLebar, $TmbTinggi, $lebar, $tinggi);

	if( !file_exists("img/thumbnail/") ){
		$CD = mkdir($D."thumbnail/", 0777);
	}

	imagejpeg($TmbImage, $D . "thumbnail/". $nama_file);
	chmod($D . "thumbnail/". $nama_file, 0777);
	
	imagedestroy($Image);
	imagedestroy($TmbImage);
	
	
	return $Image;
}

function hitungFile($dir, $format="jpg"){
	$filecount = 0;
	$files = glob($dir . "*.".$format);

	if ($files){
	$filecount = count($files);
	}

	return $filecount;
}