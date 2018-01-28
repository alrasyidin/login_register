<?php  
	include_once "core/init.php";
	protected_page();
	include_once "template/header.php";

	for ($i=1; $i <= hitungFile("img/"); $i++) { 
		thumbnailImage("slide".$i.".jpg");
	}
?>
	
	<div class="gallery centerlayout">
		<?php  
		for ($i=1; $i <= hitungFile("img/thumbnail/"); $i++) {
		?>
		
		<div class="gallery-img">
			<img src="img/thumbnail/slide<?=$i?>.jpg" alt="gambar gallery <?=$i?>">
			<div class="gallery-desc">
				<h4>Gambar <?=$i?></h4>
				<p>Gambar Pemandangan</p>
			</div>
		</div>

		<?php
			}
		?>
	</div>

	<div class="modal" id="myModal">
		<span class="modal-close">&times;</span>

		<img class="modal-content">

		<div class="modal-caption">
			
		</div>
	</div>
	
<?php  
	include_once "template/footer.php";
?>