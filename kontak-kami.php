<?php  
	include_once "core/init.php";
	protected_page();
	include_once "template/header.php";

	if (!empty($_POST)) {
		$required_fields = array("nama", "email", "telp", "subjek", "pesan");

		foreach ($_POST as $key => $value) {
			if(empty($value) && in_array($key, $required_fields)){
				$errors[] = "The fields must filled, can\'t empty";
				break 1;
			}
		}


		if(empty($errors)){
			if( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ){
				$errors[] = "Email fields not valid, please enter valid email";
			}

			if( !filter_var((int)$_POST["telp"], FILTER_VALIDATE_INT) ){
				$errors[] = "Telephone field can only contain number";
			}

			if(!email_exist($_POST["email"])){
			    $errors[] = "You can send message only with email registered";
			}
		}


	}

	if(isset($_POST["submit"]) == "Kirim Pesan"){
		if(empty($errors)){
			// kontak_kami

			$kontak_kami = array(
				"nama"   => $_POST["nama"],
				"email"  => $_POST["email"],
				"telp"   => $_POST["telp"],
				"subjek" => $_POST["subjek"],
				"pesan"  => $_POST["pesan"]
			);
			
			//unset session error
			// session_destroy();
			unset($_GET["kontak_error"]);
			// redirect
			if(kontak_kami($kontak_kami)){
				header("Location: kontak-kami.php?success=".$kontak_kami["email"]);
			}
		}else{
			header("Location: kontak-kami.php?kontak_error=".implode("|", $errors));
		}
	}
?>

	<div class="kontak centerlayout">
		<div class="kontak-alamat kolom2">
			<div class="kontak-desc">
				<h3>Universitas Langlangbuana</h3>
				<p>
					Alamat: Jalan Karapitan no 116, Cikawao, Lengkong.
					Cikawao, Lengkong, Kota Bandung, Jawa Barat 40261
				</p>
				
				<ul>
					<li>Telp: 022-4112881</li>
					<li>Fax: 022-4231766</li>
					<li>E-mail: mail@unla.ac.id & info@unla.ac.id</li>
				</ul>

				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.662239380296!2d107.61360621416755!3d-6.93091336976743!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e883d90c0f6b%3A0xb36c11cb8eeb8886!2sUniversitas+Langlangbuana!5e0!3m2!1sid!2sid!4v1516757575826" width="400" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>

		<div class="kontak-kami tabbox kolom2">
			<h3 class="kontak-head">Kontak Kami</h3>
			<form action="" method="post" novalidate> 
				<div class="input-field">
					<input type="text" name="nama" class="field">
					<label for="nama" class="awesome-label">Nama</label>
				</div>
					
				<div class="input-field">
					<input type="text" name="email" class="field">
					<label for="email" class="awesome-label">Email</label>
				</div>

				<div class="input-field">
					<input type="text" name="telp" class="field">
					<label for="telp" class="awesome-label">Telp/HP</label>
				</div>

				<div class="input-field">
					<input type="text" name="subjek" class="field">
					<label for="subjek" class="awesome-label">Subjek</label>
				</div>

				<div class="input-field">
					<textarea name="pesan" class="field"></textarea>
					<label for="pesan" class="awesome-label">Pesan</label>
				</div>
				<?php 
					if( isset($_GET["kontak_error"]) ){
						$kontakError = explode("|", $_GET["kontak_error"]);
						echo output_error($kontakError);
					}

					if( isset($_GET["success"]) ){
						echo "You have sent message succesfully";
					}
				?>	
				<label></label>
				<div class="input-field">
					<input type="submit" name="submit" value="Kirim Pesan">
				</div>
			</form>
		</div>
	</div>
<?php 
	include_once "template/footer.php"; 
?>
