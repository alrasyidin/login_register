<?php  
	include_once "core/init.php";
	protected_page();
	include_once "template/header.php";

	$data;
	if( isset($_GET["user"])){
		$user = $_GET["user"];

		$data_pengguna = array(
			"username" => $user,
			"nama"     => @$_POST["nama"],
			"telp"     => @$_POST["telp"],
			"alamat"   => @$_POST["alamat"],
			"email"    => @$_POST["email"],
			"photo"    => @$_FILES["gambar"]["name"]
		);

		$data = generate_user($data_pengguna);

		if( isset($_POST["submit"])){
			$required_fields = array("nama", "email", "telp", "subjek", "pesan");

			foreach ($_POST as $key => $value) {
				if(empty($value) && in_array($key, $required_fields)){
					$errors[] = "The fields must filled, can\'t empty";
					break 1;
				}
			}

			if( empty($errors) ){
				if( !filter_var((int)$_POST["telp"], FILTER_VALIDATE_INT) ){
					$errors[] = "Telephone field can only contain number";
				}
			}

			if( empty($errors) ){
				if(update_user($data_pengguna)){
					header("Location: pengguna.php?user=$user&successubah");
				}else{
					$errors[] = "Gagal ubah profile";
				}

				$asal = $_FILES["gambar"]["tmp_name"];
				$namaimg = $_FILES["gambar"]["name"];

				if( isset($namaimg) ){
					move_uploaded_file($asal, "photo_upload/".$namaimg);
				}
			}else{
				header("Location: pengguna.php?user=$user&ubah_error=".implode("|", $errors));
			}
		}


		if( isset($_POST["change"]) ){

			$required_fields = array("old_password", "old_password_confirm", "new_password");

			foreach ($_POST as $key => $value) {
				if(empty($value) && in_array($key, $required_fields)){
					$errors[] = "The fields must filled, can\'t empty";
					break 1;
				}
			}

			if(empty($errors)){
				if($_POST["old_password"] !== $_POST["old_password_confirm"]){
					$errors[] = "Harap samakan Old Password dengan Old Password Confirm";
				}
			}

			if(empty($errors)){
				if(update_password($user, $_POST["new_password"], $_POST["old_password"])){
					header("Location:pengguna.php?user=$user&successupdatepassword");
				}else{
					$errors[] = "Cannot change password";
				}
			}else{
				header("Location: pengguna.php?user=$user&change_error=".implode("|", $errors));
			}
			
		}
	}else{
		protected_page();
	}
	
?>


	<div class="tabbox pengguna centerlayout">
		<div class="image_upload">
			<?php 
				$image;
				if( !empty(get_photo($user)) ){
					$image = "photo_upload/".get_photo($user);
				}else{
					$image = "img/photo.png";
				}
			?>
			<img src="<?= $image ?>" alt="Photo User">
		</div>
		<h3 class="pengguna-head">Informasi Pengguna</h3>
			<form action="" method="post" enctype="multipart/form-data" novalidate> 

				<div class="input-field">
					<input type="text" name="nama" class="field" value="<?= $data["nama"]; ?>" >
					<label for="nama" class="awesome-label">Nama Lengkap</label>
				</div>
					
				<div class="input-field">
					<input type="text" name="email" class="field" value="<?= $data["email"]; ?>" readonly>
					<label for="email" class="awesome-label">Email</label>
				</div>

				<div class="input-field">
					<input type="text" name="telp" class="field" value="<?= $data["telp"]; ?>">
					<label for="telp" class="awesome-label">Telp/HP</label>
				</div>

				<div class="input-field">
					<textarea name="alamat" class="field"><?= trim($data["alamat"]); ?></textarea>
					<label for="alamat" class="awesome-label">ALamat</label>
				</div>

				<div class="input-upload">
					<label for="gambar">Upload Image: </label>
					<input type="file" name="gambar">
				</div>
				<br><br>
				<?php 
					if( isset($_GET["ubah_error"]) ){
						$ubahError = explode("|", $_GET["ubah_error"]);
						echo output_error($ubahError);
					}

					if( isset($_GET["successubah"]) ){
						echo "You have change the profile successfully";
					}
				?>	
				<label></label>
				<div class="input-field">
					<input type="submit" name="submit" value="Ubah Profil">
				</div>
			</form>
	</div>
	
	<div class="tabbox change centerlayout">
		<h3 class="change-head">Change Password</h3>
			<form action="" method="post" novalidate> 

				<div class="input-field">
					<input type="password" name="old_password" class="field" >
					<label for="nama" class="awesome-label">Old Password</label>
				</div>
				
				<div class="input-field">
					<input type="password" name="old_password_confirm" class="field">
					<label for="telp" class="awesome-label">Old Password Confirm</label>
				</div>

				<div class="input-field">
					<input type="password" class="field" name="new_password">
					<label for="new_password" class="awesome-label">New Password</label>
				</div>

				<?php 
					if( isset($_GET["change_error"]) ){
						$changeError = explode("|", $_GET["change_error"]);
						echo output_error($changeError);
					}

					if( isset($_GET["successupdatepassword"]) ){
						echo "You have succesfully change password";
					}

				?>	
				<label></label>
				<div class="input-field">
					<input type="submit" name="change" value="Change Password">
				</div>
			</form>
	</div>
<?php  
	include_once "template/footer.php";
?>