<!DOCTYPE html>
<html>
<head>
	<title>Login Register System Simple</title>
	<link rel="stylesheet" type="text/css" href="node_modules/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="box">
		<div class="box-header">
			<div class="box-head">
				<div class="box-logo kolom2">
					<div class="box-logo_img">
						<img src="img/logo.png" alt="logo website">
					</div>
					<div class="box-npm">
						<div>HAFIDH PRADIPTA ARRASYID</div>
						<div>411550505160111</div>
					</div>
				</div>
				<?php  
					$username = selectDataBaseId($_SESSION["user_id"]);
				?>
				<div class="box-welcome kolom2">
					Selamat Datang,<br><b><a href="pengguna.php?user=<?= $username; ?>" > <?= $username; ?></a></b>
				</div>
			</div>
			<div class="clear"></div>
			<div class="box-menu">
				<ul class="box-list kolom2">
					<li><a href="home.php">Beranda</a></li>
					<li><a href="gallery.php">Gallery</a></li>
					<li><a href="kontak-kami.php">Kontak Kami</a></li>
				</ul>
				
				<div class="box-logout kolom2">
					<a href="logout.php" class="button-logout keluar">Keluar</a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>